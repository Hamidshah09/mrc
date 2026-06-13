<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('divorce_hearings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('divorce_case_id')->constrained('divorce_cases')->cascadeOnDelete();
            $table->unsignedTinyInteger('notice_number');
            $table->date('notice_date');
            $table->date('hearing_date');
            $table->enum('status', ['scheduled', 'heard', 'postponed'])->default('scheduled');
            $table->date('next_hearing_date')->nullable();
            $table->string('proceeding_path')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['divorce_case_id', 'notice_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('divorce_hearings');
    }
};
