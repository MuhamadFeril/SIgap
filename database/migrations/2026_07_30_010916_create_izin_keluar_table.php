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
        Schema::create('izin_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->string('alasan', 100);
            $table->text('deskripsi')->nullable()->comment('keterangan tambahan dari siswa');
            $table->string('bukti_path')->nullable()->comment('path file foto/pdf bukti (opsional)');
            $table->time('jam_keluar_rencana');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->foreignId('disetujui_oleh')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->timestamp('waktu_keputusan')->nullable();

            $table->timestamp('jam_keluar_aktual')->nullable()
                  ->comment('diisi satpam saat tandai keluar');
            $table->timestamp('jam_kembali_aktual')->nullable()
                  ->comment('diisi satpam saat tandai kembali');

            $table->foreignId('dicatat_keluar_oleh')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->foreignId('dicatat_kembali_oleh')->nullable()
                  ->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_keluar');
    }
};