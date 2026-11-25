@extends('layouts.app')

@section('title', 'Portal Siswa')
@section('user-role', $siswa?->kelas ?? 'Siswa')

@section('sidebar')
    <li>
        <a href="{{ route('siswa.dashboard') }}" class="active">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('siswa.izin_keluar.index') }}">
            <i class="bi bi-box-arrow-right"></i> Izin Keluar
        </a>
    </li>
@endsection

@section('styles')
    <style>
        .page {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            padding: 32px 0 48px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 24px;
        }

        .eyebrow {
            color: var(--amber);
            font: 600 13px 'IBM Plex Mono', monospace;
            letter-spacing: .08em;
        }

        h1 {
            margin: 6px 0 8px;
            font: 700 32px/1.15 'Space Grotesk', sans-serif;
            letter-spacing: -.02em;
        }

        .lead {
            max-width: 660px;
            margin: 0;
            color: var(--ink-soft);
            font-size: 16px;
            line-height: 1.6;
        }

        .card,
        .profile-form {
            overflow: hidden;
            margin-bottom: 22px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
            box-shadow: 0 8px 22px rgba(21, 63, 55, .06);
        }

        .card-title {
            padding: 20px 24px;
            border-bottom: 1px solid var(--line);
            font: 700 20px 'Space Grotesk', sans-serif;
        }

        .card-body { padding: 24px; }

        .profile-form {
            padding: 18px 20px;
        }

        .profile-form summary {
            cursor: pointer;
            color: var(--pine);
            font-weight: 700;
        }

        .profile-form form { margin-top: 18px; }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .field { margin-bottom: 18px; }

        label {
            display: block;
            margin-bottom: 8px;
            color: #344842;
            font-weight: 700;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            min-height: 52px;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 0 16px;
            background: var(--surface);
            color: var(--ink);
            font: 500 16px Inter, sans-serif;
        }

        input:focus,
        select:focus {
            outline: 0;
            border-color: var(--pine);
            box-shadow: 0 0 0 4px rgba(21, 63, 55, .1);
        }

        input[readonly] {
            background: #f7f9f8;
            color: var(--ink-soft);
        }

        input[type="file"] {
            height: auto;
            padding: 10px;
            line-height: 1.4;
        }

        input[type="file"]::file-selector-button {
            margin-right: 12px;
            border: 0;
            border-radius: 7px;
            padding: 10px 14px;
            background: var(--paper);
            color: var(--pine);
            cursor: pointer;
            font-weight: 700;
        }

        .hint {
            margin: 10px 0 0;
            padding: 12px 14px;
            border-radius: 8px;
            background: var(--paper);
            color: var(--ink-soft);
            font-size: 14px;
            line-height: 1.5;
        }

        .alert {
            margin: 0 0 18px;
            padding: 13px 15px;
            border-radius: 8px;
            color: var(--terracotta);
            background: #fdf3f1;
            font-weight: 600;
        }

        .success {
            color: #176344;
            background: #e5f4ec;
        }

        button[type="submit"]:not(.logout) {
            min-height: 50px;
            border: 0;
            border-radius: 8px;
            padding: 13px 22px;
            background: var(--pine);
            color: #fff;
            cursor: pointer;
            font: 700 16px Inter, sans-serif;
        }

        button[type="submit"]:not(.logout):hover {
            background: var(--pine-light);
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 680px;
            border-collapse: collapse;
        }

        th {
            padding: 14px 18px;
            background: var(--paper);
            color: var(--ink-soft);
            text-align: left;
            font-size: 12px;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        td {
            padding: 16px 18px;
            border-top: 1px solid var(--line);
            font-size: 15px;
        }

        .time {
            font: 600 15px 'IBM Plex Mono', monospace;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border-radius: 999px;
            padding: 8px 12px;
            font: 600 12px 'IBM Plex Mono', monospace;
        }

        .badge::before { content: ''; width: 7px; height: 7px; border-radius: 999px; background: currentColor; }
        .pending { color: #9a660d; background: #fff0cf; }
        .approved { color: #147356; background: #dff4eb; }
        .rejected { color: #a33d2c; background: #fbe4df; }

        .actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        @media (max-width: 760px) {
            .page {
                width: min(100% - 24px, 1180px);
                padding-top: 22px;
            }

            .top {
                align-items: center;
            }

            h1 {
                font-size: 26px;
            }

            .lead {
                font-size: 14px;
            }

            .grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .card-title,
            .card-body {
                padding-left: 16px;
                padding-right: 16px;
            }

            input,
            select {
                min-height: 48px;
                font-size: 15px;
            }

            button[type="submit"]:not(.logout) {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page">
        <div class="top">
            <div>
                <div class="eyebrow">PORTAL SISWA</div>
                <h1>Ajukan & pantau izin keluar</h1>
                <p class="lead">Izin harus disetujui guru piket sebelum kamu boleh keluar gerbang.</p>
            </div>
        </div>

        <details class="profile-form" @if($errors->has('name') || $errors->has('email') || $errors->has('foto_profil')) open @endif>
            <summary>Edit profil</summary>
            <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="grid">
                    <div class="field">
                        <label for="profile_name">Nama</label>
                        <input id="profile_name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>
                    <div class="field">
                        <label for="profile_email">Email</label>
                        <input type="email" id="profile_email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                    <div class="field">
                        <label for="profile_kelas">Kelas</label>
                        <input id="profile_kelas" name="kelas" value="{{ old('kelas', $siswa?->kelas) }}" required>
                    </div>
                    <div class="field">
                        <label for="foto_profil">Foto profil</label>
                        <input type="file" id="foto_profil" name="foto_profil" accept="image/png,image/jpeg,image/webp">
                    </div>
                </div>
                <button type="submit">Simpan profil</button>
            </form>
        </details>

        <section class="card">
            <div class="card-title">Form pengajuan izin keluar</div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('user.izin.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid">
                        <div class="field">
                            <label for="kelas">Kelas</label>
                            <input id="kelas" name="kelas" value="{{ old('kelas', $siswa?->kelas) }}" {{ $siswa ? 'readonly' : '' }} required placeholder="Contoh: XI RPL 2">
                        </div>
                        <div class="field">
                            <label for="jam_keluar_rencana">Jam keluar rencana</label>
                            <input type="time" id="jam_keluar_rencana" name="jam_keluar_rencana" value="{{ old('jam_keluar_rencana') }}" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="alasan">Alasan</label>
                        <select id="alasan" name="alasan" required>
                            <option value="" disabled {{ old('alasan') ? '' : 'selected' }}>Pilih alasan izin</option>
                            @foreach(['Dijemput orang tua', 'Keperluan keluarga', 'Berobat', 'Lainnya'] as $alasan)
                                <option value="{{ $alasan }}" @selected(old('alasan') === $alasan)>{{ $alasan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field" id="deskripsi-wrap" style="display: {{ old('alasan') === 'Lainnya' ? 'block' : 'none' }}">
                        <label for="deskripsi">Jelaskan alasan izin</label>
                        <input id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}" maxlength="500" placeholder="Tuliskan alasan izin secara singkat dan jelas">
                        <p class="hint">Wajib diisi jika memilih alasan Lainnya.</p>
                    </div>

                    <div class="field">
                        <label for="bukti">Foto atau video bukti izin</label>
                        <input type="file" id="bukti" name="bukti" accept="image/png,image/jpeg,image/webp,video/mp4,video/quicktime,video/webm" required>
                        <p class="hint">Wajib diisi. Foto atau video MP4, MOV, WEBM maksimal 20 MB.</p>
                    </div>

                    <div class="actions">
                        <button type="submit">Ajukan izin</button>
                        <p class="hint">Pengajuan akan masuk ke antrean guru piket. Kamu bisa pantau statusnya di riwayat bawah ini.</p>
                    </div>
                </form>
            </div>
        </section>

        <section class="card">
            <div class="card-title">Riwayat izin saya</div>
            @if($izinKeluar->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada pengajuan izin keluar.</p>
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Alasan</th>
                                <th>Kelas</th>
                                <th>Jam keluar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($izinKeluar as $izin)
                                <tr>
                                    <td>{{ $izin->alasan }}</td>
                                    <td>{{ $siswa?->kelas ?? '-' }}</td>
                                    <td class="time">{{ $izin->jam_keluar_rencana?->format('H:i') ?? $izin->jam_keluar_rencana }}</td>
                                    <td>
                                        <span class="badge {{ $izin->status }}">
                                            {{ ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'][$izin->status] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        const alasan = document.getElementById('alasan');
        const deskripsiWrap = document.getElementById('deskripsi-wrap');
        const deskripsi = document.getElementById('deskripsi');

        function toggleDeskripsi() {
            const lainnya = alasan.value === 'Lainnya';
            deskripsiWrap.style.display = lainnya ? 'block' : 'none';
            deskripsi.required = lainnya;
            if (!lainnya) deskripsi.value = '';
        }

        alasan.addEventListener('change', toggleDeskripsi);
        toggleDeskripsi();
    </script>
@endsection
