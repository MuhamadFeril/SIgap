<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — SIGAP</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap');

        :root {
            --pine: #153f37;
            --pine-light: #1e5a4d;
            --amber: #c9821e;
            --ink: #182421;
            --ink-soft: #4b5b56;
            --surface: #ffffff;
            --paper: #f1f4f2;
            --line: #dce3df;
            --terracotta: #ae4e37;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: #e8edea;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            -webkit-font-smoothing: antialiased;
        }

        .auth-wrapper {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: var(--surface);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            min-height: 600px;
        }

        .auth-left {
            flex: 1;
            background: var(--pine);
            color: #fff;
            padding: 56px 48px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(201, 130, 30, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .brand-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 64px;
        }

        .brand-slash {
            color: var(--amber);
            font-weight: 700;
            font-size: 24px;
            line-height: 1;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .brand-sub {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            color: #a0b5ae;
            letter-spacing: 0.05em;
            margin-top: 4px;
        }

        .auth-left h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 34px;
            font-weight: 600;
            line-height: 1.25;
            margin: 0 0 20px 0;
            max-width: 380px;
            letter-spacing: -0.02em;
        }

        .auth-left p {
            color: #a0b5ae;
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
            max-width: 400px;
        }

        .auth-stats {
            margin-top: auto;
            display: flex;
            gap: 32px;
            font-family: 'IBM Plex Mono', monospace;
            z-index: 1;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .stat-val {
            font-size: 24px;
            font-weight: 700;
            font-family: 'Space Grotesk', sans-serif;
        }

        .stat-label {
            font-size: 10px;
            color: #a0b5ae;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .auth-right {
            width: 480px;
            padding: 56px 48px;
            display: flex;
            flex-direction: column;
        }

        .back-link {
            color: var(--ink-soft);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 32px;
            transition: color 0.2s;
        }
        
        .back-link:hover {
            color: var(--ink);
        }

        .auth-tabs {
            display: flex;
            background: var(--paper);
            padding: 4px;
            border-radius: 12px;
            margin-bottom: 32px;
        }

        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--ink-soft);
            text-decoration: none;
            transition: all 0.2s;
        }

        .auth-tab.active {
            background: var(--surface);
            color: var(--ink);
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-soft);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--line);
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            color: var(--ink);
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--pine);
            box-shadow: 0 0 0 3px #e4f0ea;
        }

        .btn-primary {
            width: 100%;
            background: var(--pine);
            color: #fff;
            border: none;
            padding: 16px;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: var(--pine-light);
        }

        .alert-error {
            background: #fdf3f1;
            border: 1px solid #f9dcd8;
            color: var(--terracotta);
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        @media (max-width: 900px) {
            .auth-wrapper {
                flex-direction: column;
            }
            .auth-left {
                padding: 40px 32px;
            }
            .auth-right {
                width: 100%;
                padding: 40px 32px;
            }
            .brand-header {
                margin-bottom: 40px;
            }
        }
        
        @media (max-width: 500px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-left">
            <div class="brand-header">
                <div class="brand-slash">/</div>
                <div class="brand-text">
                    <span class="brand-name">SIGAP</span>
                    <span class="brand-sub">GATE & SHIFT SYSTEM</span>
                </div>
            </div>
            <h1>Satu gerbang, satu sumber kebenaran.</h1>
            <p>Izin keluar siswa terverifikasi guru, terpantau satpam secara real-time — dan jadwal jaga yang tidak lagi bentrok di kertas.</p>
            
            <div class="auth-stats">
                <div class="stat-item">
                    <span class="stat-val">04</span>
                    <span class="stat-label">ROLE PENGGUNA</span>
                </div>
                <div class="stat-item">
                    <span class="stat-val">Real-time</span>
                    <span class="stat-label">STATUS GERBANG</span>
                </div>
                <div class="stat-item">
                    <span class="stat-val">0</span>
                    <span class="stat-label">ALASAN PALSU LOLOS</span>
                </div>
            </div>
        </div>
        <div class="auth-right">
            <a href="/" class="back-link">← Kembali ke beranda</a>
            
            <div class="auth-tabs">
                <a href="{{ route('admin.login') }}" class="auth-tab">Masuk</a>
                <a href="{{ route('admin.register') }}" class="auth-tab active">Daftar</a>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <form method="POST" action="{{ route('admin.register') }}">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama Anda">
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@sekolah.sch.id">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Kata sandi</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="margin-top: 8px;">Daftar Akun</button>
            </form>
        </div>
    </div>
</body>
</html>
