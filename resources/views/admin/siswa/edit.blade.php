@extends('layouts.app')

@section('title', 'Edit Siswa')
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
        <a href="{{ route('admin.siswa.index') }}" class="active">
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
            <h5>Edit Siswa: {{ $siswa?->user?->name }}</h5>
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
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

            <form action="{{ route('admin.siswa.update', $siswa) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $siswa?->user?->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $siswa?->user?->email) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Password (Biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $siswa->kelas) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $siswa->no_telepon) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="aktif" {{ $siswa?->user?->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $siswa?->user?->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-lg"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .alert-error {
            background: #fdf3f1;
            border: 1px solid #f9dcd8;
            color: var(--terracotta);
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 24px;
        }
    </style>
@endsection
