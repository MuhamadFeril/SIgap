@extends('layouts.app')

@section('title', 'Manajemen Tukar Shift')
@section('user-role', 'Admin Sekolah')

@section('sidebar')
    <li>
        <a href="{{ route('admin.dashboard') }}">
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
        <a href="{{ route('admin.tukar_shift.index') }}" class="active">
            <i class="bi bi-arrow-left-right"></i> Tukar Shift
        </a>
    </li>
@endsection

@section('content')
    <div class="mb-4">
        <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:700;margin-bottom:8px;">Manajemen Tukar Shift</h2>
        <p style="color:var(--ink-soft);margin:0;">Daftar dan persetujuan pengajuan tukar shift satpam.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="content-card">
        <div class="content-card-header">
            <h5><i class="bi bi-arrow-left-right"></i> Pengajuan Tukar Shift</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.tukar_shift.index') }}" class="btn btn-outline-primary btn-sm {{ !$status ? 'active' : '' }}">Semua</a>
                <a href="{{ route('admin.tukar_shift.index', ['status' => 'pending']) }}" class="btn btn-outline-primary btn-sm {{ $status === 'pending' ? 'active' : '' }}">Menunggu</a>
                <a href="{{ route('admin.tukar_shift.index', ['status' => 'approved']) }}" class="btn btn-outline-primary btn-sm {{ $status === 'approved' ? 'active' : '' }}">Disetujui</a>
                <a href="{{ route('admin.tukar_shift.index', ['status' => 'rejected']) }}" class="btn btn-outline-primary btn-sm {{ $status === 'rejected' ? 'active' : '' }}">Ditolak</a>
            </div>
        </div>
        <div class="content-card-body p-0">
            @if($tukarShifts->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pengaju</th>
                            <th>Jadwal Pengaju</th>
                            <th>Penerima</th>
                            <th>Jadwal Penerima</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tukarShifts as $tukar)
                            <tr>
                                <td>{{ $tukar->pengaju?->user?->name ?? '-' }}</td>
                                <td>
                                    @if($tukar->jadwal)
                                        {{ $tukar->jadwal->tanggal?->locale('id')->translatedFormat('d M Y') }} · {{ ucfirst($tukar->jadwal->shift) }}
                                    @else - @endif
                                </td>
                                <td>{{ $tukar->penerima?->user?->name ?? '-' }}</td>
                                <td>
                                    @if($tukar->jadwalPenerima)
                                        {{ $tukar->jadwalPenerima->tanggal?->locale('id')->translatedFormat('d M Y') }} · {{ ucfirst($tukar->jadwalPenerima->shift) }}
                                    @else
                                        <span class="text-muted">Belum dipilih</span>
                                    @endif
                                </td>
                                <td>
                                    @if($tukar->status === 'pending')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif($tukar->status === 'approved')
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.tukar_shift.show', $tukar) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-3">{{ $tukarShifts->links() }}</div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada pengajuan tukar shift.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
