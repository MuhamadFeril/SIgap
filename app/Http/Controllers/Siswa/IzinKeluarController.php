<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use Illuminate\Http\Request;

class IzinKeluarController extends Controller
{
    private function currentSiswa()
    {
        return auth()->user()?->siswa;
    }

    private function missingSiswaRedirect()
    {
        return redirect()
            ->route('siswa.dashboard')
            ->with('error', 'Profil siswa akun ini belum terhubung. Silakan hubungi admin.');
    }

    public function index()
    {
        $siswa = $this->currentSiswa();

        if (!$siswa) {
            return $this->missingSiswaRedirect();
        }

        $izinKeluar = IzinKeluar::where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        return view('siswa.izin_keluar.index', compact('izinKeluar', 'siswa'));
    }

    public function create()
    {
        $siswa = $this->currentSiswa();

        if (!$siswa) {
            return $this->missingSiswaRedirect();
        }

        return view('siswa.izin_keluar.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $siswa = $this->currentSiswa();

        if (!$siswa) {
            return $this->missingSiswaRedirect();
        }

        $request->validate([
            'alasan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'jam_keluar_rencana' => 'required|date_format:H:i',
        ]);

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
        $siswa = $this->currentSiswa();

        if (!$siswa) {
            return $this->missingSiswaRedirect();
        }

        $izinKeluar->load('siswa.user', 'disetujuiOleh', 'dicatatKeluarOleh', 'dicatatKembaliOleh');
        
        if ($izinKeluar->siswa_id !== $siswa->id) {
            abort(403);
        }

        return view('siswa.izin_keluar.show', compact('izinKeluar', 'siswa'));
    }

    public function destroy(IzinKeluar $izinKeluar)
    {
        $siswa = $this->currentSiswa();

        if (!$siswa) {
            return $this->missingSiswaRedirect();
        }

        if ($izinKeluar->siswa_id !== $siswa->id) {
            abort(403);
        }

        if ($izinKeluar->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya permintaan pending yang bisa dibatalkan');
        }

        $izinKeluar->delete();

        return redirect()->route('siswa.izin_keluar.index')->with('success', 'Permintaan izin keluar dibatalkan');
    }
}