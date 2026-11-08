<?php

use App\Services\ListingDeveloper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class LinkImportedListingDevelopers extends Migration
{
    public function up()
    {
        DB::table('properties')->where('sync_source', 'propertyfinder')->whereNull('developer_id')
            ->select('id', 'source_payload', 'building', 'location', 'community')->chunkById(100, function ($rows) {
                foreach ($rows as $row) {
                    $name = data_get(json_decode($row->source_payload ?? '{}', true), 'listing.developer');
                    $developer = ListingDeveloper::resolve($name, [
                        'building' => $row->building, 'name' => $row->location, 'community' => $row->community,
                    ]);
                    if ($developer) {
                        DB::table('properties')->where('id', $row->id)->whereNull('developer_id')
                            ->update(['developer_id' => $developer]);
                    }
                }
            });
    }

    public function down()
    {
        // Keep assignments, which administrators can subsequently edit.
    }
}
