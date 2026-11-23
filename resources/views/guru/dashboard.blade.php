@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('sidebar')
    <li>
        <a href="{{ route('guru.dashboard') }}" class="active">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('guru.izin_keluar.index') }}">
            <i class="bi bi-person-badge"></i> Izin Keluar
        </a>
    </li>
@endsection

@section('content')
    <div class="mb-4">
        <h2 style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; margin-bottom: 8px;">
            Dashboard Guru
        </h2>
        <p style="color: var(--ink-soft); margin: 0;">
            Selamat datang, {{ Auth::user()->name }}! Pantau aktivitas izin keluar siswa.
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
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-value">{{ $izinPending }}</div>
                <div class="stat-label">Izin Menunggu Persetujuan</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon amber">
                    <i class="bi bi-person-walking"></i>
                </div>
                <div class="stat-value">{{ $izinToday }}</div>
                <div class="stat-label">Izin Keluar Hari Ini</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon terracotta">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <div class="stat-value">{{ $tukarShiftPending }}</div>
                <div class="stat-label">Permintaan Tukar Shift</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="content-card">
                <div class="content-card-header">
                    <h5>Izin Keluar Menunggu Persetujuan</h5>
                    <a href="{{ route('guru.izin_keluar.index') }}" style="color: var(--pine); text-decoration: none; font-weight: 500;">
                        @if($izinPending > 0)
                            <span class="badge badge-warning">{{ $izinPending }}</span>
                        @endif
                        Kelola Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="content-card-body p-0">
                    @if($izinKeluarTerbaru->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Foto & Bukti</th>
                                    <th>Alasan</th>
                                    <th>Jam Keluar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($izinKeluarTerbaru as $izin)
                                    <tr>
                                        <td>{{ $izin->siswa?->user?->name ?? '-' }}</td>
                                        <td>
                                            @if($izin->siswa?->foto_profil_path)
                                                <img src="{{ asset('storage/' . $izin?->siswa?->foto_profil_path) }}" alt="Foto {{ $izin->siswa?->user?->name ?? 'siswa' }}" width="42" height="42" style="object-fit:cover;border-radius:50%;" class="me-2">
                                            @endif
                                            @if($izin->bukti_path)
                                                @php($buktiVideo = in_array(strtolower(pathinfo($izin->bukti_path, PATHINFO_EXTENSION)), ['mp4', 'mov', 'webm']))
                                                <a href="{{ asset('storage/' . $izin->bukti_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">{{ $buktiVideo ? 'Putar video' : 'Lihat bukti' }}</a>
                                            @endif
                                        </td>
                                        <td>{{ $izin->alasan }}</td>
                                        <td>{{ $izin->jam_keluar_rencana instanceof \DateTime ? $izin->jam_keluar_rencana->format('H:i') : $izin->jam_keluar_rencana }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <form method="POST" action="{{ route('guru.izin_keluar.approve', $izin) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i> Setujui</button>
                                                </form>
                                                <form method="POST" action="{{ route('guru.izin_keluar.reject', $izin) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak izin ini?')"><i class="bi bi-x-lg"></i> Tolak</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-check-circle"></i>
                            <p>Tidak ada izin menunggu persetujuan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="content-card">
                <div class="content-card-header">
                    <h5>Informasi Guru</h5>
                </div>
                <div class="content-card-body">
                    @if($guru?->mapel)
                        <div class="mapel-info">
                            <h6><i class="bi bi-book"></i> Mata Pelajaran</h6>
                            <p>{{ $guru->mapel }}</p>
                        </div>
                    @endif
                    @if($guru?->nip)
                        <div class="mapel-info">
                            <h6><i class="bi bi-person-badge"></i> NIP</h6>
                            <p>{{ $guru->nip }}</p>
                        </div>
                    @endif
                    @if(!$guru)
                        <div class="mapel-info">
                            <h6><i class="bi bi-exclamation-circle"></i> Profil Guru</h6>
                            <p>Profil guru belum terhubung. Silakan hubungi admin.</p>
                        </div>
                    @endif
                    <div class="mapel-info">
                        <h6><i class="bi bi-calendar"></i> Tanggal</h6>
                        <p>{{ now()->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="bi bi-person-walking"></i>
                </div>
                <div class="stat-value">{{ $totalKeluarHariIni }}</div>
                <div class="stat-label">Siswa Keluar Hari Ini</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon amber">
                    <i class="bi bi-arrow-return-left"></i>
                </div>
                <div class="stat-value">{{ $totalKembaliHariIni }}</div>
                <div class="stat-label">Siswa Kembali Hari Ini</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon terracotta">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-value">{{ $totalTelatHariIni }}</div>
                <div class="stat-label">Siswa Kembali Telat</div>
            </div>
        </div>
    </div>

    <div class="content-card mb-4">
        <div class="content-card-header">
            <h5><i class="bi bi-clipboard-data"></i> Rekap Izin Keluar Hari Ini ({{ now()->locale('id')->translatedFormat('d F Y') }})</h5>
            <a href="{{ route('guru.izin_keluar.index') }}" style="color: var(--pine); text-decoration: none; font-weight: 500;">
                Kelola <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="content-card-body p-0">
            @if($rekapHariIni->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Jam Keluar</th>
                            <th>Jam Kembali</th>
                            <th>Rencana Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapHariIni as $rekap)
                            <tr>
                                <td>{{ $rekap->siswa?->user?->name ?? '-' }}</td>
                                <td>{{ $rekap->siswa?->kelas ?? '-' }}</td>
                                <td>{{ $rekap->jam_keluar_aktual?->locale('id')->translatedFormat('H:i') ?? '<span class="text-muted">-</span>' }}</td>
                                <td>{{ $rekap->jam_kembali_aktual?->locale('id')->translatedFormat('H:i') ?? '<span class="text-muted">Belum</span>' }}</td>
                                <td>{{ $rekap->jam_kembali_rencana?->format('H:i') ?? '-' }}</td>
                                <td>
                                    @if(!$rekap->jam_kembali_aktual)
                                        <span class="badge badge-warning">Belum Kembali</span>
                                    @elseif($rekap->terlambat)
                                        <span class="badge badge-danger">Telat</span>
                                    @else
                                        <span class="badge badge-success">Tepat Waktu</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada aktivitas izin keluar hari ini</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .mapel-info {
            background: var(--mint);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .mapel-info h6 {
            margin: 0 0 8px 0;
            color: var(--pine);
            font-weight: 600;
        }

        .mapel-info p {
            margin: 0;
            color: var(--ink-soft);
            font-size: 14px;
        }
    </style>
@endsection
