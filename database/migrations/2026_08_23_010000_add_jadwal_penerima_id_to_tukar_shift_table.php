<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tukar_shift', function (Blueprint $table) {
            if (!Schema::hasColumn('tukar_shift', 'jadwal_penerima_id')) {
                $table->uuid('jadwal_penerima_id')->nullable()->after('jadwal_id');
                $table->foreign('jadwal_penerima_id')
                    ->references('id')
                    ->on('jadwal_satpam')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tukar_shift', function (Blueprint $table) {
            if (Schema::hasColumn('tukar_shift', 'jadwal_penerima_id')) {
                $table->dropForeign(['jadwal_penerima_id']);
                $table->dropColumn('jadwal_penerima_id');
            }
        });
    }
};
