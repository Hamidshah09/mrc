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
        Schema::create('policestations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->timestamps();
        });

        // Insert default data
        DB::table('policestations')->insert([
            ['name' => 'Abpara', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bani Gala', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bharakahu', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Golra Sharif', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Industrial Area I-9', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Karachi Company', 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Khanna", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Koral", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Lohi Bher", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Margalla", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Nilor", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Noon", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Shams Colony", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Others", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Ramna", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Sabzi Mandi", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Secretriat", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Shahzad Town", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Shalimar", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Sehala", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Tarnol", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Kohsar", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Koral", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Lohi Bher", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Margalla", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Nilor", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Noon", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Shams Colony", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Others", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Ramna", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Sabzi Mandi", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Secretriat", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Shahzad Town", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Shalimar", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Sehala", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Tarnol", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Women Police Station", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Kirpa", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Sangjani", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Phulgaran", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Sumbal", 'created_at' => now(), 'updated_at' => now()],
            ['name' =>"Hummak", 'created_at' => now(), 'updated_at' => now()],
                                      
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policestations');
    }
};
