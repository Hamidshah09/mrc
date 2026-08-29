<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Map any legacy status values to the new set BEFORE
         * altering the column, otherwise MySQL will refuse
         * with "Data truncated for column 'status'" if any row
         * still holds a value not in the new ENUM.
         *
         *   'Not Verified' -> 'Pending'   (registrar hasn't finished)
         *   'Confirmed'    -> 'Pending'   (legacy value used by store())
         *   anything else  -> 'Pending'   (safe fallback)
         */
        DB::statement("
            UPDATE mrc
            SET status = 'Pending'
            WHERE status NOT IN ('Pending', 'Completed', 'Verified')
        ");

        /*
         * Keep only the statuses needed by the workflow:
         *
         * Pending   = data entry not completed
         * Completed = data entry completed
         * Verified  = reserved for future verification
         */
        DB::statement("
            ALTER TABLE mrc
            MODIFY status ENUM(
                'Pending',
                'Completed',
                'Verified'
            )
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
            NOT NULL
            DEFAULT 'Pending'
        ");
    }

    public function down(): void
    {
        /*
         * Completed records remain Completed.
         *
         * Verified records are converted back to
         * Not Verified because that status will be
         * restored by this rollback.
         */
        

        DB::statement("
            ALTER TABLE mrc
            MODIFY status ENUM(
                'Verified',
                'Not Verified',
                'Pending',
                'Completed'
            )
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
            NOT NULL
            DEFAULT 'Pending'
        ");
    }
};