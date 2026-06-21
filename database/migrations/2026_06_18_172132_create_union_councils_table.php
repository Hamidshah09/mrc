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
        Schema::create('union_councils', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->timestamps();
        });

        // Insert initial data
        DB::table('union_councils')->insert([
            ['name'=>'Arbitration Council'],
            ['name' => 'Said Pur No 1'],
            ['name' => 'Noor Pur Shahan No 2'],
            ['name' => 'Malpur No 3'],
            ['name' => 'Kot Hathial No 4'],
            ['name' => 'Kot Hathial No 5'],
            ['name' => 'Phulgran No 6'],
            ['name' => 'Pind Begwal No 7'],
            ['name' => 'Tumair No 8'],
            ['name' => 'Cherah No 9'],
            ['name' => 'Kirpa No 10'],
            ['name' => 'Mughal No 11'],
            ['name' => 'Rawat No 12'],
            ['name' => 'Humak No 13'],
            ['name' => 'Sihala No 14'],
            ['name' => 'Lohi Bhar No 15'],
            ['name' => 'Phag Panwal No 16'],
            ['name' => 'Koral No 17'],
            ['name' => 'Khana Dak No 18'],
            ['name' => 'Tarlai No 19'],
            ['name' => 'Alipur No 20'],
            ['name' => 'Sohan Dehati No 21'],
            ['name' => 'Chak Shahzad No 22'],
            ['name' => 'Kuri No 23'],
            ['name' => 'Rawal Town No 24'],
            ['name' => 'Maira Sumbal Jafar No 39'],
            ['name' => 'Borka No 44'],
            ['name' => 'Jhangi Syedain No 45'],
            ['name' => 'Bhadana Kalan No 46'],
            ['name' => 'Tarnol No 47'],
            ['name' => 'Sarai Karboza No 48'],
            ['name' => 'Shah Allah Ditta No 49'],
            ['name' => 'Golra Sharif No 50'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('union_councils');
    }
};
