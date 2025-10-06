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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service',length:15);
        });
        DB::table('services')->insert([
            ['id' => 1, 'service' => 'arms'],
            ['id' => 2, 'service' => 'domicile'],
            ['id' => 3, 'service' => 'idp'],
            ['id' => 4, 'service' => 'mrc'],
            ['id' => 5, 'service' => 'birth'],
            ['id' => 6, 'service' => 'police'],
        ]);
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('location',length:15);
            $table->timestamps();
        });
        DB::table('centers')->insert([
            ['id'=>'1', 'location'=>'G-11'],
            ['id'=>'2', 'location'=>'F-6'],
            ['id'=>'3', 'location'=>'Gulberg Green'],
            ['id'=>'4', 'location'=>'Taramri'],
        ]);
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('center_id');
            $table->integer('service_id');
            $table->integer('service_count');
            $table->date('report_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
        Schema::dropIfExists('centers');
        Schema::dropIfExists('statistics');
    }
};
