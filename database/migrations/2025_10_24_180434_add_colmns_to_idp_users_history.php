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
        Schema::table('idp_users', function (Blueprint $table) {
            $table->string('user_name', length:50);
            $table->enum('scheme',['Normal','Update','Extended'])->default('Normal');
        });
        Schema::table('idp_history', function(Blueprint $table){
            
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth', 15)->nullable();
            $table->string('contact',15)->nullable();
            $table->date('app_issue_date')->nullable();
            $table->date('app_expiry_date')->nullable();
            $table->string('passport_no', length:50)->nullable();
            $table->string('driving_license_no', length:50)->nullable();
            $table->date('driving_license_issue')->nullable();
            $table->date('driving_license_expiry')->nullable();
            $table->enum('status',['Pending', 'Approved (Certificate Ready)', 'Approved (Payment Done)'])->nullable();
            $table->string('application_type')->nullable();
            $table->unsignedInteger('driving_years')->nullable();
            $table->unsignedInteger('amount')->nullable();
            $table->unsignedInteger('center_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('idp_users', function (Blueprint $table) {
            $table->dropColumn('scheme');
            $table->dropColumn('user_name');
        });
        Schema::table('idp_history', function(Blueprint $table){
            $table->dropColumn('amount');
            $table->dropColumn('driving_license_no');
            $table->dropColumn('driving_license_issue');
            $table->dropColumn('driving_license_expiry');
            $table->dropColumn('status');
            $table->dropColumn('application_type');
            $table->dropColumn('driving_years');
            $table->dropColumn('center_id');
        });
    }
};
