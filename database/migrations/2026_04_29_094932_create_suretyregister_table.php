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
        Schema::create('suretyregister', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('register_id');
            $table->string('guarantaor_name', 80);
            $table->string('mobile_no', 15);
            $table->string('receipt_no', 50);
            $table->date('receipt_date');
            $table->unsignedInteger('police_station_id');
            $table->string('section_of_law', 50);
            $table->string('accused_name', 80);
            $table->unsignedInteger('amount');
            $table->unsignedInteger('surety_type_id');
            $table->unsignedInteger('surety_status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suretyregister');
    }
};
