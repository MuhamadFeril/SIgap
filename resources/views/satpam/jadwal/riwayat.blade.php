<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Presensi — SIGAP</title>
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

        .filter-row {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .filter-row .form-select,
        .filter-row .form-control {
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 14px;
        }

        .stats-row {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-item {
            flex: 1;
            background: var(--theme-bg);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
        }

        .stat-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--theme-color);
        }

        .stat-label {
            font-size: 12px;
            color: var(--ink-soft);
            margin-top: 4px;
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
                <h5><i class="bi bi-clock-history"></i> Riwayat Presensi</h5>
                <a href="{{ route('satpam.jadwal.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-calendar-check"></i> Jadwal
                </a>
            </div>
            <div class="content-card-body">
                <div class="stats-row">
                    <div class="stat-item">
                        <div class="stat-value">{{ $riwayatJadwal->where('waktu_masuk', '!=', null)->where('waktu_pulang', '!=', null)->count() }}</div>
                        <div class="stat-label">Hadir Lengkap</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $riwayatJadwal->where('waktu_masuk', '!=', null)->where('waktu_pulang', null)->count() }}</div>
                        <div class="stat-label">Belum Pulang</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $riwayatJadwal->where('waktu_masuk', null)->count() }}</div>
                        <div class="stat-label">Tidak Hadir</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $riwayatJadwal->count() }}</div>
                        <div class="stat-label">Total Shift</div>
                    </div>
                </div>

                <div class="filter-row">
                    <select class="form-select" style="width: auto;" id="monthFilter" onchange="filterTable()">
                        <option value="">Semua Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->locale('id')->translatedFormat('F') }}</option>
                        @endfor
                    </select>
                    <select class="form-select" style="width: auto;" id="statusFilter" onchange="filterTable()">
                        <option value="">Semua Status</option>
                        <option value="complete">Hadir Lengkap</option>
                        <option value="incomplete">Belum Pulang</option>
                        <option value="absent">Tidak Hadir</option>
                    </select>
                    <input type="number" class="form-control" style="width: 120px;" id="yearFilter" placeholder="Tahun" onchange="filterTable()">
                </div>

                <div class="table-responsive">
                    <table class="table" id="presensiTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Shift</th>
                                <th>Jadwal</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Pulang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatJadwal as $jadwal)
                                @php
                                    $status = $jadwal->waktu_masuk && $jadwal->waktu_pulang ? 'complete' : 
                                              ($jadwal->waktu_masuk ? 'incomplete' : 'absent');
                                @endphp
                                <tr data-status="{{ $status }}" data-month="{{ $jadwal->tanggal->format('n') }}" data-year="{{ $jadwal->tanggal->format('Y') }}">
                                    <td>
                                        <strong>{{ $jadwal->tanggal->locale('id')->translatedFormat('d M Y') }}</strong>
                                    </td>
                                    <td>{{ $jadwal->tanggal->locale('id')->translatedFormat('l') }}</td>
                                    <td>
                                        @if($jadwal->shift)
                                            <span class="badge badge-info">{{ ucfirst($jadwal->shift) }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $jadwal->jam_masuk?->format('H:i') ?? '-' }} - {{ $jadwal->jam_pulang?->format('H:i') ?? '-' }}</td>
                                    <td>
                                        @if($jadwal->waktu_masuk)
                                            <span class="text-success">{{ $jadwal->waktu_masuk->format('H:i') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($jadwal->waktu_pulang)
                                            <span class="text-success">{{ $jadwal->waktu_pulang->format('H:i') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($jadwal->waktu_masuk && $jadwal->waktu_pulang)
                                            <span class="badge badge-success">
                                                <i class="bi bi-check-circle"></i> Hadir Lengkap
                                            </span>
                                        @elseif($jadwal->waktu_masuk)
                                            <span class="badge badge-warning">
                                                <i class="bi bi-circle"></i> Belum Pulang
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="bi bi-x-circle"></i> Tidak Hadir
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 32px; color: var(--ink-soft);"></i>
                                        <p class="mt-2 mb-0 text-muted">Tidak ada riwayat presensi</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($riwayatJadwal->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $riwayatJadwal->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterTable() {
            const monthFilter = document.getElementById('monthFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const yearFilter = document.getElementById('yearFilter').value;
            const table = document.getElementById('presensiTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                let showRow = true;

                // Month filter
                if (monthFilter && showRow) {
                    const rowMonth = row.getAttribute('data-month');
                    if (rowMonth !== monthFilter) showRow = false;
                }

                // Status filter
                if (statusFilter && showRow) {
                    const rowStatus = row.getAttribute('data-status');
                    if (rowStatus !== statusFilter) showRow = false;
                }

                // Year filter
                if (yearFilter && showRow) {
                    const rowYear = row.getAttribute('data-year');
                    if (rowYear !== yearFilter) showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        // Set current year as default
        document.getElementById('yearFilter').value = new Date().getFullYear();
    </script>
</body>
</html>