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
        Schema::create('occupations', function (Blueprint $table) {
            $table->id();
            $table->string('occupation');
            $table->timestamps();
        });
        
        DB::table('occupations')->insert([
            ['occupation' => 'Government Employee', 'created_at' => now(), 'updated_at' => now()],
            ['occupation' => 'Non Government Employee', 'created_at' => now(), 'updated_at' => now()],
            ['occupation' => 'Own Business', 'created_at' => now(), 'updated_at' => now()],
            ['occupation' => 'Student', 'created_at' => now(), 'updated_at' => now()],
            ['occupation' => 'Other', 'created_at' => now(), 'updated_at' => now()],
            ['occupation' => 'House Wife', 'created_at' => now(), 'updated_at' => now()],
            ['occupation' => 'Private Job', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupations');
    }
};
