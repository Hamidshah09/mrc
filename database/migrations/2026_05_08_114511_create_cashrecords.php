<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'remote_mysql';
    
    public function up(): void
    {
        
        Schema::connection($this->connection)->create('cashrecords', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('cnic', 13);
            $table->string('name', 70);
            $table->string('mobile', 15);
            $table->enum('service_type', ['offline', 'online']);
            $table->string('request_type', 10);
            $table->string('domicile_number', 20)->nullable();
            $table->string('status', 30)->nullable();
            $table->string('operator_name', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('cashrecords');
    }
};
