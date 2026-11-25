<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use App\Models\LogGerbang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function show(IzinKeluar $izinKeluar)
    {
        $izinKeluar->load('siswa.user', 'disetujuiOleh', 'dicatatKeluarOleh', 'dicatatKembaliOleh');

        return view('satpam.izin_keluar.show', compact('izinKeluar'));
    }

    public function tandaiKeluar(Request $request, IzinKeluar $izinKeluar)
    {
        if (!in_array($izinKeluar->status, [IzinKeluar::STATUS_APPROVED, IzinKeluar::STATUS_SAKIT])) {
            return redirect()->back()->with('error', 'Hanya izin yang disetujui atau sakit yang bisa ditandai keluar');
        }

        if ($izinKeluar->jam_keluar_aktual) {
            return redirect()->back()->with('error', 'Siswa sudah ditandai keluar');
        }

        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'jam_keluar_aktual' => now(),
            'dicatat_keluar_oleh' => auth()->id(),
        ];

        if ($request->hasFile('foto')) {
            if ($izinKeluar->foto_keluar_path) {
                Storage::disk('public')->delete($izinKeluar->foto_keluar_path);
            }
            $data['foto_keluar_path'] = $request->file('foto')->store('bukti-keluar', 'public');
        }

        $izinKeluar->update($data);

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

        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'jam_kembali_aktual' => now(),
            'dicatat_kembali_oleh' => auth()->id(),
        ];

        $izinKeluar->jam_kembali_aktual = $data['jam_kembali_aktual'];
        $data['terlambat'] = $izinKeluar->isTerlambat();

        if ($request->hasFile('foto')) {
            if ($izinKeluar->foto_kembali_path) {
                Storage::disk('public')->delete($izinKeluar->foto_kembali_path);
            }
            $data['foto_kembali_path'] = $request->file('foto')->store('bukti-keluar', 'public');
        }

        $izinKeluar->update($data);

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
