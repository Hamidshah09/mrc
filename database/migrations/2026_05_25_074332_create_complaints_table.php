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
        Schema::create('complaints', function (Blueprint $table) {

            $table->id();

            // Users
            $table->foreignId('operator_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('ac_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('magistrate_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Area
            $table->foreignId('sub_division_id')
                ->constrained('sub_divisions');

            $table->unsignedBigInteger('policestation_id');
            $table->foreign('policestation_id')
                ->references('id')
                ->on('policestations')
                ->cascadeOnDelete();

            // Images
            $table->string('before_image');

            $table->string('after_image')
                ->nullable();

            // GPS
            $table->decimal('latitude', 10, 7)
                ->nullable();

            $table->decimal('longitude', 10, 7)
                ->nullable();

            $table->text('google_map_link')
                ->nullable();

            // Remarks
            $table->text('operator_remarks')
                ->nullable();

            $table->text('magistrate_remarks')
                ->nullable();

            $table->text('ac_remarks')
                ->nullable();

            $table->text('admin_remarks')
                ->nullable();

            // Status
            $table->enum('status', [
                'pending',
                'assigned',
                'resolved',
                'approved',
                'rejected',
                'disposed'
            ])->default('pending');

            // Timestamps
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('disposed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};