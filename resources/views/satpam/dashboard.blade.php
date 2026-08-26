<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Satpam — SIGAP</title>
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

        .jadwal-info {
            background: var(--theme-bg);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .jadwal-info h6 {
            margin: 0 0 8px 0;
            color: var(--theme-color);
            font-weight: 600;
        }

        .jadwal-info p {
            margin: 0;
            color: var(--ink-soft);
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
                        <a class="nav-link active" href="{{ route('satpam.dashboard') }}">
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
                        <a href="{{ route('satpam.dashboard') }}" class="active">
                            <i class="bi bi-grid-fill"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('satpam.izin_keluar.index') }}">
                            <i class="bi bi-person-badge"></i>
                            Izin Keluar
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
                        Dashboard Satpam
                    </h2>
                    <p style="color: var(--ink-soft); margin: 0;">
                        Selamat datang, {{ Auth::user()->name }}! Pantau aktivitas gerbang dan jadwal jaga Anda.
                    </p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle"></i> {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon primary">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div class="stat-value">{{ $izinMenungguKeluar }}</div>
                            <div class="stat-label">Menunggu Tandai Keluar</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon amber">
                                <i class="bi bi-person-walking"></i>
                            </div>
                            <div class="stat-value">{{ $siswaSedangKeluar }}</div>
                            <div class="stat-label">Siswa Sedang Keluar</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon terracotta">
                                <i class="bi bi-arrow-left-right"></i>
                            </div>
                            <div class="stat-value">{{ $tukarShiftMasuk }}</div>
                            <div class="stat-label">Permintaan Tukar Shift</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon blue">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="stat-value">{{ $jadwalHariIni ? 'Ada' : 'Tidak' }}</div>
                            <div class="stat-label">Jadwal Hari Ini</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="content-card mb-4">
                            <div class="content-card-header">
                                <h5>Jadwal Hari Ini</h5>
                            </div>
                            <div class="content-card-body">
                                @if($jadwalHariIni)
                                    <div class="jadwal-info">
                                        <h6><i class="bi bi-calendar"></i> {{ $jadwalHariIni->tanggal->format('d F Y') }}</h6>
                                        <p><strong>Shift:</strong> {{ ucfirst($jadwalHariIni->shift) }}</p>
                                        <p><strong>Status:</strong> 
                                            <span id="jdwlStatus">
                                            @if($jadwalHariIni->status_hadir === 'hadir')
                                                <span class="badge badge-success">Hadir</span>
                                            @elseif($jadwalHariIni->status_hadir === 'belum_presensi')
                                                <span class="badge badge-warning">Belum Presensi</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Hadir</span>
                                            @endif
                                            </span>
                                        </p>
                                        <p><strong>Jadwal Masuk:</strong> {{ $jadwalHariIni->jam_masuk?->format('H:i') ?? '-' }}</p>
                                        <p><strong>Jadwal Pulang:</strong> {{ $jadwalHariIni->jam_pulang?->format('H:i') ?? '-' }}</p>
                                        <p><strong>Presensi Masuk:</strong> <span id="jdwlWaktuMasuk">{{ $jadwalHariIni->waktu_masuk?->format('H:i') ?? '-' }}</span>
                                            <span id="jdwlTelatMasuk">@if($jadwalHariIni->telat_masuk && $jadwalHariIni->waktu_masuk)<span class="badge badge-danger">Telat</span>@endif</span>
                                        </p>
                                        <p><strong>Presensi Pulang:</strong> <span id="jdwlWaktuPulang">{{ $jadwalHariIni->waktu_pulang?->format('H:i') ?? '-' }}</span></p>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="bi bi-calendar-x" style="font-size: 32px; color: var(--ink-soft);"></i>
                                        <p class="mt-2" style="color: var(--ink-soft);">Tidak ada jadwal hari ini</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content-card">
                            <div class="content-card-header">
                                <h5>Aksi Cepat</h5>
                            </div>
                            <div class="content-card-body">
                                <div class="d-grid gap-2">
                                    @php
                                        $sudahMasuk = $jadwalHariIni && $jadwalHariIni->waktu_masuk;
                                        $sudahPulang = $jadwalHariIni && $jadwalHariIni->waktu_pulang;
                                        $presensiState = !$sudahMasuk ? 'masuk' : (!$sudahPulang ? 'pulang' : 'selesai');
                                        $bisaPulang = !$jadwalHariIni || !$jadwalHariIni->jam_pulang || now()->gte($jadwalHariIni->jam_pulang);
                                        $pulangDisabled = $presensiState === 'pulang' && !$bisaPulang;
                                    @endphp
                                    <button type="button" id="presensiBtn" class="btn w-100 @if($presensiState === 'masuk') btn-success @elseif($presensiState === 'pulang') btn-warning @else btn-outline-secondary @endif"
                                        data-state="{{ $presensiState }}"
                                        @if($presensiState === 'selesai' || $pulangDisabled) disabled @endif
                                        @if($pulangDisabled) data-buka="{{ $jadwalHariIni->jam_pulang->format('H:i') }}" @endif>
                                        @if($presensiState === 'masuk')
                                            <i class="bi bi-box-arrow-in-right"></i> Presensi Masuk
                                        @elseif($presensiState === 'pulang')
                                            <i class="bi bi-box-arrow-left"></i> Presensi Pulang
                                        @else
                                            <i class="bi bi-check2-all"></i> Presensi Hari Ini Selesai
                                        @endif
                                    </button>
                                        @if($pulangDisabled)
                                        <small class="text-muted mt-1 d-block" id="pulangNote">Belum waktunya presensi pulang (jam {{ $jadwalHariIni->jam_pulang->format('H:i') }})</small>
                                    @endif
                                    <a href="{{ route('satpam.izin_keluar.index') }}" class="btn btn-outline-primary">
                                        <i class="bi bi-person-badge"></i> Kelola Izin Keluar
                                    </a>
                                    <a href="{{ route('satpam.izin_keluar.keluar_hari_ini') }}" class="btn btn-outline-warning">
                                        <i class="bi bi-person-walking"></i> Siswa Keluar Hari Ini
                                    </a>
                                    <a href="{{ route('satpam.jadwal.index') }}" class="btn btn-outline-info">
                                        <i class="bi bi-calendar-check"></i> Lihat Jadwal Lengkap
                                    </a>
                                    @if($tukarShiftMasuk > 0)
                                        <a href="{{ route('satpam.tukar_shift.permintaan_masuk') }}" class="btn btn-outline-danger">
                                            <i class="bi bi-arrow-left-right"></i> Permintaan Tukar Shift ({{ $tukarShiftMasuk }})
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1090;">
        <div id="presensiToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="presensiToastBody"></div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('presensiBtn');
            if (!btn) return;

            const buka = btn.dataset.buka;
            if (buka) {
                const parts = buka.split(':').map(Number);
                const target = new Date();
                target.setHours(parts[0], parts[1], 0, 0);
                const diff = target - new Date();
                if (diff > 0) {
                    setTimeout(() => {
                        btn.disabled = false;
                        const note = document.getElementById('pulangNote');
                        if (note) note.remove();
                    }, diff);
                }
            }

            const toastEl = document.getElementById('presensiToast');
            const toastBody = document.getElementById('presensiToastBody');
            const toast = toastEl ? new bootstrap.Toast(toastEl, { delay: 3000 }) : null;

            function showToast(message, type) {
                if (!toast) return;
                toastEl.className = 'toast align-items-center border-0 text-bg-' + (type === 'error' ? 'danger' : 'success');
                toastBody.textContent = message;
                toast.show();
            }

            function applyState(state, data) {
                if (state === 'masuk') {
                    btn.className = 'btn btn-warning w-100';
                    btn.innerHTML = '<i class="bi bi-box-arrow-left"></i> Presensi Pulang';
                    btn.dataset.state = 'pulang';
                    btn.disabled = false;
                } else if (state === 'pulang') {
                    btn.className = 'btn btn-outline-secondary w-100';
                    btn.innerHTML = '<i class="bi bi-check2-all"></i> Presensi Hari Ini Selesai';
                    btn.dataset.state = 'selesai';
                    btn.disabled = true;
                }
                if (data) {
                    if (data.status_hadir) {
                        const map = {
                            'hadir': '<span class="badge badge-success">Hadir</span>',
                            'belum_presensi': '<span class="badge badge-warning">Belum Presensi</span>',
                            'tidak_hadir': '<span class="badge badge-danger">Tidak Hadir</span>',
                        };
                        const el = document.getElementById('jdwlStatus');
                        if (el && map[data.status_hadir]) el.innerHTML = map[data.status_hadir];
                    }
                    if (document.getElementById('jdwlWaktuMasuk')) document.getElementById('jdwlWaktuMasuk').textContent = data.waktu_masuk ?? '-';
                    if (document.getElementById('jdwlWaktuPulang')) document.getElementById('jdwlWaktuPulang').textContent = data.waktu_pulang ?? '-';
                    const telatEl = document.getElementById('jdwlTelatMasuk');
                    if (telatEl) telatEl.innerHTML = (data.telat_masuk) ? '<span class="badge badge-danger">Telat</span>' : '';
                }
            }

            btn.addEventListener('click', function () {
                const original = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

                fetch('{{ route("satpam.presensi") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        applyState(res.state, res);
                        showToast(res.message, 'success');
                    } else {
                        btn.disabled = false;
                        btn.innerHTML = original;
                        showToast(res.message || 'Gagal presensi', 'error');
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = original;
                    showToast('Terjadi kesalahan, coba lagi', 'error');
                });
            });
        });
    </script>
</body>
</html>
