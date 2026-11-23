<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode === 'register' ? 'Daftar' : 'Masuk' }} — SIGAP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --pine: #153f37;
            --pine-light: #1e5a4d;
            --pine-deep: #0e2f28;
            --pine-grad: linear-gradient(175deg, #1a4a41 0%, #123830 55%, #0e2f28 100%);
            --mint: #e4f0ea;
            --mint-soft: #f0f7f3;
            --amber: #c9821e;
            --amber-soft: #e9a94e;
            --ink: #182421;
            --soft: #4b5b56;
            --line: #dce3df;
            --line-soft: #e9eeeb;
            --paper: #eef2f0;
            --surface: #ffffff;
            --danger: #ae4e37;
            --danger-bg: #f8e7e2;
            --danger-line: #f2d3cb;
            --success: #1f5e23;
            --success-bg: #e8f5e9;
            --success-line: #c8e6c9;
            --radius: 12px;
            --shadow-sm: 0 1px 2px rgba(16, 40, 34, 0.05);
            --shadow: 0 1px 3px rgba(16, 40, 34, 0.06), 0 10px 28px -18px rgba(16, 40, 34, 0.28);
            --shadow-lg: 0 2px 6px rgba(16, 40, 34, 0.07), 0 24px 48px -24px rgba(16, 40, 34, 0.3);
            --font-head: 'Space Grotesk', 'Inter', sans-serif;
            --font-body: 'Inter', system-ui, sans-serif;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            padding: clamp(16px, 3vw, 32px);
            display: grid;
            place-items: center;
            background:
                radial-gradient(900px 460px at 100% -10%, rgba(21, 63, 55, 0.08), transparent 60%),
                radial-gradient(760px 440px at -8% 110%, rgba(201, 130, 30, 0.07), transparent 55%),
                var(--paper);
            color: var(--ink);
            font-family: var(--font-body);
            font-size: 14.5px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        /* ---------- Shell: split layout ---------- */
        .auth {
            width: min(100%, 1020px);
            min-height: 600px;
            display: grid;
            grid-template-columns: 1fr minmax(360px, 450px);
            overflow: hidden;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
        }

        /* ---------- Brand / story panel ---------- */
        .intro {
            position: relative;
            overflow: hidden;
            padding: clamp(38px, 4vw, 56px);
            color: #fff;
            display: flex;
            flex-direction: column;
            background:
                radial-gradient(440px 320px at 92% 8%, rgba(201, 130, 30, 0.26), transparent 65%),
                radial-gradient(400px 340px at -5% 100%, rgba(46, 142, 120, 0.32), transparent 65%),
                var(--pine-grad);
        }
        .intro::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 52px 52px;
            -webkit-mask-image: radial-gradient(circle at 40% 40%, #000 10%, transparent 78%);
            mask-image: radial-gradient(circle at 40% 40%, #000 10%, transparent 78%);
            pointer-events: none;
        }
        /* decorative gate-arm streak */
        .intro::after {
            content: '';
            position: absolute;
            right: -70px;
            bottom: 14%;
            width: 280px;
            height: 10px;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--amber), rgba(201, 130, 30, 0));
            transform: rotate(-20deg);
            opacity: 0.55;
            pointer-events: none;
        }
        .intro > * { position: relative; z-index: 1; }
        .brand {
            font-family: var(--font-head);
            font-weight: 700;
            font-size: 22px;
            letter-spacing: -0.03em;
            color: #fff;
        }
        .brand span { color: var(--amber-soft); }
        .intro h1 {
            max-width: 380px;
            margin: auto 0 14px;
            font-family: var(--font-head);
            font-weight: 700;
            font-size: clamp(26px, 2.6vw, 34px);
            line-height: 1.18;
            letter-spacing: -0.03em;
            color: #fff;
        }
        .intro p {
            max-width: 380px;
            margin: 0;
            color: #c6d5d0;
            line-height: 1.65;
            font-size: 15px;
        }

        /* ---------- Form panel ---------- */
        .panel {
            padding: clamp(34px, 4vw, 50px) clamp(28px, 4vw, 52px);
            display: flex;
            flex-direction: column;
            background: var(--surface);
        }
        .back {
            color: var(--soft);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            align-self: flex-start;
            transition: color 0.15s;
        }
        .back:hover { color: var(--pine); }

        /* ---------- Tabs (segmented switcher) ---------- */
        .tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px;
            padding: 5px;
            margin: 26px 0 26px;
            border-radius: 14px;
            background: var(--mint-soft);
            border: 1px solid var(--line-soft);
        }
        .tabs a {
            padding: 10px 12px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            color: var(--soft);
            font-size: 14px;
            font-weight: 600;
            transition: color 0.16s, background 0.16s, box-shadow 0.16s;
        }
        .tabs a:hover { color: var(--pine); }
        .tabs a.active {
            color: var(--pine);
            background: var(--surface);
            box-shadow: var(--shadow-sm), inset 0 0 0 1px var(--line);
        }

        h2 {
            margin: 0 0 6px;
            font-family: var(--font-head);
            font-weight: 700;
            font-size: clamp(24px, 2.4vw, 28px);
            line-height: 1.2;
            letter-spacing: -0.02em;
            color: var(--ink);
        }
        .sub {
            margin: 0 0 24px;
            color: var(--soft);
            font-size: 14px;
            line-height: 1.55;
        }

        /* ---------- Notices ---------- */
        .notice {
            padding: 12px 15px;
            margin-bottom: 18px;
            border-radius: var(--radius);
            font-size: 13.5px;
            line-height: 1.5;
            border: 1px solid transparent;
            box-shadow: var(--shadow-sm);
        }
        .notice.error {
            color: #8a3c29;
            background: var(--danger-bg);
            border-color: var(--danger-line);
        }
        .notice.success {
            color: var(--success);
            background: var(--success-bg);
            border-color: var(--success-line);
        }

        /* ---------- Fields ---------- */
        .group { margin-bottom: 16px; }
        label {
            display: block;
            margin-bottom: 7px;
            color: var(--ink);
            font-size: 13.5px;
            font-weight: 600;
        }
        input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid var(--line);
            border-radius: 12px;
            font-family: var(--font-body);
            font-size: 14.5px;
            color: var(--ink);
            background: var(--surface);
            transition: border-color 0.16s, box-shadow 0.16s;
        }
        input::placeholder { color: #9aa8a3; }
        input:hover { border-color: #c3cec9; }
        input:focus {
            outline: none;
            border-color: var(--pine);
            box-shadow: 0 0 0 4px rgba(21, 63, 55, 0.13);
            background: #fff;
        }
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* ---------- Submit ---------- */
        button {
            width: 100%;
            margin-top: 10px;
            border: 0;
            border-radius: 12px;
            padding: 15px;
            background: var(--pine);
            color: #fff;
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            box-shadow: 0 12px 24px -16px rgba(21, 63, 55, 0.95);
            transition: background 0.17s, transform 0.17s, box-shadow 0.17s;
        }
        button:hover {
            background: var(--pine-light);
            transform: translateY(-1px);
        }
        button:active { transform: translateY(0); }
        button:focus-visible {
            outline: 3px solid rgba(21, 63, 55, 0.28);
            outline-offset: 2px;
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 760px) {
            body { padding: 0; }
            .auth {
                min-height: 100vh;
                border-radius: 0;
                border: 0;
                grid-template-columns: 1fr;
            }
            .intro { display: none; }
            .panel {
                padding: 36px 24px;
                justify-content: center;
                max-width: 520px;
                width: 100%;
                margin: 0 auto;
            }
        }
        @media (max-width: 390px) {
            .row { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>
<body>
    <main class="auth">
        <section class="intro"><div class="brand"><span>/</span> SIGAP</div><div><h1>Satu gerbang, satu sumber kebenaran.</h1><p>Kelola akses dan aktivitas sekolah dari satu sistem yang terintegrasi.</p></div></section>
        <section class="panel">
            <a class="back" href="{{ route('landing') }}">← Kembali ke beranda</a>
            <nav class="tabs" aria-label="Autentikasi"><a class="{{ $mode === 'login' ? 'active' : '' }}" href="{{ route('login') }}">Masuk</a><a class="{{ $mode === 'register' ? 'active' : '' }}" href="{{ route('register') }}">Daftar</a></nav>
            <h2>{{ $mode === 'register' ? 'Buat akun' : 'Selamat datang' }}</h2>
            <p class="sub">{{ $mode === 'register' ? 'Akun baru akan terdaftar sebagai pengguna.' : 'Masuk untuk melanjutkan ke SIGAP.' }}</p>
            @if (session('status'))<div class="notice success">{{ session('status') }}</div>@endif
            @if (session('error'))<div class="notice error">{{ session('error') }}</div>@endif
            @if ($errors->any())
                <div class="notice error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @if ($mode === 'register')
                <form method="POST" action="{{ route('register.submit') }}">@csrf
                    <div class="group"><label for="name">Nama lengkap</label><input id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"></div>
                    <div class="group"><label for="email">Email</label><input type="text" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@sekolah.sch.id"></div>
                    <div class="row"><div class="group"><label for="nis">NIS</label><input id="nis" name="nis" value="{{ old('nis') }}" required autocomplete="off" placeholder="Nomor Induk Siswa"></div><div class="group"><label for="kelas">Kelas</label><input id="kelas" name="kelas" value="{{ old('kelas') }}" required autocomplete="off" placeholder="Contoh: X-A"></div></div>
                    <div class="row"><div class="group"><label for="password">Kata sandi</label><input type="password" id="password" name="password" required autocomplete="new-password"></div><div class="group"><label for="password_confirmation">Konfirmasi kata sandi</label><input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"></div></div>
                    <button type="submit">Daftar akun</button>
                </form>
            @else
                <form method="POST" action="{{ route('login.submit') }}">@csrf
                    <div class="group"><label for="email">Email / Akun</label><input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@sekolah.sch.id"></div>
                    <div class="group"><label for="password">Kata sandi</label><input type="password" id="password" name="password" required autocomplete="current-password"></div>
                    <button type="submit">Masuk</button>
                </form>
            @endif
        </section>
    </main>
</body>
</html>
