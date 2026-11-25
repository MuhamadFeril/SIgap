<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add the default role used by self-registered accounts.
     */
    public function up(): void
    {
        // Avoid doctrine/dbal dependency: modify the enum using raw SQL.
        // Idempotent: the role column already allows these values.
        DB::statement("ALTER TABLE users MODIFY role ENUM('user','siswa','guru','admin','satpam') NOT NULL");
    }

    /**
     * Remove the self-registered user role.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('siswa','guru','admin','satpam') NOT NULL");
    }
};
