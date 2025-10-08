<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('arms_approvals', function (Blueprint $table) {
            $table->id();
            $table->integer('applicant_id')->nullable();
            $table->string('cnic', 13)->nullable();
            $table->string('name', 60)->nullable();
            $table->string('license_no', 45)->nullable();
            $table->string('weapon_no', 20)->nullable();
            $table->string('request_type', 20)->nullable();
            $table->string('action', 45)->nullable();
            $table->string('operator', 45)->nullable();
            $table->string('file_status', 45)->nullable();
            $table->string('url', 80)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('arms_approvals');
    }

};
