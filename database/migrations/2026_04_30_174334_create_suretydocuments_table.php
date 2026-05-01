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
                'completed'     // fully digitized
            ])->default('uploaded');

            // Optional metadata
            $table->integer('total_expected_entries')->nullable(); // e.g. 20+ entries
            $table->integer('entered_entries')->default(0);
            $table->index(['status', 'locked_by']);
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
