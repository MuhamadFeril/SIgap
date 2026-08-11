<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode === 'register' ? 'Daftar' : 'Masuk' }} — SIGAP</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap');
        :root { --pine:#153f37; --pine-light:#1e5a4d; --ink:#182421; --soft:#4b5b56; --line:#dce3df; --paper:#f1f4f2; --danger:#ae4e37; }
        *, *::before, *::after { box-sizing:border-box; }
        body { min-height:100vh; margin:0; padding:24px; display:grid; place-items:center; background:#e8edea; color:var(--ink); font-family:Inter, sans-serif; }
        .auth { width:min(100%, 960px); min-height:580px; display:grid; grid-template-columns:1fr 440px; overflow:hidden; background:#fff; border-radius:24px; box-shadow:0 20px 40px rgba(0,0,0,.08); }
        .intro { padding:52px 46px; color:#fff; background:linear-gradient(145deg, #0d2e28, var(--pine)); display:flex; flex-direction:column; }
        .brand { font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:22px; letter-spacing:-.03em; }
        .brand span { color:#c9821e; }
        .intro h1 { max-width:360px; margin:auto 0 16px; font:700 34px/1.2 'Space Grotesk',sans-serif; letter-spacing:-.03em; }
        .intro p { max-width:360px; margin:0; color:#c6d5d0; line-height:1.65; font-size:15px; }
        .panel { padding:48px; }
        .back { color:var(--soft); text-decoration:none; font-size:13px; font-weight:600; }
        .tabs { display:grid; grid-template-columns:1fr 1fr; gap:4px; padding:4px; margin:28px 0; border-radius:12px; background:var(--paper); }
        .tabs a { padding:10px; border-radius:8px; text-align:center; text-decoration:none; color:var(--soft); font-size:14px; font-weight:600; }
        .tabs a.active { color:var(--ink); background:#fff; box-shadow:0 2px 4px rgba(0,0,0,.05); }
        h2 { margin:0 0 6px; font:700 27px 'Space Grotesk',sans-serif; letter-spacing:-.02em; }
        .sub { margin:0 0 24px; color:var(--soft); font-size:14px; line-height:1.5; }
        .group { margin-bottom:17px; }
        label { display:block; margin-bottom:7px; color:var(--soft); font-size:13px; font-weight:600; }
        input { width:100%; padding:13px 14px; border:1.5px solid var(--line); border-radius:10px; font:14px Inter,sans-serif; }
        input:focus { outline:0; border-color:var(--pine); box-shadow:0 0 0 3px #e4f0ea; }
        .row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        button { width:100%; margin-top:8px; border:0; border-radius:10px; padding:15px; background:var(--pine); color:#fff; font:600 14px Inter,sans-serif; cursor:pointer; }
        button:hover { background:var(--pine-light); }
        .notice { padding:11px 13px; margin-bottom:18px; border-radius:10px; font-size:13px; line-height:1.45; }
        .error { color:var(--danger); background:#fdf3f1; border:1px solid #f9dcd8; }
        .success { color:#1e5a4d; background:#e4f0ea; }
        @media (max-width:760px) { body { padding:0; } .auth { min-height:100vh; border-radius:0; grid-template-columns:1fr; } .intro { display:none; } .panel { padding:36px 24px; } }
        @media (max-width:390px) { .row { grid-template-columns:1fr; gap:0; } }
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
            @if ($errors->any())<div class="notice error">{{ $errors->first() }}</div>@endif
            @if ($mode === 'register')
                <form method="POST" action="{{ route('register.submit') }}">@csrf
                    <div class="group"><label for="name">Nama lengkap</label><input id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"></div>
                    <div class="group"><label for="email">Email</label><input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@sekolah.sch.id"></div>
                    <div class="row"><div class="group"><label for="password">Kata sandi</label><input type="password" id="password" name="password" required autocomplete="new-password"></div><div class="group"><label for="password_confirmation">Konfirmasi kata sandi</label><input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"></div></div>
                    <button type="submit">Daftar akun</button>
                </form>
            @else
                <form method="POST" action="{{ route('login.submit') }}">@csrf
                    <div class="group"><label for="email">Email</label><input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@sekolah.sch.id"></div>
                    <div class="group"><label for="password">Kata sandi</label><input type="password" id="password" name="password" required autocomplete="current-password"></div>
                    <button type="submit">Masuk</button>
                </form>
            @endif
        </section>
    </main>
</body>
</html>
