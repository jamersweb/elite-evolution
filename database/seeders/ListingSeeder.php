<?php

namespace Database\Seeders;

use App\Models\Amenities;
use App\Models\Developer;
use App\Models\Property;
use App\Models\User;
use App\Models\media;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    public function run()
    {
        $agent = User::where('email', 'graeme@eliteevolutionrealestate.ae')->first()
            ?: User::where('is_agent', true)->first()
            ?: User::where('email', 'admin@eliteevolutionrealestate.ae')->first()
            ?: User::query()->first();

        $developer = Developer::whereIn('slug', [
            'new-evolution-property-development',
            'new-evolution',
        ])->first();

        if (!$developer) {
            $developer = Developer::create([
                'slug' => 'new-evolution-property-development',
                'name' => 'New Evolution Property Development',
                'description' => 'Bespoke residential design studio known for fully renovated luxury villas across Jumeirah Islands and prime Dubai communities.',
                'status' => 1,
                'user_id' => optional($agent)->id,
            ]);
        }

        $amenityTitles = [
            'Private Swimming Pool',
            'Smart Home Automation',
            "Maid's & Driver's Quarters",
            'Walk-in Dressing Room',
            'Fully Equipped Miele Kitchen',
            'Covered Multi-Car Garage',
            '24/7 Security & Concierge',
            'Landscaped Zen Garden',
            'Private Cinema Room',
            'Outdoor BBQ & Pergola',
            'Glass Pavilion Dining',
            'Private pool',
            'Outdoor BBQ Area',
            'Sunken Outdoor Seating',
            "Maid's Quarters",
            'Enclosed 2 Car Garage',
            'Landscaped Gardens',
            'Cinema Room',
            'Build in wardrobes',
            'Central Air Conditioning',
            'Covered Parking',
            'Swimming Pool',
        ];

        $amenityIds = Amenities::whereIn('title', $amenityTitles)
            ->pluck('id')
            ->map(function ($id) {
                return (string) $id;
            })
            ->all();

        $property = Property::updateOrCreate(
            ['reference_no' => 'EERE-V-105'],
            [
                'title' => 'New Evolution Signature Villa, Jumeirah Islands',
                'slug' => 'new-evolution-villa-jumeirah-islands',
                'type' => 'sale',
                'land_type' => 'residential',
                'property_type' => 'Villa',
                'completion_status' => 'Ready',
                'price' => null,
                'bedrooms' => 5,
                'bathrooms' => 6,
                'parkings' => 2,
                'furnishing_type' => 'Furnished',
                'community' => 'Jumeirah Islands',
                'sub_community' => 'Jumeirah Islands',
                'state' => 'Dubai',
                'country' => 'United Arab Emirates',
                'address' => 'Jumeirah Islands, Dubai',
                'lat' => '25.0574653',
                'lng' => '55.1555195',
                'completesearch' => 'Jumeirah Islands - Dubai - United Arab Emirates',
                'map' => 'https://maps.google.com/?q=Jumeirah+Islands+-+Dubai+-+United+Arab+Emirates',
                'view36' => 'https://tour.panoee.net/66f78eacae7bdf6eef86e227/66f79307ae7bdf283c86e326',
                'video' => 'https://www.instagram.com/reel/DcoGldUtvhn/',
                'description' => '<p>A fully renovated signature villa in Jumeirah Islands by New Evolution Property Development. Soft stone, warm timber, and black-framed glass open the house to a private pool garden, outdoor kitchen, and covered dining pergola.</p><p>The ground floor holds a double-height living room under a glass lantern, formal dining, a home theatre, a guest suite, and a chef kitchen with a separate dirty kitchen. Upstairs, the master suite includes a walk-in dressing room and marble bathrooms, with two further bedrooms, family living, and staff quarters.</p><ul><li>Private pool with circular sunken seating and daybeds</li><li>Outdoor BBQ kitchen and pergola dining for eight</li><li>Covered garage, LED-lit stone stair, and marble water feature at the entrance</li><li>Walk-through 3D tour and Instagram house walk-through available</li></ul>',
                'meta_title' => 'New Evolution Villa, Jumeirah Islands | Elite Evolution Real Estate',
                'meta_description' => 'Fully renovated 5-bedroom New Evolution villa in Jumeirah Islands with private pool, outdoor kitchen, 3D tour, and Instagram house walk-through. Price upon request.',
                'user_id' => optional($agent)->id,
                'developer_id' => $developer->id,
                'amenities' => json_encode(array_values(array_unique($amenityIds))),
                'is_verified' => 1,
                'status' => 1,
            ]
        );

        $attached = 0;
        for ($i = 1; $i <= 44; $i++) {
            $filename = sprintf('eere-v-105-%02d.jpg', $i);
            if (!file_exists(public_path('images/media/' . $filename))) {
                continue;
            }

            media::firstOrCreate([
                'reference_id' => (string) $property->id,
                'reference_type' => 'property',
                'image' => $filename,
            ]);
            $attached++;
        }

        if ($this->command) {
            $this->command->info("Seeded {$property->reference_no} with {$attached} photos.");
        }
    }
}
