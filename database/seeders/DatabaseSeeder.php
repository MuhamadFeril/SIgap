<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $users = [
           [
               'name' => 'Admin Sekolah',
               'email' => 'admin@sekolah.com',
               'username' => 'admin',
               'password' => Hash::make('admin123'),
               'role' => 'admin',
           ],
           [
               'name' => 'Guru Piket',
               'email' => 'gurupiket@sekolah.com',
               'username' => 'gurupiket',
               
               'password' => Hash::make('guru123'),
               'role' => 'guru',
           ],
           [
               'name' => 'Satpam Sekolah',
               'email' => 'satpam@sekolah.com',
               'username'=> 'satpam',
               'password' => Hash::make('satpam123'),
               'role' => 'satpam',
           ],
           [
               'name' => 'Siswa Sekolah',
               'email' => 'siswa@sekolah.com',
               'username' => 'siswa',
               'password' => Hash::make('siswa123'),
               'role' => 'siswa',
           ]
       ];

       foreach ($users as $userData) {
           $user = User::firstOrCreate(
               ['email' => $userData['email']],
               [
                   'name' => $userData['name'],
                   'username' => $userData['username'],
                   'email' => $userData['email'],
                   'password' => $userData['password'],
                   'role' => $userData['role'],
                   'status' => 'aktif',
               ]
           );
       }
    }
}
