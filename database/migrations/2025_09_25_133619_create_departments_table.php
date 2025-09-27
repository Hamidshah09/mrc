<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // auto-increment primary key
            $table->string('department');
            $table->timestamps();
        });

        // Insert default records
        DB::table('departments')->insert([
            ['id' => 1, 'department' => 'Deputy Commissioner Office'],
            ['id' => 2, 'department' => 'Fishereies Department, ICT'],
            ['id' => 3, 'department' => 'Citizen Facilitation Center'],
            ['id' => 4, 'department' => 'MC/ICT'],
            ['id' => 5, 'department' => 'Local Government Department'],
            ['id' => 6, 'department' => 'Auqaf Department ICT'],
            ['id' => 7, 'department' => 'Budget Branch'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
