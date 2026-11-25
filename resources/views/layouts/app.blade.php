{{-- ============================================================
     layouts/app.blade.php — Shell bersama SELURUH halaman app
     ------------------------------------------------------------
     Sections yang tersedia:
       @section('title', ...)        judul halaman (<title>)
       @section('user-role', ...)    label role di topbar (opsional)
       @section('sidebar')           daftar link menu sidebar (<li>...)
       @section('styles')            CSS khusus halaman (opsional)
       @section('content')           isi utama halaman (wajib)
       @section('scripts')           JS khusus halaman (opsional)
     ============================================================ --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — SIGAP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/sigap.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    @php
        $user = Auth::user();
        $roleLabels = ['admin' => 'Admin Sekolah', 'guru' => 'Guru', 'satpam' => 'Satpam', 'siswa' => 'Siswa'];
        $defaultRole = $roleLabels[$user->role] ?? ucfirst($user->role);
    @endphp

    <div class="app">
        <header class="topbar">
            <button class="menu-toggle" type="button" id="menuToggle" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>

            <a class="brand" href="{{ route('landing') }}">
                <span><span class="slash">/</span> SIGAP</span>
                <small>Izin &amp; Absensi</small>
            </a>

            <div class="spacer"></div>

            <div class="topbar-user">
                <div class="user-info">
                    <div class="user-avatar">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                    <div class="user-details">
                        <span class="user-name">{{ $user->name }}</span>
                        <span class="user-role">@yield('user-role', $defaultRole)</span>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                <button type="submit" form="logout-form" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </div>
        </header>

        <div class="shell">
            <aside class="sidebar" id="sidebar">
                <ul class="sidebar-menu">
                    @yield('sidebar')
                </ul>
            </aside>
            <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

            <main class="main">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            var toggle = document.getElementById('menuToggle');
            var sidebar = document.getElementById('sidebar');
            var backdrop = document.getElementById('sidebarBackdrop');
            if (!toggle || !sidebar) return;
            function close() { sidebar.classList.remove('open'); backdrop && backdrop.classList.remove('show'); }
            toggle.addEventListener('click', function () {
                sidebar.classList.toggle('open');
                backdrop && backdrop.classList.toggle('show');
            });
            backdrop && backdrop.addEventListener('click', close);
            window.addEventListener('resize', function () { if (window.innerWidth >= 992) close(); });
        })();
    </script>
    @yield('scripts')
</body>
</html>
