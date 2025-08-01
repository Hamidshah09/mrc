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
        Schema::create('passcodes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 6)->unique();  // 6-digit passcode
            $table->date('valid_on');            // Date it's valid for
            $table->boolean('used')->default(false);
            $table->foreignId('submitted_by')->nullable()->constrained('nocapplicants');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passcodes');
    }
};
