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
        Schema::create('arbitration_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status', 50)->unique();
            $table->timestamps();
        });

        DB::table('arbitration_statuses')->insert([
            ['status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 'out of jurisdiction', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 'certificate issued', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 'reconciled', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 'pending for presence', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 'referred to adcr', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 'referred to magistrate', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arbitration_statuses');
    }
};
