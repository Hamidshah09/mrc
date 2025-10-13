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
        Schema::create('application_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('application_status', length:40);
            $table->timestamps();
        });
        DB::table('application_statuses')->insert([
            ['application_status'=>'Pending'],
            ['application_status'=>'Letters Sent for Verification'],
            ['application_status'=>'Sent for Approval'],
            ['application_status'=>'Application Approved'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_statuses');
    }
};
