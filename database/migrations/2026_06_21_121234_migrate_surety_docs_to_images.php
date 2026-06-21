<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Copy existing docs values to surety_images table
        if (Schema::hasTable('suretyregister') && Schema::hasTable('surety_images')) {
            $records = DB::table('suretyregister')->whereNotNull('docs')->get();

            foreach ($records as $r) {
                DB::table('surety_images')->insert([
                    'surety_register_id' => $r->id,
                    'path' => $r->docs,
                    'original_name' => basename($r->docs),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // drop the old docs column
            if (Schema::hasColumn('suretyregister', 'docs')) {
                Schema::table('suretyregister', function (Blueprint $table) {
                    $table->dropColumn('docs');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate docs column and populate from first image if available
        if (Schema::hasTable('suretyregister')) {
            if (!Schema::hasColumn('suretyregister', 'docs')) {
                Schema::table('suretyregister', function (Blueprint $table) {
                    $table->string('docs', 100)->nullable()->after('checque_no');
                });

                // populate docs from first related surety_images entry
                if (Schema::hasTable('surety_images')) {
                    $groups = DB::table('surety_images')
                        ->select('surety_register_id', 'path')
                        ->orderBy('id')
                        ->get()
                        ->groupBy('surety_register_id');

                    foreach ($groups as $suretyId => $imgs) {
                        $first = $imgs->first();
                        DB::table('suretyregister')->where('id', $suretyId)->update(['docs' => $first->path]);
                    }
                }
            }
        }
    }
};
