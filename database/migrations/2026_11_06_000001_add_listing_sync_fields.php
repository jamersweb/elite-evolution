<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddListingSyncFields extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('sync_source', 32)->nullable();
            $table->string('sync_id', 128)->nullable();
            $table->unique(['sync_source', 'sync_id']);
            $table->string('rent_period', 12)->nullable();
            $table->json('sync_details')->nullable();
        });
        Schema::table('media', function (Blueprint $table) {
            $table->text('source_url')->nullable();
        });
    }

    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('source_url');
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->dropUnique(['sync_source', 'sync_id']);
            $table->dropColumn(['sync_source', 'sync_id', 'rent_period', 'sync_details']);
        });
    }
}
