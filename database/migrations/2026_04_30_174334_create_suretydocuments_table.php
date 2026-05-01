<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('suretydocuments', function (Blueprint $table) {
            $table->id();

            // File info
            $table->string('file_path'); // stored file path
            $table->string('original_name')->nullable();

            // Ownership
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();

            // Locking system
            $table->foreignId('locked_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('locked_at')->nullable();

            // Status tracking
            $table->enum('status', [
                'uploaded',     // just uploaded
                'processing',   // currently being worked on
                'completed',    // fully digitized
                'audit failed'
            ])->default('uploaded');

            // Optional metadata
            $table->unsignedInteger('total_amount')->nullable(); // e.g. total amount in the document
            $table->integer('total_expected_entries')->nullable(); // e.g. 20+ entries
            $table->integer('entered_entries')->default(0);
            $table->index('locked_by');
            $table->index('status');
            $table->index('entered_entries');
            $table->index('total_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suretydocuments');
    }
};
