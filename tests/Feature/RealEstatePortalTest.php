<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\Developer;

class RealEstatePortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_homepage_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Elite Evolution Real Estate');
    }

    public function test_property_listing_page_loads()
    {
        $response = $this->get('/listing/sale');
        $response->assertStatus(200);
        $response->assertSee('Properties');
    }

    public function test_luxury_rentals_page_loads()
    {
        $response = $this->get('/luxury-rentals');
        $response->assertStatus(200);
    }

    public function test_map_view_loads_successfully()
    {
        $response = $this->get('/map-view');
        $response->assertStatus(200);
        $response->assertSee('Interactive Map Search');
    }

    public function test_ready_and_offplan_listing_filters_load()
    {
        $readyRes = $this->get('/listing/ready');
        $readyRes->assertStatus(200);

        $offplanRes = $this->get('/listing/off-plan');
        $offplanRes->assertStatus(200);
    }

    public function test_cookies_policy_page_loads()
    {
        $response = $this->get('/cookies-policy');
        $response->assertStatus(200);
    }

    public function test_agents_directory_loads_and_displays_licensed_brokers()
    {
        $response = $this->get('/agents');
        $response->assertStatus(200);
        $response->assertSee('Alexander Wright');
        $response->assertSee('Graeme Highlands');
        $response->assertSee('78334'); // Graeme BRN
        $response->assertSee('52410'); // Alexander BRN
    }

    public function test_agent_detail_page_loads()
    {
        $response = $this->get('/agents/alexander-wright');
        $response->assertStatus(200);
        $response->assertSee('Alexander Wright');
    }

    public function test_graeme_direct_page_loads_with_full_profile_and_listings()
    {
        $response = $this->get('/graeme');
        $response->assertStatus(200);
        $response->assertSee('Graeme Highlands');
        $response->assertSee('78334');
        $response->assertSee('Senior Luxury Property Advisor');
        $response->assertSee('WhatsApp Advisor');
        $response->assertSee('Active Property Portfolio');
    }

    public function test_graeme_vcard_download_returns_vcf()
    {
        $response = $this->get('/graeme/vcard');
        $response->assertStatus(200);
        $this->assertStringContainsString('text/vcard', $response->headers->get('Content-Type'));
        $response->assertSee('Graeme Highlands');
        $response->assertSee('78334');
    }

    public function test_graeme_inquiry_records_crm_lead()
    {
        $response = $this->post('/graeme/inquire', [
            'name' => 'Sheikh Al-Maktoum Office',
            'email' => 'advisory@investor.ae',
            'phone' => '+971508889999',
            'message' => 'Interested in Palm Jumeirah beachfront acquisitions',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('leads', [
            'email' => 'advisory@investor.ae',
            'source' => 'Direct Agent Advisory: Graeme Highlands',
        ]);
    }

    public function test_non_existent_page_returns_404_cleanly_without_server_error()
    {
        $response = $this->get('/non-existent-page-testing-404');
        $response->assertStatus(404);
        $response->assertSee('Page Not Found');
    }

    public function test_property_detail_page_displays_compliance_fields()
    {
        $response = $this->get('/detail/signature-beachfront-villa-palm-jumeirah');
        $response->assertStatus(200);
        $response->assertSee('EERE-V-101'); // Reference number
        $response->assertSee('7123984501'); // Trakheesi Permit
    }

    public function test_new_evolution_jumeirah_islands_listing_is_published()
    {
        $response = $this->get('/detail/new-evolution-villa-jumeirah-islands');
        $response->assertStatus(200);
        $response->assertSee('EERE-V-105');
        $response->assertSee('New Evolution Signature Villa');
        $response->assertSee('Price Upon Request');
        $response->assertSee('https://tour.panoee.net/66f78eacae7bdf6eef86e227/66f79307ae7bdf283c86e326', false);
        $response->assertSee('https://www.instagram.com/reel/DcoGldUtvhn/', false);
        $response->assertSee('Jumeirah Islands');
        $this->assertTrue(
            Developer::whereIn('slug', ['new-evolution-property-development', 'new-evolution'])->exists()
        );
        $this->assertDatabaseHas('properties', [
            'reference_no' => 'EERE-V-105',
            'community' => 'Jumeirah Islands',
            'bedrooms' => 5,
            'status' => 1,
        ]);

        $developer = Developer::whereIn('slug', ['new-evolution-property-development', 'new-evolution'])->first();
        $this->get('/developer/' . $developer->slug)
            ->assertOk()
            ->assertSee('New Evolution Signature Villa');
    }

    public function test_property_description_renders_formatting_without_unsafe_markup()
    {
        $property = Property::where('reference_no', 'EERE-V-101')->first();
        $property->update([
            'description' => '<p><span style="font-weight: 400;">Underground wine cellar</span></p>'
                . '<p onclick="alert(1)">Private pool</p><script>alert(2)</script><img src=x onerror=alert(3)>',
        ]);

        $response = $this->get('/detail/' . $property->slug);

        $response->assertStatus(200);
        $response->assertSee('<p>Underground wine cellar</p>', false);
        $response->assertSee('<p>Private pool</p>', false);
        $response->assertDontSee('&lt;span', false);

        $html = $property->fresh()->description_html;
        $this->assertStringNotContainsString('onclick', $html);
        $this->assertStringNotContainsString('<img', $html);
        $this->assertStringNotContainsString('<script', $html);
    }

    public function test_home_page_shows_listings_developers_and_blog()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Featured Properties');
        $response->assertSee('Signature Beachfront Villa, Palm Jumeirah');
        $response->assertSee('Off-Plan Investments');
        $response->assertSee('Leading Developers');
        $response->assertSee('Nakheel');
        $response->assertSee('Dubai Real Estate Market 2026');
    }

    public function test_ai_concierge_chat_api_responds_with_inventory()
    {
        $response = $this->postJson('/api/concierge/chat', [
            'message' => 'Show me luxury villas on Palm Jumeirah for sale',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['reply']);
    }

    public function test_brochure_inquiry_records_lead()
    {
        $property = Property::first();
        $response = $this->post("/inquire-brochure/{$property->id}", [
            'name' => 'Test Investor',
            'email' => 'investor@example.com',
            'phone' => '+971501112233',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('property_inquiries', [
            'email' => 'investor@example.com',
            'type' => 'brochure',
        ]);
    }

    public function test_viewing_request_records_inquiry()
    {
        $property = Property::first();
        $response = $this->post("/book-viewing/{$property->id}", [
            'name' => 'VIP Client',
            'email' => 'client@example.com',
            'phone' => '+971509998877',
            'date' => '2026-10-15',
            'message' => 'Interested in an afternoon private viewing',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('property_inquiries', [
            'email' => 'client@example.com',
            'type' => 'viewing',
        ]);
    }

    public function test_admin_dashboard_loads_real_estate_kpis()
    {
        $admin = User::where('email', 'admin@eliteevolutionrealestate.ae')->first();
        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Executive Overview');
        $response->assertSee('Active Properties');
        $response->assertSee('Licensed Brokers');
    }

    public function test_admin_can_manage_licensed_agents_and_automatically_reflect_on_frontend()
    {
        $admin = User::where('email', 'admin@eliteevolutionrealestate.ae')->first();

        // 1. Directory loads in backend
        $response = $this->actingAs($admin)->get('/admin/agents');
        $response->assertStatus(200);
        $response->assertSee('Alexander Wright');
        $response->assertSee('Graeme Highlands');

        // 2. Create new licensed broker with custom slug 'fatima'
        $postRes = $this->actingAs($admin)->post('/admin/agents', [
            'name' => 'Fatima Al-Zahra',
            'slug' => 'fatima',
            'email' => 'fatima@eliteevolutionrealestate.ae',
            'password' => 'secret123',
            'phone' => '+971509876543',
            'whatsapp_no' => '971509876543',
            'brn' => '77890',
            'occupation' => 'Luxury Villa Specialist',
            'experience' => '7 Years in Dubai',
            'nationality' => 'Emirati',
            'area_tags' => 'Palm Jumeirah, Emirates Hills',
            'language_multi_select' => ['Arabic', 'English'],
            'about' => 'Specializing in beachfront estates and private luxury listings.',
            'status' => 'active',
        ]);

        $postRes->assertRedirect(route('agents.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'fatima@eliteevolutionrealestate.ae',
            'slug' => 'fatima',
            'brn' => '77890',
            'is_agent' => 1,
        ]);

        // 3. Verify it is AUTOMATICALLY showed on the public frontend directory (/agents)
        $frontAgentsRes = $this->get('/agents');
        $frontAgentsRes->assertStatus(200);
        $frontAgentsRes->assertSee('Fatima Al-Zahra');
        $frontAgentsRes->assertSee('77890');
        $frontAgentsRes->assertSee('Luxury Villa Specialist');

        // 4. Verify dedicated vanity page loads automatically on frontend (/fatima)
        $frontDetailRes = $this->get('/fatima');
        $frontDetailRes->assertStatus(200);
        $frontDetailRes->assertSee('Fatima Al-Zahra');
        $frontDetailRes->assertSee('77890');
        $frontDetailRes->assertSee('Specializing in beachfront estates');

        // 5. Edit agent details in backend
        $agent = User::where('email', 'fatima@eliteevolutionrealestate.ae')->first();
        $editPageRes = $this->actingAs($admin)->get("/admin/agents/{$agent->id}/edit");
        $editPageRes->assertStatus(200);
        $editPageRes->assertSee('Fatima Al-Zahra');

        $updateRes = $this->actingAs($admin)->put("/admin/agents/{$agent->id}", [
            'name' => 'Fatima Al-Zahra',
            'slug' => 'fatima-prime',
            'email' => 'fatima@eliteevolutionrealestate.ae',
            'phone' => '+971501112222',
            'whatsapp_no' => '971501112222',
            'brn' => '77890',
            'occupation' => 'Senior Vice President - Prime Waterfront',
            'experience' => '10 Years in Dubai Luxury',
            'nationality' => 'Emirati',
            'area_tags' => 'Palm Jumeirah, Bulgari Residences',
            'about' => 'Updated senior bio with focus on Bulgari Residences.',
            'status' => 'active',
        ]);

        $updateRes->assertRedirect(route('agents.index'));

        // 6. Verify edited details AUTOMATICALLY show on frontend (/fatima-prime)
        $updatedFrontRes = $this->get('/fatima-prime');
        $updatedFrontRes->assertStatus(200);
        $updatedFrontRes->assertSee('Senior Vice President - Prime Waterfront');
        $updatedFrontRes->assertSee('+971501112222');
        $updatedFrontRes->assertSee('Updated senior bio with focus on Bulgari Residences');

        // 7. Verify inactive agent is automatically hidden from frontend directory
        $this->actingAs($admin)->put("/admin/agents/{$agent->id}", [
            'name' => 'Fatima Al-Zahra',
            'email' => 'fatima@eliteevolutionrealestate.ae',
            'status' => 'inactive',
        ]);
        $hiddenRes = $this->get('/agents');
        $hiddenRes->assertDontSee('Senior Vice President - Prime Waterfront');
    }

    public function test_admin_can_create_property_with_dld_compliance_and_agent_assignment()
    {
        $admin = User::where('email', 'admin@eliteevolutionrealestate.ae')->first();
        $agent = User::where('email', 'alexander@eliteevolutionrealestate.ae')->first();

        $response = $this->actingAs($admin)->post('/admin/property', [
            'title' => 'Ultra Mansion Palm Jumeirah Frond G',
            'type' => 'sale',
            'land_type' => 'residential',
            'property_type' => 'Villa',
            'completion_status' => 'Ready',
            'price' => 65000000,
            'bedrooms' => 7,
            'bathrooms' => 8,
            'reference_no' => 'EERE-V-777',
            'trakheesi_permit_no' => '7199881122',
            'community' => 'Palm Jumeirah',
            'sub_community' => 'Frond G',
            'user_id' => $agent->id,
            'status' => 1,
        ]);

        $response->assertRedirect(route('property.index'));
        $this->assertDatabaseHas('properties', [
            'reference_no' => 'EERE-V-777',
            'trakheesi_permit_no' => '7199881122',
            'user_id' => $agent->id,
            'completion_status' => 'Ready',
        ]);
    }
}
