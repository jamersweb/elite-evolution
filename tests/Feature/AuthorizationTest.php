<?php

namespace Tests\Feature;

use App\Models\media;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    private function registeredUser()
    {
        $this->post('/register', [
            'name' => 'Public Visitor',
            'email' => 'visitor@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ]);
        auth()->logout();

        return User::where('email', 'visitor@example.com')->firstOrFail();
    }

    private function agent($email = 'alexander@eliteevolutionrealestate.ae')
    {
        return User::where('email', $email)->firstOrFail();
    }

    private function propertyOwnedBy(User $user)
    {
        return Property::where('user_id', $user->id)->firstOrFail();
    }

    public function test_public_registration_creates_a_user_role_account()
    {
        $user = $this->registeredUser();
        $this->assertTrue($user->hasRole('User'));
    }

    public function test_registered_user_cannot_open_admin_pages()
    {
        $user = $this->registeredUser();

        foreach ([
            '/admin/dashboard',
            '/admin/contact',
            '/admin/career',
            '/admin/subscribers',
            '/admin/brochure-leads',
            '/admin/requests?type=appraise',
            '/admin/agents',
            '/admin/agents/create',
        ] as $url) {
            $this->actingAs($user)->get($url)->assertStatus(403);
        }
    }

    public function test_registered_user_cannot_create_an_admin_account()
    {
        $user = $this->registeredUser();

        $this->actingAs($user)->post('/admin/agents', [
            'name' => 'Sneaky Admin',
            'email' => 'sneaky@example.com',
            'password' => 'secret123',
            'role' => 'Admin',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('users', ['email' => 'sneaky@example.com']);
    }

    public function test_agent_cannot_manage_agents()
    {
        $this->actingAs($this->agent())->get('/admin/agents')->assertStatus(403);
        $this->actingAs($this->agent())->post('/admin/agents', [
            'name' => 'Another Admin',
            'email' => 'another@example.com',
            'password' => 'secret123',
            'role' => 'Admin',
        ])->assertStatus(403);
    }

    public function test_registered_user_cannot_update_staff_profile()
    {
        $user = $this->registeredUser();

        $this->actingAs($user)->post('/admin/myprofile', [
            'name' => 'Public Visitor',
            'image' => UploadedFile::fake()->create('shell.php', 1, 'application/x-php'),
        ])->assertStatus(403);
    }

    public function test_agent_cannot_mass_assign_status_through_profile()
    {
        $agent = $this->agent();

        $this->actingAs($agent)->post('/admin/myprofile', [
            'name' => 'Alexander Wright',
            'status' => 'inactive',
            'is_agent' => 0,
        ])->assertStatus(302);

        $agent->refresh();
        $this->assertSame('active', $agent->status);
        $this->assertTrue($agent->is_agent);
    }

    public function test_agent_cannot_touch_another_agents_listing()
    {
        $alexander = $this->agent();
        $layla = $this->agent('layla@eliteevolutionrealestate.ae');
        $laylaListing = $this->propertyOwnedBy($layla);

        $this->actingAs($alexander)->get("/admin/property/{$laylaListing->id}/edit")->assertStatus(403);
        $this->actingAs($alexander)->put("/admin/property/{$laylaListing->id}", ['title' => 'Hijacked'])->assertStatus(403);

        $this->assertDatabaseMissing('properties', ['id' => $laylaListing->id, 'title' => 'Hijacked']);
    }

    public function test_agent_cannot_delete_another_agents_listing_image()
    {
        $layla = $this->agent('layla@eliteevolutionrealestate.ae');
        $image = media::where('reference_type', 'property')
            ->where('reference_id', $this->propertyOwnedBy($layla)->id)
            ->firstOrFail();

        $this->actingAs($this->agent())->post('/admin/image-delete', ['id' => $image->id])->assertStatus(403);

        $this->assertDatabaseHas('media', ['id' => $image->id]);
    }

    public function test_agent_can_edit_own_listing_but_cannot_self_publish()
    {
        $alexander = $this->agent();
        $listing = $this->propertyOwnedBy($alexander);
        $listing->update(['status' => 0]);

        $this->actingAs($alexander)->get("/admin/property/{$listing->id}/edit")->assertStatus(200);
        $this->actingAs($alexander)->put("/admin/property/{$listing->id}", [
            'title' => 'Updated By Owner',
            'status' => 1,
        ])->assertStatus(302);

        $this->assertDatabaseHas('properties', ['id' => $listing->id, 'title' => 'Updated By Owner', 'status' => 0]);
    }

    public function test_agent_created_listing_requires_approval()
    {
        $alexander = $this->agent();

        $this->actingAs($alexander)->post('/admin/property', [
            'title' => 'Agent Draft Listing',
            'status' => 1,
            'user_id' => $this->agent('layla@eliteevolutionrealestate.ae')->id,
        ])->assertRedirect(route('property.index'));

        $this->assertDatabaseHas('properties', [
            'title' => 'Agent Draft Listing',
            'status' => 0,
            'user_id' => $alexander->id,
        ]);
    }

    public function test_property_uploads_reject_executable_files()
    {
        $admin = User::where('email', 'admin@eliteevolutionrealestate.ae')->firstOrFail();

        $this->actingAs($admin)->post('/admin/property', [
            'title' => 'Upload Probe',
            'brochure' => UploadedFile::fake()->create('brochure.php', 1, 'application/x-php'),
            'permit_qr_image' => UploadedFile::fake()->create('qr.php', 1, 'application/x-php'),
            'image' => [UploadedFile::fake()->create('gallery.php', 1, 'application/x-php')],
        ])->assertSessionHasErrors(['brochure', 'permit_qr_image', 'image.0']);

        $this->assertDatabaseMissing('properties', ['title' => 'Upload Probe']);
    }

    public function test_property_upload_is_saved_with_content_based_extension()
    {
        $admin = User::where('email', 'admin@eliteevolutionrealestate.ae')->firstOrFail();

        $this->actingAs($admin)->post('/admin/property', [
            'title' => 'Upload Extension Probe',
            'image' => [UploadedFile::fake()->image('photo.jpg')],
        ])->assertRedirect(route('property.index'));

        $property = Property::where('title', 'Upload Extension Probe')->firstOrFail();
        $image = media::where('reference_type', 'property')->where('reference_id', $property->id)->firstOrFail();

        $this->assertStringEndsWith('.jpg', $image->image);
        @unlink(public_path('images/media/' . $image->image));
    }
}
