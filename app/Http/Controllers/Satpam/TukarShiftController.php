<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\JadwalSatpam;
use App\Models\TukarShift;
use Illuminate\Http\Request;

class TukarShiftController extends Controller
{
    public function index()
    {
        $tukarShift = TukarShift::with('jadwal.satpam.user', 'pengaju.user', 'penerima.user', 'disetujuiOleh')
            ->where('pengaju_id', auth()->user()->satpam->id)
            ->latest()
            ->get();

        return view('satpam.tukar_shift.index', compact('tukarShift'));
    }

    public function create()
    {
        $jadwalSatpam = JadwalSatpam::with('satpam.user')
            ->where('satpam_id', auth()->user()->satpam->id)
            ->where('tanggal', '>=', now()->startOfDay())
            ->orderBy('tanggal')
            ->orderBy('shift')
            ->get();

        $satpamLain = \App\Models\Satpam::with('user')
            ->where('id', '!=', auth()->user()->satpam->id)
            ->get();

        return view('satpam.tukar_shift.create', compact('jadwalSatpam', 'satpamLain'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_satpam,id',
            'penerima_id' => 'required|exists:satpam,id|different:' . auth()->user()->satpam->id,
        ]);

        $jadwal = JadwalSatpam::findOrFail($request->jadwal_id);

        if ($jadwal->satpam_id !== auth()->user()->satpam->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke jadwal ini');
        }

        // Check if there's already a pending request for this schedule
        $exists = TukarShift::where('jadwal_id', $request->jadwal_id)
            ->where('pengaju_id', auth()->user()->satpam->id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Anda sudah memiliki permintaan pending untuk jadwal ini');
        }

        TukarShift::create([
            'jadwal_id' => $request->jadwal_id,
            'pengaju_id' => auth()->user()->satpam->id,
            'penerima_id' => $request->penerima_id,
            'status' => 'pending',
        ]);

        return redirect()->route('satpam.tukar_shift.index')->with('success', 'Permintaan pertukaran shift berhasil dibuat');
    }

    public function show(TukarShift $tukarShift)
    {
        $tukarShift->load('jadwal.satpam.user', 'pengaju.user', 'penerima.user', 'disetujuiOleh');
        return view('satpam.tukar_shift.show', compact('tukarShift'));
    }

    public function destroy(TukarShift $tukarShift)
    {
        if ($tukarShift->pengaju_id !== auth()->user()->satpam->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke permintaan ini');
        }

        if ($tukarShift->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya permintaan pending yang bisa dibatalkan');
        }

        $tukarShift->delete();

        return redirect()->route('satpam.tukar_shift.index')->with('success', 'Permintaan pertukaran shift dibatalkan');
    }

    public function permintaanMasuk()
    {
        $tukarShift = TukarShift::with('jadwal.satpam.user', 'pengaju.user', 'penerima.user', 'disetujuiOleh')
            ->where('penerima_id', auth()->user()->satpam->id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('satpam.tukar_shift.permintaan_masuk', compact('tukarShift'));
    }
}