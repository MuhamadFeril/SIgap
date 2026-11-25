@extends('layouts.app')

@section('title', 'Manajemen Jadwal Satpam')
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
            <h5>Manajemen Jadwal Satpam</h5>
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Jadwal</a>
        </div>
        <div class="content-card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-4">
                    <select name="satpam_id" class="form-select">
                        <option value="">Semua Satpam</option>
                        @foreach($satpams as $s)
                            <option value="{{ $s->id }}" {{ request('satpam_id') == $s->id ? 'selected' : '' }}>{{ $s?->user?->name ?? "-" }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="shift" class="form-select">
                        <option value="">Semua Shift</option>
                        <option value="pagi" {{ request('shift') == 'pagi' ? 'selected' : '' }}>Pagi</option>
                        <option value="siang" {{ request('shift') == 'siang' ? 'selected' : '' }}>Siang</option>
                        <option value="malam" {{ request('shift') == 'malam' ? 'selected' : '' }}>Malam</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Satpam</th>
                            <th>Tanggal</th>
                            <th>Shift</th>
                            <th>Jam Jadwal</th>
                            <th>Status Hadir</th>
                            <th>Presensi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwalSatpam as $item)
                            <tr>
                                <td>{{ $item->satpam?->user?->name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d M Y') }}</td>
                                <td>{{ ucfirst($item->shift) }}</td>
                                <td>
                                    @if($item->jam_masuk)
                                        <div>Masuk: {{ \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') }}</div>
                                    @endif
                                    @if($item->jam_pulang)
                                        <div>Pulang: {{ \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') }}</div>
                                    @endif
                                    @if(!$item->jam_masuk && !$item->jam_pulang)
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status_hadir === 'hadir')
                                        <span class="badge badge-success">Hadir</span>
                                    @elseif($item->status_hadir === 'tidak_hadir')
                                        <span class="badge badge-danger">Tidak Hadir</span>
                                    @else
                                        <span class="badge badge-warning">Belum Presensi</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->waktu_masuk)
                                        <div>Masuk: {{ \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i') }}
                                        @if($item->telat_masuk)<span class="badge badge-danger">Telat</span>@endif
                                        </div>
                                    @endif
                                    @if($item->waktu_pulang)
                                        <div>Pulang: {{ \Carbon\Carbon::parse($item->waktu_pulang)->format('H:i') }}</div>
                                    @endif
                                    @if(!$item->waktu_masuk && !$item->waktu_pulang)
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.jadwal.edit', $item) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('admin.jadwal.destroy', $item) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus jadwal ini?')"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="bi bi-calendar-x"></i>
                                        <p>Belum ada data jadwal</p>
                                        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Jadwal</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($jadwalSatpam->hasPages())
                <div class="d-flex justify-content-center mt-4">{{ $jadwalSatpam->links() }}</div>
            @endif
        </div>
    </div>
@endsection
