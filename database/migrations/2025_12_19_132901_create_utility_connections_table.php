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
        Schema::create('utility_connections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mousque_id');
            $table->enum('utility_type',['Electricity', 'Water', 'Gas']);
            $table->string('reference_number')->unique();
            $table->enum('benificiary_type', ['Khateeb', 'Moazin', 'Khadim']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utility_connections');
    }
};
