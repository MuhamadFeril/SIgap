<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Izin Keluar — SIGAP</title>
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

        .search-box {
            position: relative;
        }

        .search-box input {
            padding-left: 40px;
            border: 1px solid var(--line);
            border-radius: 8px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-soft);
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
                        <a class="nav-link active" href="{{ route('satpam.izin_keluar.index') }}">
                            <i class="bi bi-person-badge"></i> Izin Keluar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('satpam.jadwal.index') }}">
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
                <h5><i class="bi bi-clock-history"></i> Riwayat Izin Keluar</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('satpam.izin_keluar.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-list"></i> Semua Izin
                    </a>
                    <a href="{{ route('satpam.izin_keluar.keluar_hari_ini') }}" class="btn btn-outline-primary">
                        <i class="bi bi-calendar-day"></i> Hari Ini
                    </a>
                </div>
            </div>
            <div class="content-card-body">
                <div class="filter-row">
                    <div class="search-box" style="flex: 1; min-width: 200px;">
                        <i class="bi bi-search"></i>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari nama siswa..." onkeyup="searchTable()">
                    </div>
                    <select class="form-select" style="width: auto;" id="statusFilter" onchange="filterTable()">
                        <option value="">Semua Status</option>
                        <option value="completed">Selesai</option>
                        <option value="approved">Disetujui</option>
                        <option value="pending">Menunggu</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                    <input type="date" class="form-control" style="width: auto;" id="dateFilter" onchange="filterTable()">
                </div>

                <div class="table-responsive">
                    <table class="table" id="izinTable">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th>Rencana Keluar</th>
                                <th>Aktual Keluar</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Waktu Sebenarnya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($izinKeluar as $izin)
                                <tr data-status="{{ $izin->jam_kembali_aktual ? 'completed' : ($izin->status === 'approved' ? 'approved' : $izin->status) }}" data-date="{{ $izin->jam_keluar_rencana?->toDateString() }}">
                                    <td>
                                        <strong>{{ $izin->siswa?->user?->name ?? '-' }}</strong>
                                    </td>
                                    <td>{{ $izin->siswa?->kelas ?? '-' }}</td>
                                    <td>
                                        {{ $izin->jam_keluar_rencana?->locale('id')->translatedFormat('d M Y H:i') ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $izin->jam_keluar_aktual?->locale('id')->translatedFormat('d M Y H:i') ?? '-' }}
                                    </td>
                                    <td>{{ \Str::limit($izin->alasan ?? $izin->deskripsi, 30) }}</td>
                                    <td>
                                        @if($izin->jam_kembali_aktual)
                                            <span class="badge badge-success">Selesai</span>
                                        @elseif($izin->jam_keluar_aktual)
                                            <span class="badge badge-info">Sedang Keluar</span>
                                        @elseif($izin->status === 'approved')
                                            <span class="badge badge-success">Disetujui</span>
                                        @elseif($izin->status === 'rejected')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @else
                                            <span class="badge badge-warning">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($izin->jam_keluar_aktual)
                                            <small>Out: {{ $izin->jam_keluar_aktual->format('H:i') }}</small>
                                            <br>
                                        @endif
                                        @if($izin->jam_kembali_aktual)
                                            <small>In: {{ $izin->jam_kembali_aktual->format('H:i') }}</small>
                                        @endif
                                        @if(!$izin->jam_keluar_aktual && !$izin->jam_kembali_aktual)
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 32px; color: var(--ink-soft);"></i>
                                        <p class="mt-2 mb-0 text-muted">Tidak ada riwayat izin keluar</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($izinKeluar->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $izinKeluar->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function searchTable() {
            filterTable();
        }

        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;
            const table = document.getElementById('izinTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let showRow = true;

                // Search filter
                if (searchInput) {
                    let found = false;
                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j]) {
                            const textValue = cells[j].textContent || cells[j].innerText;
                            if (textValue.toLowerCase().indexOf(searchInput) > -1) {
                                found = true;
                                break;
                            }
                        }
                    }
                    if (!found) showRow = false;
                }

                // Status filter
                if (statusFilter && showRow) {
                    const rowStatus = row.getAttribute('data-status');
                    if (rowStatus !== statusFilter) showRow = false;
                }

                // Date filter
                if (dateFilter && showRow) {
                    const rowDate = row.getAttribute('data-date');
                    if (rowDate !== dateFilter) showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }
    </script>
</body>
</html>
