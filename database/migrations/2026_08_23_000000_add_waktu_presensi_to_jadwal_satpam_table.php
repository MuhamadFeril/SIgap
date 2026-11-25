<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_satpam', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_satpam', 'waktu_masuk')) {
                $table->timestamp('waktu_masuk')->nullable()->after('jam_pulang');
            }
            if (!Schema::hasColumn('jadwal_satpam', 'waktu_pulang')) {
                $table->timestamp('waktu_pulang')->nullable()->after('waktu_masuk');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_satpam', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_satpam', 'waktu_masuk')) {
                $table->dropColumn('waktu_masuk');
            }
            if (Schema::hasColumn('jadwal_satpam', 'waktu_pulang')) {
                $table->dropColumn('waktu_pulang');
            }
        });
    }
};
