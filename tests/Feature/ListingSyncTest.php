<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ListingSyncTest extends TestCase
{
    use RefreshDatabase;

    private function row($id, $price = 3500)
    {
        return ['id' => $id, 'reference' => 'REF-'.$id, 'title' => ['en' => 'Villa '.$id],
            'price' => ['type' => 'monthly', 'amounts' => ['monthly' => $price]], 'type' => 'villa',
            'media' => ['images' => [['large' => ['url' => 'https://example.org/villa.jpg']]]]];
    }

    public function test_crm_preview_updates_withdrawal_and_failed_batch()
    {
        $file = tempnam(sys_get_temp_dir(), 'crm');
        $write = function ($rows) use ($file) {
            file_put_contents($file, json_encode(['total' => count($rows), 'results' => $rows]));
        };
        try {
            $write([$this->row('a'), $this->row('b')]);
            $this->artisan('listings:sync', ['--file' => $file, '--limit' => '10'])->assertExitCode(0);
            $this->assertSame(0, Property::count());
            $apply = ['--file' => $file, '--apply' => true];
            $this->artisan('listings:sync', $apply)->assertExitCode(0);
            $a = Property::where('sync_id', 'a')->firstOrFail();
            $this->assertEquals('month', $a->rent_unit);
            $this->assertEquals('https://example.org/villa.jpg', $a->featuredImage->display_url);
            $manual = Property::create(['title' => 'Local', 'status' => 1]);
            $changed = $this->row('a', 4200);
            $changed['media']['images'][0]['large']['url'] = 'https://example.org/new-photo.jpg';
            $write([$changed]);
            $this->artisan('listings:sync', $apply + ['--withdraw' => true])->assertExitCode(0);
            $this->assertEquals(4200, $a->fresh()->price);
            $this->assertSame(1, $a->media()->count());
            $this->assertEquals('https://example.org/new-photo.jpg', $a->fresh()->featuredImage->display_url);
            $this->get('/detail/'.Property::where('sync_id', 'b')->value('slug'))->assertNotFound();
            $this->assertEquals(0, Property::where('sync_id', 'b')->value('status'));
            $this->assertEquals(1, $manual->fresh()->status);
            $write([$this->row('a', 9999), $this->row('a')]);
            $this->artisan('listings:sync', $apply)->assertExitCode(1);
            $this->assertEquals(4200, $a->fresh()->price);
        } finally {
            unlink($file);
        }
    }

    public function test_property_finder_paged_import_uses_bearer_token()
    {
        config(['listing_sync.key' => 'test-key', 'listing_sync.secret' => 'test-secret']);
        Http::fake(function ($request) {
            if ($request->method() === 'POST') {
                $this->assertSame('https://atlas.propertyfinder.com/v1/auth/token', $request->url());
                $this->assertSame('test-key', $request['apiKey']);
                return Http::response(['accessToken' => 'test-token']);
            }
            $this->assertTrue($request->hasHeader('Authorization', 'Bearer test-token'));
            if (strpos($request->url(), '/locations?') !== false) {
                return Http::response(['data' => [['id' => 42, 'type' => 'COMMUNITY', 'name' => 'Jumeirah Islands', 'tree' => []]]]);
            }
            parse_str(parse_url($request->url(), PHP_URL_QUERY), $query);
            $this->assertSame('live', $query['filter']['state']);
            $page = (int) $query['page'];
            return Http::response(['results' => [$this->row('pf-'.$page) + ['location' => ['id' => 42]]], 'pagination' => [
                'page' => $page, 'totalPages' => 2, 'total' => 2,
            ]]);
        });
        $this->artisan('listings:sync', ['--apply' => true])->assertExitCode(0);
        $property = Property::first();
        $payload = json_decode($property->source_payload, true);
        $this->assertSame($this->row('pf-1') + ['location' => ['id' => 42]], $payload['listing']);
        $this->assertSame('Jumeirah Islands', $payload['location']['name']);
        $this->assertArrayNotHasKey('source_payload', $property->toArray());
        $this->assertSame('Jumeirah Islands', $property->community);
        $this->assertSame(2, Property::where('sync_source', 'propertyfinder')->count());
    }
}
