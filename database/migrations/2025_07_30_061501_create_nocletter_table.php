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
        Schema::create('nocletters', function (Blueprint $table) {
            $table->id();
            $table->string('district', length:30);
            $table->string('referenced_letter_no', length:30)->nullable();
            $table->date('referenced_letter_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nocletter');
    }
};
