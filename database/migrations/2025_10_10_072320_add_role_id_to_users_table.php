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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');
        });
        // ✅ Populate the role_id column based on existing "role" values
        $roles = DB::table('roles')->pluck('id', 'role'); // ['admin' => 1, 'domicile' => 2, ...]

        foreach ($roles as $roleName => $roleId) {
            DB::table('users')
                ->where('role', $roleName)
                ->update(['role_id' => $roleId]);
        }

        // ✅ Now drop old columns safely after data is migrated
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'license_number']);
        });
    }
        
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropConstrainedForeignId('role_id');
             $table->enum('role', ['admin', 'registrar', 'mrc', 'idp', 'verifier', 'domicile', 'ea', 'customer'])->default('customer');
             $table->string('license_number', length:10)->nullable();
        });
    }
};
