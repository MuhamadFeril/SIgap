<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Satpam — SIGAP</title>
    <meta name="description" content="Login portal satpam SIGAP — Sistem Izin Gerbang dan Presensi">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap');

        :root {
            --theme-color: #4b5b56;
            --theme-light: #60756e;
            --theme-dark: #34423e;
            --theme-bg: #e8edea;
            --amber: #c9821e;
            --ink: #182421;
            --ink-soft: #4b5b56;
            --surface: #ffffff;
            --paper: #f1f4f2;
            --line: #dce3df;
            --terracotta: #ae4e37;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: #e3e8e5;
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
            max-width: 1040px;
            background: var(--surface);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(0,0,0,0.10), 0 4px 12px rgba(0,0,0,0.06);
            min-height: 620px;
            animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* LEFT PANEL */
        .auth-left {
            flex: 1;
            background: linear-gradient(145deg, #34423e 0%, var(--theme-color) 100%);
            color: #fff;
            padding: 56px 48px;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: -80px;
            left: -80px;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 70%);
            border-radius: 50%;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: -60px;
            width: 360px;
            height: 360px;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
            border-radius: 50%;
        }

        .brand-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 64px;
            position: relative;
            z-index: 1;
        }

        .brand-slash {
            color: var(--amber);
            font-weight: 700;
            font-size: 28px;
            line-height: 1;
            font-family: 'Space Grotesk', sans-serif;
        }

        .brand-text { display: flex; flex-direction: column; }

        .brand-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .brand-sub {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            color: rgba(255,255,255,0.65);
            letter-spacing: 0.08em;
            margin-top: 4px;
            text-transform: uppercase;
        }

        .left-content { flex: 1; position: relative; z-index: 1; }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            color: rgba(255,255,255,0.9);
            padding: 6px 14px;
            border-radius: 20px;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.05em;
            margin-bottom: 24px;
        }

        .role-badge-dot {
            width: 6px;
            height: 6px;
            background: #a8c5bd;
            border-radius: 50%;
        }

        .auth-left h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 34px;
            font-weight: 700;
            line-height: 1.2;
            margin: 0 0 20px 0;
            max-width: 360px;
            letter-spacing: -0.03em;
        }

        .auth-left p {
            color: rgba(255,255,255,0.78);
            font-size: 15px;
            line-height: 1.7;
            margin: 0;
            max-width: 380px;
        }

        .auth-stats {
            margin-top: auto;
            display: flex;
            gap: 28px;
            position: relative;
            z-index: 1;
            padding-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.12);
        }

        .stat-item { display: flex; flex-direction: column; gap: 5px; }

        .stat-val {
            font-size: 22px;
            font-weight: 700;
            font-family: 'Space Grotesk', sans-serif;
            color: #fff;
        }

        .stat-label {
            font-size: 9px;
            color: rgba(255,255,255,0.58);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-family: 'IBM Plex Mono', monospace;
        }

        /* RIGHT PANEL */
        .auth-right {
            width: 460px;
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
            margin-bottom: 40px;
            transition: color 0.2s, gap 0.2s;
        }

        .back-link:hover { color: var(--theme-color); gap: 10px; }

        .auth-heading { margin-bottom: 8px; }

        .auth-heading h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--ink);
            margin: 0;
            letter-spacing: -0.02em;
        }

        .auth-heading p {
            color: var(--ink-soft);
            font-size: 14px;
            margin: 8px 0 28px;
            line-height: 1.5;
        }

        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-soft);
            margin-bottom: 8px;
        }

        .input-wrap { position: relative; }

        .form-control {
            width: 100%;
            padding: 13px 16px;
            border: 1.5px solid var(--line);
            border-radius: 12px;
            font-family: inherit;
            font-size: 14px;
            color: var(--ink);
            background: #fafbfa;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--theme-color);
            box-shadow: 0 0 0 4px var(--theme-bg);
            background: #fff;
        }

        .form-control::placeholder { color: #a8b5b0; }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--theme-color);
            cursor: pointer;
        }

        .remember-row label {
            font-size: 13px;
            font-weight: 500;
            color: var(--ink-soft);
            cursor: pointer;
            user-select: none;
        }

        .btn-primary {
            width: 100%;
            background: var(--theme-color);
            color: #fff;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 12px rgba(75, 91, 86, 0.35);
        }

        .btn-primary:hover {
            background: var(--theme-light);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(75, 91, 86, 0.45);
        }

        .btn-primary:active { transform: translateY(0); }

        .alert-error {
            background: #fdf3f1;
            border: 1.5px solid #f5c9be;
            color: var(--terracotta);
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            animation: shake 0.4s cubic-bezier(.36,.07,.19,.97);
        }

        @keyframes shake {
            10%, 90% { transform: translateX(-1px); }
            20%, 80% { transform: translateX(2px); }
            30%, 50%, 70% { transform: translateX(-3px); }
            40%, 60% { transform: translateX(3px); }
        }

        .auth-footer-text {
            margin-top: 28px;
            font-size: 12px;
            color: var(--ink-soft);
            line-height: 1.6;
            padding-top: 20px;
            border-top: 1px solid var(--line);
        }

        @media (max-width: 900px) {
            .auth-wrapper { flex-direction: column; min-height: auto; }
            .auth-left { padding: 40px 32px; }
            .auth-right { width: 100%; padding: 36px 32px; }
            .brand-header { margin-bottom: 32px; }
            .auth-stats { gap: 20px; }
            .auth-left h1 { font-size: 28px; }
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
                    <span class="brand-sub">Gate &amp; Shift System</span>
                </div>
            </div>

            <div class="left-content">
                <div class="role-badge">
                    <div class="role-badge-dot"></div>
                    PORTAL SATPAM
                </div>
                <h1>Pantau gerbang dengan akurat.</h1>
                <p>Lihat daftar siswa yang disetujui untuk keluar dan catat waktu kembali mereka dalam satu layar praktis.</p>
            </div>

            <div class="auth-stats">
                <div class="stat-item">
                    <span class="stat-val">04</span>
                    <span class="stat-label">Role Pengguna</span>
                </div>
                <div class="stat-item">
                    <span class="stat-val">Real-time</span>
                    <span class="stat-label">Status Gerbang</span>
                </div>
                <div class="stat-item">
                    <span class="stat-val">0</span>
                    <span class="stat-label">Alasan Palsu Lolos</span>
                </div>
            </div>
        </div>

        <div class="auth-right">
            <a href="{{ url('/') }}" class="back-link">← Kembali ke beranda</a>

            <div class="auth-heading">
                <h2>Selamat datang</h2>
                <p>Masuk dengan akun satpam Anda untuk memantau gerbang sekolah.</p>
            </div>

            @if (session('error'))
                <div class="alert-error">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email / NIP</label>
                    <div class="input-wrap">
                        <input type="text" class="form-control" id="email" name="email"
                               value="{{ old('email') }}" required autofocus
                               placeholder="satpam@sekolah.com atau NIP">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="input-wrap">
                        <input type="password" class="form-control" id="password" name="password"
                               required placeholder="••••••••">
                    </div>
                </div>

                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="btn-primary">Masuk ke SIGAP</button>
            </form>

            <div class="auth-footer-text">
                Demo: <strong>satpam@sekolah.com</strong> / <strong>satpam123</strong>
            </div>
        </div>
    </div>
</body>
</html>
