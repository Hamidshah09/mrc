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
        Schema::create('marital_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('marital_status');
            $table->timestamps();
        });
        DB::table('marital_statuses')->insert([
            ['marital_status'=>'Single', 'created_at' => now(), 'updated_at' => now()],
            ['marital_status'=>'Married', 'created_at' => now(), 'updated_at' => now()],
            ['marital_status'=>'Divorced', 'created_at' => now(), 'updated_at' => now()],
            ['marital_status'=>'Widowed', 'created_at' => now(), 'updated_at' => now()],
            ['marital_status'=>'Widower', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marital_statuses');
    }
};
