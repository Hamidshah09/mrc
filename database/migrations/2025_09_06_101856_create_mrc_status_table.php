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
        Schema::create('mrc_status', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id', length:50);
            $table->enum('certificate_type',['Marriage', 'Divorce']);
            $table->string('applicant_name', length:60);
            $table->string('applicant_cnic', length:15);
            $table->date('processing_date');
            $table->enum('status',['Certificate Signed', 'Sent for Verification', 'Objection']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrc_status');
    }
};
