<?php

use Database\Seeders\FeaturedDeveloperProjectsSeeder;
use Illuminate\Database\Migrations\Migration;

class AddFeaturedProjectGalleries extends Migration
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
        // Gallery rows and amenity links are removed with the featured projects migration.
    }
}
