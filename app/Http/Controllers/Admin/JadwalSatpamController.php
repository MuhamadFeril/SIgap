<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSatpam;
use App\Models\Satpam;
use Illuminate\Http\Request;

class JadwalSatpamController extends Controller
{
    public function index()
    {
        $satpams = Satpam::with('user')->orderBy(
            \App\Models\User::select('name')
                ->whereColumn('users.id', 'satpam.user_id')
                ->limit(1)
        )->get();

        $query = JadwalSatpam::with('satpam.user');

        if (request('satpam_id')) {
            $query->where('satpam_id', request('satpam_id'));
        }

        if (request('shift')) {
            $query->where('shift', request('shift'));
        }

        if (request('tanggal')) {
            $query->whereDate('tanggal', request('tanggal'));
        }

        $jadwalSatpam = $query->orderBy('tanggal', 'desc')
            ->orderBy('shift')
            ->paginate(20)
            ->withQueryString();

        return view('admin.jadwal.index', compact('jadwalSatpam', 'satpams'));
    }

    public function create()
    {
        $satpams = Satpam::with('user')->orderBy(
            \App\Models\User::select('name')
                ->whereColumn('users.id', 'satpam.user_id')
                ->limit(1)
        )->get();

        return view('admin.jadwal.create', compact('satpams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'satpam_id' => 'required|exists:satpam,id',
            'tanggal' => 'required|date',
            'shift' => 'required|in:pagi,siang,malam',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
        ], [
            'satpam_id.required' => 'Satpam harus dipilih.',
            'tanggal.required' => 'Tanggal harus diisi.',
            'shift.required' => 'Shift harus dipilih.',
            'jam_masuk.date_format' => 'Format jam masuk tidak valid.',
            'jam_pulang.date_format' => 'Format jam pulang tidak valid.',
        ]);

        $exists = JadwalSatpam::where('satpam_id', $validated['satpam_id'])
            ->where('tanggal', $validated['tanggal'])
            ->where('shift', $validated['shift'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal untuk satpam, tanggal, dan shift tersebut sudah ada.');
        }

        JadwalSatpam::create([
            'satpam_id' => $validated['satpam_id'],
            'tanggal' => $validated['tanggal'],
            'shift' => $validated['shift'],
            'jam_masuk' => $request->jam_masuk ? \Carbon\Carbon::parse($validated['tanggal'] . ' ' . $request->jam_masuk) : null,
            'jam_pulang' => $request->jam_pulang ? \Carbon\Carbon::parse($validated['tanggal'] . ' ' . $request->jam_pulang) : null,
            'status_hadir' => 'belum_presensi',
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal satpam berhasil dibuat.');
    }

    public function edit(JadwalSatpam $jadwalSatpam)
    {
        $satpams = Satpam::with('user')->orderBy(
            \App\Models\User::select('name')
                ->whereColumn('users.id', 'satpam.user_id')
                ->limit(1)
        )->get();

        return view('admin.jadwal.edit', compact('jadwalSatpam', 'satpams'));
    }

    public function update(Request $request, JadwalSatpam $jadwalSatpam)
    {
        $validated = $request->validate([
            'satpam_id' => 'required|exists:satpam,id',
            'tanggal' => 'required|date',
            'shift' => 'required|in:pagi,siang,malam',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
        ]);

        $exists = JadwalSatpam::where('satpam_id', $validated['satpam_id'])
            ->where('tanggal', $validated['tanggal'])
            ->where('shift', $validated['shift'])
            ->where('id', '!=', $jadwalSatpam->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal untuk satpam, tanggal, dan shift tersebut sudah ada.');
        }

        $jadwalSatpam->update([
            'satpam_id' => $validated['satpam_id'],
            'tanggal' => $validated['tanggal'],
            'shift' => $validated['shift'],
            'jam_masuk' => $request->jam_masuk ? \Carbon\Carbon::parse($validated['tanggal'] . ' ' . $request->jam_masuk) : null,
            'jam_pulang' => $request->jam_pulang ? \Carbon\Carbon::parse($validated['tanggal'] . ' ' . $request->jam_pulang) : null,
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal satpam berhasil diperbarui.');
    }

    public function destroy(JadwalSatpam $jadwalSatpam)
    {
        $jadwalSatpam->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal satpam berhasil dihapus.');
    }
}
