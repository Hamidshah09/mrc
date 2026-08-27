<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mrc', function (Blueprint $table) {
            $table->string('groom_name', 50)
                ->nullable()
                ->change();

            $table->string('bride_name', 50)
                ->nullable()
                ->change();

            $table->string('groom_father_name', 50)
                ->nullable()
                ->change();

            $table->string('bride_father_name', 50)
                ->nullable()
                ->change();

            $table->date('marriage_date')
                ->nullable()
                ->change();

            $table->date('registration_date')
                ->nullable()
                ->change();

            $table->unsignedBigInteger('user_id')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('mrc', function (Blueprint $table) {
            $table->string('groom_name', 50)
                ->nullable(false)
                ->change();

            $table->string('bride_name', 50)
                ->nullable(false)
                ->change();

            $table->string('groom_father_name', 50)
                ->nullable(false)
                ->change();

            $table->string('bride_father_name', 50)
                ->nullable(false)
                ->change();

            $table->date('marriage_date')
                ->nullable(false)
                ->change();

            $table->date('registration_date')
                ->nullable(false)
                ->change();

            $table->unsignedBigInteger('user_id')
                ->nullable(false)
                ->change();
        });
    }
};