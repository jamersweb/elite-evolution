<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable()->index();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('brn')->nullable()->comment('Broker Registration Number');
            $table->string('experience')->nullable();
            $table->string('occupation')->nullable();
            $table->text('about')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->text('area_tags')->nullable();
            $table->text('language_multi_select')->nullable();
            $table->string('nationality')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_agent')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
