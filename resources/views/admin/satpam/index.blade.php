@extends('layouts.app')

@section('title', 'Manajemen Satpam')
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
        <a href="{{ route('admin.satpam.index') }}" class="active">
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
            <h5>Manajemen Satpam</h5>
            <a href="{{ route('admin.satpam.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Satpam
            </a>
        </div>
        <div class="content-card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($satpam as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm">
                                            {{ substr($item?->user?->name, 0, 1) }}
                                        </div>
                                        <span>{{ $item?->user?->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item?->user?->email }}</td>
                                <td>{{ $item->no_telepon ?? '-' }}</td>
                                <td>
                                    @if($item?->user?->status == 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.satpam.show', $item) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.satpam.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.satpam.destroy', $item) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus satpam ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($satpam->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-shield-check"></i>
                    <p>Belum ada data satpam</p>
                    <a href="{{ route('admin.satpam.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Tambah Satpam
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
