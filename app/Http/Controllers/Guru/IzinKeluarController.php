<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use App\Models\LogGerbang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IzinKeluarController extends Controller
{
    public function show(IzinKeluar $izinKeluar)
    {
        $izinKeluar->load('siswa.user', 'disetujuiOleh', 'dicatatKeluarOleh', 'dicatatKembaliOleh');

        return view('guru.izin_keluar.show', compact('izinKeluar'));
    }

    public function index()
    {
        $izinKeluar = IzinKeluar::with('siswa.user', 'disetujuiOleh')
            ->latest()
            ->paginate(20);

        return view('guru.izin_keluar.index', compact('izinKeluar'));
    }

    public function edit(IzinKeluar $izinKeluar)
    {
        $izinKeluar->load('siswa.user', 'disetujuiOleh', 'dicatatKeluarOleh', 'dicatatKembaliOleh');

        return view('guru.izin_keluar.edit', compact('izinKeluar'));
    }

    public function update(Request $request, IzinKeluar $izinKeluar)
    {
        $action = $request->input('action');

        if ($action === 'tandai_keluar') {
            if (!in_array($izinKeluar->status, [IzinKeluar::STATUS_APPROVED, IzinKeluar::STATUS_SAKIT])) {
                return redirect()->back()->with('error', 'Hanya izin yang disetujui atau sakit yang bisa ditandai keluar');
            }

            if ($izinKeluar->jam_keluar_aktual) {
                return redirect()->back()->with('error', 'Siswa sudah ditandai keluar');
            }

            $izinKeluar->update([
                'jam_keluar_aktual' => now(),
                'dicatat_keluar_oleh' => auth()->id(),
            ]);

            LogGerbang::create([
                'izin_id' => $izinKeluar->id,
                'tipe' => 'keluar',
                'waktu' => now(),
                'dicatat_oleh' => auth()->id(),
            ]);

            return redirect()->back()->with('success', 'Siswa berhasil ditandai keluar');
        }

        if ($action === 'tandai_kembali') {
            if (!$izinKeluar->jam_keluar_aktual) {
                return redirect()->back()->with('error', 'Siswa belum ditandai keluar');
            }

            if ($izinKeluar->jam_kembali_aktual) {
                return redirect()->back()->with('error', 'Siswa sudah ditandai kembali');
            }

            $izinKeluar->jam_kembali_aktual = now();
            $izinKeluar->dicatat_kembali_oleh = auth()->id();
            $izinKeluar->terlambat = $izinKeluar->isTerlambat() || $izinKeluar->status === IzinKeluar::STATUS_SAKIT;
            $izinKeluar->save();

            LogGerbang::create([
                'izin_id' => $izinKeluar->id,
                'tipe' => 'kembali',
                'waktu' => now(),
                'dicatat_oleh' => auth()->id(),
            ]);

            $pesan = $izinKeluar->terlambat
                ? 'Siswa berhasil ditandai kembali (TELAT)'
                : 'Siswa berhasil ditandai kembali (tepat waktu)';

            return redirect()->back()->with('success', $pesan);
        }

        $request->validate([
            'jam_keluar_rencana' => 'required|date_format:H:i',
            'jam_kembali_rencana' => 'required|date_format:H:i|after:jam_keluar_rencana',
            'jam_keluar_aktual' => 'nullable|date',
            'jam_kembali_aktual' => 'nullable|date',
        ]);

        $data = [
            'jam_keluar_rencana' => $request->jam_keluar_rencana,
            'jam_kembali_rencana' => $request->jam_kembali_rencana,
            'jam_keluar_aktual' => $request->jam_keluar_aktual ?: null,
            'jam_kembali_aktual' => $request->jam_kembali_aktual ?: null,
        ];

        if ($request->hasFile('foto_keluar')) {
            if ($izinKeluar->foto_keluar_path) {
                Storage::disk('public')->delete($izinKeluar->foto_keluar_path);
            }
            $data['foto_keluar_path'] = $request->file('foto_keluar')->store('bukti-keluar', 'public');
        }

        if ($request->hasFile('foto_kembali')) {
            if ($izinKeluar->foto_kembali_path) {
                Storage::disk('public')->delete($izinKeluar->foto_kembali_path);
            }
            $data['foto_kembali_path'] = $request->file('foto_kembali')->store('bukti-keluar', 'public');
        }

        $izinKeluar->update($data);

        if ($izinKeluar->jam_kembali_aktual) {
            $izinKeluar->terlambat = $izinKeluar->isTerlambat();
            $izinKeluar->saveQuietly();
        }

        return redirect()->back()->with('success', 'Data izin keluar berhasil diperbarui');
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
