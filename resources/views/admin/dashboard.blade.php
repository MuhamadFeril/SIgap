@extends('layouts.app')

@section('title', 'Dashboard Admin Sekolah')
@section('user-role', 'Admin Sekolah')

@section('sidebar')
    <li>
        <a href="{{ route('admin.dashboard') }}" class="active">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('admin.guru.index') }}">
            <i class="bi bi-person-badge"></i> Guru
        </a>
    </li>
    <li>
        <a href="{{ route('admin.siswa.index') }}">
            <i class="bi bi-people"></i> Siswa
        </a>
    </li>
    <li>
        <a href="{{ route('admin.satpam.index') }}">
            <i class="bi bi-shield-check"></i> Satpam
        </a>
    </li>
    <li>
        <a href="{{ route('admin.jadwal.index') }}">
            <i class="bi bi-calendar-check"></i> Jadwal
        </a>
    </li>
    <li>
        <a href="{{ route('admin.tukar_shift.index') }}">
            <i class="bi bi-arrow-left-right"></i> Tukar Shift
        </a>
    </li>
@endsection

@section('content')
    <div class="mb-4">
        <h2 style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; margin-bottom: 8px;">
            Dashboard Admin Sekolah
        </h2>
        <p style="color: var(--ink-soft); margin: 0;">
            Selamat datang di panel kontrol SIGAP — pantau semua aktivitas izin keluar dan jadwal satpam.
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
                <div class="stat-value">{{ $totalGuru }}</div>
                <div class="stat-label">Total Guru</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon amber">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-value">{{ $totalSiswa }}</div>
                <div class="stat-label">Total Siswa</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon terracotta">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="stat-value">{{ $totalSatpam }}</div>
                <div class="stat-label">Total Satpam</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div class="stat-value">{{ $satpamAktif }}</div>
                <div class="stat-label">Satpam Aktif</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="content-card mb-4">
                <div class="content-card-header">
                    <h5>Guru Terbaru</h5>
                    <a href="{{ route('admin.guru.index') }}" style="color: var(--pine); text-decoration: none; font-weight: 500;">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="content-card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $recentGuru = \App\Models\Guru::with('user')->latest()->take(5)->get();
                            @endphp
                            @foreach($recentGuru as $guru)
                                <tr>
                                    <td>{{ $guru?->user?->name }}</td>
                                    <td>{{ $guru->mapel }}</td>
                                    <td>
                                        @if($guru?->user?->status == 'aktif')
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="content-card mb-4">
                <div class="content-card-header">
                    <h5>Siswa Terbaru</h5>
                    <a href="{{ route('admin.siswa.index') }}" style="color: var(--pine); text-decoration: none; font-weight: 500;">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="content-card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $recentSiswa = \App\Models\Siswa::with('user')->latest()->take(5)->get();
                            @endphp
                            @foreach($recentSiswa as $siswa)
                                <tr>
                                    <td>{{ $siswa?->user?->name }}</td>
                                    <td>{{ $siswa->kelas }}</td>
                                    <td>
                                        @if($siswa?->user?->status == 'aktif')
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="content-card mb-4">
                <div class="content-card-header">
                    <h5>Satpam Terbaru</h5>
                    <a href="{{ route('admin.satpam.index') }}" style="color: var(--pine); text-decoration: none; font-weight: 500;">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="content-card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $recentSatpam = \App\Models\Satpam::with('user')->latest()->take(5)->get();
                            @endphp
                            @foreach($recentSatpam as $satpam)
                                <tr>
                                    <td>{{ $satpam?->user?->name }}</td>
                                    <td>{{ $satpam->nip }}</td>
                                    <td>
                                        @if($satpam?->user?->status == 'aktif')
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
