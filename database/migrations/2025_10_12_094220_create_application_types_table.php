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
        Schema::create('application_types', function (Blueprint $table) {
            $table->id();
            $table->string('application_type', length:50);
            $table->string('route', length:50);
            $table->string('icon', length:20);
            $table->timestamps();
        });
        DB::table('application_types')->insert([
            ['application_type'=>'Noc for other District Domicile', 'route'=>'noc.other_district.create', 'icon'=>'📄'],
            ['application_type'=>'Noc for events', 'route'=>'hcg.noc_events.create', 'icon'=>'🎉'],
            ['application_type'=>'Permission for open fuel', 'route'=>'hcg.noc_fuel.create', 'icon'=>'⛽'],
            ['application_type'=>'L4 (Explosive Usage License)', 'route'=>'alc.l4.create', 'icon'=>'🧨'],
            ['application_type'=>'L7 (Explosive Transportaion License)', 'route'=>'hcg.l7.create', 'icon'=>'🚚'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_types');
    }
};
