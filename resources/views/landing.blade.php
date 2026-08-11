<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP — Sistem Izin Gerbang &amp; Absensi Pengamanan</title>
    <style>
@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap');

:root {
    --ink: #182421;
    --ink-soft: #4b5b56;
    --paper: #f1f4f2;
    --surface: #ffffff;
    --line: #dce3df;
    --pine: #153f37;
    --pine-light: #1e5a4d;
    --mint: #e4f0ea;
    --amber: #c9821e;
    --amber-bg: #fbf0dd;
    --terracotta: #ae4e37;
    --terracotta-bg: #f8e7e2;
    --teal-bg: #dcefe6;
    --teal-text: #1b6e4f;
    --radius: 14px;
    --shadow: 0 1px 2px rgba(21, 30, 27, 0.06), 0 8px 24px -12px rgba(21, 30, 27, 0.18);
}

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
}

body.landing {
    font-family: 'Inter', system-ui, sans-serif;
    background: var(--paper);
    color: var(--ink);
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
}

.landing h1,
.landing h2,
.landing h3,
.landing h4,
.landing .display {
    font-family: 'Space Grotesk', 'Inter', sans-serif;
    letter-spacing: -0.01em;
    margin: 0;
}

.landing a {
    color: inherit;
    text-decoration: none;
}

.landing :focus-visible {
    outline: 2px solid var(--pine);
    outline-offset: 2px;
}

@media (prefers-reduced-motion: reduce) {
    .landing * {
        animation: none !important;
        transition: none !important;
    }
}

/* Gate mark */
.gate-mark {
    width: 34px;
    height: 34px;
    position: relative;
    flex-shrink: 0;
}

.gate-mark .post {
    position: absolute;
    left: 2px;
    top: 4px;
    bottom: 4px;
    width: 4px;
    background: var(--pine);
    border-radius: 2px;
}

.gate-mark .arm {
    position: absolute;
    left: 6px;
    top: 5px;
    width: 24px;
    height: 4px;
    background: var(--amber);
    border-radius: 2px;
    transform-origin: 0% 50%;
    transform: rotate(0deg);
    transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.gate-mark.open .arm {
    transform: rotate(-58deg);
}

.brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

.brand .wordmark {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700;
    font-size: 19px;
    letter-spacing: -0.02em;
}

.brand .tagline {
    font-size: 11px;
    color: var(--ink-soft);
    font-family: 'IBM Plex Mono', monospace;
    letter-spacing: 0.02em;
}

/* Badges (mock card) */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 99px;
    font-family: 'IBM Plex Mono', monospace;
}

.badge.approved {
    background: var(--teal-bg);
    color: var(--teal-text);
}

.badge.out {
    background: var(--amber-bg);
    color: var(--amber);
}

.badge.back {
    background: var(--teal-bg);
    color: var(--teal-text);
}

.badge .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

/* Nav */
.lp-nav {
    position: sticky;
    top: 0;
    z-index: 20;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 6vw;
    background: rgba(241, 244, 242, 0.85);
    backdrop-filter: blur(8px);
    border-bottom: 1px solid var(--line);
}

.lp-nav-links {
    display: flex;
    align-items: center;
    gap: 28px;
}

.lp-nav-links a {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--ink-soft);
}

.lp-nav-links a:hover {
    color: var(--pine);
}

.lp-nav-cta {
    background: var(--pine);
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 9px;
    font-weight: 600;
    font-size: 13.5px;
    cursor: pointer;
    font-family: inherit;
}

.lp-nav-cta:hover {
    background: var(--pine-light);
}

/* Hero */
.lp-hero {
    position: relative;
    padding: 72px 6vw 60px;
    display: grid;
    grid-template-columns: 1.05fr 0.95fr;
    gap: 40px;
    align-items: center;
    overflow: hidden;
    background:
        radial-gradient(1100px 480px at 8% -15%, #e4f0ea 0%, transparent 60%),
        radial-gradient(800px 420px at 105% 0%, #f3e7d6 0%, transparent 55%);
}

.lp-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'IBM Plex Mono', monospace;
    font-size: 11.5px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--amber);
    font-weight: 600;
    background: var(--amber-bg);
    padding: 6px 12px;
    border-radius: 99px;
    margin-bottom: 20px;
}

.lp-hero h1 {
    font-size: clamp(32px, 4.2vw, 50px);
    line-height: 1.08;
    font-weight: 700;
    letter-spacing: -0.02em;
}

.lp-hero h1 .accent {
    color: var(--pine);
}

.lp-hero p.lead {
    font-size: 16px;
    color: var(--ink-soft);
    line-height: 1.65;
    margin-top: 18px;
    max-width: 480px;
}

.lp-cta-row {
    display: flex;
    gap: 12px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.lp-btn-primary {
    background: var(--pine);
    color: #fff;
    border: none;
    padding: 14px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14.5px;
    cursor: pointer;
    font-family: inherit;
    display: inline-block;
}

.lp-btn-primary:hover {
    background: var(--pine-light);
}

.lp-btn-secondary {
    background: var(--surface);
    color: var(--ink);
    border: 1.5px solid var(--line);
    padding: 14px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14.5px;
    cursor: pointer;
    font-family: inherit;
    display: inline-block;
}

.lp-btn-secondary:hover {
    border-color: var(--pine);
    color: var(--pine);
}

.lp-trust {
    display: flex;
    gap: 26px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.lp-trust div {
    font-family: 'IBM Plex Mono', monospace;
}

.lp-trust .n {
    font-size: 24px;
    font-weight: 700;
    color: var(--pine);
}

.lp-trust .l {
    font-size: 11px;
    color: var(--ink-soft);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Hero visual */
.lp-hero-visual {
    position: relative;
}

.lp-mock-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: 18px;
    box-shadow: var(--shadow);
    padding: 22px;
    position: relative;
    z-index: 1;
}

.lp-mock-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.lp-mock-head .t {
    font-size: 13px;
    font-weight: 700;
}

.lp-mock-gate {
    width: 52px;
    height: 52px;
    position: relative;
}

.lp-mock-gate .post {
    position: absolute;
    left: 4px;
    top: 6px;
    bottom: 6px;
    width: 6px;
    background: var(--pine);
    border-radius: 3px;
}

.lp-mock-gate .arm {
    position: absolute;
    left: 10px;
    top: 8px;
    width: 36px;
    height: 6px;
    background: var(--amber);
    border-radius: 3px;
    transform-origin: 0% 50%;
    animation: gateSwing 3.2s ease-in-out infinite;
}

@keyframes gateSwing {
    0%,
    15% {
        transform: rotate(0deg);
    }
    45%,
    70% {
        transform: rotate(-62deg);
    }
    100% {
        transform: rotate(-62deg);
    }
}

.lp-mock-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 11px 0;
    border-top: 1px solid var(--line);
    font-size: 12.5px;
}

.lp-mock-row:first-of-type {
    border-top: none;
}

.lp-mock-row .nm {
    font-weight: 600;
}

.lp-mock-row .kl {
    color: var(--ink-soft);
    font-size: 11px;
}

.lp-float-card {
    position: absolute;
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: 12px;
    box-shadow: var(--shadow);
    padding: 12px 14px;
    font-size: 11.5px;
    font-weight: 600;
    z-index: 2;
}

.lp-float-card.f1 {
    top: -16px;
    right: -18px;
    color: var(--teal-text);
    animation: floatY 4s ease-in-out infinite;
}

.lp-float-card.f2 {
    bottom: -18px;
    left: -22px;
    color: var(--amber);
    animation: floatY 4.6s ease-in-out infinite reverse;
}

@keyframes floatY {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-8px);
    }
}

/* Sections */
.lp-section {
    padding: 64px 6vw;
}

.lp-section-head {
    max-width: 560px;
    margin-bottom: 38px;
}

.lp-section-head .lp-eyebrow {
    margin-bottom: 14px;
}

.lp-section-head h2 {
    font-size: clamp(24px, 2.6vw, 32px);
    line-height: 1.2;
}

.lp-section-head p {
    color: var(--ink-soft);
    font-size: 14.5px;
    margin-top: 10px;
    line-height: 1.6;
}

.lp-problem-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.lp-problem-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 26px;
    position: relative;
}

.lp-problem-card .tag {
    font-family: 'IBM Plex Mono', monospace;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--terracotta);
    background: var(--terracotta-bg);
    display: inline-block;
    padding: 4px 10px;
    border-radius: 99px;
    margin-bottom: 14px;
}

.lp-problem-card h3 {
    font-size: 17px;
    margin-bottom: 8px;
}

.lp-problem-card p {
    font-size: 13.5px;
    color: var(--ink-soft);
    line-height: 1.6;
}

.lp-problem-card blockquote {
    margin: 16px 0 0;
    padding: 12px 14px;
    background: var(--paper);
    border-left: 3px solid var(--amber);
    border-radius: 0 8px 8px 0;
    font-size: 12.5px;
    color: var(--ink);
    font-style: italic;
}

.lp-steps {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    position: relative;
}

.lp-step {
    padding: 0 18px 0 0;
    position: relative;
}

.lp-step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 22px;
    right: 0;
    width: 100%;
    height: 1.5px;
    background: repeating-linear-gradient(90deg, var(--line) 0 6px, transparent 6px 12px);
    z-index: 0;
}

.lp-step-num {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--pine);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700;
    font-size: 16px;
    position: relative;
    z-index: 1;
    margin-bottom: 16px;
}

.lp-step h4 {
    font-size: 14.5px;
    margin-bottom: 6px;
}

.lp-step p {
    font-size: 12.5px;
    color: var(--ink-soft);
    line-height: 1.55;
}

.lp-role-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.lp-role-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 22px;
    transition: 0.15s;
}

.lp-role-card:hover {
    border-color: var(--pine);
    box-shadow: var(--shadow);
    transform: translateY(-2px);
}

.lp-role-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: var(--mint);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
}

.lp-role-icon svg {
    width: 18px;
    height: 18px;
    stroke: var(--pine);
}

.lp-role-card h4 {
    font-size: 15px;
    margin-bottom: 10px;
}

.lp-role-card ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.lp-role-card li {
    font-size: 12.5px;
    color: var(--ink-soft);
    padding: 5px 0 5px 16px;
    position: relative;
    line-height: 1.4;
}

.lp-role-card li::before {
    content: '—';
    position: absolute;
    left: 0;
    color: var(--amber);
}

.lp-cta-band {
    margin: 0 6vw 64px;
    background: linear-gradient(155deg, var(--pine) 0%, #0f2d27 100%);
    border-radius: 22px;
    padding: 52px 6vw;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.lp-cta-band::after {
    content: '';
    position: absolute;
    right: -80px;
    top: -80px;
    width: 260px;
    height: 260px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201, 130, 30, 0.3), transparent 70%);
}

.lp-cta-band h2 {
    color: #fff;
    font-size: clamp(22px, 3vw, 30px);
    position: relative;
    z-index: 1;
}

.lp-cta-band p {
    color: #c4d6cd;
    font-size: 14px;
    margin-top: 10px;
    position: relative;
    z-index: 1;
}

.lp-cta-band .lp-cta-row {
    justify-content: center;
    position: relative;
    z-index: 1;
}

.lp-cta-band .lp-btn-secondary {
    background: transparent;
    border-color: rgba(255, 255, 255, 0.3);
    color: #fff;
}

.lp-cta-band .lp-btn-secondary:hover {
    border-color: #fff;
}

.lp-footer {
    padding: 28px 6vw;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--line);
    font-size: 12px;
    color: var(--ink-soft);
    flex-wrap: wrap;
    gap: 10px;
}

@media (max-width: 900px) {
    .lp-hero {
        grid-template-columns: 1fr;
        padding-top: 48px;
    }

    .lp-problem-grid {
        grid-template-columns: 1fr;
    }

    .lp-steps {
        grid-template-columns: 1fr 1fr;
        row-gap: 28px;
    }

    .lp-step:nth-child(2)::after {
        display: none;
    }

    .lp-role-grid {
        grid-template-columns: 1fr 1fr;
    }

    .lp-nav-links {
        display: none;
    }
}

@media (max-width: 600px) {
    .lp-hero {
        padding: 32px 6vw 48px;
        text-align: center;
    }

    .lp-hero-visual {
        display: none;
    }

    .lp-eyebrow {
        margin-left: auto;
        margin-right: auto;
    }

    .lp-cta-row {
        justify-content: center;
    }

    .lp-steps {
        grid-template-columns: 1fr;
    }

    .lp-step:not(:last-child)::after {
        display: none;
    }

    .lp-role-grid {
        grid-template-columns: 1fr;
    }
}
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
</style>
</head>
<body class="landing">

<nav class="lp-nav">
    <div class="brand">
        <div class="gate-mark open">
            <div class="post"></div>
            <div class="arm"></div>
        </div>
        <div>
            <div class="wordmark">SIGAP</div>
            <div class="tagline">GATE &amp; SHIFT SYSTEM</div>
        </div>
    </div>
    <div class="lp-nav-links">
        <a href="#lp-masalah">Masalah</a>
        <a href="#lp-caranya">Cara kerja</a>
        <a href="#lp-fitur">Fitur</a>
    </div>
    <a href="{{ route('login') }}" class="lp-nav-cta">Masuk</a>
</nav>

<section class="lp-hero">
    <div>
        <span class="lp-eyebrow">Dari riset lapangan bersama satpam sekolah</span>
        <h1>Satu gerbang,<br>satu <span class="accent">sumber kebenaran.</span></h1>
        <p class="lead">SIGAP mengganti izin keluar lisan dan jadwal jaga di kertas dengan satu sistem digital — supaya siswa tidak bisa berbohong soal alasan keluar, dan satpam tidak lagi kewalahan dengan jadwal yang bentrok.</p>
        <div class="lp-cta-row">
            <a href="{{ route('login') }}" class="lp-btn-primary">Coba demo SIGAP</a>
            <a href="#lp-masalah" class="lp-btn-secondary">Lihat masalahnya</a>
        </div>
        <div class="lp-trust">
            <div><div class="n">04</div><div class="l">Role pengguna</div></div>
            <div><div class="n">Real-time</div><div class="l">Status gerbang</div></div>
            <div><div class="n">100%</div><div class="l">Izin terverifikasi guru</div></div>
        </div>
    </div>
    <div class="lp-hero-visual">
        <div class="lp-float-card f1">📎 Bukti terlampir</div>
        <div class="lp-mock-card">
            <div class="lp-mock-head">
                <div class="t">Izin disetujui hari ini</div>
                <div class="lp-mock-gate">
                    <div class="post"></div>
                    <div class="arm"></div>
                </div>
            </div>
            <div class="lp-mock-row">
                <div>
                    <div class="nm">Ahmad Fauzan</div>
                    <div class="kl">XI RPL 2 · Dijemput orang tua</div>
                </div>
                <span class="badge approved"><span class="dot"></span>Disetujui</span>
            </div>
            <div class="lp-mock-row">
                <div>
                    <div class="nm">Siti Nurhaliza</div>
                    <div class="kl">X TKJ 1 · Sakit</div>
                </div>
                <span class="badge out"><span class="dot"></span>Sudah keluar</span>
            </div>
            <div class="lp-mock-row">
                <div>
                    <div class="nm">Nadia Ramadhani</div>
                    <div class="kl">XI RPL 2 · Dijemput</div>
                </div>
                <span class="badge back"><span class="dot"></span>Sudah kembali</span>
            </div>
        </div>
        <div class="lp-float-card f2">✓ Jadwal jaga tidak bentrok</div>
    </div>
</section>

<section class="lp-section" id="lp-masalah">
    <div class="lp-section-head reveal">
        <span class="lp-eyebrow">Temuan dari lapangan</span>
        <h2>Dua masalah nyata yang kami temukan langsung dari satpam sekolah</h2>
        <p>Bukan asumsi — ini hasil wawancara langsung dengan satpam yang bertugas setiap hari di gerbang.</p>
    </div>
    <div class="lp-problem-grid">
        <div class="lp-problem-card">
            <span class="tag">Masalah 01</span>
            <h3>Siswa bisa keluar dengan alasan bohong</h3>
            <p>Tidak ada sistem izin yang jelas — siswa cukup bilang lisan ke satpam, tanpa ada yang bisa diverifikasi.</p>
            <blockquote>"Tadi murid juga keluar, tapi bohong alasannya."</blockquote>
        </div>
        <div class="lp-problem-card">
            <span class="tag">Masalah 02</span>
            <h3>Jadwal jaga satpam tidak teratur</h3>
            <p>Pembagian shift masih manual, rawan bentrok, dan sulit dipantau siapa yang seharusnya bertugas hari itu.</p>
            <blockquote>Dicatat di kertas, sering tidak sinkron antar petugas.</blockquote>
        </div>
    </div>
</section>

<section class="lp-section" id="lp-caranya">
    <div class="lp-section-head reveal">
        <span class="lp-eyebrow">Cara kerja</span>
        <h2>Dari pengajuan sampai siswa keluar gerbang</h2>
        <p>Empat langkah, semua tercatat dan bisa dipantau real-time.</p>
    </div>
    <div class="lp-steps">
        <div class="lp-step">
            <div class="lp-step-num">01</div>
            <h4>Siswa ajukan izin</h4>
            <p>Isi alasan, kelas, dan jam keluar — bisa lampirkan bukti seperti pesan orang tua.</p>
        </div>
        <div class="lp-step">
            <div class="lp-step-num">02</div>
            <h4>Guru verifikasi</h4>
            <p>Guru piket meninjau lalu menyetujui atau menolak pengajuan.</p>
        </div>
        <div class="lp-step">
            <div class="lp-step-num">03</div>
            <h4>Satpam cek di gerbang</h4>
            <p>Nama yang disetujui otomatis muncul — tinggal dicocokkan, lalu ditandai keluar.</p>
        </div>
        <div class="lp-step">
            <div class="lp-step-num">04</div>
            <h4>Admin pantau semua</h4>
            <p>Rekap izin, kehadiran satpam, dan jadwal shift dalam satu dashboard.</p>
        </div>
    </div>
</section>

<section class="lp-section" id="lp-fitur">
    <div class="lp-section-head reveal">
        <span class="lp-eyebrow">Fitur per peran</span>
        <h2>Satu sistem, empat sudut pandang</h2>
        <p>Setiap peran cuma melihat yang relevan buat tugasnya.</p>
    </div>
    <div class="lp-role-grid">
        <div class="lp-role-card">
            <div class="lp-role-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 1 8l11 5 9-4.09V15h2V8L12 3z"/><path d="M5 13.18v4L12 21l7-3.82v-4"/></svg>
            </div>
            <h4>Siswa</h4>
            <ul>
                <li>Ajukan izin keluar</li>
                <li>Lampirkan bukti</li>
                <li>Pantau riwayat izin</li>
            </ul>
        </div>
        <div class="lp-role-card">
            <div class="lp-role-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <h4>Guru piket</h4>
            <ul>
                <li>Tinjau pengajuan masuk</li>
                <li>Setujui atau tolak</li>
                <li>Lihat riwayat keputusan</li>
            </ul>
        </div>
        <div class="lp-role-card">
            <div class="lp-role-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 5v6c0 5 3.4 8.4 8 11 4.6-2.6 8-6 8-11V5l-8-3z"/></svg>
            </div>
            <h4>Satpam</h4>
            <ul>
                <li>Daftar izin disetujui real-time</li>
                <li>Tandai keluar / kembali</li>
                <li>Ajukan tukar shift</li>
            </ul>
        </div>
        <div class="lp-role-card">
            <div class="lp-role-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
            </div>
            <h4>Admin sekolah</h4>
            <ul>
                <li>Kelola akun &amp; jadwal shift</li>
                <li>Setujui tukar shift</li>
                <li>Rekap &amp; laporan bulanan</li>
            </ul>
        </div>
    </div>
</section>

<div class="lp-cta-band reveal">
    <h2>Siap coba SIGAP?</h2>
    <p>Masuk ke demo dan jelajahi keempat dashboard-nya langsung.</p>
    <div class="lp-cta-row">
        <a href="{{ route('login') }}" class="lp-btn-primary">Coba demo SIGAP</a>
        <a href="{{ route('register') }}" class="lp-btn-secondary">Daftar akun</a>
    </div>
</div>

<footer class="lp-footer">
    <div class="brand">
        <div class="gate-mark">
            <div class="post"></div>
            <div class="arm"></div>
        </div>
        <span class="wordmark" style="font-size:14px;">SIGAP</span>
    </div>
    <div>Prototipe tugas sekolah — Sistem Izin Gerbang &amp; Absensi Pengamanan</div>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal, .lp-problem-card, .lp-step, .lp-role-card').forEach((el) => {
            el.classList.add('reveal');
            observer.observe(el);
        });
    });
</script>

</body>
</html>
