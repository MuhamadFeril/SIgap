<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Jadwal Satpam — SIGAP</title>
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

        .navbar { background: var(--theme-color) !important; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .navbar-brand { font-family: 'Space Grotesk', sans-serif; font-weight: 700; color: #fff !important; letter-spacing: -0.02em; }
        .nav-link { color: rgba(255,255,255,0.85) !important; font-weight: 500; transition: color 0.2s; }
        .nav-link:hover, .nav-link.active { color: #fff !important; }

        .sidebar { background: var(--surface); border-right: 1px solid var(--line); min-height: calc(100vh - 56px); padding: 24px 0; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li { margin-bottom: 4px; }
        .sidebar-menu a { display: flex; align-items: center; gap: 12px; padding: 12px 24px; color: var(--ink-soft); text-decoration: none; font-weight: 500; transition: all 0.2s; border-left: 3px solid transparent; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: var(--theme-bg); color: var(--theme-color); border-left-color: var(--theme-color); }
        .sidebar-menu i { font-size: 18px; }

        .content-card { background: var(--surface); border-radius: 16px; border: 1px solid var(--line); overflow: hidden; }
        .content-card-header { padding: 20px 24px; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; }
        .content-card-header h5 { margin: 0; font-weight: 600; color: var(--ink); }
        .content-card-body { padding: 24px; }

        .table { margin: 0; }
        .table th { font-weight: 600; color: var(--ink-soft); font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid var(--line); padding: 12px 16px; }
        .table td { padding: 16px; color: var(--ink); font-size: 14px; }

        .badge { padding: 6px 12px; border-radius: 8px; font-weight: 500; font-size: 12px; }
        .badge-success { background: #e8f5e9; color: #2e7d32; }
        .badge-warning { background: #fef3e7; color: #c9821e; }
        .badge-danger { background: #fdf3f1; color: #ae4e37; }
        .badge-info { background: #e8f0f9; color: #2d6aa8; }

        .btn-primary { background: var(--theme-color); color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 500; }
        .btn-primary:hover { background: var(--theme-light); }
        .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
        .btn-outline-primary { border: 1px solid var(--theme-color); color: var(--theme-color); background: transparent; }
        .btn-outline-primary:hover { background: var(--theme-bg); }
        .btn-danger { background: var(--terracotta); color: #fff; border: none; }
        .btn-danger:hover { background: #9a4330; }

        .user-info { display: flex; align-items: center; gap: 12px; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--theme-color); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px; }
        .user-details { display: flex; flex-direction: column; }
        .user-name { font-weight: 600; color: var(--ink); }
        .user-role { font-size: 12px; color: var(--ink-soft); }
        .btn-logout { background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); padding: 8px 16px; border-radius: 8px; font-weight: 500; }
        .btn-logout:hover { background: rgba(255,255,255,0.25); color: #fff; }
        .form-select, .form-control { border: 1px solid var(--line); border-radius: 8px; padding: 8px 12px; font-size: 14px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><span style="color: var(--amber); font-weight: 700;">/</span> SIGAP</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.guru.index') }}"><i class="bi bi-person-badge"></i> Guru</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.siswa.index') }}"><i class="bi bi-people"></i> Siswa</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.satpam.index') }}"><i class="bi bi-shield-check"></i> Satpam</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.jadwal.index') }}"><i class="bi bi-calendar-check"></i> Jadwal</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="user-info">
                        <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                        <div class="user-details"><span class="user-name">{{ Auth::user()->name }}</span><span class="user-role">Admin</span></div>
                    </div>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">@csrf</form>
                    <button type="submit" form="logout-form" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <ul class="sidebar-menu">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                    <li><a href="{{ route('admin.guru.index') }}"><i class="bi bi-person-badge"></i> Guru</a></li>
                    <li><a href="{{ route('admin.siswa.index') }}"><i class="bi bi-people"></i> Siswa</a></li>
                    <li><a href="{{ route('admin.satpam.index') }}"><i class="bi bi-shield-check"></i> Satpam</a></li>
                    <li><a href="{{ route('admin.jadwal.index') }}" class="active"><i class="bi bi-calendar-check"></i> Jadwal</a></li>
                </ul>
            </div>
            <div class="col-md-10 p-4">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5>Manajemen Jadwal Satpam</h5>
                        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Jadwal</a>
                    </div>
                    <div class="content-card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                        @endif

                        <form method="GET" class="row g-2 mb-3">
                            <div class="col-md-4">
                                <select name="satpam_id" class="form-select">
                                    <option value="">Semua Satpam</option>
                                    @foreach($satpams as $s)
                                        <option value="{{ $s->id }}" {{ request('satpam_id') == $s->id ? 'selected' : '' }}>{{ $s?->user?->name ?? "-" }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="shift" class="form-select">
                                    <option value="">Semua Shift</option>
                                    <option value="pagi" {{ request('shift') == 'pagi' ? 'selected' : '' }}>Pagi</option>
                                    <option value="siang" {{ request('shift') == 'siang' ? 'selected' : '' }}>Siang</option>
                                    <option value="malam" {{ request('shift') == 'malam' ? 'selected' : '' }}>Malam</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Satpam</th>
                                        <th>Tanggal</th>
                                        <th>Shift</th>
                                        <th>Jam Jadwal</th>
                                        <th>Status Hadir</th>
                                        <th>Presensi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jadwalSatpam as $item)
                                        <tr>
                                            <td>{{ $item->satpam?->user?->name ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d M Y') }}</td>
                                            <td>{{ ucfirst($item->shift) }}</td>
                                            <td>
                                                @if($item->jam_masuk)
                                                    <div>Masuk: {{ \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') }}</div>
                                                @endif
                                                @if($item->jam_pulang)
                                                    <div>Pulang: {{ \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') }}</div>
                                                @endif
                                                @if(!$item->jam_masuk && !$item->jam_pulang)
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->status_hadir === 'hadir')
                                                    <span class="badge badge-success">Hadir</span>
                                                @elseif($item->status_hadir === 'tidak_hadir')
                                                    <span class="badge badge-danger">Tidak Hadir</span>
                                                @else
                                                    <span class="badge badge-warning">Belum Presensi</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->waktu_masuk)
                                                    <div>Masuk: {{ \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i') }}
                                                    @if($item->telat_masuk)<span class="badge badge-danger">Telat</span>@endif
                                                    </div>
                                                @endif
                                                @if($item->waktu_pulang)
                                                    <div>Pulang: {{ \Carbon\Carbon::parse($item->waktu_pulang)->format('H:i') }}</div>
                                                @endif
                                                @if(!$item->waktu_masuk && !$item->waktu_pulang)
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.jadwal.edit', $item) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                                    <form action="{{ route('admin.jadwal.destroy', $item) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus jadwal ini?')"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <i class="bi bi-calendar-x" style="font-size: 48px; color: var(--ink-soft);"></i>
                                                <p class="mt-3" style="color: var(--ink-soft);">Belum ada data jadwal</p>
                                                <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Jadwal</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($jadwalSatpam->hasPages())
                            <div class="d-flex justify-content-center mt-4">{{ $jadwalSatpam->links() }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
