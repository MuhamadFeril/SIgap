@extends('layouts.app')

@section('title', 'Detail Tukar Shift')

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
                    <h5><i class="bi bi-file-text"></i> Detail Permintaan Tukar Shift</h5>
                    <div class="d-flex gap-2">
                        @if($tukarShift->status === 'pending')
                            @if($tukarShift->penerima_id === Auth::user()->satpam?->id)
                                @php($jadwalSaya = $tukarShift?->penerima?->jadwalSatpam->where('tanggal', '>=', \Carbon\Carbon::today())->sortBy('tanggal'))
                                @if($jadwalSaya->isNotEmpty())
                                    <form action="{{ route('satpam.tukar_shift.approve', $tukarShift) }}" method="POST" class="d-inline">
                                        @csrf
                                        <select name="jadwal_penerima_id" class="form-select form-select-sm d-inline-block align-middle" style="width:auto;" required title="Pilih jadwal Anda yang diberikan balik">
                                            <option value="">Pilih jadwal tukar balik</option>
                                            @foreach($jadwalSaya as $js)
                                                <option value="{{ $js->id }}">{{ $js->tanggal?->locale('id')->translatedFormat('d M Y') }} — {{ ucfirst($js->shift) }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui dan tukar shift ini?')">
                                            <i class="bi bi-check"></i> Setujui
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small align-self-center">Tidak ada jadwal untuk ditukar</span>
                                @endif
                                <form action="{{ route('satpam.tukar_shift.reject', $tukarShift) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak permintaan tukar shift ini?')">
                                        <i class="bi bi-x"></i> Tolak
                                    </button>
                                </form>
                            @elseif($tukarShift->pengaju_id === Auth::user()->satpam?->id)
                                <form action="{{ route('satpam.tukar_shift.destroy', $tukarShift) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permintaan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-x-circle"></i> Batalkan
                                    </button>
                                </form>
                            @endif
                        @endif
                        <a href="{{ route('satpam.tukar_shift.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="content-card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="detail-row">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            @if($tukarShift->status === 'pending')
                                <span class="badge badge-warning">Menunggu Persetujuan</span>
                            @elseif($tukarShift->status === 'approved')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($tukarShift->status === 'rejected')
                                <span class="badge badge-danger">Ditolak</span>
                            @else
                                <span class="badge badge-info">{{ ucfirst($tukarShift->status) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Tanggal</div>
                        <div class="detail-value">
                            {{ $tukarShift->jadwal?->tanggal?->locale('id')->translatedFormat('l, d F Y') ?? '-' }}
                        </div>
                    </div>

                    <div class="shift-comparison">
                        <div class="shift-box">
                            <h6>Shift Pemohon ({{ $tukarShift->pengaju?->user?->name ?? '-' }})</h6>
                            <div class="shift-label">{{ ucfirst($tukarShift->jadwal?->shift ?? '-') }}</div>
                            <div class="shift-time">{{ $tukarShift->jadwal?->tanggal?->locale('id')->translatedFormat('d M Y') ?? '-' }}</div>
                        </div>
                        @if($tukarShift->jadwalPenerima)
                            <div class="arrow-exchange"><i class="bi bi-arrow-left-right"></i></div>
                            <div class="shift-box target">
                                <h6>Shift Anda yang Diberikan</h6>
                                <div class="shift-label">{{ ucfirst($tukarShift->jadwalPenerima?->shift ?? '-') }}</div>
                                <div class="shift-time">{{ $tukarShift->jadwalPenerima?->tanggal?->locale('id')->translatedFormat('d M Y') ?? '-' }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Pemohon</div>
                        <div class="detail-value">
                            <strong>{{ $tukarShift->pengaju?->user?->name ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Tukar Dengan</div>
                        <div class="detail-value">
                            @if($tukarShift->penerima)
                                <strong>{{ $tukarShift?->penerima?->user?->name ?? '-' }}</strong>
                            @else
                                <span class="text-muted">Belum dipilih</span>
                            @endif
                        </div>
                    </div>

                    @if($tukarShift->status === 'approved')
                        <div class="detail-row">
                            <div class="detail-label">Disetujui Oleh</div>
                            <div class="detail-value">
                                @if($tukarShift->disetujuiOleh)
                                    {{ $tukarShift->disetujuiOleh->name }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="detail-row">
                        <div class="detail-label">Dibuat Pada</div>
                        <div class="detail-value">
                            {{ \Carbon\Carbon::parse($tukarShift->created_at)->locale('id')->translatedFormat('l, d F Y H:i') }}
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="mb-3">Timeline Status</h6>
                        <div class="status-timeline">
                            <div class="timeline-item">
                                <div class="timeline-time">{{ \Carbon\Carbon::parse($tukarShift->created_at)->locale('id')->translatedFormat('d F Y H:i') }}</div>
                                <div class="timeline-title">Permintaan Dibuat</div>
                                <div class="timeline-desc">Permintaan tukar shift diajukan oleh {{ $tukarShift->pengaju?->user?->name ?? '-' }}</div>
                            </div>

                            @if($tukarShift->status === 'approved')
                                <div class="timeline-item">
                                    <div class="timeline-time">{{ \Carbon\Carbon::parse($tukarShift->updated_at)->locale('id')->translatedFormat('d F Y H:i') }}</div>
                                    <div class="timeline-title">Disetujui</div>
                                    <div class="timeline-desc">Permintaan disetujui oleh {{ $tukarShift->disetujuiOleh?->name ?? $tukarShift->penerima?->user?->name ?? '-' }}</div>
                                </div>
                            @endif

                            @if($tukarShift->status === 'rejected')
                                <div class="timeline-item">
                                    <div class="timeline-time">{{ \Carbon\Carbon::parse($tukarShift->updated_at)->locale('id')->translatedFormat('d F Y H:i') }}</div>
                                    <div class="timeline-title">Ditolak</div>
                                    <div class="timeline-desc">Permintaan ditolak oleh {{ $tukarShift->penerima?->user?->name ?? '-' }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            width: 200px;
            font-weight: 500;
            color: var(--ink-soft);
            flex-shrink: 0;
        }

        .detail-value {
            color: var(--ink);
            flex: 1;
        }

        .shift-comparison {
            display: flex;
            gap: 16px;
            margin: 20px 0;
        }

        .shift-box {
            flex: 1;
            background: var(--mint);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
        }

        .shift-box.target {
            background: #fef3e7;
        }

        .shift-box h6 {
            margin: 0 0 12px 0;
            color: var(--pine);
            font-weight: 600;
        }

        .shift-box .shift-label {
            font-size: 18px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .shift-box .shift-time {
            font-size: 14px;
            color: var(--ink-soft);
        }

        .arrow-exchange {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--amber);
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
    </style>
@endsection
