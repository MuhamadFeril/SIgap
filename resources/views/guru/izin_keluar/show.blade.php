@extends('layouts.app')

@section('title', 'Detail Izin Keluar')

@section('sidebar')
    <li>
        <a href="{{ route('guru.dashboard') }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('guru.izin_keluar.index') }}" class="active">
            <i class="bi bi-person-badge"></i> Izin Keluar
        </a>
    </li>
@endsection

@section('content')
    <div class="mb-3">
        <a href="{{ route('guru.izin_keluar.edit', $izinKeluar) }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-pencil-square"></i> Kelola / Tandai Kehadiran
        </a>
    </div>
    @include('izin_keluar._detail', ['izinKeluar' => $izinKeluar, 'backRoute' => 'guru.izin_keluar.index'])
@endsection

@section('styles')
    <style>
        .detail-row { display: flex; padding: 14px 0; border-bottom: 1px solid var(--line); }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { width: 220px; font-weight: 500; color: var(--ink-soft); flex-shrink: 0; }
        .detail-value { color: var(--ink); flex: 1; }
    </style>
@endsection
