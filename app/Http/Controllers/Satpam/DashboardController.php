<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use App\Models\JadwalSatpam;
use App\Models\TukarShift;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $satpam = auth()->user()?->satpam;

            // Jika belum ada profil satpam, tampilkan dashboard kosong
            if (!$satpam) {
                return view('satpam.dashboard', [
                    'satpam' => null,
                    'izinMenungguKeluar' => 0,
                    'siswaSedangKeluar' => 0,
                    'jadwalHariIni' => null,
                    'tukarShiftMasuk' => 0,
                    'daftarMenungguKeluar' => collect(),
                ]);
            }

            // Izin keluar yang perlu ditandai keluar (sudah disetujui, belum keluar)
            $izinMenungguKeluar = IzinKeluar::where('status', 'approved')
                ->whereNull('jam_keluar_aktual')
                ->count();

            // Siswa yang sedang keluar (sudah keluar, belum kembali)
            $siswaSedangKeluar = IzinKeluar::where('status', 'approved')
                ->whereNotNull('jam_keluar_aktual')
                ->whereNull('jam_kembali_aktual')
                ->count();

            // Jadwal hari ini
            $jadwalHariIni = JadwalSatpam::where('satpam_id', $satpam->id)
                ->whereDate('tanggal', today())
                ->orderByDesc('id')
                ->first();

            // Permintaan tukar shift masuk
            $tukarShiftMasuk = TukarShift::where('penerima_id', $satpam->id)
                ->where('status', 'pending')
                ->count();

            // Daftar lengkap siswa yang izinnya sudah disetujui & menunggu ditandai keluar
            $daftarMenungguKeluar = IzinKeluar::with('siswa.user', 'disetujuiOleh')
                ->where('status', 'approved')
                ->whereNull('jam_keluar_aktual')
                ->latest('waktu_keputusan')
                ->get();

            return view('satpam.dashboard', compact(
                'satpam',
                'izinMenungguKeluar',
                'siswaSedangKeluar',
                'jadwalHariIni',
                'tukarShiftMasuk',
                'daftarMenungguKeluar'
            ));
        } catch (\Exception $e) {
            return view('satpam.dashboard', [
                'satpam' => auth()->user()?->satpam,
                'izinMenungguKeluar' => 0,
                'siswaSedangKeluar' => 0,
                'jadwalHariIni' => null,
                'tukarShiftMasuk' => 0,
                'daftarMenungguKeluar' => collect(),
                'error' => $e->getMessage()
            ]);
        }
    }
}