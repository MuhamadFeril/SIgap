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
        Schema::create('tukar_shift', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('jadwal_id')->constrained('jadwal_satpam')->cascadeOnDelete()
                  ->comment('jadwal yang ingin ditukar');
            $table->foreignUuid('pengaju_id')->constrained('satpam')->cascadeOnDelete()
                  ->comment('satpam yang mengajukan');
            $table->foreignUuid('penerima_id')->constrained('satpam')->cascadeOnDelete()
                  ->comment('satpam pengganti');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignUuid('disetujui_oleh')->nullable()
                  ->constrained('users')->nullOnDelete()
                  ->comment('admin yang menyetujui');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tukar_shift');
    }
};