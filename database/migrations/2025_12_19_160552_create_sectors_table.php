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
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        
        DB::table('sectors')->insert([
            ['name' => 'I-8'], ['name' => 'I-9'], ['name' => 'I-10'], ['name' => 'I-11'], ['name' => 'I-12'], ['name' => 'I-13'], ['name' => 'I-14'], ['name' => 'I-15'], ['name'=>'I-16'],
            ['name' => 'F-5'], ['name' => 'F-6'], ['name' => 'F-7'], ['name' => 'F-8'], ['name' => 'F-9'], ['name' => 'F-10'], ['name' => 'F-11'], ['name' => 'F-12'], ['name' => 'F-13'], ['name' => 'F-14'], ['name'=>'F-15'], ['name'=>'F-16'],
            ['name' => 'G-5'], ['name' => 'G-6'], ['name' => 'G-7'], ['name' => 'G-8'], ['name' => 'G-9'], ['name' => 'G-10'], ['name' => 'G-11'], ['name' => 'G-12'], ['name' => 'G-13'], ['name' => 'G-14'], ['name'=>'G-15'], ['name'=>'G-16'],
            ['name' => 'H-8'], ['name' => 'H-9'], ['name' => 'H-10'], ['name' => 'H-11'], ['name' => 'H-12'], ['name' => 'H-13'], ['name' => 'H-14'], ['name' => 'H-15'],
            ['name' => 'E-7'], ['name' => 'E-8'], ['name' => 'E-9'], ['name' => 'E-10'], ['name' => 'E-11'], ['name' => 'E-12'], ['name' => 'E-13'], ['name' => 'E-14'], ['name'=>'E-15'], ['name'=>'E-16'],
            ['name' => 'D-12'], ['name' => 'D-13'], ['name' => 'D-14'], ['name' => 'D-15'], ['name'=>'D-16'], ['name' => 'D-17'],
            ['name' => 'C-13'], ['name' => 'C-14'], ['name' => 'C-15'], ['name'=>'C-16'],
            ['name' => 'B-14'], ['name' => 'B-15'], ['name'=>'B-16'],
            ['name' => 'A-15'], ['name'=>'A-16'], ['name'=>'R-1'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sectors');
    }
};
