<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\IzinKeluar;
use App\Models\JadwalSatpam;
use App\Models\Satpam;
use App\Models\Siswa;
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
        // ─── 1. Admin ────────────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@sekolah.com'],
            [
                'name'     => 'Admin Sekolah',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'status'   => 'aktif',
            ]
        );

        // ─── 2. Guru Piket ────────────────────────────────────────────────────
        $userGuru = User::firstOrCreate(
            ['email' => 'gurupiket@sekolah.com'],
            [
                'name'     => 'Guru Piket',
                'password' => Hash::make('guru123'),
                'role'     => 'guru',
                'status'   => 'aktif',
            ]   
        );

        Guru::firstOrCreate(
            ['user_id' => $userGuru->id],
            [
                'nip'        => '198501012010011001',
                'mapel'      => 'Matematika',
                'no_telepon' => '081234567890',
            ]
        );

        // ─── 3. Satpam #1 ─────────────────────────────────────────────────────
        $userSatpam1 = User::firstOrCreate(
            ['email' => 'satpam@sekolah.com'],
            [
                'name'     => 'Satpam Sekolah',
                'password' => Hash::make('satpam123'),
                'role'     => 'satpam',
                'status'   => 'aktif',
            ]
        );

        $satpam1 = Satpam::firstOrCreate(
            ['user_id' => $userSatpam1->id],
            [
                'nip'        => '199001012015011001',
                'no_telepon' => '082345678901',
            ]
        );

        // ─── 4. Satpam #2 (untuk testing tukar shift) ─────────────────────────
        $userSatpam2 = User::firstOrCreate(
            ['email' => 'satpam2@sekolah.com'],
            [
                'name'     => 'Satpam Dua',
                'password' => Hash::make('satpam123'),
                'role'     => 'satpam',
                'status'   => 'aktif',
            ]
        );

        $satpam2 = Satpam::firstOrCreate(
            ['user_id' => $userSatpam2->id],
            [
                'nip'        => '199002022015011002',
                'no_telepon' => '083456789012',
            ]
        );

        // ─── 5. Siswa ─────────────────────────────────────────────────────────
        $userSiswa = User::firstOrCreate(
            ['email' => 'siswa@sekolah.com'],
            [
                'name'     => 'Siswa Sekolah',
                'password' => Hash::make('siswa123'),
                'role'     => 'siswa',
                'status'   => 'aktif',
            ]
        );

        $siswa = Siswa::firstOrCreate(
            ['user_id' => $userSiswa->id],
            [
                'nis'          => '2024001',
                'kelas'        => 'XII IPA 1',
                'nomor_absen'  => '001',
                'no_telepon'   => '085678901234',
                'alamat'       => 'Jl. Contoh No. 1, Kota',
            ]
        );

        // ─── 6. Jadwal Satpam (hari ini & mendatang) ──────────────────────────
        $jadwalData = [
            ['satpam_id' => $satpam1->id, 'tanggal' => now()->toDateString(),          'shift' => 'pagi',  'status_hadir' => 'hadir',           'jam_masuk' => now()->setTime(7, 0),  'jam_pulang' => now()->setTime(15, 0), 'waktu_masuk' => now()->setTime(7, 5)],
            ['satpam_id' => $satpam1->id, 'tanggal' => now()->addDay()->toDateString(), 'shift' => 'siang', 'status_hadir' => 'belum_presensi',  'jam_masuk' => now()->addDay()->setTime(15, 0), 'jam_pulang' => now()->addDay()->setTime(23, 0)],
            ['satpam_id' => $satpam1->id, 'tanggal' => now()->addDays(2)->toDateString(),'shift' => 'malam', 'status_hadir' => 'belum_presensi', 'jam_masuk' => now()->addDays(2)->setTime(23, 0), 'jam_pulang' => now()->addDays(3)->setTime(7, 0)],
            ['satpam_id' => $satpam2->id, 'tanggal' => now()->toDateString(),          'shift' => 'siang', 'status_hadir' => 'belum_presensi',  'jam_masuk' => now()->setTime(15, 0), 'jam_pulang' => now()->setTime(23, 0)],
            ['satpam_id' => $satpam2->id, 'tanggal' => now()->addDay()->toDateString(), 'shift' => 'pagi',  'status_hadir' => 'belum_presensi', 'jam_masuk' => now()->addDay()->setTime(7, 0), 'jam_pulang' => now()->addDay()->setTime(15, 0)],
        ];

        foreach ($jadwalData as $j) {
            JadwalSatpam::firstOrCreate(
                [
                    'satpam_id' => $j['satpam_id'],
                    'tanggal'   => $j['tanggal'],
                    'shift'     => $j['shift'],
                ],
                [
                    'status_hadir' => $j['status_hadir'],
                    'jam_masuk'    => $j['jam_masuk'],
                    'jam_pulang'   => $j['jam_pulang'] ?? null,
                    'waktu_masuk'  => $j['waktu_masuk'] ?? null,
                ]
            );
        }

        // ─── 7. Contoh IzinKeluar ─────────────────────────────────────────────
        // Pending – menunggu persetujuan guru
        IzinKeluar::firstOrCreate(
            ['siswa_id' => $siswa->id, 'alasan' => 'Berobat', 'status' => 'pending'],
            [
                'deskripsi'          => 'Kontrol kesehatan rutin ke klinik',
                'jam_keluar_rencana' => '10:00:00',
            ]
        );

        // Approved & sudah keluar – satpam sudah menandai keluar
        IzinKeluar::firstOrCreate(
            ['siswa_id' => $siswa->id, 'alasan' => 'Dijemput orang tua', 'status' => 'approved'],
            [
                'jam_keluar_rencana'  => '13:00:00',
                'disetujui_oleh'      => $userGuru->id,
                'waktu_keputusan'     => now()->subHour(),
                'jam_keluar_aktual'   => now()->subMinutes(30),
                'dicatat_keluar_oleh' => $userSatpam1->id,
            ]
        );    }
}
