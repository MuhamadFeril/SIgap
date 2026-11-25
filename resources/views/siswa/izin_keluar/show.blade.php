@extends('layouts.app')

@section('title', 'Detail Izin Keluar')
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

@section('styles')
    <style>
        .detail-row {
            display: flex;
            padding: 16px 0;
            border-bottom: 1px solid var(--line);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 220px;
            font-weight: 500;
            color: var(--ink-soft);
            flex-shrink: 0;
        }

        .detail-value {
            color: var(--ink);
            flex: 1;
        }

        .status-timeline {
            position: relative;
            padding-left: 30px;
        }

        .status-timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--line);
        }

        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 4px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--pine);
            border: 2px solid var(--surface);
        }

        .timeline-item.inactive::before {
            background: var(--line);
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-time {
            font-size: 12px;
            color: var(--ink-soft);
            margin-bottom: 4px;
        }

        .timeline-title {
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 2px;
        }

        .timeline-desc {
            font-size: 13px;
            color: var(--ink-soft);
        }

        /* Approved notice banner */
        .approved-notice {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            border: 1px solid #a5d6a7;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .approved-notice i {
            font-size: 24px;
            color: #2e7d32;
        }

        .approved-notice-text strong {
            display: block;
            color: #1b5e20;
            font-weight: 600;
        }

        .approved-notice-text span {
            color: #2e7d32;
            font-size: 14px;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Banner jika izin sudah disetujui dan belum keluar --}}
                @if($izinKeluar->status === 'approved' && !$izinKeluar->jam_keluar_aktual)
                    <div class="approved-notice">
                        <i class="bi bi-shield-check-fill"></i>
                        <div class="approved-notice-text">
                            <strong>Izin Anda Sudah Disetujui!</strong>
                            <span>Silakan melapor ke Satpam untuk dicatat keluar. Tunjukkan halaman ini.</span>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="content-card">
                    <div class="content-card-header">
                        <h5><i class="bi bi-file-text"></i> Detail Izin Keluar</h5>
                        <div class="d-flex gap-2">
                            @if($izinKeluar->status === 'pending')
                                <form action="{{ route('siswa.izin_keluar.destroy', $izinKeluar) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permohonan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-x-circle"></i> Batalkan
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('siswa.izin_keluar.index') }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="content-card-body">

                        {{-- Status utama --}}
                        <div class="detail-row">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                @if($izinKeluar->status === 'pending')
                                    <span class="badge badge-warning"><i class="bi bi-hourglass-split"></i> Menunggu Persetujuan Guru</span>
                                @elseif($izinKeluar->status === 'approved' && !$izinKeluar->jam_keluar_aktual)
                                    <span class="badge badge-success"><i class="bi bi-check-circle"></i> Disetujui — Harap lapor ke Satpam</span>
                                @elseif($izinKeluar->status === 'approved' && $izinKeluar->jam_keluar_aktual && !$izinKeluar->jam_kembali_aktual)
                                    <span class="badge badge-warning"><i class="bi bi-person-walking"></i> Sedang Keluar</span>
                                @elseif($izinKeluar->status === 'approved' && $izinKeluar->jam_kembali_aktual)
                                    @if($izinKeluar->terlambat)
                                        <span class="badge badge-danger"><i class="bi bi-clock-history"></i> Selesai — Terlambat Kembali</span>
                                    @else
                                        <span class="badge badge-success"><i class="bi bi-check2-circle"></i> Selesai — Tepat Waktu</span>
                                    @endif
                                @elseif($izinKeluar->status === 'rejected')
                                    <span class="badge badge-danger"><i class="bi bi-x-circle"></i> Ditolak</span>
                                @endif
                            </div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">Alasan</div>
                            <div class="detail-value">{{ $izinKeluar->alasan ?? '-' }}</div>
                        </div>

                        @if($izinKeluar->deskripsi)
                            <div class="detail-row">
                                <div class="detail-label">Deskripsi</div>
                                <div class="detail-value">{{ $izinKeluar->deskripsi }}</div>
                            </div>
                        @endif

                        <div class="detail-row">
                            <div class="detail-label">Jam Keluar Rencana</div>
                            <div class="detail-value">
                                {{ $izinKeluar->jam_keluar_rencana ? $izinKeluar->jam_keluar_rencana->format('H:i') : '-' }}
                            </div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">Jam Kembali Rencana</div>
                            <div class="detail-value">
                                {{ $izinKeluar->jam_kembali_rencana ? $izinKeluar->jam_kembali_rencana->format('H:i') : '-' }}
                            </div>
                        </div>

                        @if($izinKeluar->bukti_path)
                            <div class="detail-row">
                                <div class="detail-label">Bukti Terlampir</div>
                                <div class="detail-value">
                                    @php($buktiVideo = in_array(strtolower(pathinfo($izinKeluar->bukti_path, PATHINFO_EXTENSION)), ['mp4', 'mov', 'webm']))
                                    <a href="{{ asset('storage/' . $izinKeluar->bukti_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi {{ $buktiVideo ? 'bi-play-circle' : 'bi-file-earmark-image' }}"></i>
                                        {{ $buktiVideo ? 'Putar video bukti' : 'Lihat foto bukti' }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="detail-row">
                            <div class="detail-label">Tanggal Pengajuan</div>
                            <div class="detail-value">
                                {{ $izinKeluar->created_at->locale('id')->translatedFormat('l, d F Y H:i') }}
                            </div>
                        </div>

                        {{-- Info keputusan guru --}}
                        @if($izinKeluar->disetujuiOleh)
                            <div class="detail-row">
                                <div class="detail-label">
                                    {{ $izinKeluar->status === 'approved' ? 'Disetujui Oleh' : 'Ditolak Oleh' }}
                                </div>
                                <div class="detail-value">
                                    {{ $izinKeluar->disetujuiOleh->name }}
                                    @if($izinKeluar->waktu_keputusan)
                                        <span class="text-muted">({{ $izinKeluar->waktu_keputusan->locale('id')->translatedFormat('d F Y H:i') }})</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Info catatan satpam --}}
                        @if($izinKeluar->jam_keluar_aktual)
                            <div class="detail-row">
                                <div class="detail-label">Jam Keluar Aktual</div>
                                <div class="detail-value">
                                    {{ $izinKeluar->jam_keluar_aktual->locale('id')->translatedFormat('d F Y H:i') }}
                                    @if($izinKeluar->dicatatKeluarOleh)
                                        <span class="text-muted">(dicatat oleh {{ $izinKeluar->dicatatKeluarOleh->name }})</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($izinKeluar->jam_kembali_aktual)
                            <div class="detail-row">
                                <div class="detail-label">Jam Kembali Aktual</div>
                                <div class="detail-value">
                                    {{ $izinKeluar->jam_kembali_aktual->locale('id')->translatedFormat('d F Y H:i') }}
                                    @if($izinKeluar->dicatatKembaliOleh)
                                        <span class="text-muted">(dicatat oleh {{ $izinKeluar->dicatatKembaliOleh->name }})</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Timeline status --}}
                        <div class="mt-4">
                            <h6 class="mb-3" style="font-family: 'Space Grotesk', sans-serif; font-weight: 600;">Timeline Status</h6>
                            <div class="status-timeline">
                                <div class="timeline-item">
                                    <div class="timeline-time">{{ $izinKeluar->created_at->locale('id')->translatedFormat('d F Y H:i') }}</div>
                                    <div class="timeline-title">Permohonan Diajukan</div>
                                    <div class="timeline-desc">Permohonan izin keluar dikirim dan menunggu persetujuan Guru Piket</div>
                                </div>

                                @if($izinKeluar->status === 'approved' || ($izinKeluar->status === 'approved' && $izinKeluar->waktu_keputusan))
                                    <div class="timeline-item">
                                        <div class="timeline-time">
                                            {{ $izinKeluar->waktu_keputusan ? $izinKeluar->waktu_keputusan->locale('id')->translatedFormat('d F Y H:i') : '-' }}
                                        </div>
                                        <div class="timeline-title">Disetujui oleh Guru Piket</div>
                                        <div class="timeline-desc">
                                            Permohonan disetujui oleh {{ $izinKeluar->disetujuiOleh?->name ?? 'Guru Piket' }}.
                                            Silakan lapor ke Satpam untuk dicatat keluar.
                                        </div>
                                    </div>
                                @elseif($izinKeluar->status === 'rejected')
                                    <div class="timeline-item">
                                        <div class="timeline-time">
                                            {{ $izinKeluar->waktu_keputusan ? $izinKeluar->waktu_keputusan->locale('id')->translatedFormat('d F Y H:i') : '-' }}
                                        </div>
                                        <div class="timeline-title">Ditolak oleh Guru Piket</div>
                                        <div class="timeline-desc">Permohonan ditolak oleh {{ $izinKeluar->disetujuiOleh?->name ?? 'Guru Piket' }}</div>
                                    </div>
                                @endif

                                @if($izinKeluar->jam_keluar_aktual)
                                    <div class="timeline-item">
                                        <div class="timeline-time">{{ $izinKeluar->jam_keluar_aktual->locale('id')->translatedFormat('d F Y H:i') }}</div>
                                        <div class="timeline-title">Dicatat Keluar oleh Satpam</div>
                                        <div class="timeline-desc">
                                            Siswa keluar dari sekolah dan dicatat oleh {{ $izinKeluar->dicatatKeluarOleh?->name ?? 'Satpam' }}
                                        </div>
                                    </div>
                                @endif

                                @if($izinKeluar->jam_kembali_aktual)
                                    <div class="timeline-item">
                                        <div class="timeline-time">{{ $izinKeluar->jam_kembali_aktual->locale('id')->translatedFormat('d F Y H:i') }}</div>
                                        <div class="timeline-title">Dicatat Kembali oleh Satpam</div>
                                        <div class="timeline-desc">
                                            Siswa kembali ke sekolah dan dicatat oleh {{ $izinKeluar->dicatatKembaliOleh?->name ?? 'Satpam' }}.
                                            @if($izinKeluar->terlambat)
                                                <span class="text-danger fw-semibold">Catatan: Kembali melebihi waktu yang dijanjikan.</span>
                                            @else
                                                <span class="text-success fw-semibold">Kembali tepat waktu.</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
