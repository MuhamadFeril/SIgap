<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $izinKeluar = $siswa
            ? IzinKeluar::where('siswa_id', $siswa->id)->latest()->get()
            : collect();

        return view('siswa.portal', compact('siswa', 'izinKeluar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|string|max:20',
            'alasan' => 'required|in:Dijemput orang tua,Keperluan keluarga,Berobat,Lainnya',
            'deskripsi' => 'nullable|string|max:500|required_if:alasan,Lainnya',
            'jam_keluar_rencana' => 'required|date_format:H:i',
            'bukti' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov,webm|max:20480',
        ]);

        $buktiPath = $request->file('bukti')->store('bukti_izin', 'public');

        DB::transaction(function () use ($validated, $buktiPath) {
            $user = auth()->user();
            $siswa = $user->siswa;

            if (!$siswa) {
                $siswa = Siswa::create([
                    'user_id' => $user->id,
                    'kelas' => $validated['kelas'],
                    'nomor_absen' => 'REG-' . strtoupper(substr(str_replace('-', '', $user->id), 0, 12)),
                ]);
            }

            IzinKeluar::create([
                'siswa_id' => $siswa->id,
                'alasan' => $validated['alasan'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'bukti_path' => $buktiPath,
                'jam_keluar_rencana' => $validated['jam_keluar_rencana'],
                'status' => 'pending',
            ]);
        });

        return redirect()->route('user.dashboard')->with('success', 'Pengajuan izin berhasil dikirim ke antrean guru piket.');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'kelas' => 'required|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fotoProfilPath = $request->hasFile('foto_profil')
            ? $request->file('foto_profil')->store('foto_profil_siswa', 'public')
            : null;

        DB::transaction(function () use ($user, $validated, $fotoProfilPath) {
            $user->update(['name' => $validated['name'], 'email' => $validated['email']]);
            $siswa = $user->siswa;

            if (!$siswa) {
                Siswa::create([
                    'user_id' => $user->id,
                    'kelas' => $validated['kelas'],
                    'nomor_absen' => 'REG-' . strtoupper(substr(str_replace('-', '', $user->id), 0, 12)),
                    'foto_profil_path' => $fotoProfilPath,
                ]);
                return;
            }

            $updates = ['kelas' => $validated['kelas']];
            if ($fotoProfilPath) {
                if ($siswa->foto_profil_path) {
                    Storage::disk('public')->delete($siswa->foto_profil_path);
                }
                $updates['foto_profil_path'] = $fotoProfilPath;
            }
            $siswa->update($updates);
        });

        return redirect()->route('user.dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}
