<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('izin_keluar', function (Blueprint $table) {
            if (!Schema::hasColumn('izin_keluar', 'foto_keluar_path')) {
                $table->string('foto_keluar_path')->nullable()->after('jam_keluar_aktual');
            }
            if (!Schema::hasColumn('izin_keluar', 'foto_kembali_path')) {
                $table->string('foto_kembali_path')->nullable()->after('foto_keluar_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('izin_keluar', function (Blueprint $table) {
            if (Schema::hasColumn('izin_keluar', 'foto_kembali_path')) {
                $table->dropColumn('foto_kembali_path');
            }
            if (Schema::hasColumn('izin_keluar', 'foto_keluar_path')) {
                $table->dropColumn('foto_keluar_path');
            }
        });
    }
};
