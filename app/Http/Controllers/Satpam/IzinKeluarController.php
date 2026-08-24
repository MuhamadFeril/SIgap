<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use App\Models\LogGerbang;
use Illuminate\Http\Request;

class IzinKeluarController extends Controller
{
    public function index()
    {
        $izinKeluar = IzinKeluar::with('siswa.user')
            ->where('status', 'approved')
            ->whereNull('jam_keluar_aktual')
            ->latest()
            ->get();

        return view('satpam.izin_keluar.index', compact('izinKeluar'));
    }

    public function tandaiKeluar(Request $request, IzinKeluar $izinKeluar)
    {
        if ($izinKeluar->status !== 'approved') {
            return redirect()->back()->with('error', 'Hanya izin yang disetujui yang bisa ditandai keluar');
        }

        if ($izinKeluar->jam_keluar_aktual) {
            return redirect()->back()->with('error', 'Siswa sudah ditandai keluar');
        }

        $izinKeluar->update([
            'jam_keluar_aktual' => now(),
            'dicatat_keluar_oleh' => auth()->id(),
        ]);

        // Create log gerbang
        LogGerbang::create([
            'izin_id' => $izinKeluar->id,
            'tipe' => 'keluar',
            'waktu' => now(),
            'dicatat_oleh' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditandai keluar');
    }

    public function tandaiKembali(Request $request, IzinKeluar $izinKeluar)
    {
        if (!$izinKeluar->jam_keluar_aktual) {
            return redirect()->back()->with('error', 'Siswa belum ditandai keluar');
        }

        if ($izinKeluar->jam_kembali_aktual) {
            return redirect()->back()->with('error', 'Siswa sudah ditandai kembali');
        }

        $izinKeluar->update([
            'jam_kembali_aktual' => now(),
            'dicatat_kembali_oleh' => auth()->id(),
        ]);

        // Create log gerbang
        LogGerbang::create([
            'izin_id' => $izinKeluar->id,
            'tipe' => 'kembali',
            'waktu' => now(),
            'dicatat_oleh' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditandai kembali');
    }

    public function keluarHariIni()
    {
        $izinKeluar = IzinKeluar::with('siswa.user')
            ->where('status', 'approved')
            ->whereNotNull('jam_keluar_aktual')
            ->whereNull('jam_kembali_aktual')
            ->whereDate('jam_keluar_aktual', today())
            ->latest()
            ->get();

        return view('satpam.izin_keluar.keluar-hari-ini', [
            'izinKeluarHariIni' => $izinKeluar,
        ]);
    }

    public function riwayat()
    {
        $izinKeluar = IzinKeluar::with('siswa.user', 'dicatatKeluarOleh', 'dicatatKembaliOleh')
            ->whereNotNull('jam_keluar_aktual')
            ->latest()
            ->paginate(20);

        return view('satpam.izin_keluar.riwayat', compact('izinKeluar'));
    }
}
