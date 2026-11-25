@extends('layouts.app')

@section('title', 'Tambah Jadwal Satpam')
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
        <a href="{{ route('admin.jadwal.index') }}" class="active">
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
            <h5>Tambah Jadwal Satpam</h5>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        <div class="content-card-body">
            @if($errors->any())
                <div class="alert-error">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.jadwal.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Satpam</label>
                    <select name="satpam_id" class="form-select" required>
                        <option value="">Pilih Satpam</option>
                        @foreach($satpams as $s)
                            <option value="{{ $s->id }}" {{ old('satpam_id') == $s->id ? 'selected' : '' }}>{{ $s?->user?->name ?? "-" }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Shift</label>
                    <select name="shift" class="form-select" required>
                        <option value="">Pilih Shift</option>
                        <option value="pagi" {{ old('shift') == 'pagi' ? 'selected' : '' }}>Pagi</option>
                        <option value="siang" {{ old('shift') == 'siang' ? 'selected' : '' }}>Siang</option>
                        <option value="malam" {{ old('shift') == 'malam' ? 'selected' : '' }}>Malam</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jam Masuk (Jadwal)</label>
                        <input type="time" name="jam_masuk" class="form-control" value="{{ old('jam_masuk') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jam Pulang (Jadwal)</label>
                        <input type="time" name="jam_pulang" class="form-control" value="{{ old('jam_pulang') }}">
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary"><i class="bi bi-x-lg"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('styles')
    .alert-error {
        background: #fdf3f1;
        border: 1px solid #f9dcd8;
        color: var(--terracotta);
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13px;
        margin-bottom: 24px;
    }
@endsection
