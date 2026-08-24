<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\JadwalSatpam;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalSatpamController extends Controller
{
    private function currentSatpam()
    {
        return auth()->user()?->satpam;
    }

    private function missingSatpamRedirect()
    {
        return redirect()
            ->route('satpam.dashboard')
            ->with('error', 'Profil satpam akun ini belum terhubung. Silakan hubungi admin.');
    }

    public function index()
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        $weekOffset = (int) request('week_offset', 0);
        $startDate = Carbon::today()->startOfWeek(Carbon::MONDAY)->addWeeks($weekOffset);
        $endDate = $startDate->copy()->addDays(6)->endOfDay();

        $jadwalSatpam = JadwalSatpam::with('satpam.user')
            ->where('satpam_id', $satpam->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal')
            ->orderBy('shift')
            ->get();

        return view('satpam.jadwal.index', compact('jadwalSatpam', 'startDate', 'endDate', 'weekOffset'));
    }

    public function presensiMasuk(Request $request, JadwalSatpam $jadwalSatpam)
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        if ($jadwalSatpam->satpam_id !== $satpam->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke jadwal ini');
        }

        if ($jadwalSatpam->waktu_masuk) {
            return redirect()->back()->with('error', 'Anda sudah presensi masuk');
        }

        $jadwalSatpam->update([
            'waktu_masuk' => now(),
            'status_hadir' => 'hadir',
        ]);

        return redirect()->back()->with('success', 'Presensi masuk berhasil');
    }

    public function presensiPulang(Request $request, JadwalSatpam $jadwalSatpam)
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        if ($jadwalSatpam->satpam_id !== $satpam->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke jadwal ini');
        }

        if (!$jadwalSatpam->waktu_masuk) {
            return redirect()->back()->with('error', 'Anda belum presensi masuk');
        }

        if ($jadwalSatpam->waktu_pulang) {
            return redirect()->back()->with('error', 'Anda sudah presensi pulang');
        }

        $jadwalSatpam->update([
            'waktu_pulang' => now(),
        ]);

        return redirect()->back()->with('success', 'Presensi pulang berhasil');
    }

    public function riwayat()
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        $riwayatJadwal = JadwalSatpam::with('satpam.user')
            ->where('satpam_id', $satpam->id)
            ->where('tanggal', '<', Carbon::today())
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('satpam.jadwal.riwayat', compact('riwayatJadwal'));
    }
}
