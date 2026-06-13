<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('divorce_cases', function (Blueprint $table) {
            $table->id();
            $table->enum('entry_type', ['live', 'old'])->default('live');
            $table->string('case_no', 50)->unique();
            $table->enum('divorce_type', ['Talaq', 'Khula', 'Talaq Tafveez']);
            $table->enum('applicant_side', ['groom', 'bride']);
            $table->string('groom_cnic', 13);
            $table->string('groom_name', 100);
            $table->string('groom_father_name', 100);
            $table->text('groom_address');
            $table->string('bride_cnic', 13);
            $table->string('bride_name', 100);
            $table->string('bride_father_name', 100);
            $table->text('bride_address');
            $table->date('decision_date')->nullable();
            $table->date('issue_date')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        if (Schema::hasTable('roles')) {
            DB::table('roles')->updateOrInsert(['role' => 'drc'], ['updated_at' => now(), 'created_at' => now()]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('divorce_cases');

        if (Schema::hasTable('roles')) {
            DB::table('roles')->where('role', 'drc')->delete();
        }
    }
};
