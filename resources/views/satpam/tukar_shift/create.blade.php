@extends('layouts.app')

@section('title', 'Buat Permintaan Tukar Shift')

@section('sidebar')
    <li>
        <a href="{{ route('satpam.dashboard') }}">
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
        <a href="{{ route('satpam.tukar_shift.index') }}" class="active">
            <i class="bi bi-arrow-left-right"></i> Tukar Shift
        </a>
    </li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="content-card-header">
                    <h5><i class="bi bi-plus-circle"></i> Buat Permintaan Tukar Shift</h5>
                    <a href="{{ route('satpam.tukar_shift.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="content-card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="shift-info">
                        <h6><i class="bi bi-info-circle"></i> Informasi</h6>
                        <p>Pilih jadwal shift Anda yang ingin ditukar dan satpam lain yang bersedia menukar shift dengan Anda.</p>
                    </div>

                    <form action="{{ route('satpam.tukar_shift.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="jadwal_id" class="form-label">Jadwal Anda <span class="text-danger">*</span></label>
                            <select class="form-select" id="jadwal_id" name="jadwal_id" required>
                                <option value="">Pilih jadwal yang ingin ditukar</option>
                                @foreach($jadwalSatpam as $jadwal)
                                    <option value="{{ $jadwal->id }}" {{ old('jadwal_id') == $jadwal->id ? 'selected' : '' }}>
                                        {{ $jadwal->tanggal->locale('id')->translatedFormat('l, d F Y') }} - {{ ucfirst($jadwal->shift) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="help-text">Hanya jadwal hari ini dan yang akan datang yang ditampilkan</div>
                        </div>

                        <div class="mb-4">
                            <label for="penerima_id" class="form-label">Tukar Dengan <span class="text-danger">*</span></label>
                            <select class="form-select" id="penerima_id" name="penerima_id" required>
                                <option value="">Pilih Satpam</option>
                                @foreach($satpams as $satpam)
                                    <option value="{{ $satpam->id }}" {{ old('penerima_id') == $satpam->id ? 'selected' : '' }}>
                                        {{ $satpam?->user?->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="help-text">Pilih satpam yang ingin diajak tukar shift</div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> <strong>Informasi:</strong> Permintaan tukar shift akan dikirim ke satpam target dan menunggu persetujuan mereka.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Kirim Permintaan
                            </button>
                            <a href="{{ route('satpam.tukar_shift.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .shift-info {
            background: var(--mint);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 16px;
        }

        .shift-info h6 {
            margin: 0 0 8px 0;
            color: var(--pine);
            font-weight: 600;
        }

        .shift-info p {
            margin: 0;
            color: var(--ink-soft);
            font-size: 14px;
        }
    </style>
@endsection
