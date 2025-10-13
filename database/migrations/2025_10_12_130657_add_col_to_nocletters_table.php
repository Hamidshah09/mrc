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
        Schema::table('nocletters', function (Blueprint $table) {
            $table->foreignId('app_id')->nullable()->constrained('online_applications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nocletters', function (Blueprint $table) {
            $table->dropConstrainedForeignId('app_id');
            $table->dropColumn('app_id');
        });
    }
};
