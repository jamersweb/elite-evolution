<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPartnerDevelopers extends Migration
{
    public function up()
    {
        $partners = [
            'new-evolution-property-development' => 'New Evolution Property Development',
            'emaar' => 'Emaar Properties',
            'omniyat' => 'Omniyat',
            'deyaar' => 'Deyaar',
            'binghatti' => 'Binghatti',
            'nakheel' => 'Nakheel',
            'damac' => 'DAMAC',
            'arada' => 'Arada',
        ];

        DB::transaction(function () use ($partners) {
            $owner = DB::table('developers')->whereNotNull('user_id')->orderBy('id')->value('user_id');
            foreach ($partners as $slug => $name) {
                $existing = DB::table('developers')->where('slug', $slug)->orWhere('name', $name)->first();
                if ($existing) {
                    DB::table('developers')->where('id', $existing->id)->update(['status' => 1]);
                } else {
                    DB::table('developers')->insert([
                        'user_id' => $owner, 'slug' => $slug, 'name' => $name, 'status' => 1,
                        'created_at' => now(), 'updated_at' => now(),
                    ]);
                }
            }
        });
    }

    public function down()
    {
        // Retain partners since listings can reference them after deployment.
    }
}
