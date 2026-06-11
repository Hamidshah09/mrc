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
        Schema::table('suretyregister', function (Blueprint $table) {
            $table->unsignedBigInteger('register_id')->nullable()->change();
            $table->string('receipt_no')->nullable()->change(); 
            $table->unsignedBigInteger('document_id')->nullable()->change();
            $table->unsignedBigInteger('court_id')->nullable()->after('register_id');
            $table->string('guarantor_cnic', 13)->nullable()->after('court_id');
            $table->string('guarantor_father_name', 80)->nullable()->after('guarantor_name');
            $table->string('po_no', 50)->nullable()->after('payment_mode');
            $table->unsignedBigInteger('bank_id')->nullable()->after('po_no');
            $table->string('branch_name', 100)->nullable()->after('bank_id');
            $table->string('checque_no', 50)->nullable()->after('branch_name');
            $table->string('docs', 100)->nullable()->after('checque_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suretyregister', function (Blueprint $table) {
            // 1. Drop newly added columns (Reverse order of addition)
            $table->dropColumn([
                'docs',
                'checque_no',
                'branch_name',
                'bank_id',
                'po_no',
                'guarantor_father_name',
                'guarantor_cnic',
                'court_id',
            ]);

            // 2. Revert modified columns back to their original types
            $table->string('receipt_no')->change();
            $table->unsignedBigInteger('register_id')->change();
        });
    }
};
