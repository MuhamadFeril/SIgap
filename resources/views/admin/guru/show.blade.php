@extends('layouts.app')

@section('title', 'Detail Guru')
@section('user-role', 'Admin Sekolah')

@section('sidebar')
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('admin.guru.index') }}" class="active">
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
    <div class="content-card">
        <div class="content-card-header">
            <h5>Detail Guru</h5>
            <div>
                <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="content-card-body">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ substr($guru?->user?->name, 0, 1) }}
                </div>
                <div class="profile-info">
                    <h3>{{ $guru?->user?->name }}</h3>
                    <p>{{ $guru->mapel }}</p>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">NIP</div>
                <div class="detail-value">{{ $guru->nip }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Email</div>
                <div class="detail-value">{{ $guru?->user?->email }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Mata Pelajaran</div>
                <div class="detail-value">{{ $guru->mapel }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">No. Telepon</div>
                <div class="detail-value">{{ $guru->no_telepon ?? '-' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    @if($guru?->user?->status == 'aktif')
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Nonaktif</span>
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Tanggal Dibuat</div>
                <div class="detail-value">{{ $guru?->user?->created_at->format('d F Y H:i') }}</div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .profile-header {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 32px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--pine);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 32px;
        }

        .profile-info h3 {
            margin: 0 0 8px 0;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            color: var(--ink);
        }

        .profile-info p {
            margin: 0;
            color: var(--ink-soft);
        }

        .detail-row {
            display: flex;
            gap: 0;
            padding: 16px 0;
            border-bottom: 1px solid var(--line);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 200px;
            font-weight: 600;
            color: var(--ink-soft);
            font-size: 14px;
        }

        .detail-value {
            flex: 1;
            color: var(--ink);
            font-size: 14px;
        }
    </style>
@endsection
