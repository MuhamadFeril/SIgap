<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use Illuminate\Http\Request;

class IzinKeluarController extends Controller
{
    public function index()
    {
        $izinKeluar = IzinKeluar::with('siswa.user', 'disetujuiOleh')
            ->latest()
            ->paginate(20);

        return view('guru.izin_keluar.index', compact('izinKeluar'));
    }

    public function approve(Request $request, IzinKeluar $izinKeluar)
    {
        if ($izinKeluar->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pengajuan pending yang bisa disetujui.');
        }

        $izinKeluar->update([
            'status' => 'approved',
            'disetujui_oleh' => auth()->id(),
            'waktu_keputusan' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin keluar berhasil disetujui.');
    }

    public function reject(Request $request, IzinKeluar $izinKeluar)
    {
        if ($izinKeluar->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pengajuan pending yang bisa ditolak.');
        }

        $izinKeluar->update([
            'status' => 'rejected',
            'disetujui_oleh' => auth()->id(),
            'waktu_keputusan' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin keluar berhasil ditolak.');
    }
}
