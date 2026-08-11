<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Jaga — SIGAP</title>
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

        .table {
            margin: 0;
        }

        .table th {
            font-weight: 600;
            color: var(--ink-soft);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--line);
            padding: 12px 16px;
        }

        .table td {
            padding: 16px;
            color: var(--ink);
            font-size: 14px;
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

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 6px;
        }

        .btn-success {
            background: var(--theme-color);
            color: #fff;
            border: none;
        }

        .btn-success:hover {
            background: var(--theme-light);
        }

        .btn-primary {
            background: var(--theme-color);
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background: var(--theme-light);
        }

        .btn-outline-primary {
            border: 1px solid var(--theme-color);
            color: var(--theme-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--theme-bg);
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

        .shift-card {
            background: var(--theme-bg);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            border-left: 4px solid var(--theme-color);
        }

        .shift-card.today {
            border-left-color: var(--amber);
            background: #fef3e7;
        }

        .shift-card.completed {
            border-left-color: var(--theme-color);
            opacity: 0.7;
        }

        .shift-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .shift-day {
            font-weight: 600;
            color: var(--ink);
            font-size: 16px;
        }

        .shift-date {
            font-size: 12px;
            color: var(--ink-soft);
        }

        .shift-time {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .shift-time i {
            color: var(--theme-color);
        }

        .shift-status {
            font-size: 13px;
            margin-bottom: 12px;
        }

        .week-navigator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .week-navigator button {
            background: var(--surface);
            border: 1px solid var(--line);
            padding: 8px 16px;
            border-radius: 8px;
            color: var(--ink);
            font-weight: 500;
        }

        .week-navigator button:hover {
            border-color: var(--theme-color);
            color: var(--theme-color);
        }

        .week-range {
            font-weight: 600;
            color: var(--ink);
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
                        <a class="nav-link active" href="{{ route('satpam.jadwal.index') }}">
                            <i class="bi bi-calendar-check"></i> Jadwal Jaga
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('satpam.tukar_shift.index') }}">
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
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="bi bi-calendar-check"></i> Jadwal Jaga</h5>
                <a href="{{ route('satpam.jadwal.riwayat') }}" class="btn btn-outline-primary">
                    <i class="bi bi-clock-history"></i> Riwayat Presensi
                </a>
            </div>
            <div class="content-card-body">
                <div class="week-navigator">
                    <button onclick="changeWeek(-1)">
                        <i class="bi bi-chevron-left"></i> Minggu Lalu
                    </button>
                    <span class="week-range" id="weekRange">
                        {{ $startDate->locale('id')->translatedFormat('d M Y') }} - {{ $endDate->locale('id')->translatedFormat('d M Y') }}
                    </span>
                    <button onclick="changeWeek(1)">
                        Minggu Depan <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

                @forelse($jadwalSatpam as $jadwal)
                    <div class="shift-card {{ $jadwal->tanggal->isToday() ? 'today' : '' }} {{ $jadwal->waktu_pulang ? 'completed' : '' }}">
                        <div class="shift-header">
                            <div>
                                <div class="shift-day">
                                    {{ $jadwal->tanggal->locale('id')->translatedFormat('l') }}
                                    @if($jadwal->tanggal->isToday())
                                        <span class="badge badge-warning ms-2">Hari Ini</span>
                                    @endif
                                </div>
                                <div class="shift-date">{{ $jadwal->tanggal->locale('id')->translatedFormat('d F Y') }}</div>
                            </div>
                            <div>
                                @if($jadwal->shift)
                                    <span class="badge badge-info">{{ ucfirst($jadwal->shift) }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="shift-time">
                            <i class="bi bi-clock"></i>
                            <span>{{ $jadwal->jam_masuk }} - {{ $jadwal->jam_pulang }}</span>
                        </div>

                        <div class="shift-status">
                            @if($jadwal->waktu_masuk && $jadwal->waktu_pulang)
                                <span class="badge badge-success">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </span>
                            @elseif($jadwal->waktu_masuk)
                                <span class="badge badge-info">
                                    <i class="bi bi-circle"></i> Sedang Bertugas
                                </span>
                            @elseif($jadwal->tanggal->isPast())
                                <span class="badge badge-danger">
                                    <i class="bi bi-x-circle"></i> Tidak Hadir
                                </span>
                            @elseif($jadwal->tanggal->isToday())
                                <span class="badge badge-warning">
                                    <i class="bi bi-clock"></i> Belum Presensi
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    <i class="bi bi-calendar"></i> Akan Datang
                                </span>
                            @endif
                        </div>

                        @if($jadwal->tanggal->isToday() || $jadwal->tanggal->isPast())
                            <div class="d-flex gap-2">
                                @if(!$jadwal->waktu_masuk)
                                    <form action="{{ route('satpam.jadwal.presensi_masuk', $jadwal) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" {{ $jadwal->tanggal->isPast() ? 'disabled' : '' }} onclick="return confirm('Presensi masuk untuk shift ini?')">
                                            <i class="bi bi-box-arrow-in-right"></i> Presensi Masuk
                                        </button>
                                    </form>
                                @elseif(!$jadwal->waktu_pulang)
                                    <form action="{{ route('satpam.jadwal.presensi_pulang', $jadwal) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Presensi pulang untuk shift ini?')">
                                            <i class="bi bi-box-arrow-right"></i> Presensi Pulang
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif

                        @if($jadwal->waktu_masuk)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="bi bi-clock-history"></i> Masuk: {{ $jadwal->waktu_masuk->format('H:i') }}
                                    @if($jadwal->waktu_pulang)
                                        | Pulang: {{ $jadwal->waktu_pulang->format('H:i') }}
                                    @endif
                                </small>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x" style="font-size: 48px; color: var(--ink-soft);"></i>
                        <p class="mt-3 mb-0 text-muted">Tidak ada jadwal jaga untuk minggu ini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function changeWeek(direction) {
            const currentUrl = new URL(window.location.href);
            const currentOffset = parseInt(currentUrl.searchParams.get('week_offset') || '0');
            const newOffset = currentOffset + direction;
            currentUrl.searchParams.set('week_offset', newOffset);
            window.location.href = currentUrl.toString();
        }
    </script>
</body>
</html>