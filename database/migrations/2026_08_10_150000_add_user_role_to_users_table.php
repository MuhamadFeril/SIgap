<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add the default role used by self-registered accounts.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'siswa', 'guru', 'admin', 'satpam'])->change();
        });
    }

    /**
     * Remove the self-registered user role.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['siswa', 'guru', 'admin', 'satpam'])->change();
        });
    }
};
