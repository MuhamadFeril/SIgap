<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            $siswa = $user?->siswa;

            // Jika belum ada profil siswa, tampilkan dashboard kosong
            if (!$siswa) {
                return view('siswa.dashboard', [
                    'siswa' => null,
                    'izinKeluar' => collect([]),
                    'izinPending' => 0,
                    'izinApproved' => 0,
                ]);
            }

            $izinKeluar = IzinKeluar::where('siswa_id', $siswa->id)
                ->latest()
                ->take(5)
                ->get();

            $izinPending = IzinKeluar::where('siswa_id', $siswa->id)
                ->where('status', 'pending')
                ->count();

            $izinApproved = IzinKeluar::where('siswa_id', $siswa->id)
                ->where('status', 'approved')
                ->whereNull('jam_kembali_aktual')
                ->count();

            return view('siswa.dashboard', compact('siswa', 'izinKeluar', 'izinPending', 'izinApproved'));
        } catch (\Exception $e) {
            return view('siswa.dashboard', [
                'siswa' => auth()->user()?->siswa,
                'izinKeluar' => collect([]),
                'izinPending' => 0,
                'izinApproved' => 0,
                'error' => $e->getMessage()
            ]);
        }
    }
}