@extends('layouts.app')

@section('title', 'Izin Keluar Hari Ini')

@section('sidebar')
    <li>
        <a href="{{ route('satpam.dashboard') }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.izin_keluar.index') }}" class="active">
            <i class="bi bi-person-badge"></i> Izin Keluar
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.jadwal.index') }}">
            <i class="bi bi-calendar-check"></i> Jadwal Jaga
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.tukar_shift.index') }}">
            <i class="bi bi-arrow-left-right"></i> Tukar Shift
        </a>
    </li>
@endsection

@section('content')
    <div class="content-card">
        <div class="content-card-header">
            <h5><i class="bi bi-calendar-day"></i> Izin Keluar Hari Ini</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('satpam.izin_keluar.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-list"></i> Semua Izin
                </a>
                <a href="{{ route('satpam.izin_keluar.riwayat') }}" class="btn btn-outline-primary">
                    <i class="bi bi-clock-history"></i> Riwayat
                </a>
            </div>
        </div>
        <div class="content-card-body">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-value">{{ $izinKeluarHariIni->count() }}</div>
                    <div class="stat-label">Total Izin</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $izinKeluarHariIni->where('jam_keluar_aktual', null)->where('status', 'approved')->count() }}</div>
                    <div class="stat-label">Belum Keluar</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $izinKeluarHariIni->where('jam_keluar_aktual', '!=', null)->where('jam_kembali_aktual', null)->count() }}</div>
                    <div class="stat-label">Sedang Keluar</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $izinKeluarHariIni->where('jam_kembali_aktual', '!=', null)->count() }}</div>
                    <div class="stat-label">Sudah Kembali</div>
                </div>
            </div>

            <div class="search-box mb-3">
                <i class="bi bi-search"></i>
                <input type="text" class="form-control" id="searchInput" placeholder="Cari nama siswa..." onkeyup="searchTable()">
            </div>

            <div class="table-responsive">
                <table class="table" id="izinTable">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Rencana Keluar</th>
                            <th>Aktual Keluar</th>
                            <th>Waktu Kembali</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($izinKeluarHariIni as $izin)
                            <tr>
                                <td>
                                    <strong>{{ $izin->siswa?->user?->name ?? '-' }}</strong>
                                </td>
                                <td>{{ $izin->siswa?->kelas ?? '-' }}</td>
                                <td>
                                    {{ $izin->jam_keluar_rencana?->locale('id')->translatedFormat('d M Y H:i') ?? '-' }}
                                </td>
                                <td>
                                    {{ $izin->jam_keluar_aktual?->locale('id')->translatedFormat('d M Y H:i') ?? '-' }}
                                </td>
                                <td>
                                    {{ $izin->jam_kembali_aktual?->locale('id')->translatedFormat('d M Y H:i') ?? '-' }}
                                </td>
                                <td>{{ \Str::limit($izin->alasan ?? $izin->deskripsi, 30) }}</td>
                                <td>
                                    @if(!$izin->jam_keluar_aktual && !$izin->jam_kembali_aktual)
                                        <span class="badge badge-warning">Belum Keluar</span>
                                    @elseif($izin->jam_keluar_aktual && !$izin->jam_kembali_aktual)
                                        <span class="badge badge-info">Sedang Keluar</span>
                                    @else
                                        <span class="badge badge-success">Sudah Kembali</span>
                                    @endif
                                </td>
                                <td>
                                    @if($izin->status === 'approved')
                                        @if(!$izin->jam_keluar_aktual)
                                            <form action="{{ route('satpam.izin_keluar.tandai_keluar', $izin) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                                @csrf
                                                <input type="file" name="foto" accept="image/*" class="form-control form-control-sm d-inline-block align-middle" style="width:auto; max-width:160px;" title="Foto bukti saat keluar">
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Tandai siswa ini keluar?')">
                                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                                </button>
                                            </form>
                                        @elseif(!$izin->jam_kembali_aktual)
                                            <form action="{{ route('satpam.izin_keluar.tandai_kembali', $izin) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                                @csrf
                                                <input type="file" name="foto" accept="image/*" class="form-control form-control-sm d-inline-block align-middle" style="width:auto; max-width:160px;" title="Foto bukti saat kembali">
                                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Tandai siswa ini kembali?')">
                                                    <i class="bi bi-box-arrow-in-right"></i> Kembali
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">Selesai</span>
                                        @endif
                                    @else
                                        <span class="text-muted small">{{ ucfirst($izin->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Tidak ada izin keluar hari ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .search-box {
            position: relative;
        }

        .search-box input {
            padding-left: 40px;
            border: 1px solid var(--line);
            border-radius: 8px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-soft);
        }

        .stats-row {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-item {
            flex: 1;
            background: var(--mint);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
        }

        .stat-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--pine);
        }

        .stat-label {
            font-size: 12px;
            color: var(--ink-soft);
            margin-top: 4px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('izinTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j]) {
                        const textValue = cells[j].textContent || cells[j].innerText;
                        if (textValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }

                row.style.display = found ? '' : 'none';
            }
        }
    </script>
@endsection
