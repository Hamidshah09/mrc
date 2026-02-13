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
        Schema::create('postalservice', function (Blueprint $table) {
            $table->id();
            $table->string('article_number')->nullable();
            $table->string('receiver_name');
            $table->string('receiver_address');
            $table->string('weight')->nullable();
            $table->integer('rate')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->integer('status_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postalservice');
    }
};
