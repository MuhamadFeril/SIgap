@extends('layouts.app')

@section('title', 'Dashboard Siswa')
@section('user-role', $siswa?->kelas ?? 'Siswa')

@section('sidebar')
    <li>
        <a href="{{ route('siswa.dashboard') }}" class="active">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    @if($siswa)
    <li>
        <a href="{{ route('siswa.izin_keluar.index') }}">
            <i class="bi bi-box-arrow-right"></i> Izin Keluar
        </a>
    </li>
    @endif
@endsection

@section('content')
    <div class="mb-4">
        <h2 style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; margin-bottom: 8px;">
            Dashboard Siswa
        </h2>
        <p style="color: var(--ink-soft); margin: 0;">
            Selamat datang, {{ Auth::user()->name }}! Kelola izin keluar Anda di sini.
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

    @if(!$siswa)
        <div class="alert alert-warning border-0 mb-4" role="alert">
            <strong>Profil siswa belum lengkap.</strong> Hubungi admin untuk melengkapi NIS dan kelas Anda sebelum mengajukan izin keluar.
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
                <div class="stat-value">{{ $izinApproved }}</div>
                <div class="stat-label">Izin Disetujui (Sedang Keluar)</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon terracotta">
                    <i class="bi bi-file-earmark-check"></i>
                </div>
                <div class="stat-value">{{ $izinKeluar->count() }}</div>
                <div class="stat-label">Total Izin Keluar</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="content-card">
                <div class="content-card-header">
                    <h5>Izin Keluar Terbaru</h5>
                    @if($siswa)
                    <a href="{{ route('siswa.izin_keluar.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Buat Izin Baru
                    </a>
                    @endif
                </div>
                <div class="content-card-body p-0">
                    @if($izinKeluar->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Alasan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Jam Keluar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($izinKeluar as $izin)
                                    <tr>
                                        <td>{{ $izin->alasan }}</td>
                                        <td>{{ $izin->created_at->format('d M Y') }}</td>
                                        <td>{{ $izin->jam_keluar_rencana }}</td>
                                        <td>
                                            @if($izin->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($izin->status === 'approved')
                                                <span class="badge badge-success">Disetujui</span>
                                            @else
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('siswa.izin_keluar.show', $izin) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada izin keluar</p>
                            @if($siswa)
                            <a href="{{ route('siswa.izin_keluar.create') }}" class="btn btn-primary">Buat Izin Pertama</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
