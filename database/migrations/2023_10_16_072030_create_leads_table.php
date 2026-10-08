<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable()->default('new');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('passport_id')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->text('address')->nullable();
            $table->string('p_o_box')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('land_type')->nullable();
            $table->string('type')->nullable();
            $table->string('property_type')->nullable();
            $table->string('budget')->nullable();
            $table->string('quality')->nullable();
            $table->string('financial_status')->nullable();
            $table->string('source')->nullable();
            $table->string('rep_firstname')->nullable();
            $table->string('rep_lastname')->nullable();
            $table->string('rep_email')->nullable();
            $table->string('rep_phone')->nullable();
            $table->string('time_frame')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('assigned_agent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
