<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix Satpam table
        Schema::table('satpam', function (Blueprint $table) {
            if (!Schema::hasColumn('satpam', 'no_telepon')) {
                $table->string('no_telepon', 20)->nullable()->after('nip');
            }
        });

        // Fix Guru table
        Schema::table('guru', function (Blueprint $table) {
            if (!Schema::hasColumn('guru', 'no_telepon')) {
                $table->string('no_telepon', 20)->nullable();
            }
            if (!Schema::hasColumn('guru', 'mapel') && Schema::hasColumn('guru', 'Mapel')) {
                $table->renameColumn('Mapel', 'mapel');
            } elseif (!Schema::hasColumn('guru', 'mapel')) {
                $table->string('mapel', 100)->nullable();
            }
        });

        // Fix Siswa table
        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'nis')) {
                $table->string('nis', 50)->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('siswa', 'no_telepon')) {
                $table->string('no_telepon', 20)->nullable();
            }
            if (!Schema::hasColumn('siswa', 'alamat')) {
                $table->string('alamat', 255)->nullable();
            }
            // Avoid doctrine/dbal dependency for ->change().
            if (Schema::hasColumn('siswa', 'nomor_absen')) {
                DB::statement('ALTER TABLE siswa MODIFY nomor_absen VARCHAR(100) NULL');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('satpam', function (Blueprint $table) {
            if (Schema::hasColumn('satpam', 'no_telepon')) {
                $table->dropColumn('no_telepon');
            }
        });

        Schema::table('guru', function (Blueprint $table) {
            if (Schema::hasColumn('guru', 'no_telepon')) {
                $table->dropColumn('no_telepon');
            }
        });

        Schema::table('siswa', function (Blueprint $table) {
            $cols = array_filter(['nis', 'no_telepon', 'alamat'], fn($col) => Schema::hasColumn('siswa', $col));
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
