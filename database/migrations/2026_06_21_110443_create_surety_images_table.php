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
        Schema::create('surety_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surety_register_id');
            $table->string('path', 255);
            $table->string('original_name', 255)->nullable();
            $table->timestamps();

            $table->foreign('surety_register_id')->references('id')->on('suretyregister')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surety_images');
    }
};
