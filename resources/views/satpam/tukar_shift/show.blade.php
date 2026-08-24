<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tukar Shift — SIGAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap');

        :root {
            --theme-color: #153f37;
            --theme-light: #1e5a4d;
            --theme-bg: #e4f0ea;
            --amber: #c9821e;
            --ink: #182421;
            --ink-soft: #4b5b56;
            --surface: #ffffff;
            --paper: #f1f4f2;
            --line: #dce3df;
            --terracotta: #ae4e37;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--paper);
            color: var(--ink);
        }

        .navbar {
            background: var(--theme-color) !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            color: #fff !important;
            letter-spacing: -0.02em;
        }

        .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: #fff !important;
        }

        .content-card {
            background: var(--surface);
            border-radius: 16px;
            border: 1px solid var(--line);
            overflow: hidden;
        }

        .content-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--ink);
        }

        .content-card-body {
            padding: 24px;
        }

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

        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 12px;
        }

        .badge-success {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-warning {
            background: #fef3e7;
            color: #c9821e;
        }

        .badge-danger {
            background: #fdf3f1;
            color: #ae4e37;
        }

        .badge-info {
            background: #e8f0f9;
            color: #2d6aa8;
        }

        .badge-secondary {
            background: #e9ecef;
            color: #6c757d;
        }

        .btn-primary {
            background: var(--theme-color);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: var(--theme-light);
        }

        .btn-secondary {
            background: var(--surface);
            color: var(--ink);
            border: 1px solid var(--line);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-secondary:hover {
            border-color: var(--theme-color);
            color: var(--theme-color);
        }

        .btn-danger {
            background: var(--terracotta);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-danger:hover {
            background: #9a4330;
        }

        .btn-success {
            background: var(--theme-color);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-success:hover {
            background: var(--theme-light);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--theme-color);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: var(--ink);
        }

        .user-role {
            font-size: 12px;
            color: var(--ink-soft);
        }

        .btn-logout {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: rgba(255,255,255,0.25);
            color: #fff;
        }

        .shift-comparison {
            display: flex;
            gap: 16px;
            margin: 20px 0;
        }

        .shift-box {
            flex: 1;
            background: var(--theme-bg);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
        }

        .shift-box.target {
            background: #fef3e7;
        }

        .shift-box h6 {
            margin: 0 0 12px 0;
            color: var(--theme-color);
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
            background: var(--theme-color);
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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <span style="color: var(--amber); font-weight: 700;">/</span> SIGAP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('satpam.dashboard') }}">
                            <i class="bi bi-grid-fill"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('satpam.izin_keluar.index') }}">
                            <i class="bi bi-person-badge"></i> Izin Keluar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('satpam.jadwal.index') }}">
                            <i class="bi bi-calendar-check"></i> Jadwal Jaga
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('satpam.tukar_shift.index') }}">
                            <i class="bi bi-arrow-left-right"></i> Tukar Shift
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="user-details">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-role">Satpam</span>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('satpam.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button type="button" class="btn-logout" onclick="document.getElementById('logout-form').submit()">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5><i class="bi bi-file-text"></i> Detail Permintaan Tukar Shift</h5>
                        <div class="d-flex gap-2">
                            @if($tukarShift->status === 'pending')
                                @if($tukarShift->penerima_id === Auth::user()->satpam?->id)
                                    @php($jadwalSaya = $tukarShift->penerima->jadwalSatpam->where('tanggal', '>=', \Carbon\Carbon::today())->sortBy('tanggal'))
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
                                    <strong>{{ $tukarShift->penerima->user?->name ?? '-' }}</strong>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
