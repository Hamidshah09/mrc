<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('divorce_cases') && Schema::hasColumn('divorce_cases', 'decision_date')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement('ALTER TABLE divorce_cases MODIFY decision_date DATE NULL');
            }
        }

        if (Schema::hasTable('divorce_hearings') && !Schema::hasColumn('divorce_hearings', 'notice_date')) {
            Schema::table('divorce_hearings', function (Blueprint $table) {
                $table->date('notice_date')->nullable()->after('notice_number');
            });

            DB::table('divorce_hearings')->whereNull('notice_date')->update([
                'notice_date' => DB::raw('hearing_date'),
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('divorce_hearings') && Schema::hasColumn('divorce_hearings', 'notice_date')) {
            Schema::table('divorce_hearings', function (Blueprint $table) {
                $table->dropColumn('notice_date');
            });
        }

        if (Schema::hasTable('divorce_cases') && Schema::hasColumn('divorce_cases', 'decision_date')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement('ALTER TABLE divorce_cases MODIFY decision_date DATE NOT NULL');
            }
        }
    }
};
