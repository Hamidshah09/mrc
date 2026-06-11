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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('banks')->insert([
            ['name' => 'Allied Bank Limited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Askari Bank Limited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bank Al Habib Limited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bank Alfalah Limited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bank of Khyber', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bank of Punjab', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Faysal Bank Limited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Habib Bank Limited (HBL)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Habib Metropolitan Bank', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'JS Bank Limited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MCB Bank Limited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meezan Bank Limited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'National Bank of Pakistan (NBP)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sindh Bank Limited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Soneri Bank Limited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Standard Chartered Bank Pakistan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Summit Bank Limited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'UBL (United Bank Limited)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dubai Islamic Bank Pakistan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Al Baraka Bank Pakistan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'The Bank of Azad Jammu & Kashmir', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};