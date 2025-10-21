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
        Schema::create('employee_types', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('employee_type', length:20);
            $table->timestamps();
        });
        DB::table('employee_types')->insert([
            ['employee_type'=>'Daily Wages'],
            ['employee_type'=>'Regular'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_types');
    }
};
