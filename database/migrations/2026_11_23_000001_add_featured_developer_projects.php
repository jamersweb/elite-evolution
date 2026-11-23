<?php

use Database\Seeders\FeaturedDeveloperProjectsSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFeaturedDeveloperProjects extends Migration
{
    public function up()
    {
        if (app()->runningUnitTests()) {
            return;
        }

        (new FeaturedDeveloperProjectsSeeder())->run();
    }

    public function down()
    {
        $ids = DB::table('properties')->where('sync_source', 'featured-project')->pluck('id');
        if ($ids->isEmpty()) {
            return;
        }

        DB::table('media')->where('reference_type', 'property')->whereIn('reference_id', $ids)->delete();
        DB::table('properties')->whereIn('id', $ids)->delete();
    }
}
