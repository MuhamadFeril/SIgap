@extends('layouts.app')

@section('title', 'Detail Izin Keluar')

@section('sidebar')
    <li>
        <a href="{{ route('satpam.dashboard') }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.izin_keluar.index') }}" class="active">
            <i class="bi bi-person-badge"></i> Izin Keluar
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.izin_keluar.keluar_hari_ini') }}">
            <i class="bi bi-person-walking"></i> Keluar Hari Ini
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.izin_keluar.riwayat') }}">
            <i class="bi bi-clock-history"></i> Riwayat
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
    @include('izin_keluar._detail', ['izinKeluar' => $izinKeluar, 'backRoute' => 'satpam.izin_keluar.index'])
@endsection

@section('styles')
    <style>
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
    </style>
@endsection
