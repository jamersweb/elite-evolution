<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->nullable()->default(0)->comment('1: Published/Approved, 0: Draft/Pending');
            $table->unsignedBigInteger('user_id')->nullable()->comment('Listing/Assigned Agent');
            $table->unsignedBigInteger('developer_id')->nullable();
            
            // Core Identity & Compliance
            $table->string('reference_no')->nullable()->unique();
            $table->string('trakheesi_permit_no')->nullable()->comment('DLD Trakheesi Permit Number');
            $table->string('permit_qr_image')->nullable()->comment('Madmoun QR Code image path or URL');
            $table->string('title');
            $table->string('slug')->nullable()->index();
            $table->longText('description')->nullable();
            $table->string('deeds')->nullable();
            
            // Classification & Status
            $table->string('land_type')->nullable()->default('residential')->comment('residential, commercial');
            $table->string('type')->nullable()->default('sale')->comment('sale, rent');
            $table->string('property_type')->nullable()->comment('Villa, Apartment, Penthouse, Townhouse, etc.');
            $table->string('completion_status')->nullable()->default('Ready')->comment('Ready, Off-plan');
            $table->string('handover_date')->nullable();
            $table->string('furnishing_type')->nullable();
            $table->string('layout_type')->nullable();
            
            // Dimensions & Specs
            $table->string('build_up_area')->nullable();
            $table->string('size')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('parkings')->nullable();
            $table->string('financial_status')->nullable();
            $table->string('project_status')->nullable();
            $table->text('amenities')->nullable();
            
            // Pricing & Rental Specs
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('end_price', 15, 2)->nullable();
            $table->decimal('yearly_rent', 15, 2)->nullable();
            $table->integer('cheques')->nullable()->comment('Number of cheques allowed');
            $table->decimal('deposit', 15, 2)->nullable();
            $table->date('available_from')->nullable();
            $table->decimal('service_charges', 10, 2)->nullable();
            
            // Media & Tours
            $table->string('view36')->nullable();
            $table->string('video')->nullable();
            $table->string('brochure')->nullable();
            
            // Location Details
            $table->string('country')->nullable()->default('United Arab Emirates');
            $table->string('state')->nullable()->default('Dubai');
            $table->string('community')->nullable();
            $table->string('sub_community')->nullable();
            $table->string('building')->nullable();
            $table->string('location')->nullable();
            $table->text('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->text('map')->nullable();
            $table->text('completesearch')->nullable();
            
            // Flags
            $table->boolean('is_verified')->default(true);
            $table->boolean('is_new_project')->default(false);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_tag')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
