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

        if ($jadwalSatpam->jam_pulang && now()->lt($jadwalSatpam->jam_pulang)) {
            return redirect()->back()->with('error', 'Belum waktunya presensi pulang (jam pulang ' . $jadwalSatpam->jam_pulang->format('H:i') . ')');
        }

        $jadwalSatpam->update([
            'waktu_pulang' => now(),
        ]);

        return redirect()->back()->with('success', 'Presensi pulang berhasil');
    }

    public function presensiHariIni(Request $request)
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        $jadwal = JadwalSatpam::where('satpam_id', $satpam->id)
            ->whereDate('tanggal', today())
            ->orderByDesc('id')
            ->first();

        if (!$jadwal) {
            $jadwal = JadwalSatpam::create([
                'satpam_id' => $satpam->id,
                'tanggal' => today(),
                'shift' => 'pagi',
                'status_hadir' => 'belum_presensi',
            ]);
        }

        $state = 'selesai';
        $message = 'Anda sudah presensi masuk dan pulang hari ini';

        if (!$jadwal->waktu_masuk) {
            $waktuMasuk = now();
            $telat = $jadwal->jam_masuk
                ? $waktuMasuk->gt($jadwal->jam_masuk)
                : false;

            $jadwal->update([
                'waktu_masuk' => $waktuMasuk,
                'status_hadir' => 'hadir',
                'telat_masuk' => $telat,
            ]);
            $state = 'masuk';
            $message = $telat
                ? 'Presensi masuk berhasil, tetapi Anda telat'
                : 'Presensi masuk berhasil';
        } elseif (!$jadwal->waktu_pulang) {
            if ($jadwal->jam_pulang && now()->lt($jadwal->jam_pulang)) {
                $message = 'Belum waktunya presensi pulang (jam pulang ' . $jadwal->jam_pulang->format('H:i') . ')';
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $message]);
                }
                return redirect()->back()->with('error', $message);
            }

            $jadwal->update([
                'waktu_pulang' => now(),
            ]);
            $state = 'pulang';
            $message = 'Presensi pulang berhasil';
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'state' => $state,
                'status_hadir' => $jadwal->status_hadir,
                'telat_masuk' => $jadwal->telat_masuk,
                'waktu_masuk' => $jadwal->waktu_masuk?->format('H:i'),
                'waktu_pulang' => $jadwal->waktu_pulang?->format('H:i'),
            ]);
        }

        return redirect()->back()->with(
            $state === 'selesai' ? 'info' : 'success',
            $message
        );
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
