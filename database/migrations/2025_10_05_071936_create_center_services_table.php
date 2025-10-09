<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('center_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('centers_id');
            $table->foreignId('services_id');
            $table->timestamps();
            $table->unique(['center_id', 'service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('center_services');
    }
};
