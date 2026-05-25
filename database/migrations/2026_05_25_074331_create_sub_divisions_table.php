<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sub_divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('sub_divisions')->insert([
            ['name' => 'Saddar'],
            ['name' => 'Shalimar'],
            ['name' => 'Industrial Area'],
            ['name' => 'City'],
            ['name' => 'Secretariat'],
            ['name' => 'Rural'],
            ['name' => 'Potohar'],
            ['name' => 'Nilore'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_divisions');
    }
};