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
        Schema::table('users', function (Blueprint $table) {

            $table->foreignId('sub_division_id')
                ->nullable()
                ->after('role_id')
                ->constrained('sub_divisions')
                ->nullOnDelete();

            $table->unsignedBigInteger('policestation_id')
                ->nullable()
                ->after('sub_division_id');

            $table->foreign('policestation_id')
                ->references('id')
                ->on('policestations')
                ->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['sub_division_id']);
            $table->dropForeign(['policestation_id']);

            $table->dropColumn([
                'sub_division_id',
                'policestation_id'
            ]);
        });
    }
};