<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('domicileapplicants', function (Blueprint $table) {
             $table->id();
            $table->string('cnic', 13);
            $table->string('name', 45);
            $table->string('fathername', 45);
            $table->string('spousename', 45);
            $table->date('date_of_birth');
            $table->unsignedTinyInteger('gender_id'); // Assuming 1-3 range
            $table->string('place_of_birth', 45);
            $table->unsignedTinyInteger('marital_status_id'); // Assuming 1-5 range
            $table->string('religion', 45);
            $table->unsignedBigInteger('qualification_id')->nullable();
            $table->unsignedBigInteger('occupation_id')->nullable();

            // Temporary address
            $table->unsignedBigInteger('temporaryAddress_province_id');
            $table->unsignedBigInteger('temporaryAddress_tehsil_id');
            $table->unsignedBigInteger('temporaryAddress_district_id');
            $table->string('temporaryAddress', 100);

            // Permanent address
            $table->unsignedBigInteger('permanentAddress_province_id');
            $table->unsignedBigInteger('permanentAddress_tehsil_id');
            $table->unsignedBigInteger('permanentAddress_district_id');
            $table->string('permanentAddress', 100);

            $table->date('date_of_arrival');
            $table->string('contact', 11);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domicileapplicants');
    }
};
