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
        Schema::create('old_idp_ids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('old_id');
            $table->enum('status', ['Not Used', 'Reserved', 'Used'])->default('Not Used');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_idp_ids');
    }
};
