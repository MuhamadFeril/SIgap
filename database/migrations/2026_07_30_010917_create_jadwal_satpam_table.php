<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_satpam', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('satpam_id')->constrained('satpam')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('shift', ['pagi', 'siang', 'malam']);
            $table->enum('status_hadir', ['belum_presensi', 'hadir', 'tidak_hadir'])
                  ->default('belum_presensi');
            $table->timestamp('jam_masuk')->nullable();
            $table->timestamp('jam_pulang')->nullable();
            $table->timestamps();

            $table->unique(['satpam_id', 'tanggal', 'shift'], 'uniq_satpam_tanggal_shift');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_satpam');
    }
};