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
        Schema::create('domicile_status', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', length:80)->nullable();
            $table->string('cnic', length:13)->nullable();
            $table->string('status', length:20)->nullable();
            $table->integer('receipt_no')->nullable();
            $table->string('remarks', length:120)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domicile_status');
    }
};
