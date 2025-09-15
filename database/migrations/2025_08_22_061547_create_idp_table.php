<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idps', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('father_name')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('cnic')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->unsignedBigInteger('qualification_id')->nullable();
            $table->unsignedBigInteger('occupation_id')->nullable();

            // Temporary Address
            $table->unsignedBigInteger('temporary_address_province_id')->nullable();
            $table->unsignedBigInteger('temporary_address_district_id')->nullable();
            $table->unsignedBigInteger('temporary_address_tehsil_id')->nullable();
            $table->string('temporary_address')->nullable();

            $table->string('contact')->nullable();

            // Driving License
            $table->string('driving_license_number')->nullable();
            $table->date('driving_license_issue_date')->nullable();
            $table->date('driving_license_expiry_date')->nullable();
            $table->unsignedBigInteger('driving_license_vehicle_type_id')->nullable();
            $table->string('driving_license_issuing_authority')->nullable();

            // Passport
            $table->string('passport_number')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->unsignedBigInteger('passport_type_id')->nullable();
            $table->string('passcode', length:10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idps');
    }
};

