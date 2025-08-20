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
        Schema::table('domicileapplicants', function (Blueprint $table) {
            $table->enum('purpose',['study', 'job']);
            $table->string('passcode', length:6);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('domicileapplicants', function (Blueprint $table) {
            $table->dropColumn('purpose');
            $table->dropColumn('passcode');
        });
    }
};
