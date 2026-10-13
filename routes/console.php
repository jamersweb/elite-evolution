<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('portal:sync-schema', function () {
    $this->info('Starting database schema sync...');

    // 1. Users table
    \Illuminate\Support\Facades\Schema::table('users', function ($table) {
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'slug')) $table->string('slug')->nullable()->index();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'phone')) $table->string('phone')->nullable();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'image')) $table->string('image')->nullable();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'brn')) $table->string('brn')->nullable();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'experience')) $table->string('experience')->nullable();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'occupation')) $table->string('occupation')->nullable();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'about')) $table->text('about')->nullable();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'whatsapp_no')) $table->string('whatsapp_no')->nullable();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'linkedin_url')) $table->string('linkedin_url')->nullable();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'area_tags')) $table->text('area_tags')->nullable();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'language_multi_select')) $table->text('language_multi_select')->nullable();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'nationality')) $table->string('nationality')->nullable();
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'status')) $table->string('status')->default('active');
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'is_agent')) $table->boolean('is_agent')->default(false);
    });
    $this->info('✓ Users table columns verified.');

    // 2. Properties table
    if (\Illuminate\Support\Facades\Schema::hasTable('properties')) {
        \Illuminate\Support\Facades\Schema::table('properties', function ($table) {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'status')) $table->tinyInteger('status')->nullable()->default(0);
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'user_id')) $table->unsignedBigInteger('user_id')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'developer_id')) $table->unsignedBigInteger('developer_id')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'reference_no')) $table->string('reference_no')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'trakheesi_permit_no')) $table->string('trakheesi_permit_no')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'permit_qr_image')) $table->string('permit_qr_image')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'deeds')) $table->string('deeds')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'land_type')) $table->string('land_type')->nullable()->default('residential');
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'type')) $table->string('type')->nullable()->default('sale');
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'property_type')) $table->string('property_type')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'completion_status')) $table->string('completion_status')->nullable()->default('Ready');
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'handover_date')) $table->string('handover_date')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'furnishing_type')) $table->string('furnishing_type')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'layout_type')) $table->string('layout_type')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'build_up_area')) $table->string('build_up_area')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'size')) $table->string('size')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'bedrooms')) $table->integer('bedrooms')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'bathrooms')) $table->integer('bathrooms')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'parkings')) $table->integer('parkings')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'financial_status')) $table->string('financial_status')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'project_status')) $table->string('project_status')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'amenities')) $table->text('amenities')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'price')) $table->decimal('price', 15, 2)->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'end_price')) $table->decimal('end_price', 15, 2)->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'yearly_rent')) $table->decimal('yearly_rent', 15, 2)->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'cheques')) $table->integer('cheques')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'deposit')) $table->decimal('deposit', 15, 2)->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'available_from')) $table->date('available_from')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'service_charges')) $table->decimal('service_charges', 10, 2)->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'view36')) $table->string('view36')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'video')) $table->string('video')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'brochure')) $table->string('brochure')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'country')) $table->string('country')->nullable()->default('United Arab Emirates');
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'state')) $table->string('state')->nullable()->default('Dubai');
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'community')) $table->string('community')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'sub_community')) $table->string('sub_community')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'building')) $table->string('building')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'location')) $table->string('location')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'address')) $table->text('address')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'postcode')) $table->string('postcode')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'lat')) $table->string('lat')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'lng')) $table->string('lng')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'map')) $table->text('map')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'completesearch')) $table->text('completesearch')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'is_verified')) $table->boolean('is_verified')->default(true);
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'is_new_project')) $table->boolean('is_new_project')->default(false);
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'meta_title')) $table->string('meta_title')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'meta_description')) $table->text('meta_description')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('properties', 'meta_tag')) $table->string('meta_tag')->nullable();
        });
        $this->info('✓ Properties table columns verified.');
    }

    // 3. Developers table
    if (\Illuminate\Support\Facades\Schema::hasTable('developers')) {
        \Illuminate\Support\Facades\Schema::table('developers', function ($table) {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('developers', 'slug')) $table->string('slug')->nullable()->index();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('developers', 'image')) $table->string('image')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('developers', 'cover')) $table->string('cover')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('developers', 'description')) $table->longText('description')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('developers', 'status')) $table->tinyInteger('status')->default(1);
            if (!\Illuminate\Support\Facades\Schema::hasColumn('developers', 'meta_title')) $table->string('meta_title')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('developers', 'meta_description')) $table->text('meta_description')->nullable();
            if (!\Illuminate\Support\Facades\Schema::hasColumn('developers', 'meta_tag')) $table->string('meta_tag')->nullable();
        });
        $this->info('✓ Developers table columns verified.');
    }

    $this->info('Database schema successfully synchronized!');
})->purpose('Synchronize missing database columns safely without data loss');
