@extends('layouts.app')

@section('title', 'Izin Keluar')
@section('user-role', $siswa->kelas ?? 'Siswa')

@section('sidebar')
    <li>
        <a href="{{ route('siswa.dashboard') }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('siswa.izin_keluar.index') }}" class="active">
            <i class="bi bi-box-arrow-right"></i> Izin Keluar
        </a>
    </li>
@endsection

@section('content')
    <div class="mb-4">
        <h2 style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; margin-bottom: 8px;">
            Izin Keluar
        </h2>
        <p style="color: var(--ink-soft); margin: 0;">
            Kelola dan ajukan izin keluar Anda.
        </p>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h5>Riwayat Izin Keluar</h5>
            <a href="{{ route('siswa.izin_keluar.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Buat Izin Baru
            </a>
        </div>
        <div class="content-card-body p-0">
            @if($izinKeluar->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Alasan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Jam Keluar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($izinKeluar as $izin)
                            <tr>
                                <td>{{ $izin->alasan }}</td>
                                <td>{{ $izin->created_at->format('d M Y') }}</td>
                                <td>{{ $izin->jam_keluar_rencana }}</td>
                                <td>
                                    @if($izin->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($izin->status === 'approved')
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('siswa.izin_keluar.show', $izin) }}" class="btn btn-outline-primary btn-sm me-2">Detail</a>
                                    @if($izin->status === 'pending')
                                        <form method="POST" action="{{ route('siswa.izin_keluar.destroy', $izin) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Batalkan izin ini?')">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada izin keluar</p>
                    <a href="{{ route('siswa.izin_keluar.create') }}" class="btn btn-primary">Buat Izin Pertama</a>
                </div>
            @endif
        </div>
    </div>
@endsection
