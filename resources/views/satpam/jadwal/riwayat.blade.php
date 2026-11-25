@extends('layouts.app')

@section('title', 'Riwayat Presensi')

@section('sidebar')
    <li>
        <a href="{{ route('satpam.dashboard') }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.izin_keluar.index') }}">
            <i class="bi bi-person-badge"></i> Izin Keluar
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.jadwal.index') }}" class="active">
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
            <h5><i class="bi bi-clock-history"></i> Riwayat Presensi</h5>
            <a href="{{ route('satpam.jadwal.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-calendar-check"></i> Jadwal
            </a>
        </div>
        <div class="content-card-body">
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-value">{{ $riwayatJadwal->where('waktu_masuk', '!=', null)->where('waktu_pulang', '!=', null)->count() }}</div>
                    <div class="stat-label">Hadir Lengkap</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $riwayatJadwal->where('waktu_masuk', '!=', null)->where('waktu_pulang', null)->count() }}</div>
                    <div class="stat-label">Belum Pulang</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $riwayatJadwal->where('waktu_masuk', null)->count() }}</div>
                    <div class="stat-label">Tidak Hadir</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $riwayatJadwal->count() }}</div>
                    <div class="stat-label">Total Shift</div>
                </div>
            </div>

            <div class="filter-row">
                <select class="form-select" style="width: auto;" id="monthFilter" onchange="filterTable()">
                    <option value="">Semua Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->locale('id')->translatedFormat('F') }}</option>
                    @endfor
                </select>
                <select class="form-select" style="width: auto;" id="statusFilter" onchange="filterTable()">
                    <option value="">Semua Status</option>
                    <option value="complete">Hadir Lengkap</option>
                    <option value="incomplete">Belum Pulang</option>
                    <option value="absent">Tidak Hadir</option>
                </select>
                <input type="number" class="form-control" style="width: 120px;" id="yearFilter" placeholder="Tahun" onchange="filterTable()">
            </div>

            <div class="table-responsive">
                <table class="table" id="presensiTable">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Shift</th>
                            <th>Jadwal</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Pulang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatJadwal as $jadwal)
                            @php
                                $status = $jadwal->waktu_masuk && $jadwal->waktu_pulang ? 'complete' : 
                                          ($jadwal->waktu_masuk ? 'incomplete' : 'absent');
                            @endphp
                            <tr data-status="{{ $status }}" data-month="{{ $jadwal->tanggal->format('n') }}" data-year="{{ $jadwal->tanggal->format('Y') }}">
                                <td>
                                    <strong>{{ $jadwal->tanggal->locale('id')->translatedFormat('d M Y') }}</strong>
                                </td>
                                <td>{{ $jadwal->tanggal->locale('id')->translatedFormat('l') }}</td>
                                <td>
                                    @if($jadwal->shift)
                                        <span class="badge badge-info">{{ ucfirst($jadwal->shift) }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $jadwal->jam_masuk?->format('H:i') ?? '-' }} - {{ $jadwal->jam_pulang?->format('H:i') ?? '-' }}</td>
                                <td>
                                    @if($jadwal->waktu_masuk)
                                        <span class="text-success">{{ $jadwal->waktu_masuk->format('H:i') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($jadwal->waktu_pulang)
                                        <span class="text-success">{{ $jadwal->waktu_pulang->format('H:i') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($jadwal->waktu_masuk && $jadwal->waktu_pulang)
                                        <span class="badge badge-success">
                                            <i class="bi bi-check-circle"></i> Hadir Lengkap
                                        </span>
                                    @elseif($jadwal->waktu_masuk)
                                        <span class="badge badge-warning">
                                            <i class="bi bi-circle"></i> Belum Pulang
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <i class="bi bi-x-circle"></i> Tidak Hadir
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Tidak ada riwayat presensi</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($riwayatJadwal->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $riwayatJadwal->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .filter-row {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .filter-row .form-select,
        .filter-row .form-control {
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 14px;
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
        function filterTable() {
            const monthFilter = document.getElementById('monthFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const yearFilter = document.getElementById('yearFilter').value;
            const table = document.getElementById('presensiTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                let showRow = true;

                // Month filter
                if (monthFilter && showRow) {
                    const rowMonth = row.getAttribute('data-month');
                    if (rowMonth !== monthFilter) showRow = false;
                }

                // Status filter
                if (statusFilter && showRow) {
                    const rowStatus = row.getAttribute('data-status');
                    if (rowStatus !== statusFilter) showRow = false;
                }

                // Year filter
                if (yearFilter && showRow) {
                    const rowYear = row.getAttribute('data-year');
                    if (rowYear !== yearFilter) showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        // Set current year as default
        document.getElementById('yearFilter').value = new Date().getFullYear();
    </script>
@endsection
