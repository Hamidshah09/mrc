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
        Schema::create('mousques', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->unsignedBigInteger('sector_id');
            $table->string('sub_sector', 10)->nullable();
            $table->string('location');
            $table->enum('sect', ['Barelvi', 'Deobandi', 'Ahl-e-Hadith', 'Shia', 'Other']);
            $table->integer('status')->default(1); // 1 for active, 0 for inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mousques');
    }
};
