<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Izin Keluar — SIGAP</title>
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

        .form-label {
            font-weight: 500;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--theme-color);
            box-shadow: 0 0 0 3px rgba(21, 63, 55, 0.1);
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

        .alert {
            border-radius: 12px;
            border: none;
        }

        .help-text {
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
                        <a class="nav-link" href="{{ route('siswa.dashboard') }}">
                            <i class="bi bi-grid-fill"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('siswa.izin_keluar.index') }}">
                            <i class="bi bi-person-badge"></i> Izin Keluar
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
                            <span class="user-role">{{ $siswa->kelas }}</span>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('siswa.logout') }}" method="POST" style="display: none;">
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
                        <h5><i class="bi bi-plus-circle"></i> Buat Permohonan Izin Keluar</h5>
                        <a href="{{ route('siswa.izin_keluar.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="content-card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('siswa.izin_keluar.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="alasan" class="form-label">Alasan Keluar <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="alasan" name="alasan" rows="4" required placeholder="Jelaskan alasan Anda ingin keluar dari sekolah...">{{ old('alasan') }}</textarea>
                                <div class="help-text">Jelaskan secara singkat dan jelas alasan izin keluar Anda</div>
                            </div>

                            <div class="mb-4">
                                <label for="jam_keluar_rencana" class="form-label">Jam Keluar Rencana <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="jam_keluar_rencana" name="jam_keluar_rencana" required value="{{ old('jam_keluar_rencana') }}">
                                <div class="help-text">Pilih jam rencana keluar Anda</div>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label">Deskripsi Tambahan</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Keterangan tambahan (opsional)">{{ old('deskripsi') }}</textarea>
                                <div class="help-text">Tambahkan keterangan jika diperlukan</div>
                            </div>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> <strong>Informasi:</strong> Permohonan izin keluar akan disetujui oleh guru dan dicatat oleh satpam saat Anda keluar dan kembali.
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Kirim Permohonan
                                </button>
                                <a href="{{ route('siswa.izin_keluar.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>