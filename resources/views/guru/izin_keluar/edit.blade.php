@extends('layouts.app')

@section('title', 'Edit Izin Keluar')

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

    <div class="mb-3">
        <a href="{{ route('guru.izin_keluar.show', $izinKeluar) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali ke Detail</a>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="content-card">
                <div class="content-card-header"><h5><i class="bi bi-clock-history"></i> Tandai Kehadiran</h5></div>
                <div class="content-card-body">
                    <div class="mb-3">
                        @if($izinKeluar->jam_keluar_aktual)
                            <span class="badge badge-success">Sudah keluar: {{ $izinKeluar->jam_keluar_aktual->locale('id')->translatedFormat('d F Y H:i') }}</span>
                        @else
                            <span class="badge badge-warning">Belum keluar</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        @if($izinKeluar->jam_kembali_aktual)
                            <span class="badge badge-success">Sudah kembali: {{ $izinKeluar->jam_kembali_aktual->locale('id')->translatedFormat('d F Y H:i') }}</span>
                            @if($izinKeluar->terlambat)
                                <span class="badge badge-danger">TELAT</span>
                            @else
                                <span class="badge badge-info">Tepat Waktu</span>
                            @endif
                        @else
                            <span class="badge badge-warning">Belum kembali</span>
                        @endif
                    </div>

                    @if($izinKeluar->status === 'approved')
                        @if(!$izinKeluar->jam_keluar_aktual)
                            <form method="POST" action="{{ route('guru.izin_keluar.update', $izinKeluar) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="tandai_keluar">
                                <button type="submit" class="btn btn-success"><i class="bi bi-box-arrow-right"></i> Tandai Keluar Sekarang</button>
                            </form>
                        @elseif(!$izinKeluar->jam_kembali_aktual)
                            <form method="POST" action="{{ route('guru.izin_keluar.update', $izinKeluar) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="tandai_kembali">
                                <button type="submit" class="btn btn-success"><i class="bi bi-box-arrow-in-left"></i> Tandai Kembali Sekarang</button>
                            </form>
                        @endif
                    @else
                        <p class="info-text">Izin harus disetujui terlebih dahulu untuk dapat ditandai keluar/kembali.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="content-card">
                <div class="content-card-header"><h5><i class="bi bi-pencil-square"></i> Edit Data</h5></div>
                <div class="content-card-body">
                    <form method="POST" action="{{ route('guru.izin_keluar.update', $izinKeluar) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="jam_keluar_rencana" class="form-label">Jam Keluar Rencana</label>
                            <input type="time" class="form-control" id="jam_keluar_rencana" name="jam_keluar_rencana" required
                                value="{{ old('jam_keluar_rencana', $izinKeluar->jam_keluar_rencana?->format('H:i')) }}">
                        </div>
                        <div class="mb-3">
                            <label for="jam_kembali_rencana" class="form-label">Jam Kembali Rencana</label>
                            <input type="time" class="form-control" id="jam_kembali_rencana" name="jam_kembali_rencana" required
                                value="{{ old('jam_kembali_rencana', $izinKeluar->jam_kembali_rencana?->format('H:i')) }}">
                            <div class="info-text mt-1">Jika jam kembali aktual melebihi ini, akan dicatat "TELAT".</div>
                        </div>
                        <div class="mb-3">
                            <label for="jam_keluar_aktual" class="form-label">Jam Keluar Aktual</label>
                            <input type="datetime-local" class="form-control" id="jam_keluar_aktual" name="jam_keluar_aktual"
                                value="{{ old('jam_keluar_aktual', $izinKeluar->jam_keluar_aktual?->format('Y-m-d\TH:i')) }}">
                        </div>
                        <div class="mb-3">
                            <label for="jam_kembali_aktual" class="form-label">Jam Kembali Aktual</label>
                            <input type="datetime-local" class="form-control" id="jam_kembali_aktual" name="jam_kembali_aktual"
                                value="{{ old('jam_kembali_aktual', $izinKeluar->jam_kembali_aktual?->format('Y-m-d\TH:i')) }}">
                            <div class="info-text mt-1">Diisi manual jika satpam belum mencatat. Status telat dihitung otomatis.</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
                            <a href="{{ route('guru.izin_keluar.show', $izinKeluar) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .info-text { font-size: 13px; color: var(--ink-soft); }
    </style>
@endsection
