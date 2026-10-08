<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingRequestTable extends Migration
{
    public function up()
    {
        Schema::create('listing_request', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('type')->nullable()->comment('sale or rent');
            $table->string('property_type')->nullable();
            $table->string('bedrooms')->nullable();
            $table->decimal('expected_price', 15, 2)->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('listing_request');
    }
}
