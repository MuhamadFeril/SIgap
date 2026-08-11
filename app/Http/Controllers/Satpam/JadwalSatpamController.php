<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\JadwalSatpam;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalSatpamController extends Controller
{
    public function index()
    {
        $jadwalSatpam = JadwalSatpam::with('satpam.user')
            ->where('satpam_id', auth()->user()->satpam->id)
            ->where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal')
            ->orderBy('shift')
            ->get();

        return view('satpam.jadwal.index', compact('jadwalSatpam'));
    }

    public function presensiMasuk(Request $request, JadwalSatpam $jadwalSatpam)
    {
        if ($jadwalSatpam->satpam_id !== auth()->user()->satpam->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke jadwal ini');
        }

        if ($jadwalSatpam->jam_masuk) {
            return redirect()->back()->with('error', 'Anda sudah presensi masuk');
        }

        $jadwalSatpam->update([
            'jam_masuk' => now(),
            'status_hadir' => 'hadir',
        ]);

        return redirect()->back()->with('success', 'Presensi masuk berhasil');
    }

    public function presensiPulang(Request $request, JadwalSatpam $jadwalSatpam)
    {
        if ($jadwalSatpam->satpam_id !== auth()->user()->satpam->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke jadwal ini');
        }

        if (!$jadwalSatpam->jam_masuk) {
            return redirect()->back()->with('error', 'Anda belum presensi masuk');
        }

        if ($jadwalSatpam->jam_pulang) {
            return redirect()->back()->with('error', 'Anda sudah presensi pulang');
        }

        $jadwalSatpam->update([
            'jam_pulang' => now(),
        ]);

        return redirect()->back()->with('success', 'Presensi pulang berhasil');
    }

    public function riwayat()
    {
        $jadwalSatpam = JadwalSatpam::with('satpam.user')
            ->where('satpam_id', auth()->user()->satpam->id)
            ->where('tanggal', '<', Carbon::today())
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('satpam.jadwal.riwayat', compact('jadwalSatpam'));
    }
}