<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Masuk — SIGAP</title>
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

        .btn-success {
            background: var(--theme-color);
            color: #fff;
            border: none;
        }

        .btn-success:hover {
            background: var(--theme-light);
        }

        .btn-danger {
            background: var(--terracotta);
            color: #fff;
            border: none;
        }

        .btn-danger:hover {
            background: #9a4330;
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

        .filter-row .form-select {
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
        <div class="content-card">
            <div class="content-card-header">
                <h5><i class="bi bi-inbox"></i> Permintaan Masuk</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('satpam.tukar_shift.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left-right"></i> Permintaan Saya
                    </a>
                    <a href="{{ route('satpam.tukar_shift.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Buat Permintaan
                    </a>
                </div>
            </div>
            <div class="content-card-body">
                <div class="stats-row">
                    <div class="stat-item">
                        <div class="stat-value">{{ $permintaanMasuk->where('status', 'pending')->count() }}</div>
                        <div class="stat-label">Menunggu</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $permintaanMasuk->where('status', 'approved')->count() }}</div>
                        <div class="stat-label">Disetujui</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $permintaanMasuk->where('status', 'rejected')->count() }}</div>
                        <div class="stat-label">Ditolak</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $permintaanMasuk->count() }}</div>
                        <div class="stat-label">Total</div>
                    </div>
                </div>

                <div class="filter-row">
                    <select class="form-select" style="width: auto;" id="statusFilter" onchange="filterTable()">
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table" id="permintaanTable">
                        <thead>
                            <tr>
                                <th>Dari</th>
                                <th>Tanggal</th>
                                <th>Shift Pengirim</th>
                                <th>Shift Anda</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permintaanMasuk as $tukar)
                                <tr data-status="{{ $tukar->status }}">
                                    <td>
                                        <strong>{{ $tukar->satpam->user->name }}</strong>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($tukar->tanggal)->locale('id')->translatedFormat('d M Y') }}
                                    </td>
                                    <td>
                                        {{ ucfirst($tukar->shift_asal) }}
                                        <br>
                                        <small class="text-muted">{{ $tukar->jam_asal }}</small>
                                    </td>
                                    <td>
                                        {{ ucfirst($tukar->shift_target) }}
                                        <br>
                                        <small class="text-muted">{{ $tukar->jam_target }}</small>
                                    </td>
                                    <td>{{ \Str::limit($tukar->alasan, 30) }}</td>
                                    <td>
                                        @if($tukar->status === 'pending')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($tukar->status === 'approved')
                                            <span class="badge badge-success">Disetujui</span>
                                        @elseif($tukar->status === 'rejected')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @else
                                            <span class="badge badge-info">{{ ucfirst($tukar->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('satpam.tukar_shift.show', $tukar) }}" class="btn btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($tukar->status === 'pending')
                                                <form action="{{ route('satpam.tukar_shift.approve', $tukar) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success" onclick="return confirm('Setujui permintaan tukar shift ini?')">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('satpam.tukar_shift.reject', $tukar) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak permintaan tukar shift ini?')">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 32px; color: var(--ink-soft);"></i>
                                        <p class="mt-2 mb-0 text-muted">Tidak ada permintaan masuk</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($permintaanMasuk->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $permintaanMasuk->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterTable() {
            const statusFilter = document.getElementById('statusFilter').value;
            const table = document.getElementById('permintaanTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                let showRow = true;

                if (statusFilter && showRow) {
                    const rowStatus = row.getAttribute('data-status');
                    if (rowStatus !== statusFilter) showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }
    </script>
</body>
</html>