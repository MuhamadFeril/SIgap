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

            $izinPending = IzinKeluar::where('status', 'pending')->count();

            $izinToday = IzinKeluar::where('status', 'approved')
                ->whereDate('created_at', today())
                ->count();

            $tukarShiftPending = TukarShift::where('status', 'pending')->count();

            $izinKeluarTerbaru = IzinKeluar::with('siswa.user')
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();

            return view('guru.dashboard', compact(
                'guru',
                'izinPending',
                'izinToday',
                'tukarShiftPending',
                'izinKeluarTerbaru'
            ));
        } catch (\Exception $e) {
            return view('guru.dashboard', [
                'guru' => Auth::user()?->guru,
                'izinPending' => 0,
                'izinToday' => 0,
                'tukarShiftPending' => 0,
                'izinKeluarTerbaru' => collect([]),
                'error' => $e->getMessage()
            ]);
        }
    }
}