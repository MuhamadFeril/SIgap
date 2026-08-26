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
                ]);
            }

            // Izin keluar yang perlu ditandai keluar (semua yang sudah disetujui
            // dan belum dicatat keluar, terlepas dari tanggal pengajuan)
            $izinMenungguKeluar = IzinKeluar::with('siswa.user')
                ->where('status', 'approved')
                ->whereNull('jam_keluar_aktual')
                ->count();

            // Siswa yang sedang keluar
            $siswaSedangKeluar = IzinKeluar::with('siswa.user')
                ->where('status', 'approved')
                ->whereNotNull('jam_keluar_aktual')
                ->whereNull('jam_kembali_aktual')
                ->count();

            // Jadwal hari ini (terbaru = jadwal baru dari admin diprioritaskan)
            $jadwalHariIni = JadwalSatpam::where('satpam_id', $satpam->id)
                ->whereDate('tanggal', today())
                ->orderByDesc('id')
                ->first();

            // Permintaan tukar shift masuk
            $tukarShiftMasuk = TukarShift::where('penerima_id', $satpam->id)
                ->where('status', 'pending')
                ->count();

            return view('satpam.dashboard', compact(
                'satpam',
                'izinMenungguKeluar',
                'siswaSedangKeluar',
                'jadwalHariIni',
                'tukarShiftMasuk'
            ));
        } catch (\Exception $e) {
            // Return error message if something goes wrong
            return view('satpam.dashboard', [
                'satpam' => auth()->user()?->satpam,
                'izinMenungguKeluar' => 0,
                'siswaSedangKeluar' => 0,
                'jadwalHariIni' => null,
                'tukarShiftMasuk' => 0,
                'error' => $e->getMessage()
            ]);
        }
    }
}