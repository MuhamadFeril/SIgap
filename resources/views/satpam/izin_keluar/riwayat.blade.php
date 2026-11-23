@extends('layouts.app')

@section('title', 'Riwayat Izin Keluar')

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
            <h5><i class="bi bi-clock-history"></i> Riwayat Izin Keluar</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('satpam.izin_keluar.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-list"></i> Semua Izin
                </a>
                <a href="{{ route('satpam.izin_keluar.keluar_hari_ini') }}" class="btn btn-outline-primary">
                    <i class="bi bi-calendar-day"></i> Hari Ini
                </a>
            </div>
        </div>
        <div class="content-card-body">
            <div class="filter-row">
                <div class="search-box" style="flex: 1; min-width: 200px;">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari nama siswa..." onkeyup="searchTable()">
                </div>
                <select class="form-select" style="width: auto;" id="statusFilter" onchange="filterTable()">
                    <option value="">Semua Status</option>
                    <option value="completed">Selesai</option>
                    <option value="approved">Disetujui</option>
                    <option value="pending">Menunggu</option>
                    <option value="rejected">Ditolak</option>
                </select>
                <input type="date" class="form-control" style="width: auto;" id="dateFilter" onchange="filterTable()">
            </div>

            <div class="table-responsive">
                <table class="table" id="izinTable">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Rencana Keluar</th>
                            <th>Aktual Keluar</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Waktu Sebenarnya</th>
                            <th>Bukti Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($izinKeluar as $izin)
                            <tr data-status="{{ $izin->jam_kembali_aktual ? 'completed' : ($izin->status === 'approved' ? 'approved' : $izin->status) }}" data-date="{{ $izin->jam_keluar_rencana?->toDateString() }}">
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
                                <td>{{ \Str::limit($izin->alasan ?? $izin->deskripsi, 30) }}</td>
                                <td>
                                    @if($izin->jam_kembali_aktual)
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif($izin->jam_keluar_aktual)
                                        <span class="badge badge-info">Sedang Keluar</span>
                                    @elseif($izin->status === 'approved')
                                        <span class="badge badge-success">Disetujui</span>
                                    @elseif($izin->status === 'rejected')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @else
                                        <span class="badge badge-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    @if($izin->jam_keluar_aktual)
                                        <small>Out: {{ $izin->jam_keluar_aktual->format('H:i') }}</small>
                                        <br>
                                    @endif
                                    @if($izin->jam_kembali_aktual)
                                        <small>In: {{ $izin->jam_kembali_aktual->format('H:i') }}</small>
                                    @endif
                                    @if(!$izin->jam_keluar_aktual && !$izin->jam_kembali_aktual)
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                                <td>
                                    @if($izin->foto_keluar_path)
                                        <a href="{{ asset('storage/' . $izin->foto_keluar_path) }}" target="_blank" title="Foto saat keluar">
                                            <img src="{{ asset('storage/' . $izin->foto_keluar_path) }}" alt="Bukti keluar" width="48" height="48" style="object-fit:cover;border-radius:8px;" class="me-1">
                                        </a>
                                    @endif
                                    @if($izin->foto_kembali_path)
                                        <a href="{{ asset('storage/' . $izin->foto_kembali_path) }}" target="_blank" title="Foto saat kembali">
                                            <img src="{{ asset('storage/' . $izin->foto_kembali_path) }}" alt="Bukti kembali" width="48" height="48" style="object-fit:cover;border-radius:8px;">
                                        </a>
                                    @endif
                                    @if(!$izin->foto_keluar_path && !$izin->foto_kembali_path)
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Tidak ada riwayat izin keluar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($izinKeluar->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $izinKeluar->links() }}
                </div>
            @endif
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
    </style>
@endsection

@section('scripts')
    <script>
        function searchTable() {
            filterTable();
        }

        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;
            const table = document.getElementById('izinTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let showRow = true;

                // Search filter
                if (searchInput) {
                    let found = false;
                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j]) {
                            const textValue = cells[j].textContent || cells[j].innerText;
                            if (textValue.toLowerCase().indexOf(searchInput) > -1) {
                                found = true;
                                break;
                            }
                        }
                    }
                    if (!found) showRow = false;
                }

                // Status filter
                if (statusFilter && showRow) {
                    const rowStatus = row.getAttribute('data-status');
                    if (rowStatus !== statusFilter) showRow = false;
                }

                // Date filter
                if (dateFilter && showRow) {
                    const rowDate = row.getAttribute('data-date');
                    if (rowDate !== dateFilter) showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }
    </script>
@endsection
