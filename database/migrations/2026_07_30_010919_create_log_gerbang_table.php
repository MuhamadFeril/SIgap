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
        Schema::create('log_gerbang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('izin_id')->constrained('izin_keluar')->cascadeOnDelete();
            $table->enum('tipe', ['keluar', 'kembali']);
            $table->timestamp('waktu')->useCurrent();
            $table->foreignId('dicatat_oleh')->constrained('users')->cascadeOnDelete()
                  ->comment('user_id satpam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_gerbang');
    }
};