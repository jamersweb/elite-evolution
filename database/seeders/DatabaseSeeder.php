<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Developer;
use App\Models\Property;
use App\Models\Amenities;
use App\Models\media;
use App\Models\blog;
use App\Models\Leads;
use App\Models\PropertyInquiry;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Roles and Permissions
        $permissions = [
            'dashboard-permission',
            'property-list',
            'property-create',
            'property-edit',
            'property-delete',
            'property-sidebar',
            'leads-list',
            'leads-create',
            'leads-edit',
            'leads-delete',
            'leads-sidebar',
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
            'post-sidebar',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-sidebar',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'roles-and-permission-sidebar',
            'requests',
            'newsletter-subscriber',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        $agentRole = Role::firstOrCreate(['name' => 'agent', 'guard_name' => 'web']);
        $agentRole->syncPermissions([
            'dashboard-permission',
            'property-list',
            'property-create',
            'property-edit',
            'property-sidebar',
            'leads-list',
            'leads-sidebar',
            'post-list',
            'post-sidebar',
        ]);

        $eliteAgentRole = Role::firstOrCreate(['name' => 'eliteagent', 'guard_name' => 'web']);
        $eliteAgentRole->syncPermissions([
            'dashboard-permission',
            'property-list',
            'property-create',
            'property-edit',
            'property-delete',
            'property-sidebar',
            'leads-list',
            'leads-create',
            'leads-edit',
            'leads-sidebar',
            'post-list',
            'post-sidebar',
        ]);

        Role::firstOrCreate(['name' => 'User', 'guard_name' => 'web']);

        // 2. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@eliteevolutionrealestate.ae'],
            [
                'name' => 'Elite Evolution Admin',
                'slug' => 'elite-evolution-admin',
                'password' => Hash::make('password123'),
                'phone' => '+971 4 555 8899',
                'whatsapp_no' => '97145558899',
                'status' => 'active',
                'is_agent' => false,
            ]
        );
        $admin->assignRole($adminRole);

        // 3. Licensed Agents (Compliance & Public Directory)
        $agentsData = [
            [
                'name' => 'Graeme Stewart',
                'slug' => 'graeme',
                'email' => 'graeme@eliteevolutionrealestate.ae',
                'phone' => '+971 56 970 0771',
                'whatsapp_no' => '971569700771',
                'brn' => '78334',
                'experience' => '8+ Years in Prime Dubai Real Estate',
                'occupation' => 'Senior Luxury Property Advisor',
                'about' => 'Specializing in ultra-prime residential assets, waterfront villas in Palm Jumeirah, and bespoke off-plan investments across Dubai\'s most coveted communities including DAMAC Lagoons and Emirates Hills. Graeme delivers discreet, institutional-grade advisory for private clients and international family offices.',
                'languages' => ['English', 'French'],
                'areas' => ['Palm Jumeirah', 'DAMAC Lagoons', 'Dubai Marina', 'Emirates Hills'],
                'nationality' => 'British',
                'image' => 'graeme.jpg',
            ],
            [
                'name' => 'Alexander Wright',
                'slug' => 'alexander-wright',
                'email' => 'alexander@eliteevolutionrealestate.ae',
                'phone' => '+971 50 123 4567',
                'whatsapp_no' => '971501234567',
                'brn' => '52410',
                'experience' => '8 Years in UAE Luxury Real Estate',
                'occupation' => 'Senior Luxury Property Advisor',
                'about' => 'Specializing in ultra-luxury beachfront villas on Palm Jumeirah and private estates across Emirates Hills. Alexander provides discreet, high-net-worth portfolio management.',
                'languages' => ['English', 'Russian'],
                'areas' => ['Palm Jumeirah', 'Emirates Hills'],
                'nationality' => 'British',
            ],
            [
                'name' => 'Layla Al-Mansoor',
                'slug' => 'layla-al-mansoor',
                'email' => 'layla@eliteevolutionrealestate.ae',
                'phone' => '+971 52 987 6543',
                'whatsapp_no' => '971529876543',
                'brn' => '48923',
                'experience' => '6 Years in Prime Dubai Residential',
                'occupation' => 'Associate Director - Private Client Advisory',
                'about' => 'Expert advisor in off-plan luxury launches, prime Jumeirah Islands residences, and branded Downtown penthouses. Fluent in Arabic, English, and French.',
                'languages' => ['Arabic', 'English', 'French'],
                'areas' => ['Jumeirah Islands', 'Downtown Dubai'],
                'nationality' => 'Emirati',
            ],
            [
                'name' => 'Marcus Sterling',
                'slug' => 'marcus-sterling',
                'email' => 'marcus@eliteevolutionrealestate.ae',
                'phone' => '+971 54 555 7890',
                'whatsapp_no' => '971545557890',
                'brn' => '61084',
                'experience' => '5 Years in Dubai Waterfront Properties',
                'occupation' => 'Waterfront & Luxury Rentals Specialist',
                'about' => 'Dedicated to high-end waterfront mansions and exclusive luxury rentals across Dubai Harbour, Palm Jumeirah, and Bluewaters Island.',
                'languages' => ['English', 'German'],
                'areas' => ['Dubai Marina', 'Palm Jumeirah', 'Bluewaters'],
                'nationality' => 'German',
            ]
        ];

        $createdAgents = [];
        foreach ($agentsData as $aData) {
            $agent = User::firstOrCreate(
                ['email' => $aData['email']],
                [
                    'name' => $aData['name'],
                    'slug' => $aData['slug'] ?? Str::slug($aData['name']),
                    'password' => Hash::make('password123'),
                    'phone' => $aData['phone'],
                    'whatsapp_no' => $aData['whatsapp_no'],
                    'brn' => $aData['brn'],
                    'experience' => $aData['experience'],
                    'occupation' => $aData['occupation'],
                    'about' => $aData['about'],
                    'language_multi_select' => json_encode($aData['languages']),
                    'area_tags' => json_encode($aData['areas']),
                    'nationality' => $aData['nationality'],
                    'image' => $aData['image'] ?? null,
                    'status' => 'active',
                    'is_agent' => true,
                ]
            );
            $agent->assignRole($agentRole);
            $createdAgents[] = $agent;
        }

        // 4. Developers
        $developers = [
            ['name' => 'Nakheel', 'slug' => 'nakheel', 'description' => 'World-leading master developer behind iconic projects like Palm Jumeirah and the upcoming Palm Jebel Ali.'],
            ['name' => 'Emaar Properties', 'slug' => 'emaar', 'description' => 'Global developer of Burj Khalifa, Downtown Dubai, and master-planned luxury golf communities.'],
            ['name' => 'Meraas', 'slug' => 'meraas', 'description' => 'Creator of urban lifestyle destinations including Bluewaters Island, Bulgari Residences, and City Walk.'],
            ['name' => 'Sobha Realty', 'slug' => 'sobha', 'description' => 'Renowned for in-house craft and architectural mastery in Sobha Hartland and luxury canal-side towers.'],
            ['name' => 'New Evolution Property Development', 'slug' => 'new-evolution-property-development', 'description' => 'Bespoke residential design studio known for fully renovated luxury villas across Jumeirah Islands and prime Dubai communities.'],
        ];

        $createdDevs = [];
        foreach ($developers as $dev) {
            $createdDevs[] = Developer::firstOrCreate(
                ['slug' => $dev['slug']],
                [
                    'name' => $dev['name'],
                    'description' => $dev['description'],
                    'status' => 1,
                    'user_id' => $admin->id,
                ]
            );
        }

        // 5. Amenities
        $amenityList = [
            'Private Swimming Pool',
            'Private Beach Access',
            'Full Sea & Skyline View',
            'Smart Home Automation',
            'Maid\'s & Driver\'s Quarters',
            'Walk-in Dressing Room',
            'Fully Equipped Miele Kitchen',
            'Private Elevator',
            'Covered Multi-Car Garage',
            '24/7 Security & Concierge',
            'Landscaped Zen Garden',
            'Private Cinema Room',
            'Outdoor BBQ & Pergola',
            'Glass Pavilion Dining',
        ];

        $amenityIds = [];
        foreach ($amenityList as $title) {
            $amenity = Amenities::firstOrCreate(['title' => $title]);
            $amenityIds[] = $amenity->id;
        }

        // 6. Verified Properties with Trakheesi Permit & Madmoun Compliance
        $properties = [
            [
                'title' => 'Signature Beachfront Villa, Palm Jumeirah',
                'slug' => 'signature-beachfront-villa-palm-jumeirah',
                'reference_no' => 'EERE-V-101',
                'trakheesi_permit_no' => '7123984501',
                'permit_qr_image' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https%3A%2F%2Fdubailand.gov.ae%2Fpermit%2F7123984501',
                'type' => 'sale',
                'land_type' => 'residential',
                'property_type' => 'Villa',
                'completion_status' => 'Ready',
                'price' => 45000000,
                'bedrooms' => 6,
                'bathrooms' => 7,
                'parkings' => 4,
                'size' => '8,500 sq.ft',
                'build_up_area' => '9,200 sq.ft',
                'furnishing_type' => 'Furnished',
                'community' => 'Palm Jumeirah',
                'sub_community' => 'Frond N',
                'state' => 'Dubai',
                'country' => 'United Arab Emirates',
                'lat' => '25.1189',
                'lng' => '55.1386',
                'completesearch' => 'Palm Jumeirah, Frond N, Dubai',
                'description' => 'A masterpiece of contemporary coastal architecture. Situated on an exclusive Frond with direct private beach access and breathtaking sunset views across the Arabian Gulf. Features bespoke European interiors, infinity swimming pool, private elevator, and rooftop entertainment terrace.',
                'user_id' => $createdAgents[0]->id,
                'developer_id' => $createdDevs[0]->id,
                'status' => 1,
            ],
            [
                'title' => 'European Luxury Mansion, Jumeirah Islands',
                'slug' => 'european-luxury-mansion-jumeirah-islands',
                'reference_no' => 'EERE-V-102',
                'trakheesi_permit_no' => '7188204912',
                'permit_qr_image' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https%3A%2F%2Fdubailand.gov.ae%2Fpermit%2F7188204912',
                'type' => 'sale',
                'land_type' => 'residential',
                'property_type' => 'Villa',
                'completion_status' => 'Ready',
                'price' => 18500000,
                'bedrooms' => 5,
                'bathrooms' => 6,
                'parkings' => 3,
                'size' => '10,200 sq.ft',
                'build_up_area' => '7,800 sq.ft',
                'furnishing_type' => 'Furnished',
                'community' => 'Jumeirah Islands',
                'sub_community' => 'European Cluster',
                'state' => 'Dubai',
                'country' => 'United Arab Emirates',
                'lat' => '25.0560',
                'lng' => '55.1580',
                'completesearch' => 'Jumeirah Islands, European Cluster, Dubai',
                'description' => 'Completely renovated waterfront estate in the prestigious Jumeirah Islands European Cluster. Surrounded by tranquil lake vistas, lush manicured gardens, a private swimming pool, and bespoke luxury finishes throughout.',
                'user_id' => $createdAgents[1]->id,
                'developer_id' => $createdDevs[0]->id,
                'status' => 1,
            ],
            [
                'title' => 'Contemporary Lakeview Villa, Jumeirah Islands',
                'slug' => 'contemporary-lakeview-villa-jumeirah-islands',
                'reference_no' => 'EERE-V-103',
                'trakheesi_permit_no' => '7190412845',
                'permit_qr_image' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https%3A%2F%2Fdubailand.gov.ae%2Fpermit%2F7190412845',
                'type' => 'sale',
                'land_type' => 'residential',
                'property_type' => 'Villa',
                'completion_status' => 'Ready',
                'price' => 16800000,
                'bedrooms' => 4,
                'bathrooms' => 5,
                'parkings' => 2,
                'size' => '8,800 sq.ft',
                'build_up_area' => '6,400 sq.ft',
                'furnishing_type' => 'Unfurnished',
                'community' => 'Jumeirah Islands',
                'sub_community' => 'Oasis Cluster',
                'state' => 'Dubai',
                'country' => 'United Arab Emirates',
                'lat' => '25.0530',
                'lng' => '55.1610',
                'completesearch' => 'Jumeirah Islands, Oasis Cluster, Dubai',
                'description' => 'Sunlit modern villa overlooking serene waters. High ceilings, open-concept Italian chef kitchen, floor-to-ceiling glass sliding doors opening directly to the private pool terrace.',
                'user_id' => $createdAgents[1]->id,
                'developer_id' => $createdDevs[0]->id,
                'status' => 1,
            ],
            [
                'title' => 'Exclusive Beachfront Villa, Palm Jumeirah Luxury Rental',
                'slug' => 'exclusive-beachfront-villa-palm-jumeirah-luxury-rental',
                'reference_no' => 'EERE-R-201',
                'trakheesi_permit_no' => '7133901248',
                'permit_qr_image' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https%3A%2F%2Fdubailand.gov.ae%2Fpermit%2F7133901248',
                'type' => 'rent',
                'land_type' => 'residential',
                'property_type' => 'Villa',
                'completion_status' => 'Ready',
                'price' => 1200000,
                'yearly_rent' => 1200000,
                'cheques' => 2,
                'deposit' => 120000,
                'bedrooms' => 5,
                'bathrooms' => 6,
                'parkings' => 3,
                'size' => '7,000 sq.ft',
                'build_up_area' => '6,500 sq.ft',
                'furnishing_type' => 'Furnished',
                'community' => 'Palm Jumeirah',
                'sub_community' => 'Frond F',
                'state' => 'Dubai',
                'country' => 'United Arab Emirates',
                'lat' => '25.1160',
                'lng' => '55.1320',
                'completesearch' => 'Palm Jumeirah, Frond F, Dubai',
                'description' => 'Prestigious high-end rental property for discerning VIP clients. Fully furnished with designer interiors, private pool, maid room, and uninterrupted beach access.',
                'user_id' => $createdAgents[2]->id,
                'developer_id' => $createdDevs[0]->id,
                'status' => 1,
            ],
            [
                'title' => 'Palm Jebel Ali Waterfront Haven, Off-Plan',
                'slug' => 'palm-jebel-ali-waterfront-haven-off-plan',
                'reference_no' => 'EERE-OP-301',
                'trakheesi_permit_no' => '7199501233',
                'permit_qr_image' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https%3A%2F%2Fdubailand.gov.ae%2Fpermit%2F7199501233',
                'type' => 'sale',
                'land_type' => 'residential',
                'property_type' => 'Villa',
                'completion_status' => 'Off-plan',
                'handover_date' => 'Q4 2027',
                'price' => 22000000,
                'bedrooms' => 6,
                'bathrooms' => 7,
                'parkings' => 4,
                'size' => '11,000 sq.ft',
                'build_up_area' => '8,500 sq.ft',
                'furnishing_type' => 'Unfurnished',
                'community' => 'Palm Jebel Ali',
                'sub_community' => 'Beach Collection',
                'state' => 'Dubai',
                'country' => 'United Arab Emirates',
                'lat' => '25.0020',
                'lng' => '54.9850',
                'completesearch' => 'Palm Jebel Ali, Beach Collection, Dubai',
                'description' => 'The next era of luxury Dubai real estate. Groundbreaking architectural design on the brand new Palm Jebel Ali archipelago, offering generous plot sizes and world-class waterfront living.',
                'user_id' => $createdAgents[1]->id,
                'developer_id' => $createdDevs[0]->id,
                'is_new_project' => 1,
                'status' => 1,
            ],
            [
                'title' => 'Venice Luxury Waterfront Villa, DAMAC Lagoons',
                'slug' => 'venice-luxury-waterfront-villa-damac-lagoons',
                'reference_no' => 'EERE-V-104',
                'trakheesi_permit_no' => '7198302144',
                'permit_qr_image' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https%3A%2F%2Fdubailand.gov.ae%2Fpermit%2F7198302144',
                'type' => 'sale',
                'land_type' => 'residential',
                'property_type' => 'Villa',
                'completion_status' => 'Off-plan',
                'handover_date' => 'Q4 2026',
                'price' => 14500000,
                'bedrooms' => 5,
                'bathrooms' => 6,
                'parkings' => 3,
                'size' => '7,200 sq.ft',
                'build_up_area' => '6,800 sq.ft',
                'furnishing_type' => 'Unfurnished',
                'community' => 'DAMAC Lagoons',
                'sub_community' => 'Venice Cluster',
                'state' => 'Dubai',
                'country' => 'United Arab Emirates',
                'lat' => '25.0195',
                'lng' => '55.2341',
                'completesearch' => 'DAMAC Lagoons, Venice Cluster, Dubai',
                'description' => 'A masterwork of Italian-inspired waterfront architecture situated in the prestigious Venice cluster at DAMAC Lagoons. Expansive entertaining terraces, floor-to-ceiling glass, private infinity pool, and crystal lagoon views.',
                'user_id' => $createdAgents[0]->id,
                'developer_id' => $createdDevs[0]->id,
                'is_new_project' => 1,
                'status' => 1,
            ],
        ];

        foreach ($properties as $propData) {
            $propData['amenities'] = json_encode(array_slice($amenityIds, 0, 8));
            $created = Property::firstOrCreate(
                ['reference_no' => $propData['reference_no']],
                $propData
            );

            media::firstOrCreate([
                'reference_id' => $created->id,
                'reference_type' => 'property',
            ], [
                'image' => 'gallery.png',
            ]);
        }

        $this->call(ListingSeeder::class);

        // 7. Seed Sample Articles
        blog::firstOrCreate(
            ['slug' => 'dubai-real-estate-market-2026-luxury-waterfront'],
            [
                'user_id' => $admin->id,
                'title' => 'Dubai Real Estate Market 2026: The Surge of Ultra-Luxury Waterfront Assets',
                'short_description' => 'Analysis of sustained high-net-worth migration, record capital appreciation on Palm Jumeirah, and the introduction of Palm Jebel Ali.',
                'long_description' => '<p>Dubai continues to demonstrate unparalleled resilience and momentum in the global luxury property landscape. With international wealth inflows and strategic regulatory initiatives including the UAE Golden Visa, the demand for verified prime residential inventory remains at an all-time high.</p>',
                'status' => 1,
            ]
        );
    }
}
