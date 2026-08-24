<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\JadwalSatpam;
use App\Models\Satpam;
use App\Models\TukarShift;
use Illuminate\Http\Request;

class TukarShiftController extends Controller
{
    private function currentSatpam()
    {
        return auth()->user()?->satpam;
    }

    private function missingSatpamRedirect()
    {
        return redirect()
            ->route('satpam.dashboard')
            ->with('error', 'Profil satpam akun ini belum terhubung. Silakan hubungi admin.');
    }

    public function index()
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        $tukarShifts = TukarShift::with('jadwal.satpam.user', 'pengaju.user', 'penerima.user', 'disetujuiOleh')
            ->where('pengaju_id', $satpam->id)
            ->latest()
            ->paginate(20);

        return view('satpam.tukar_shift.index', compact('tukarShifts'));
    }

    public function create()
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        $jadwalSatpam = JadwalSatpam::with('satpam.user')
            ->where('satpam_id', $satpam->id)
            ->where('tanggal', '>=', now()->startOfDay())
            ->orderBy('tanggal')
            ->orderBy('shift')
            ->get();

        $satpams = Satpam::with('user')
            ->where('id', '!=', $satpam->id)
            ->orderBy(
                \App\Models\User::select('name')
                    ->whereColumn('users.id', 'satpam.user_id')
                    ->limit(1)
            )
            ->get();

        return view('satpam.tukar_shift.create', compact('jadwalSatpam', 'satpams'));
    }

    public function store(Request $request)
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_satpam,id',
            'penerima_id' => 'required|exists:satpam,id|not_in:' . $satpam->id,
        ]);

        $jadwal = JadwalSatpam::findOrFail($request->jadwal_id);

        if ($jadwal->satpam_id !== $satpam->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke jadwal ini');
        }

        // Check if there's already a pending request for this schedule
        $exists = TukarShift::where('jadwal_id', $request->jadwal_id)
            ->where('pengaju_id', $satpam->id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Anda sudah memiliki permintaan pending untuk jadwal ini');
        }

        TukarShift::create([
            'jadwal_id' => $request->jadwal_id,
            'pengaju_id' => $satpam->id,
            'penerima_id' => $request->penerima_id,
            'status' => 'pending',
        ]);

        return redirect()->route('satpam.tukar_shift.index')->with('success', 'Permintaan pertukaran shift berhasil dibuat');
    }

    public function show(TukarShift $tukarShift)
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        $tukarShift->load('jadwal.satpam.user', 'pengaju.user', 'penerima.user', 'disetujuiOleh');

        if (!in_array($satpam->id, [$tukarShift->pengaju_id, $tukarShift->penerima_id], true)) {
            return redirect()->route('satpam.tukar_shift.index')->with('error', 'Anda tidak memiliki akses ke permintaan ini');
        }

        return view('satpam.tukar_shift.show', compact('tukarShift'));
    }

    public function destroy(TukarShift $tukarShift)
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        if ($tukarShift->pengaju_id !== $satpam->id) {
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
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        $statusCounts = TukarShift::where('penerima_id', $satpam->id)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $permintaanMasuk = TukarShift::with('jadwal.satpam.user', 'pengaju.user', 'penerima.user', 'penerima.jadwalSatpam.satpam.user', 'disetujuiOleh')
            ->where('penerima_id', $satpam->id)
            ->latest()
            ->paginate(20);

        return view('satpam.tukar_shift.permintaan-masuk', compact('permintaanMasuk', 'statusCounts'));
    }

    public function approve(TukarShift $tukarShift)
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        if ($tukarShift->penerima_id !== $satpam->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke permintaan ini');
        }

        if ($tukarShift->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya permintaan pending yang bisa disetujui');
        }

        $validated = $request->validate([
            'jadwal_penerima_id' => 'required|exists:jadwal_satpam,id',
        ]);

        $jadwalPenerima = JadwalSatpam::findOrFail($validated['jadwal_penerima_id']);
        if ($jadwalPenerima->satpam_id !== $satpam->id) {
            return redirect()->back()->with('error', 'Jadwal yang dipilih bukan milik Anda');
        }

        \DB::transaction(function () use ($tukarShift, $jadwalPenerima) {
            $jadwalPengaju = $tukarShift->jadwal;
            $pengajuId = $tukarShift->pengaju_id;
            $penerimaId = $tukarShift->penerima_id;

            // Tukar dua arah: jadwal pemohon -> penerima, jadwal penerima -> pemohon
            $jadwalPengaju->update(['satpam_id' => $penerimaId]);
            $jadwalPenerima->update(['satpam_id' => $pengajuId]);

            $tukarShift->update([
                'status' => 'approved',
                'disetujui_oleh' => auth()->id(),
                'jadwal_penerima_id' => $jadwalPenerima->id,
            ]);
        });

        return redirect()->route('satpam.tukar_shift.permintaan_masuk')->with('success', 'Permintaan tukar shift disetujui');
    }

    public function reject(TukarShift $tukarShift)
    {
        $satpam = $this->currentSatpam();

        if (!$satpam) {
            return $this->missingSatpamRedirect();
        }

        if ($tukarShift->penerima_id !== $satpam->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke permintaan ini');
        }

        if ($tukarShift->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya permintaan pending yang bisa ditolak');
        }

        $tukarShift->update(['status' => 'rejected']);

        return redirect()->route('satpam.tukar_shift.permintaan_masuk')->with('success', 'Permintaan tukar shift ditolak');
    }
}
