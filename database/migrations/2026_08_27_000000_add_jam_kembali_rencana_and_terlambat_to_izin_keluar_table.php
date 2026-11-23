<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('izin_keluar', function (Blueprint $table) {
            $table->time('jam_kembali_rencana')->nullable()
                  ->comment('rencana jam kembali dari siswa')
                  ->after('jam_keluar_rencana');
            $table->boolean('terlambat')->default(false)
                  ->comment('true jika jam kembali aktual melebihi rencana')
                  ->after('jam_kembali_aktual');
        });
    }

    public function down(): void
    {
        Schema::table('izin_keluar', function (Blueprint $table) {
            $table->dropColumn(['jam_kembali_rencana', 'terlambat']);
        });
    }
};
