@extends('layouts.app')

@section('title', 'Izin Keluar')

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
    <div class="mb-4">
        <h2 style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; margin-bottom: 8px;">
            Izin Keluar
        </h2>
        <p style="color: var(--ink-soft); margin: 0;">
            Kelola dan tandai izin keluar siswa.
        </p>
    </div>

    <div class="content-card">
        <div class="content-card-header">
            <h5>Izin Keluar yang Disetujui</h5>
            <div>
                <a href="{{ route('satpam.izin_keluar.keluar_hari_ini') }}" class="btn btn-outline-primary btn-sm me-2">
                    <i class="bi bi-person-walking"></i> Keluar Hari Ini
                </a>
                <a href="{{ route('satpam.izin_keluar.riwayat') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-clock-history"></i> Riwayat
                </a>
            </div>
        </div>
        <div class="content-card-body p-0">
            @if($izinKeluar->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Foto & Bukti</th>
                            <th>Kelas</th>
                            <th>Alasan</th>
                            <th>Jam Keluar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($izinKeluar as $izin)
                            <tr>
                                <td>{{ $izin->siswa?->user?->name }}</td>
                                <td>
                                    @if($izin?->siswa?->foto_profil_path)
                                        <img src="{{ asset('storage/' . $izin?->siswa?->foto_profil_path) }}" alt="Foto {{ $izin->siswa?->user?->name }}" width="42" height="42" style="object-fit:cover;border-radius:50%;" class="me-2">
                                    @endif
                                    @if($izin->bukti_path)
                                        @php($buktiVideo = in_array(strtolower(pathinfo($izin->bukti_path, PATHINFO_EXTENSION)), ['mp4', 'mov', 'webm']))
                                        <a href="{{ asset('storage/' . $izin->bukti_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">{{ $buktiVideo ? 'Putar video' : 'Lihat bukti' }}</a>
                                    @endif
                                </td>
                                <td>{{ $izin?->siswa?->kelas }}</td>
                                <td>{{ $izin->alasan }}</td>
                                <td>{{ $izin->jam_keluar_rencana }}</td>
                                <td>
                                    @if($izin->jam_keluar_aktual && !$izin->jam_kembali_aktual)
                                        <span class="badge badge-warning">Sedang Keluar</span>
                                    @elseif($izin->jam_kembali_aktual)
                                        <span class="badge badge-success">Sudah Kembali</span>
                                    @else
                                        <span class="badge badge-success">Disetujui</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$izin->jam_keluar_aktual)
                                        <div class="d-flex gap-1 flex-wrap">
                                            <a href="{{ route('satpam.izin_keluar.show', $izin) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <form method="POST" action="{{ route('satpam.izin_keluar.tandai_keluar', $izin) }}" enctype="multipart/form-data" class="d-inline-block">
                                                @csrf
                                                <input type="file" name="foto" accept="image/*" class="form-control form-control-sm d-inline-block align-middle mb-1" style="width:auto; max-width:180px;" title="Foto bukti saat keluar">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="bi bi-box-arrow-right"></i> Tandai Keluar
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($izin->jam_keluar_aktual && !$izin->jam_kembali_aktual)
                                        <div class="d-flex gap-1 flex-wrap">
                                            <a href="{{ route('satpam.izin_keluar.show', $izin) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <form method="POST" action="{{ route('satpam.izin_keluar.tandai_kembali', $izin) }}" enctype="multipart/form-data" class="d-inline-block">
                                                @csrf
                                                <input type="file" name="foto" accept="image/*" class="form-control form-control-sm d-inline-block align-middle mb-1" style="width:auto; max-width:180px;" title="Foto bukti saat kembali">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="bi bi-box-arrow-in-left"></i> Tandai Kembali
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <a href="{{ route('satpam.izin_keluar.show', $izin) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Tidak ada izin keluar yang perlu ditandai</p>
                </div>
            @endif
        </div>
    </div>
@endsection
