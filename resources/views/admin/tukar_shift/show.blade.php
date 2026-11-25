@extends('layouts.app')

@section('title', 'Detail Tukar Shift')
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
    <div class="mb-3">
        <a href="{{ route('admin.tukar_shift.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
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
            <h5><i class="bi bi-arrow-left-right"></i> Detail Tukar Shift</h5>
            <div class="d-flex gap-2 align-items-center">
                @if($tukarShift->status === 'pending')
                    <form method="POST" action="{{ route('admin.tukar_shift.approve', $tukarShift) }}" class="d-inline-flex align-items-center gap-2">
                        @csrf
                        @if(!$tukarShift->jadwal_penerima_id)
                            <select name="jadwal_penerima_id" class="form-select form-select-sm" style="width: auto;" required>
                                <option value="">-- Pilih Jadwal Tukar {{ $tukarShift->penerima?->user?->name ?? 'Penerima' }} --</option>
                                @foreach($jadwalPenerimaList as $jp)
                                    <option value="{{ $jp->id }}">
                                        {{ $jp->tanggal?->locale('id')->translatedFormat('d F Y') }} — Shift {{ ucfirst($jp->shift) }} ({{ $jp->jam_masuk?->format('H:i') ?? '-' }} - {{ $jp->jam_pulang?->format('H:i') ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui dan tukar jadwal shift ini?')">
                            <i class="bi bi-check-lg"></i> Setujui & Tukar
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.tukar_shift.reject', $tukarShift) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak permintaan ini?')">
                            <i class="bi bi-x-lg"></i> Tolak
                        </button>
                    </form>
                @endif
            </div>
        </div>
        <div class="content-card-body">
            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    @if($tukarShift->status === 'pending')
                        <span class="badge badge-warning">Menunggu Persetujuan</span>
                    @elseif($tukarShift->status === 'approved')
                        <span class="badge badge-success">Disetujui</span>
                    @else
                        <span class="badge badge-danger">Ditolak</span>
                    @endif
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Pengaju</div>
                <div class="detail-value"><strong>{{ $tukarShift->pengaju?->user?->name ?? '-' }}</strong></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jadwal Pengaju</div>
                <div class="detail-value">
                    @if($tukarShift->jadwal)
                        {{ $tukarShift->jadwal->tanggal?->locale('id')->translatedFormat('d F Y') }} · Shift {{ ucfirst($tukarShift->jadwal->shift) }}
                        <span class="text-muted">({{ $tukarShift->jadwal->jam_masuk?->format('H:i') ?? '-' }} - {{ $tukarShift->jadwal->jam_pulang?->format('H:i') ?? '-' }})</span>
                    @else - @endif
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Penerima</div>
                <div class="detail-value"><strong>{{ $tukarShift->penerima?->user?->name ?? '-' }}</strong></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jadwal Penerima</div>
                <div class="detail-value">
                    @if($tukarShift->jadwalPenerima)
                        {{ $tukarShift->jadwalPenerima->tanggal?->locale('id')->translatedFormat('d F Y') }} · Shift {{ ucfirst($tukarShift->jadwalPenerima->shift) }}
                        <span class="text-muted">({{ $tukarShift->jadwalPenerima->jam_masuk?->format('H:i') ?? '-' }} - {{ $tukarShift->jadwalPenerima->jam_pulang?->format('H:i') ?? '-' }})</span>
                    @else
                        <span class="badge badge-warning">Penerima belum memilih (bisa ditentukan langsung oleh Admin saat menyetujui di atas)</span>
                    @endif
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Disetujui Oleh</div>
                <div class="detail-value">{{ $tukarShift->disetujuiOleh?->name ?? '-' }}</div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    .detail-row {
        display: flex;
        padding: 14px 0;
        border-bottom: 1px solid var(--line);
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        width: 220px;
        font-weight: 500;
        color: var(--ink-soft);
        flex-shrink: 0;
    }

    .detail-value {
        color: var(--ink);
        flex: 1;
    }
@endsection
