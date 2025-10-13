<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role', length:50);
            $table->timestamps();
        });
        DB::table('roles')->insert([
            ['role' => 'admin'],
            ['role' => 'domicile'],
            ['role' => 'idp'],
            ['role' => 'registrar'],
            ['role' => 'verifier'],
            ['role' => 'mrc'],
            ['role' => 'arms'],
            ['role' => 'ea'],
            ['role' => 'customer'],
        ]);
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
