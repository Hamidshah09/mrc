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
        Schema::create('arbitration_types', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->unique();
            $table->timestamps();
        });

        DB::table('arbitration_types')->insert([
            ['type' => 'Talaq', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Khula', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Talaq Tafveez', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Mubarat Deed', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Second Marriage', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Complaint', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Maintenance', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arbitration_types');
    }
};
