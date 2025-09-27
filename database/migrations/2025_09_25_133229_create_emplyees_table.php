<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key

            $table->string('cnic', 20)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('father_name', 100)->nullable();

            // Foreign key IDs (we can later add constraints if needed)
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('emp_type_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->date('date_of_birth')->nullable();
            $table->date('date_of_joining')->nullable();

            $table->string('pic', 255)->nullable();

            $table->timestamps(); // includes created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
