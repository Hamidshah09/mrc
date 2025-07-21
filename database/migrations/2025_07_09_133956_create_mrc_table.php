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
        Schema::create('mrc', function (Blueprint $table) {
            $table->id();
            $table->string('grrom_name', length: 50);
            $table->string('bride_name', length: 50);
            $table->string('groom_father_name', length: 50);
            $table->string('bride_father_name', length: 50);
            $table->string('groom_passport', length: 10)->nullable();
            $table->string('bride_passport', length: 10)->nullable();
            $table->string('groom_cnic', length: 13)->nullable();
            $table->string('bride_cnic', length: 13)->nullable();
            $table->date('marriage_date');
            $table->date('registration_date');
            $table->unsignedBigInteger('registrar_id');
            $table->foreign('registrar_id')->references('id')->on('users');
            $table->enum('status', ['Verified', 'Not Verified'])->default('Not Verified');
            $table->unsignedBigInteger('verifier_id')->nullable();
            $table->foreign('verifier_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('verification_date')->nullable();
            $table->string('remarks',  length:100)->nullable();
            $table->string('register_no', length: 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrc');
    }
};
