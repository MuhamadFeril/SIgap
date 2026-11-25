@extends('layouts.app')

@section('title', 'Dashboard Satpam')

@section('sidebar')
    <li>
        <a href="{{ route('satpam.dashboard') }}" class="active">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.izin_keluar.index') }}">
            <i class="bi bi-person-badge"></i> Izin Keluar
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.jadwal.index') }}">
            <i class="bi bi-calendar-check"></i> Jadwal Jaga
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.tukar_shift.index') }}">
            <i class="bi bi-arrow-left-right"></i> Tukar Shift
        </a>
    </li>
@endsection

@section('content')
    <div class="mb-4">
        <h2 style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; margin-bottom: 8px;">
            Dashboard Satpam
        </h2>
        <p style="color: var(--ink-soft); margin: 0;">
            Selamat datang, {{ Auth::user()->name }}! Pantau aktivitas gerbang dan jadwal jaga Anda.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div class="stat-value">{{ $izinMenungguKeluar }}</div>
                <div class="stat-label">Menunggu Tandai Keluar</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon amber">
                    <i class="bi bi-person-walking"></i>
                </div>
                <div class="stat-value">{{ $siswaSedangKeluar }}</div>
                <div class="stat-label">Siswa Sedang Keluar</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon terracotta">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <div class="stat-value">{{ $tukarShiftMasuk }}</div>
                <div class="stat-label">Permintaan Tukar Shift</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-value">{{ $jadwalHariIni ? 'Ada' : 'Tidak' }}</div>
                <div class="stat-label">Jadwal Hari Ini</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="content-card mb-4">
                <div class="content-card-header">
                    <h5>Jadwal Hari Ini</h5>
                </div>
                <div class="content-card-body">
                    @if($jadwalHariIni)
                        <div class="jadwal-info">
                            <h6><i class="bi bi-calendar"></i> {{ $jadwalHariIni->tanggal->format('d F Y') }}</h6>
                            <p><strong>Shift:</strong> {{ ucfirst($jadwalHariIni->shift) }}</p>
                            <p><strong>Status:</strong>
                                <span id="jdwlStatus">
                                @if($jadwalHariIni->status_hadir === 'hadir')
                                    <span class="badge badge-success">Hadir</span>
                                @elseif($jadwalHariIni->status_hadir === 'belum_presensi')
                                    <span class="badge badge-warning">Belum Presensi</span>
                                @else
                                    <span class="badge badge-danger">Tidak Hadir</span>
                                @endif
                                </span>
                            </p>
                            <p><strong>Jadwal Masuk:</strong> {{ $jadwalHariIni->jam_masuk?->format('H:i') ?? '-' }}</p>
                            <p><strong>Jadwal Pulang:</strong> {{ $jadwalHariIni->jam_pulang?->format('H:i') ?? '-' }}</p>
                            <p><strong>Presensi Masuk:</strong> <span id="jdwlWaktuMasuk">{{ $jadwalHariIni->waktu_masuk?->format('H:i') ?? '-' }}</span>
                                <span id="jdwlTelatMasuk">@if($jadwalHariIni->telat_masuk && $jadwalHariIni->waktu_masuk)<span class="badge badge-danger">Telat</span>@endif</span>
                            </p>
                            <p><strong>Presensi Pulang:</strong> <span id="jdwlWaktuPulang">{{ $jadwalHariIni->waktu_pulang?->format('H:i') ?? '-' }}</span></p>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-calendar-x"></i>
                            <p>Tidak ada jadwal hari ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="content-card">
                <div class="content-card-header">
                    <h5>Aksi Cepat</h5>
                </div>
                <div class="content-card-body">
                    <div class="d-grid gap-2">
                        @php
                            $sudahMasuk = $jadwalHariIni && $jadwalHariIni->waktu_masuk;
                            $sudahPulang = $jadwalHariIni && $jadwalHariIni->waktu_pulang;
                            $presensiState = !$sudahMasuk ? 'masuk' : (!$sudahPulang ? 'pulang' : 'selesai');
                            $bisaPulang = !$jadwalHariIni || !$jadwalHariIni->jam_pulang || now()->gte($jadwalHariIni->jam_pulang);
                            $pulangDisabled = $presensiState === 'pulang' && !$bisaPulang;
                        @endphp
                        <button type="button" id="presensiBtn" class="btn w-100 @if($presensiState === 'masuk') btn-success @elseif($presensiState === 'pulang') btn-warning @else btn-outline-secondary @endif"
                            data-state="{{ $presensiState }}"
                            @if($presensiState === 'selesai' || $pulangDisabled) disabled @endif
                            @if($pulangDisabled) data-buka="{{ $jadwalHariIni->jam_pulang->format('H:i') }}" @endif>
                            @if($presensiState === 'masuk')
                                <i class="bi bi-box-arrow-in-right"></i> Presensi Masuk
                            @elseif($presensiState === 'pulang')
                                <i class="bi bi-box-arrow-left"></i> Presensi Pulang
                            @else
                                <i class="bi bi-check2-all"></i> Presensi Hari Ini Selesai
                            @endif
                        </button>
                        @if($pulangDisabled)
                            <small class="text-muted mt-1 d-block" id="pulangNote">Belum waktunya presensi pulang (jam {{ $jadwalHariIni->jam_pulang->format('H:i') }})</small>
                        @endif
                        <a href="{{ route('satpam.izin_keluar.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-person-badge"></i> Kelola Izin Keluar
                        </a>
                        <a href="{{ route('satpam.izin_keluar.keluar_hari_ini') }}" class="btn btn-outline-warning">
                            <i class="bi bi-person-walking"></i> Siswa Keluar Hari Ini
                        </a>
                        <a href="{{ route('satpam.jadwal.index') }}" class="btn btn-outline-info">
                            <i class="bi bi-calendar-check"></i> Lihat Jadwal Lengkap
                        </a>
                        @if($tukarShiftMasuk > 0)
                            <a href="{{ route('satpam.tukar_shift.permintaan_masuk') }}" class="btn btn-outline-danger">
                                <i class="bi bi-arrow-left-right"></i> Permintaan Tukar Shift ({{ $tukarShiftMasuk }})
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Siswa Menunggu Ditandai Keluar --}}
    <div class="content-card mt-4">
        <div class="content-card-header">
            <h5>
                <i class="bi bi-person-badge me-2"></i>
                Siswa Menunggu Ditandai Keluar
                @if($daftarMenungguKeluar->count() > 0)
                    <span class="badge ms-1" style="background:#fef3e7;color:#c9821e;font-size:13px;border-radius:8px;padding:4px 10px;">
                        {{ $daftarMenungguKeluar->count() }}
                    </span>
                @endif
            </h5>
            <a href="{{ route('satpam.izin_keluar.index') }}" class="btn btn-sm btn-outline-primary">
                Lihat Semua
            </a>
        </div>
        <div class="content-card-body p-0">
            @if($daftarMenungguKeluar->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0" style="font-size:14px;">
                        <thead>
                            <tr>
                                <th style="padding:12px 16px;font-size:12px;text-transform:uppercase;letter-spacing:0.05em;color:var(--ink-soft);border-bottom:2px solid var(--line);">Siswa</th>
                                <th style="padding:12px 16px;font-size:12px;text-transform:uppercase;letter-spacing:0.05em;color:var(--ink-soft);border-bottom:2px solid var(--line);">Kelas</th>
                                <th style="padding:12px 16px;font-size:12px;text-transform:uppercase;letter-spacing:0.05em;color:var(--ink-soft);border-bottom:2px solid var(--line);">Alasan</th>
                                <th style="padding:12px 16px;font-size:12px;text-transform:uppercase;letter-spacing:0.05em;color:var(--ink-soft);border-bottom:2px solid var(--line);">Jam Keluar</th>
                                <th style="padding:12px 16px;font-size:12px;text-transform:uppercase;letter-spacing:0.05em;color:var(--ink-soft);border-bottom:2px solid var(--line);">Disetujui Oleh</th>
                                <th style="padding:12px 16px;font-size:12px;text-transform:uppercase;letter-spacing:0.05em;color:var(--ink-soft);border-bottom:2px solid var(--line);">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarMenungguKeluar as $izin)
                                <tr style="border-bottom:1px solid var(--line);">
                                    <td style="padding:14px 16px;vertical-align:middle;">
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            @if($izin->siswa?->foto_profil_path)
                                                <img src="{{ asset('storage/' . $izin->siswa->foto_profil_path) }}"
                                                     alt="Foto" width="36" height="36"
                                                     style="object-fit:cover;border-radius:50%;border:1px solid var(--line);flex-shrink:0;">
                                            @else
                                                <div class="avatar-sm">
                                                    {{ substr($izin->siswa?->user?->name ?? '?', 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div style="font-weight:600;">{{ $izin->siswa?->user?->name ?? 'Tanpa Nama' }}</div>
                                                <div style="font-size:12px;color:var(--ink-soft);">NIS: {{ $izin->siswa?->nis ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding:14px 16px;vertical-align:middle;">{{ $izin->siswa?->kelas ?? '-' }}</td>
                                    <td style="padding:14px 16px;vertical-align:middle;">
                                        <div style="font-weight:500;">{{ $izin->alasan }}</div>
                                        @if($izin->deskripsi)
                                            <div style="font-size:12px;color:var(--ink-soft);">{{ Str::limit($izin->deskripsi, 40) }}</div>
                                        @endif
                                    </td>
                                    <td style="padding:14px 16px;vertical-align:middle;">
                                        <span style="font-weight:600;color:var(--pine);">
                                            {{ $izin->jam_keluar_rencana ? $izin->jam_keluar_rencana->format('H:i') : '-' }}
                                        </span>
                                        <div style="font-size:12px;color:var(--ink-soft);">
                                            Kembali: {{ $izin->jam_kembali_rencana ? $izin->jam_kembali_rencana->format('H:i') : '-' }}
                                        </div>
                                    </td>
                                    <td style="padding:14px 16px;vertical-align:middle;">
                                        <div style="font-size:13px;">{{ $izin->disetujuiOleh?->name ?? '-' }}</div>
                                        @if($izin->waktu_keputusan)
                                            <div style="font-size:11px;color:var(--ink-soft);">{{ $izin->waktu_keputusan->format('H:i') }}</div>
                                        @endif
                                    </td>
                                    <td style="padding:14px 16px;vertical-align:middle;">
                                        <form method="POST" action="{{ route('satpam.izin_keluar.tandai_keluar', $izin) }}"
                                              onsubmit="return confirm('Tandai {{ addslashes($izin->siswa?->user?->name ?? 'siswa') }} sudah keluar?')">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" style="white-space:nowrap;">
                                                <i class="bi bi-box-arrow-right"></i> Tandai Keluar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-shield-check"></i>
                    <p>Tidak ada siswa yang menunggu ditandai keluar</p>
                </div>
            @endif
        </div>
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1090;">
        <div id="presensiToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="presensiToastBody"></div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .jadwal-info {
            background: var(--mint);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .jadwal-info h6 {
            margin: 0 0 8px 0;
            color: var(--pine);
            font-weight: 600;
        }

        .jadwal-info p {
            margin: 0;
            color: var(--ink-soft);
            font-size: 14px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('presensiBtn');
            if (!btn) return;

            const buka = btn.dataset.buka;
            if (buka) {
                const parts = buka.split(':').map(Number);
                const target = new Date();
                target.setHours(parts[0], parts[1], 0, 0);
                const diff = target - new Date();
                if (diff > 0) {
                    setTimeout(() => {
                        btn.disabled = false;
                        const note = document.getElementById('pulangNote');
                        if (note) note.remove();
                    }, diff);
                }
            }

            const toastEl = document.getElementById('presensiToast');
            const toastBody = document.getElementById('presensiToastBody');
            const toast = toastEl ? new bootstrap.Toast(toastEl, { delay: 3000 }) : null;

            function showToast(message, type) {
                if (!toast) return;
                toastEl.className = 'toast align-items-center border-0 text-bg-' + (type === 'error' ? 'danger' : 'success');
                toastBody.textContent = message;
                toast.show();
            }

            function applyState(state, data) {
                if (state === 'masuk') {
                    btn.className = 'btn btn-warning w-100';
                    btn.innerHTML = '<i class="bi bi-box-arrow-left"></i> Presensi Pulang';
                    btn.dataset.state = 'pulang';
                    btn.disabled = false;
                } else if (state === 'pulang') {
                    btn.className = 'btn btn-outline-secondary w-100';
                    btn.innerHTML = '<i class="bi bi-check2-all"></i> Presensi Hari Ini Selesai';
                    btn.dataset.state = 'selesai';
                    btn.disabled = true;
                }
                if (data) {
                    if (data.status_hadir) {
                        const map = {
                            'hadir': '<span class="badge badge-success">Hadir</span>',
                            'belum_presensi': '<span class="badge badge-warning">Belum Presensi</span>',
                            'tidak_hadir': '<span class="badge badge-danger">Tidak Hadir</span>',
                        };
                        const el = document.getElementById('jdwlStatus');
                        if (el && map[data.status_hadir]) el.innerHTML = map[data.status_hadir];
                    }
                    if (document.getElementById('jdwlWaktuMasuk')) document.getElementById('jdwlWaktuMasuk').textContent = data.waktu_masuk ?? '-';
                    if (document.getElementById('jdwlWaktuPulang')) document.getElementById('jdwlWaktuPulang').textContent = data.waktu_pulang ?? '-';
                    const telatEl = document.getElementById('jdwlTelatMasuk');
                    if (telatEl) telatEl.innerHTML = (data.telat_masuk) ? '<span class="badge badge-danger">Telat</span>' : '';
                }
            }

            btn.addEventListener('click', function () {
                const original = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

                fetch('{{ route("satpam.presensi") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        applyState(res.state, res);
                        showToast(res.message, 'success');
                    } else {
                        btn.disabled = false;
                        btn.innerHTML = original;
                        showToast(res.message || 'Gagal presensi', 'error');
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = original;
                    showToast('Terjadi kesalahan, coba lagi', 'error');
                });
            });
        });
    </script>
@endsection
