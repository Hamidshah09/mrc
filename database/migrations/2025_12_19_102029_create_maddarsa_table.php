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
        Schema::create('maddarsas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('no_of_students');
            $table->unsignedBigInteger('mousque_id');
            $table->string('mohtamim_name', 60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maddarsas');
    }
};
