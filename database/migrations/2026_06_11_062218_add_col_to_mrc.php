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
        Schema::table('mrc', function (Blueprint $table) {
            $table->string('registrar_name', 80)->nullable();
            $table->unsignedBigInteger('union_council_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mrc', function (Blueprint $table) {
            $table->dropColumn('registrar_name');
            $table->dropColumn('union_council_id');
        });
    }
};
