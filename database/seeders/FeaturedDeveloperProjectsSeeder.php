<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Property;
use App\Models\User;
use App\Models\media;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FeaturedDeveloperProjectsSeeder extends Seeder
{
    public function run()
    {
        $agentId = optional(
            User::where('email', 'graeme@eliteevolutionrealestate.ae')->first()
                ?: User::where('status', 'active')->where('is_agent', true)->first()
                ?: User::query()->orderBy('id')->first()
        )->id;

        $developers = Developer::whereIn('slug', ['damac', 'binghatti', 'emaar', 'nakheel'])
            ->get()
            ->keyBy('slug');

        foreach ($this->projects() as $index => $project) {
            $developer = $developers->get($project['developer']);
            if (!$developer) {
                $this->command && $this->command->warn('Skipped '.$project['title'].': developer '.$project['developer'].' is missing.');
                continue;
            }

            $property = Property::where('sync_source', 'featured-project')
                ->where('sync_id', $project['id'])
                ->first() ?: new Property();

            $property->sync_source = 'featured-project';
            $property->sync_id = $project['id'];
            $property->status = 1;
            $property->user_id = $property->user_id ?: $agentId;
            $property->developer_id = $developer->id;
            $property->reference_no = $property->reference_no ?: ('FP-'.strtoupper(str_replace('-', '', $project['id'])));
            $property->title = $project['title'];
            $property->slug = $project['id'];
            $property->description = $project['description'];
            $property->land_type = 'residential';
            $property->type = 'sale';
            $property->property_type = $project['property_type'];
            $property->completion_status = 'Off-plan';
            $property->handover_date = $project['handover'] ?? null;
            $property->layout_type = $project['units'] ?? null;
            $property->size = $project['size'] ?? null;
            $property->price = $project['price'] ?? null;
            $property->country = 'United Arab Emirates';
            $property->state = 'Dubai';
            $property->community = $project['community'];
            $property->building = $project['title'];
            $property->location = $project['community'].', Dubai';
            $property->completesearch = $project['community'].', Dubai';
            $property->is_verified = false;
            $property->is_new_project = true;
            $property->meta_title = $project['title'].' by '.$developer->name.' | Elite Evolution';
            $property->meta_description = Str::limit($project['description'], 160, '');
            $property->meta_tag = $developer->name.', '.$project['community'].', off-plan, Dubai';
            $property->save();
            Property::where('id', $property->id)->update([
                'created_at' => now()->subSeconds($index),
            ]);

            $image = $this->storeImage($project['id'], $project['image']);
            if (!$image) {
                $this->command && $this->command->warn('No image saved for '.$project['title']);
                continue;
            }

            media::updateOrCreate(
                [
                    'reference_id' => $property->id,
                    'reference_type' => 'property',
                    'caption' => 'featured',
                ],
                ['image' => $image]
            );
        }
    }

    private function storeImage($syncId, $url)
    {
        $directory = public_path('images/media/featured');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $existing = glob($directory.'/'.$syncId.'.*');
        if ($existing && is_file($existing[0]) && filesize($existing[0]) > 1000) {
            return 'featured/'.basename($existing[0]);
        }

        try {
            $response = (new Client([
                'timeout' => 45,
                'http_errors' => false,
                'headers' => ['User-Agent' => 'Mozilla/5.0'],
            ]))->get($url);
        } catch (\Throwable $exception) {
            return null;
        }

        $body = (string) $response->getBody();
        if ($response->getStatusCode() >= 400 || strlen($body) < 1000) {
            return null;
        }

        $extension = 'jpg';
        if (substr($body, 0, 8) === "\x89PNG\r\n\x1a\n") {
            $extension = 'png';
        } elseif (substr($body, 0, 4) === 'RIFF') {
            $extension = 'webp';
        }

        $relative = 'featured/'.$syncId.'.'.$extension;
        file_put_contents($directory.'/'.$syncId.'.'.$extension, $body);

        return $relative;
    }

    private function projects()
    {
        $projects = array_merge(
            $this->damac(),
            $this->binghatti(),
            $this->emaar(),
            $this->nakheel()
        );

        return $projects;
    }

    private function damac()
    {
        return [
            $this->row('damac', 'damac-sorrento', 'Sorrento', 'DAMAC Lagoons', 'Apartment', 680000, 'Studios and 1 bedroom apartments', null, null,
                'Sorrento is DAMAC’s studio and one-bedroom collection inside DAMAC Lagoons. Launch pricing starts from AED 680,000 on a 50/50 payment plan. Ask us which lagoon-facing units are still open.',
                'https://images.ctfassets.net/zoq5l15g49wj/01zrOyPuujR4Kv8KDuDmnD/d1b0b4cc1b4c0802aaf2e671f641de29/DAMAC_Lagoon_Views_Sorrento-Homepage_Hero_9x16.jpg'),
            $this->row('damac', 'damac-islands-2', 'DAMAC Islands 2', 'Dubailand', 'Villa', 2990000, '4 and 5 bedroom villas and townhouses', 'Q2 2030', 'Up to 3,159 sq.ft',
                'DAMAC Islands 2 is a waterfront villa and townhouse community in Dubailand, planned around eight tropical island districts. Prices start from AED 2,990,000, with handover quoted from Q2 2030.',
                'https://images.ctfassets.net/zoq5l15g49wj/6KZ7kQxb0ZPzNJEvYLXEO9/c0b6f1ffbcdc3693387e95301ce88045/DAMAC_Islands_2-Homepage_Hero_9x16.jpg'),
            $this->row('damac', 'damac-azure-2', 'Azure 2', 'Dubai Investment Park', 'Apartment', null, '1 and 2 bedroom apartments', 'Q1 2029', 'Up to 1,512 sq.ft',
                'Azure 2 is an apartment cluster in DAMAC Riverside at Dubai Investment Park. DAMAC is releasing one and two bedroom homes, with handover quoted for Q1 2029. Ask us for the current launch price.',
                'https://images.ctfassets.net/zoq5l15g49wj/9KdIztI3bv5N3ndJeRxvy/d6295383558a89716f2c671edffe8d5b/703270586-653x685-en.jpg'),
            $this->row('damac', 'damac-chelsea-residences', 'Chelsea Residences', 'Dubai Maritime City', 'Apartment', null, '1, 2 and 3 bedroom apartments', null, null,
                'Chelsea Residences is DAMAC’s Chelsea Football Club address in Dubai Maritime City, with more than 1,400 sea-view apartments. Ask us for the latest release price and payment schedule.',
                'https://images.ctfassets.net/zoq5l15g49wj/6yEN3dxHhcEXWPV4ZGIVFE/a7ffe7ba706485f98bbff7d6c9537849/Chelsea_Residences-Homepage_Hero_9x16.jpg'),
            $this->row('damac', 'damac-safa-gate', 'Safa Gate', 'Sheikh Zayed Road', 'Apartment', null, '1, 2 and 3 bedroom apartments', 'Q4 2029', 'Up to 3,145 sq.ft',
                'Safa Gate is a DAMAC tower on Sheikh Zayed Road, beside Safa Park. One to three bedroom apartments are planned, with handover quoted for Q4 2029.',
                'https://images.ctfassets.net/zoq5l15g49wj/5sBfkGZYp1LddKfIlkMUBy/d942ef42a83769da01112e0ec7fde267/en_2.jpg'),
            $this->row('damac', 'damac-couture-by-cavalli', 'Couture by Cavalli', 'Dubai Canal', 'Apartment', null, '3 to 5 bedroom apartments and 6 bedroom penthouses', 'Q2 2027', null,
                'Couture by Cavalli is DAMAC’s Roberto Cavalli tower on Dubai Canal at Safa Park. The release covers three to five bedroom apartments and six bedroom penthouses, with handover quoted for Q2 2027 and a 60/40 payment plan.',
                'https://images.ctfassets.net/zoq5l15g49wj/TAU2Aps7xVGuiOlk6aUmo/8dfabceb4522b6196c7e0f77cab5d669/ProjectPage-653x685-EN.jpg'),
        ];
    }

    private function binghatti()
    {
        $rows = [
            ['binghatti-starfall', 'Binghatti Starfall', 'Al Jaddaf', 759999, 'Studio, 1 and 2 bedroom', 'Apartment', 'binghatti-starfall-hero-banner.webp'],
            ['binghatti-spectre', 'Binghatti Spectre', 'Al Jaddaf', 774999, 'Studio, 1, 2 and 3 bedroom', 'Apartment', 'binghatti-spectre-new-hero-banner.webp'],
            ['binghatti-wraith', 'Binghatti Wraith', 'Al Jaddaf', 799999, 'Studio, 1, 2 and 3 bedroom', 'Apartment', 'binghatti-wraith-hero-banner-new.webp'],
            ['binghatti-tilal', 'Tilal Binghatti', 'Academic City', 4200000, '4, 5, 6 and 7 bedroom', 'Villa', 'tilal-binghatti-hero-banner.webp'],
            ['binghatti-etherea', 'Binghatti Etherea', 'Jumeirah Village Circle', 764999, 'Studio, 1 and 2 bedroom', 'Apartment', 'binghatti-etheria-hero-banner.webp'],
            ['binghatti-luxuria', 'Binghatti Luxuria', 'Jumeirah Village Triangle', 766999, 'Studio, 1 and 2 bedroom', 'Apartment', 'binghatti-luxuria-hero-banner.webp'],
            ['binghatti-skyflame', 'Binghatti Skyflame', 'Majan', 585000, 'Studio, 1 and 2 bedroom', 'Apartment', 'binghatti-skyflame-hero-banner.webp'],
            ['binghatti-cullinan', 'Binghatti Cullinan', 'Al Jaddaf', 819999, 'Studio, 1, 2 and 3 bedroom', 'Apartment', 'binghatti-cullinan-hero-banner.webp'],
            ['binghatti-skyterraces', 'Binghatti Skyterraces', 'Motor City', 774999, 'Studio, 1, 2 and 3 bedroom', 'Apartment', 'binghatti-skyterraces-hero-banner.webp'],
            ['binghatti-vintage', 'Binghatti Vintage', 'Majan', 674999, 'Studio, 1 and 2 bedroom', 'Apartment', 'binghatti-vintage-hero-banner.webp'],
            ['binghatti-titania', 'Binghatti Titania', 'Majan', 679999, 'Studio, 1 and 2 bedroom', 'Apartment', 'binghatti-titania-hero-banner-1.webp'],
            ['binghatti-hillcrest', 'Binghatti Hillcrest', 'Arjan', 799999, 'Studio, 1 and 2 bedroom', 'Apartment', 'binghatti-hillcrest-hero-banner.webp'],
            ['binghatti-hillviews', 'Binghatti Hillviews', 'Dubai Science Park', 800000, 'Studio, 1 and 2 bedroom', 'Apartment', 'hillviews_horizontal.jpg'],
            ['binghatti-ghost', 'Binghatti Ghost', 'Al Jaddaf', 830000, 'Studio, 1, 2 and 3 bedroom', 'Apartment', 'ghost_horizontal.jpg'],
            ['binghatti-skyblade', 'Binghatti Skyblade', 'Downtown Dubai', 1674999, 'Studio, 1, 2 and 3 bedroom', 'Apartment', 'binghatti-skyblade-hero-banner.webp'],
            ['binghatti-flare', 'Binghatti Flare', 'Jumeirah Village Triangle', 800000, 'Studio, 1, 2, 3 and 4 bedroom', 'Apartment', 'binghatti-flare-hero-banner-new.webp'],
            ['binghatti-moonlight', 'Binghatti Moonlight', 'Al Jaddaf', 1429999, '1, 2 and 3 bedroom', 'Apartment', 'binghatti-moonlight-hero-banner-new.webp'],
            ['binghatti-circle', 'Binghatti Circle', 'Jumeirah Village Circle', 674999, 'Studio, 1, 2 and 3 bedroom', 'Apartment', 'binghatti-circle-hero-banner-new.webp'],
            ['binghatti-twilight', 'Binghatti Twilight', 'Al Jaddaf', 1299000, '1, 2 and 3 bedroom', 'Apartment', 'binghatti-twilight-hero-banner.webp'],
            ['binghatti-aquarise', 'Binghatti Aquarise', 'Business Bay', 999999, 'Studio, 1, 2, 3 and 4 bedroom', 'Apartment', 'aquarise-horizontal.webp'],
            ['binghatti-starlight', 'Binghatti Starlight', 'Al Jaddaf', 850000, 'Studio, 1 and 2 bedroom', 'Apartment', 'starlight_horizontal.jpg'],
            ['binghatti-skyhall', 'Binghatti Skyhall', 'Business Bay', 985000, 'Studio and 1 bedroom', 'Apartment', 'binghatti-skyhall-hero-banner.webp'],
            ['binghatti-amberhall', 'Binghatti Amberhall', 'Jumeirah Village Circle', 1000000, 'Studio, 1 and 2 bedroom', 'Apartment', 'binghatti-amberhall-hero-banner.webp'],
            ['binghatti-hillside', 'Binghatti Hillside', 'Dubai Science Park', 774999, 'Studio and 1 bedroom', 'Apartment', 'binghatti-hillside-hero-banner-new.webp'],
            ['binghatti-haven', 'Binghatti Haven', 'Dubai Sports City', 715000, 'Studio, 1, 2 and 3 bedroom', 'Apartment', 'haven_horizontal.jpg'],
            ['binghatti-ruby', 'Binghatti Ruby', 'Jumeirah Village Circle', 700000, 'Studio, 1 and 2 bedroom', 'Apartment', 'ruby_horizontal.jpg'],
            ['binghatti-elite', 'Binghatti Elite', 'Dubai Production City', 600000, 'Studio and 1 bedroom', 'Apartment', 'elite_horizontal.jpg'],
            ['binghatti-skyrise', 'Binghatti Skyrise', 'Business Bay', 1050000, 'Studio, 1, 2 and 3 bedroom', 'Apartment', 'skyrise_horizontal.jpg'],
            ['binghatti-grove', 'Binghatti Grove', 'Jumeirah Village Circle', 1200000, '1, 2 and 3 bedroom', 'Apartment', 'grove_horizontal.jpg'],
            ['binghatti-dawn', 'Dawn by Binghatti', 'Jumeirah Village Circle', 750000, 'Studio, 1 and 2 bedroom', 'Apartment', 'dawn_horizontal.jpg'],
            ['binghatti-ivory', 'Binghatti Ivory', 'Al Jaddaf', 830000, 'Studio, 1 and 2 bedroom', 'Apartment', 'ivory_horizontal.jpg'],
            ['binghatti-dusk', 'Binghatti Dusk', 'Jumeirah Village Circle', 750000, 'Studio and 1 bedroom', 'Apartment', 'dusk_horizontal.jpg'],
            ['binghatti-royale', 'Binghatti Royale', 'Jumeirah Village Circle', 1200000, '1, 2 and 3 bedroom', 'Apartment', 'royale_horizontal.jpg'],
            ['binghatti-pinnacle', 'Binghatti Pinnacle', 'Al Jaddaf', 1449999, '1, 2 and 3 bedroom', 'Apartment', 'binghatti-pinnacle-hero-banner.webp'],
            ['one-by-binghatti', 'One by Binghatti', 'Business Bay', 2000000, 'Studio, 1, 2, 3 and 4 bedroom', 'Apartment', 'obb_horizontal.jpg'],
            ['binghatti-aurora', 'Binghatti Aurora', 'Jumeirah Village Circle', 700000, 'Studio, 1 and 2 bedroom', 'Apartment', 'aurora_horizontal.jpg'],
            ['binghatti-phoenix', 'Binghatti Phoenix', 'Jumeirah Village Circle', 700000, 'Studio, 1 and 2 bedroom', 'Apartment', 'phoenix_horizontal.jpg'],
            ['binghatti-hills', 'Binghatti Hills', 'Dubai Science Park', 800000, 'Studio, 1 and 2 bedroom', 'Apartment', 'binghatti-hills.webp'],
            ['mercedes-benz-places-binghatti-city', 'Mercedes-Benz Places | Binghatti City', 'Nad Al Sheba', 1599999, 'Studio to 5 bedroom', 'Apartment', 'mbp-bc-hero-banner.webp'],
            ['mercedes-benz-places-binghatti', 'Mercedes-Benz Places | Binghatti', 'Downtown Dubai', 11299999, '2, 3 and 4 bedroom', 'Apartment', 'mercedes-benz-places-branded-project.webp'],
            ['burj-binghatti-jacob-co', 'Burj Binghatti Jacob & Co Residences', 'Business Bay', 13999999, '2, 3 and 4 bedroom', 'Apartment', 'burj-binghatti-jacob-co-residences-branded-project.webp'],
            ['bugatti-residences-binghatti', 'Bugatti Residences by Binghatti', 'Business Bay', 36600000, '3, 4 and 5 bedroom apartments and penthouses', 'Apartment', 'bugatti-residences-by-binghatti-branded-project.webp'],
        ];

        $projects = [];
        foreach ($rows as $row) {
            $projects[] = $this->row(
                'binghatti',
                $row[0],
                $row[1],
                $row[2],
                $row[5],
                $row[3],
                $row[4],
                null,
                null,
                $row[1].' is an off-plan Binghatti project in '.$row[2].'. Published starting prices begin at AED '.number_format($row[3]).' for '.$row[4].' homes. Ask us which units and payment plans are open.',
                'https://binghattiweb.imgix.net/'.$row[6].'?auto=format,compress&q=70&w=1600&fit=max'
            );
        }

        return $projects;
    }

    private function emaar()
    {
        return [
            $this->row('emaar', 'emaar-rosewater', 'Rosewater', 'Dubai Creek Harbour', 'Apartment', null, '1 to 4 bedroom apartments', null, null,
                'Rosewater is Emaar’s apartment cluster at Creek Beach in Dubai Creek Harbour, with homes arranged around an inner plaza a short walk from the beach. Ask us for the current release price.',
                'https://cdn.prod.website-files.com/67fe61c09dc21807f91c90fc/6a61ba1f51888e1a3fbeae6a_ROSEWATER_CREEK_BEACH_EMAAR_2.jpg'),
            $this->row('emaar', 'emaar-elvira', 'Elvira', 'Dubai Hills Estate', 'Townhouse', 1200000, '1 to 3 bedroom', null, null,
                'Elvira is an Emaar release in Dubai Hills Estate. Published pricing starts from AED 1,200,000 for one to three bedroom homes.',
                'https://cdn.prod.website-files.com/67fe61c09dc21807f91c90fc/6a61ba1d4199f365847eb7f4_DHE_ELVIRA_RENDERS3.jpg'),
            $this->row('emaar', 'emaar-address-villas-tierra', 'Address Villas Tierra', 'The Oasis', 'Villa', 13160000, '4 to 6 bedroom villas', null, null,
                'Address Villas Tierra is an Address-branded villa release in The Oasis by Emaar. Published pricing starts from AED 13,160,000 for four to six bedroom villas.',
                'https://cdn.prod.website-files.com/67fe61c09dc21807f91c90fc/6a61ba1e5a6755245efaa5f2_ADDRESS_VILLAS_TIERRA_TS_BR9.jpg'),
            $this->row('emaar', 'emaar-park-horizon', 'Park Horizon', 'Dubai Hills Estate', 'Apartment', 1320000, '1 to 3 bedroom apartments', null, null,
                'Park Horizon is an Emaar apartment release in Dubai Hills Estate. The current published starting price is AED 1,320,000.',
                'https://cdn.prod.website-files.com/67fe61c09dc21807f91c90fc/6a61ba1d5a6755245efaa5b4_PARK_HORIZON_DHE_RENDERS5.jpg'),
            $this->row('emaar', 'emaar-the-heights', 'The Heights', 'The Heights', 'Villa', null, '4 bedroom homes', null, null,
                'The Heights is an Emaar villa community. The current phase includes four bedroom homes. Ask us for the release price and which plots are still available.',
                'https://cdn.prod.website-files.com/67fe61c09dc21807f91c90fc/6a61ba1d51888e1a3fbeae1f_THE_HEIGHTS_4br_type_c_back_the_heights_3D_render_by_VV.jpg'),
            $this->row('emaar', 'emaar-golf-lane', 'Golf Lane', 'Emaar South', 'Townhouse', null, 'Golf-facing homes', null, null,
                'Golf Lane is an Emaar South collection set along the golf course. Ask us for the current unit mix, price and handover.',
                'https://cdn.prod.website-files.com/67fe61c09dc21807f91c90fc/6a60a73b189100d6493c53fe_BRANDED%20IMAGES3.jpg'),
            $this->row('emaar', 'emaar-mareva', 'Mareva', 'The Oasis', 'Villa', null, '4 to 6 bedroom villas', null, null,
                'Mareva is a villa collection in The Oasis by Emaar, with four to six bedroom homes. Ask us for the current starting price.',
                'https://cdn.prod.website-files.com/67fe61c09dc21807f91c90fc/6a61ba1d83fdca4fd1cd3ca3_MAREVA_OASIS_BR.jpg'),
            $this->row('emaar', 'emaar-palace-residences-north', 'Palace Residences North', 'Dubai Creek Harbour', 'Apartment', 1230000, '1 to 3 bedroom apartments', null, null,
                'Palace Residences North is Emaar’s Palace apartment release in Dubai Creek Harbour. Published pricing starts from AED 1,230,000 for one to three bedroom homes.',
                'https://cdn.prod.website-files.com/67fe61c09dc21807f91c90fc/6a61ba1e9a4570eb40285541_PALACE_RESIDENCES_NORTH_DCH_RENDERS1jpg.jpg'),
        ];
    }

    private function nakheel()
    {
        return [
            $this->row('nakheel', 'nakheel-palm-central', 'Palm Central Private Residences', 'Palm Jumeirah', 'Apartment', null, 'Resort-style apartments', null, null,
                'Palm Central Private Residences is a Nakheel launch of resort-style homes across three buildings on Palm Jumeirah. Ask us for availability and the current payment plan.',
                'https://www.nakheel.com/images/nakheelcorporatelibraries/spotlight/palm-central-private-residences_banner.jpg'),
            $this->row('nakheel', 'nakheel-palm-springs', 'Palm Springs', 'Palm Springs', 'Villa', null, 'Contemporary homes', null, null,
                'Palm Springs is a new Nakheel community of contemporary homes with landscaped open space. Ask us for the unit mix and launch price.',
                'https://www.nakheel.com/images/nakheelcorporatelibraries/palm-springs/project-banner-_-desktop-1920-1080.jpg'),
            $this->row('nakheel', 'nakheel-bay-estate', 'Bay Estate', 'Dubai Islands', 'Villa', null, 'Waterfront homes and plots', null, null,
                'Bay Estate is Nakheel’s waterfront collection of homes and plots on a private island setting at Dubai Islands. Ask us which plots and homes are released.',
                'https://www.nakheel.com/images/nakheelcorporatelibraries/bay-estate/bay-estate_banner.jpg'),
            $this->row('nakheel', 'nakheel-bay-grove', 'Bay Grove Residences', 'Dubai Islands', 'Apartment', null, 'Waterfront residences', null, null,
                'Bay Grove Residences is a Nakheel waterfront residential release on Dubai Islands. Ask us for the current apartment mix and price.',
                'https://www.nakheel.com/images/nakheelcorporatelibraries/developments/projects/bay-grove-residences.jpg'),
            $this->row('nakheel', 'nakheel-como-residences', 'Como Residences', 'Palm Jumeirah', 'Apartment', null, '76 private residences', null, null,
                'Como Residences is Nakheel’s collection of 76 private residences on Palm Jumeirah. Ask us which homes are still available.',
                'https://www.nakheel.com/images/nakheelcorporatelibraries/developments/projects/como-residencesba2d50b8-c2c1-4897-9ca6-c26cdba91c08.jpg'),
            $this->row('nakheel', 'nakheel-district-one-west', 'District One West', 'District One', 'Villa', null, 'Lagoon residences', null, null,
                'District One West is Nakheel’s waterfront release on the crystal lagoon at District One in Mohammed Bin Rashid City. Ask us for villa availability.',
                'https://www.nakheel.com/images/nakheelcorporatelibraries/developments/district-one-west-banner.jpg'),
            $this->row('nakheel', 'nakheel-bay-villas', 'Bay Villas', 'Dubai Islands', 'Villa', null, 'Waterfront villas', null, null,
                'Bay Villas is a Nakheel villa release on Dubai Islands, between the beach and the landscaped parks. Ask us for the current plot and price list.',
                'https://www.nakheel.com/images/nakheelcorporatelibraries/construction-updates/bay-villas_banner1_apr-26.jpg'),
            $this->row('nakheel', 'nakheel-palm-jebel-ali', 'Palm Jebel Ali', 'Palm Jebel Ali', 'Villa', null, 'Waterfront villas and apartments', null, null,
                'Palm Jebel Ali is Nakheel’s new palm island, with waterfront villas and apartments still being released. Ask us which fronds and buildings are on sale.',
                'https://www.nakheel.com/images/nakheelcorporatelibraries/construction-updates/palm-jebel-ali_banner1_apr-26.jpg'),
            $this->row('nakheel', 'nakheel-rixos-dubai-islands', 'Rixos Dubai Islands', 'Dubai Islands', 'Apartment', null, 'Hotel and residences', null, null,
                'Rixos Dubai Islands is Nakheel’s beachfront hotel and residence on Dubai Islands, with a long beach frontage. Ask us about the branded residences still for sale.',
                'https://www.nakheel.com/images/nakheelcorporatelibraries/spotlight/new-launches/rixos-hotel-residences-dubai-islands1c0182b5-0180-4e40-870a-67e161a56cb0.jpg'),
            $this->row('nakheel', 'nakheel-naya-residences', 'Naya Residences', 'District One', 'Villa', null, 'Lagoon villas', null, null,
                'Naya Residences is Nakheel’s villa release at District One in Mohammed Bin Rashid City. Ask us for the current lagoon-facing availability.',
                'https://www.nakheel.com/images/nakheelcorporatelibraries/construction-updates/naya_banner1_apr-26.jpg'),
        ];
    }

    private function row($developer, $id, $title, $community, $propertyType, $price, $units, $handover, $size, $description, $image)
    {
        return [
            'developer' => $developer,
            'id' => $id,
            'title' => $title,
            'community' => $community,
            'property_type' => $propertyType,
            'price' => $price,
            'units' => $units,
            'handover' => $handover,
            'size' => $size,
            'description' => $description,
            'image' => $image,
        ];
    }
}
