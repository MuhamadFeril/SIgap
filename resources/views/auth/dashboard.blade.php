<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — SIGAP</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap');
        * { box-sizing:border-box; } body { margin:0; min-height:100vh; padding:24px; display:grid; place-items:center; background:#e8edea; color:#182421; font-family:Inter,sans-serif; }
        main { width:min(100%,640px); padding:44px; border-radius:22px; background:#fff; box-shadow:0 20px 40px rgba(0,0,0,.08); }
        .brand { color:#153f37; font:700 22px 'Space Grotesk',sans-serif; } .brand span { color:#c9821e; }
        h1 { margin:42px 0 10px; font:700 30px 'Space Grotesk',sans-serif; letter-spacing:-.02em; } p { margin:0; color:#4b5b56; line-height:1.6; }
        .account { margin:28px 0; padding:18px; border-radius:12px; background:#f1f4f2; } .account strong, .account span { display:block; } .account span { margin-top:4px; color:#4b5b56; font-size:14px; }
        button { width:100%; border:0; border-radius:10px; padding:14px; background:#153f37; color:#fff; cursor:pointer; font:600 14px Inter,sans-serif; } button:hover { background:#1e5a4d; }
    </style>
</head>
<body>
    <main>
        <div class="brand"><span>/</span> SIGAP</div>
        <h1>Anda berhasil masuk.</h1>
        <p>Akun Anda aktif sebagai pengguna SIGAP.</p>
        <div class="account"><strong>{{ auth()->user()->name }}</strong><span>{{ auth()->user()->email }}</span></div>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
    </main>
</body>
</html>
