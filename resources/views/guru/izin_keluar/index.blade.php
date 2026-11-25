@extends('layouts.app')

@section('title', 'Persetujuan Izin Keluar')

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
    <div class="mb-4">
        <h2 style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; margin-bottom: 8px;">
            Persetujuan Izin Keluar Siswa
        </h2>
        <p style="color: var(--ink-soft); margin: 0;">
            Daftar pengajuan izin keluar yang memerlukan tanggapan Guru Piket.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="content-card">
        <div class="content-card-header">
            <h5>Daftar Pengajuan Izin</h5>
        </div>
        <div class="content-card-body p-0">
            @if($izinKeluar->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Foto & Bukti</th>
                            <th>Alasan & Deskripsi</th>
                            <th>Jam Rencana</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($izinKeluar as $izin)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $izin->siswa?->user?->name ?? 'Siswa Tanpa Nama' }}</div>
                                    <small class="text-muted">NIS: {{ $izin->siswa?->nis ?? '-' }}</small>
                                </td>
                                <td>{{ $izin->siswa?->kelas ?? '-' }}</td>
                                <td>
                                    @if($izin->siswa?->foto_profil_path)
                                        <img src="{{ asset('storage/' . $izin?->siswa?->foto_profil_path) }}" alt="Foto {{ $izin->siswa?->user?->name ?? 'siswa' }}" width="42" height="42" style="object-fit:cover;border-radius:50%;" class="me-2 mb-1">
                                    @endif
                                    @if($izin->bukti_path)
                                        @php($buktiVideo = in_array(strtolower(pathinfo($izin->bukti_path, PATHINFO_EXTENSION)), ['mp4', 'mov', 'webm']))
                                        <a href="{{ asset('storage/' . $izin->bukti_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi {{ $buktiVideo ? 'bi-play-circle' : 'bi-file-earmark-image' }}"></i> {{ $buktiVideo ? 'Video Bukti' : 'Foto/Berkas' }}
                                        </a>
                                    @else
                                        <span class="text-muted small">Tanpa lampiran</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $izin->alasan }}</div>
                                    @if($izin->deskripsi)
                                        <small class="text-muted d-block">{{ Str::limit($izin->deskripsi, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div><i class="bi bi-clock me-1 text-primary"></i> {{ $izin->jam_keluar_rencana }}</div>
                                    <small class="text-muted">{{ $izin->created_at->format('d M Y, H:i') }}</small>
                                </td>
                                <td>
                                    @if($izin->status === 'pending')
                                        <span class="badge badge-warning"><i class="bi bi-hourglass-split"></i> Pending</span>
                                    @elseif($izin->status === 'approved')
                                        <span class="badge badge-success"><i class="bi bi-check-circle"></i> Disetujui</span>
                                    @else
                                        <span class="badge badge-danger"><i class="bi bi-x-circle"></i> Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @if($izin->status === 'pending')
                                        <div class="d-flex gap-2">
                                            <form method="POST" action="{{ route('guru.izin_keluar.approve', $izin) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-check-lg"></i> Setujui
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('guru.izin_keluar.reject', $izin) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                                                    <i class="bi bi-x-lg"></i> Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted small">
                                            Keputusan oleh: {{ $izin->disetujuiOleh?->name ?? 'Sistem' }}
                                        </span>
                                    @endif
                                    <div class="mt-2">
                                        <a href="{{ route('guru.izin_keluar.edit', $izin) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil-square"></i> Kelola
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-3">
                    {{ $izinKeluar->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada pengajuan izin keluar dari siswa.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
