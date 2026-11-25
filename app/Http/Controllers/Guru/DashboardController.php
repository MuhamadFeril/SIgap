<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use App\Models\TukarShift;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $guru = $user?->guru;
            $izinPending = $guru
                ? IzinKeluar::where('siswa_id', $guru?->siswa?->id)->where('status', 'pending')->count()
                : IzinKeluar::where('status', 'pending')->count();

            $izinToday = IzinKeluar::where('status', 'approved')
                ->whereDate('created_at', today())
                ->count();

            $tukarShiftPending = TukarShift::where('status', 'pending')->count();

            $izinKeluarTerbaru = IzinKeluar::with('siswa.user')
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();

            $rekapHariIni = IzinKeluar::with('siswa.user')
                ->where('status', 'approved')
                ->where(function ($query) {
                    $query->whereDate('jam_keluar_aktual', today())
                          ->orWhereDate('jam_kembali_aktual', today());
                })
                ->orderByDesc('jam_kembali_aktual')
                ->orderByDesc('jam_keluar_aktual')
                ->get();

            $totalKeluarHariIni = IzinKeluar::where('status', 'approved')
                ->whereDate('jam_keluar_aktual', today())
                ->count();

            $totalKembaliHariIni = IzinKeluar::where('status', 'approved')
                ->whereDate('jam_kembali_aktual', today())
                ->count();

            $totalTelatHariIni = IzinKeluar::where('status', 'approved')
                ->where('terlambat', true)
                ->whereDate('jam_kembali_aktual', today())
                ->count();

            return view('guru.dashboard', compact(
                'guru',
                'izinPending',
                'izinToday',
                'tukarShiftPending',
                'izinKeluarTerbaru',
                'rekapHariIni',
                'totalKeluarHariIni',
                'totalKembaliHariIni',
                'totalTelatHariIni'
            ));
        } catch (\Exception $e) {
            return view('guru.dashboard', [
                'guru' => Auth::user()?->guru,
                'izinPending' => 0,
                'izinToday' => 0,
                'tukarShiftPending' => 0,
                'izinKeluarTerbaru' => collect([]),
                'rekapHariIni' => collect([]),
                'totalKeluarHariIni' => 0,
                'totalKembaliHariIni' => 0,
                'totalTelatHariIni' => 0,
                'error' => $e->getMessage()
            ]);
        }
    }
}