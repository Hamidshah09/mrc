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
        Schema::create('suretypes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->timestamps();
        });

        // Insert default data
        DB::table('suretypes')->insert([
            ['name' => 'Event Noc', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fuel Station', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Desealing of Shops/Resturants', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Court Cases', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suretypes');
    }
};
