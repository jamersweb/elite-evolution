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
        $response->assertSee('52410'); // BRN
    }

    public function test_agent_detail_page_loads()
    {
        $response = $this->get('/agents/alexander-wright');
        $response->assertStatus(200);
        $response->assertSee('Alexander Wright');
    }

    public function test_property_detail_page_displays_compliance_fields()
    {
        $response = $this->get('/detail/signature-beachfront-villa-palm-jumeirah');
        $response->assertStatus(200);
        $response->assertSee('EERE-V-101'); // Reference number
        $response->assertSee('7123984501'); // Trakheesi Permit
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

    public function test_admin_can_manage_licensed_agents()
    {
        $admin = User::where('email', 'admin@eliteevolutionrealestate.ae')->first();

        // 1. Directory loads
        $response = $this->actingAs($admin)->get('/admin/agents');
        $response->assertStatus(200);
        $response->assertSee('Alexander Wright');

        // 2. Create new licensed broker
        $postRes = $this->actingAs($admin)->post('/admin/agents', [
            'name' => 'Fatima Al-Zahra',
            'email' => 'fatima@eliteevolutionrealestate.ae',
            'password' => 'secret123',
            'phone' => '+971509876543',
            'whatsapp_no' => '971509876543',
            'brn' => '77890',
            'occupation' => 'Luxury Villa Specialist',
            'experience' => '7 Years',
            'status' => 'active',
        ]);

        $postRes->assertRedirect(route('agents.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'fatima@eliteevolutionrealestate.ae',
            'brn' => '77890',
            'is_agent' => 1,
        ]);
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
