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
        Schema::create('auqaf_officials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name');
            $table->unsignedBigInteger('position');
            $table->string('contact_number', 15);
            $table->string('cnic')->unique();
            $table->enum('type', ['Regular', 'Shrine', 'Private']);
            $table->string('profile_image')->nullable();
            $table->unsignedBigInteger('mousque_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auqaf_officials');
    }
};
