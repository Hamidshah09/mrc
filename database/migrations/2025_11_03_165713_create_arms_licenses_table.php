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
        Schema::create('arms_licenses', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('applicant_id');
            $table->string('name', 60)->nullable();
            $table->string('cnic', 13)->nullable();
            $table->string('guardian_name', 60)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('weapon_number', 30)->nullable();
            $table->string('license_number', 30)->nullable();
            $table->string('caliber', 20)->nullable();
            $table->string('weapon_type', 30)->nullable();
            $table->date('issue_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('address', 255)->nullable();
            $table->unsignedInteger('approver_id')->nullable();
            $table->tinyInteger('character_certificate')->nullable();
            $table->tinyInteger('address_on_cnic')->nullable();
            $table->tinyInteger('affidavit')->nullable();
            $table->tinyInteger('should_cancel')->nullable();
            $table->tinyInteger('status_id')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arms_licenses');
    }
};
