<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izin Keluar — SIGAP</title>
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
                    <a href="{{ route('satpam.logout') }}" class="btn btn-logout"
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
                        <a href="{{ route('satpam.dashboard') }}">
                            <i class="bi bi-grid-fill"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('satpam.izin_keluar.index') }}" class="active">
                            <i class="bi bi-person-badge"></i>
                            Izin Keluar
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('satpam.izin_keluar.keluar_hari_ini') }}">
                            <i class="bi bi-person-walking"></i>
                            Keluar Hari Ini
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('satpam.izin_keluar.riwayat') }}">
                            <i class="bi bi-clock-history"></i>
                            Riwayat
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('satpam.jadwal.index') }}">
                            <i class="bi bi-calendar-check"></i>
                            Jadwal Jaga
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('satpam.tukar_shift.index') }}">
                            <i class="bi bi-arrow-left-right"></i>
                            Tukar Shift
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 p-4">
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
                                            <td>{{ $izin->siswa->user->name }}</td>
                                            <td>
                                                @if($izin->siswa->foto_profil_path)
                                                    <img src="{{ asset('storage/' . $izin->siswa->foto_profil_path) }}" alt="Foto {{ $izin->siswa->user->name }}" width="42" height="42" style="object-fit:cover;border-radius:50%;" class="me-2">
                                                @endif
                                                @if($izin->bukti_path)
                                                    @php($buktiVideo = in_array(strtolower(pathinfo($izin->bukti_path, PATHINFO_EXTENSION)), ['mp4', 'mov', 'webm']))
                                                    <a href="{{ asset('storage/' . $izin->bukti_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">{{ $buktiVideo ? 'Putar video' : 'Lihat bukti' }}</a>
                                                @endif
                                            </td>
                                            <td>{{ $izin->siswa->kelas }}</td>
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
                                                    <form method="POST" action="{{ route('satpam.izin_keluar.tandai_keluar', $izin) }}" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="bi bi-box-arrow-right"></i> Tandai Keluar
                                                        </button>
                                                    </form>
                                                @elseif($izin->jam_keluar_aktual && !$izin->jam_kembali_aktual)
                                                    <form method="POST" action="{{ route('satpam.izin_keluar.tandai_kembali', $izin) }}" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="bi bi-box-arrow-in-left"></i> Tandai Kembali
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 48px; color: var(--ink-soft);"></i>
                                <p class="mt-3" style="color: var(--ink-soft);">Tidak ada izin keluar yang perlu ditandai</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
