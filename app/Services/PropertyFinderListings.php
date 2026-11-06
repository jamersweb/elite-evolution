<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PropertyFinderListings
{
    private const BASE = 'https://atlas.propertyfinder.com/v1';

    public function fetch($limit = null)
    {
        $key = config('listing_sync.key');
        $secret = config('listing_sync.secret');
        if (!$key || !$secret) {
            throw new RuntimeException('Configure PROPERTY_FINDER_API_KEY and PROPERTY_FINDER_API_SECRET first.');
        }
        $client = Http::acceptJson()->withoutRedirecting()->timeout(30);
        $auth = $client->post(self::BASE.'/auth/token', ['apiKey' => $key, 'apiSecret' => $secret]);
        if (!$auth->successful() || !$token = $auth->json('accessToken')) {
            throw new RuntimeException('Property Finder authentication failed (HTTP '.$auth->status().').');
        }

        $locations = [];
        $rows = [];
        $total = null;
        for ($page = 1; ; $page++) {
            $response = $this->read($client->withToken($token), '/listings', [
                'page' => $page, 'perPage' => min($limit ?: 100, 100), 'filter[state]' => 'live',
            ]);
            if (!$response->successful()) {
                throw new RuntimeException('Listings request failed on page '.$page.' (HTTP '.$response->status().').');
            }
            $pagination = $response->json('pagination');
            $results = $response->json('results');
            if (!is_array($results) || !is_array($pagination) || ($pagination['page'] ?? null) !== $page
                || !is_int($pagination['total'] ?? null) || !is_int($pagination['totalPages'] ?? null)
                || ($total !== null && $total !== $pagination['total'])) {
                throw new RuntimeException('Incomplete or changing listing pagination. Retry the sync.');
            }
            $total = $pagination['total'];
            foreach ($results as $row) {
                $row['_source_record'] = $row;
                $locationId = data_get($row, 'location.id');
                if ($locationId) {
                    if (!isset($locations[$locationId])) {
                        $locations[$locationId] = config('listing_sync.locations', [])[$locationId]
                            ?? $this->location($client, $locationId);
                    }
                    $row['location'] += $locations[$locationId];
                }
                $rows[] = $row;
                if ($limit && count($rows) === $limit) {
                    return $rows;
                }
            }
            if ($page >= $pagination['totalPages']) {
                if (count($rows) !== $total) {
                    throw new RuntimeException('Listing count mismatch. Retry the sync.');
                }
                return $rows;
            }
            if (!$results) {
                throw new RuntimeException('Unexpected empty page. Retry the sync.');
            }
        }
    }

    private function location($client, $id)
    {
        $cacheKey = 'atlas-location:'.$id;
        $cached = \Illuminate\Support\Facades\Cache::get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }
        $response = $this->read($client, '/locations', ['filter[id]' => $id]);
        if (in_array($response->status(), [403, 404], true)) {
            \Illuminate\Support\Facades\Log::warning('Atlas location details unavailable', ['location_id' => $id, 'status' => $response->status()]);
            return ['lookup_status' => $response->status()];
        }
        $place = $response->json('data.0');
        if (!$response->successful() || !is_array($place) || (string) ($place['id'] ?? '') !== (string) $id) {
            throw new RuntimeException('Location lookup failed for ID '.$id.' (HTTP '.$response->status().').');
        }
        $location = ['name' => $place['name'], 'lat' => data_get($place, 'coordinates.lat'), 'lng' => data_get($place, 'coordinates.lng')];
        $fields = ['CITY' => 'state', 'COMMUNITY' => 'community', 'AREA' => 'community', 'SUBCOMMUNITY' => 'sub_community', 'TOWER' => 'building'];
        foreach (array_merge($place['tree'] ?? [], [$place]) as $node) {
            if (isset($fields[$node['type']])) {
                $location[$fields[$node['type']]] = $node['name'];
            }
        }
        $location['source_details'] = $place;
        \Illuminate\Support\Facades\Cache::put($cacheKey, $location, now()->addHours(12));
        return $location;
    }

    private function read($client, $path, array $query)
    {
        for ($attempt = 1; ; $attempt++) {
            try {
                $response = $client->get(self::BASE.$path, $query);
                if ($attempt === 3 || (!$response->serverError() && $response->status() !== 429)) {
                    return $response;
                }
            } catch (ConnectionException $error) {
                if ($attempt === 3) {
                    throw $error;
                }
            }
            $retryAfter = isset($response) ? (int) $response->header('Retry-After') : 0;
            sleep(max($attempt * 3, min($retryAfter, 60)));
        }
    }
}
