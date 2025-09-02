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
        Schema::create('idp_history', function (Blueprint $table) {
            $table->id();
            $table->string('nitb_id');
            $table->string('cnic', length:13);
            $table->string('first_name', length:60);
            $table->string('father_name', length:60);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idp_history');
    }
};
