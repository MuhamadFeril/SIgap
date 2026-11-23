<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSatpam;
use App\Models\TukarShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TukarShiftController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $query = TukarShift::with('jadwal.satpam.user', 'pengaju.user', 'penerima.user', 'disetujuiOleh');

        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $tukarShifts = $query->latest()->paginate(20);

        return view('admin.tukar_shift.index', compact('tukarShifts', 'status'));
    }

    public function show(TukarShift $tukarShift)
    {
        $tukarShift->load('jadwal.satpam.user', 'pengaju.user', 'penerima.user', 'disetujuiOleh', 'jadwalPenerima.satpam.user');

        $jadwalPenerimaList = JadwalSatpam::where('satpam_id', $tukarShift->penerima_id)
            ->where('tanggal', '>=', now()->startOfDay())
            ->orderBy('tanggal')
            ->orderBy('shift')
            ->get();

        return view('admin.tukar_shift.show', compact('tukarShift', 'jadwalPenerimaList'));
    }

    public function approve(Request $request, TukarShift $tukarShift)
    {
        if ($tukarShift->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya permintaan pending yang bisa disetujui.');
        }

        $jadwalPenerimaId = $tukarShift->jadwal_penerima_id;
        if (!$jadwalPenerimaId) {
            $request->validate([
                'jadwal_penerima_id' => 'required|exists:jadwal_satpam,id',
            ], [
                'jadwal_penerima_id.required' => 'Silakan pilih jadwal penerima yang akan ditukar.',
            ]);
            $jadwalPenerimaId = $request->jadwal_penerima_id;
        }

        $jadwalPenerima = JadwalSatpam::findOrFail($jadwalPenerimaId);

        if ($jadwalPenerima->satpam_id !== $tukarShift->penerima_id) {
            return redirect()->back()->with('error', 'Jadwal yang dipilih bukan milik penerima.');
        }

        DB::transaction(function () use ($tukarShift, $jadwalPenerima) {
            $jadwalPengaju = $tukarShift->jadwal;
            $pengajuId = $tukarShift->pengaju_id;
            $penerimaId = $tukarShift->penerima_id;

            $jadwalPengaju->update(['satpam_id' => $penerimaId]);
            $jadwalPenerima->update(['satpam_id' => $pengajuId]);

            $tukarShift->update([
                'status' => 'approved',
                'disetujui_oleh' => auth()->id(),
                'jadwal_penerima_id' => $jadwalPenerima->id,
            ]);
        });

        return redirect()->back()->with('success', 'Permintaan tukar shift disetujui dan jadwal berhasil ditukar.');
    }

    public function reject(Request $request, TukarShift $tukarShift)
    {
        if ($tukarShift->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya permintaan pending yang bisa ditolak.');
        }

        $tukarShift->update([
            'status' => 'rejected',
            'disetujui_oleh' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Permintaan tukar shift ditolak.');
    }
}
