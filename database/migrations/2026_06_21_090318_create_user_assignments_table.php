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
        Schema::create('user_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Creates:
            // assignable_type VARCHAR(255)
            // assignable_id BIGINT UNSIGNED
            $table->morphs('assignable');

            $table->timestamps();

            // Optional: prevent duplicate assignments
            $table->unique(['user_id']);

            // Optional index for faster lookups
            $table->index(['assignable_type', 'assignable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_assignments');
    }
};