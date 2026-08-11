<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use Illuminate\Http\Request;

class IzinKeluarController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $izinKeluar = IzinKeluar::where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        return view('siswa.izin_keluar.index', compact('izinKeluar'));
    }

    public function create()
    {
        return view('siswa.izin_keluar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alasan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'jam_keluar_rencana' => 'required|date_format:H:i',
        ]);

        $siswa = auth()->user()->siswa;
        $buktiPath = null;

        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti_izin', 'public');
        }

        IzinKeluar::create([
            'siswa_id' => $siswa->id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi,
            'bukti_path' => $buktiPath,
            'jam_keluar_rencana' => $request->jam_keluar_rencana,
            'status' => 'pending',
        ]);

        return redirect()->route('siswa.izin_keluar.index')->with('success', 'Permintaan izin keluar berhasil dibuat');
    }

    public function show(IzinKeluar $izinKeluar)
    {
        $izinKeluar->load('siswa.user', 'disetujuiOleh', 'dicatatKeluarOleh', 'dicatatKembaliOleh');
        
        if ($izinKeluar->siswa_id !== auth()->user()->siswa->id) {
            abort(403);
        }

        return view('siswa.izin_keluar.show', compact('izinKeluar'));
    }

    public function destroy(IzinKeluar $izinKeluar)
    {
        if ($izinKeluar->siswa_id !== auth()->user()->siswa->id) {
            abort(403);
        }

        if ($izinKeluar->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya permintaan pending yang bisa dibatalkan');
        }

        $izinKeluar->delete();

        return redirect()->route('siswa.izin_keluar.index')->with('success', 'Permintaan izin keluar dibatalkan');
    }
}