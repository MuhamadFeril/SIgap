<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fix: kolom user_id di tabel sessions harus string(36) agar bisa menyimpan UUID
     */
    public function up(): void
    {
        // Truncate sessions dulu karena data lama tidak kompatibel
        DB::table('sessions')->truncate();

        Schema::table('sessions', function (Blueprint $table) {
            // Ubah tipe user_id dari integer/bigint ke string(36) untuk UUID
            $table->string('user_id', 36)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('sessions')->truncate();

        Schema::table('sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }
};
