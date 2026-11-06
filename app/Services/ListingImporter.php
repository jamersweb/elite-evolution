<?php

namespace App\Services;

use App\Models\Amenities;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Str;
use RuntimeException;

class ListingImporter
{
    public static function httpsUrl($url)
    {
        return is_string($url) && filter_var($url, FILTER_VALIDATE_URL)
            && parse_url($url, PHP_URL_SCHEME) === 'https' ? $url : null;
    }

    public function import(array $row, string $source)
    {
        $id = (string) ($row['id'] ?? '');
        $reference = trim($row['reference'] ?? '');
        $title = data_get($row, 'title.en') ?: data_get($row, 'title.ar');
        $period = data_get($row, 'price.type');
        if ($id === '' || strlen($id) > 128 || !$reference || !$title
            || !in_array($period, ['sale', 'yearly', 'monthly', 'weekly', 'daily'], true)) {
            throw new RuntimeException('Listing missing a valid ID, reference, title or pricing period.');
        }
        $property = Property::firstOrNew(['sync_source' => $source, 'sync_id' => $id]);
        $duplicate = Property::where('reference_no', $reference);
        if ($property->exists) {
            $duplicate->where('id', '!=', $property->id);
        }
        if ($duplicate->exists()) {
            throw new RuntimeException('Reference collision for '.$reference.'. Review the existing property.');
        }
        if (strtoupper($row['currency'] ?? 'AED') !== 'AED') {
            throw new RuntimeException('Only AED pricing is supported for '.$reference.'.');
        }
        $agentId = config('listing_sync.agents', [])[data_get($row, 'assignedTo.id', '')] ?? null;
        if ($agentId && !User::agents()->whereKey($agentId)->exists()) {
            throw new RuntimeException('Invalid local agent mapping for '.$reference.'.');
        }
        $locationId = data_get($row, 'location.id', '');
        $location = array_merge(config('listing_sync.locations', [])[$locationId] ?? [], $row['location'] ?? []);
        if (isset($location['lookup_status']) && $property->exists) {
            $previous = json_decode($property->source_payload ?? '{}', true);
            if ((string) data_get($previous, 'listing.location.id') === (string) $locationId) {
                foreach (['state', 'community', 'sub_community', 'building', 'lat', 'lng'] as $field) {
                    $location[$field] = $property->$field;
                }
                $location['name'] = $property->location;
                $location['source_details'] = $previous['location'] ?? null;
            }
        }
        foreach (['lat', 'lng'] as $coordinate) {
            if (isset($location[$coordinate]) && !is_numeric($location[$coordinate])) {
                throw new RuntimeException('Invalid coordinates for '.$reference.'.');
            }
        }
        $amount = data_get($row, 'price.onRequest') ? null : data_get($row, 'price.amounts.'.$period);
        if (!$amount && !data_get($row, 'price.onRequest')) {
            throw new RuntimeException('Missing price for '.$reference.'.');
        }
        $amenities = [];
        foreach ($row['amenities'] ?? [] as $amenity) {
            $amenities[] = Amenities::firstOrCreate(['title' => Str::title(str_replace('-', ' ', $amenity))])->id;
        }
        $plans = [];
        foreach (data_get($row, 'media.floorPlans', []) as $plan) {
            if ($url = self::httpsUrl($plan['url'] ?? null)) {
                $plans[] = $url;
            }
        }
        $property->forceFill([
            'sync_source' => $source, 'sync_id' => $id, 'reference_no' => $reference,
            'status' => 1, 'title' => $title,
            'description' => data_get($row, 'description.en') ?: data_get($row, 'description.ar'),
            'property_type' => Str::title(str_replace('-', ' ', $row['type'] ?? '')),
            'type' => $period === 'sale' ? 'sale' : 'rent',
            'land_type' => $row['category'] ?? null,
            'price' => $amount, 'yearly_rent' => $period === 'yearly' ? $amount : null,
            'rent_period' => $period === 'sale' ? null : $period,
            'completion_status' => isset($row['projectStatus']) ? (Str::startsWith($row['projectStatus'], 'off_plan') ? 'Off-plan' : 'Ready') : null,
            'furnishing_type' => $row['furnishingType'] ?? null, 'available_from' => $row['availableFrom'] ?? null,
            'bedrooms' => isset($row['bedrooms']) ? (int) $row['bedrooms'] : null,
            'bathrooms' => isset($row['bathrooms']) ? (int) $row['bathrooms'] : null,
            'size' => $row['size'] ?? null, 'build_up_area' => $row['builtUpArea'] ?? null,
            'parkings' => $row['parkingSlots'] ?? null, 'cheques' => data_get($row, 'price.numberOfCheques'),
            'trakheesi_permit_no' => data_get($row, 'compliance.listingAdvertisementNumber'),
            'is_verified' => ($row['verificationStatus'] ?? null) === 'verified',
            'state' => $location['state'] ?? (isset($row['uaeEmirate']) ? Str::title(str_replace('_', ' ', $row['uaeEmirate'])) : null),
            'community' => $location['community'] ?? null, 'building' => $location['building'] ?? null,
            'sub_community' => $location['sub_community'] ?? null, 'location' => $location['name'] ?? null,
            'lat' => $location['lat'] ?? null, 'lng' => $location['lng'] ?? null,
            'completesearch' => implode(', ', array_filter([$location['building'] ?? null, $location['community'] ?? null, $location['name'] ?? null])),
            'user_id' => $agentId, 'amenities' => json_encode($amenities),
            'video' => self::httpsUrl(data_get($row, 'media.videos.default')),
            'view36' => self::httpsUrl(data_get($row, 'media.videos.view360')),
            'sync_details' => json_encode(['title' => $row['title'], 'description' => $row['description'] ?? [],
                'location_id' => $locationId, 'agent_profile_id' => data_get($row, 'assignedTo.id'), 'floor_plans' => $plans], JSON_THROW_ON_ERROR),
        ]);
        $created = !$property->exists;
        if ($source === 'propertyfinder') {
            $property->source_payload = json_encode([
                'listing' => $row['_source_record'],
                'location' => data_get($row, 'location.source_details'),
                'location_lookup_status' => data_get($row, 'location.lookup_status'),
            ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $property->save();
        $urls = [];
        foreach (data_get($row, 'media.images', []) as $image) {
            foreach (['large', 'original', 'medium', 'thumbnail'] as $size) {
                if ($url = self::httpsUrl(data_get($image, $size.'.url'))) {
                    $urls[] = $url;
                    break;
                }
            }
        }
        $existing = $property->media()->whereNotNull('source_url')->orderBy('id');
        if ($existing->pluck('source_url')->all() !== $urls) {
            $existing->delete();
            foreach ($urls as $url) {
                $image = $property->media()->make(['reference_type' => 'property', 'image' => 'external']);
                $image->source_url = $url;
                $image->save();
            }
        }
        return $created;
    }
}
