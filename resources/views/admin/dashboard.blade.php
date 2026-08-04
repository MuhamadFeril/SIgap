<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Sekolah — SIGAP</title>
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

        .sidebar {
            background: var(--surface);
            border-right: 1px solid var(--line);
            min-height: calc(100vh - 56px);
            padding: 24px 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 4px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: var(--ink-soft);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: var(--theme-bg);
            color: var(--theme-color);
            border-left-color: var(--theme-color);
        }

        .sidebar-menu i {
            font-size: 18px;
        }

        .stat-card {
            background: var(--surface);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--line);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
        }

        .stat-icon.primary {
            background: var(--theme-bg);
            color: var(--theme-color);
        }

        .stat-icon.amber {
            background: #fef3e7;
            color: var(--amber);
        }

        .stat-icon.terracotta {
            background: #fdf3f1;
            color: var(--terracotta);
        }

        .stat-icon.blue {
            background: #e8f0f9;
            color: #2d6aa8;
        }

        .stat-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--ink);
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--ink-soft);
            font-weight: 500;
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
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-fill"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-person-badge"></i> Izin Keluar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-shield-check"></i> Satpam
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-calendar-check"></i> Jadwal Jaga
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
                            <span class="user-role">Admin Sekolah</span>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="{{ route('admin.logout') }}" class="btn btn-logout"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="active">
                            <i class="bi bi-grid-fill"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-person-badge"></i>
                            Izin Keluar
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-shield-check"></i>
                            Satpam
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-calendar-check"></i>
                            Jadwal Jaga
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-people"></i>
                            Siswa
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-person-gear"></i>
                            Guru
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-gear"></i>
                            Pengaturan
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 p-4">
                <div class="mb-4">
                    <h2 style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; margin-bottom: 8px;">
                        Dashboard Admin Sekolah
                    </h2>
                    <p style="color: var(--ink-soft); margin: 0;">
                        Selamat datang di panel kontrol SIGAP — pantau semua aktivitas izin keluar dan jadwal satpam.
                    </p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon primary">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div class="stat-value">12</div>
                            <div class="stat-label">Izin Aktif Hari Ini</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon amber">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="stat-value">5</div>
                            <div class="stat-label">Menunggu Persetujuan</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon terracotta">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div class="stat-value">2</div>
                            <div class="stat-label">Terlambat Kembali</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon blue">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="stat-value">3</div>
                            <div class="stat-label">Satpam Bertugas</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="content-card mb-4">
                            <div class="content-card-header">
                                <h5>Izin Keluar Terbaru</h5>
                                <a href="#" style="color: var(--theme-color); text-decoration: none; font-weight: 500;">
                                    Lihat Semua <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <div class="content-card-body p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Siswa</th>
                                            <th>Alasan</th>
                                            <th>Waktu Keluar</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Ahmad Rizky</td>
                                            <td>Sakit</td>
                                            <td>08:30</td>
                                            <td><span class="badge badge-success">Disetujui</span></td>
                                        </tr>
                                        <tr>
                                            <td>Siti Nurhaliza</td>
                                            <td>Urusan Keluarga</td>
                                            <td>09:15</td>
                                            <td><span class="badge badge-warning">Menunggu</span></td>
                                        </tr>
                                        <tr>
                                            <td>Budi Santoso</td>
                                            <td>Kompetisi</td>
                                            <td>07:00</td>
                                            <td><span class="badge badge-success">Disetujui</span></td>
                                        </tr>
                                        <tr>
                                            <td>Dewi Lestari</td>
                                            <td>Sakit</td>
                                            <td>10:00</td>
                                            <td><span class="badge badge-danger">Terlambat</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="content-card">
                            <div class="content-card-header">
                                <h5>Jadwal Satpam Hari Ini</h5>
                            </div>
                            <div class="content-card-body">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="user-avatar" style="background: var(--amber);">
                                        BS
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;">Budi Supriyanto</div>
                                        <div style="font-size: 12px; color: var(--ink-soft);">Pagi (07:00 - 15:00)</div>
                                    </div>
                                    <span class="badge badge-success ms-auto">Aktif</span>
                                </div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="user-avatar" style="background: var(--theme-color);">
                                        AH
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;">Agus Hartono</div>
                                        <div style="font-size: 12px; color: var(--ink-soft);">Siang (15:00 - 23:00)</div>
                                    </div>
                                    <span class="badge badge-warning ms-auto">Menunggu</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar" style="background: var(--terracotta);">
                                        DI
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;">Dedi Irawan</div>
                                        <div style="font-size: 12px; color: var(--ink-soft);">Malam (23:00 - 07:00)</div>
                                    </div>
                                    <span class="badge badge-warning ms-auto">Menunggu</span>
                                </div>
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
