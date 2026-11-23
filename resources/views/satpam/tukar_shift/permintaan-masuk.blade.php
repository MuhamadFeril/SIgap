@extends('layouts.app')

@section('title', 'Permintaan Masuk')

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
        <a href="{{ route('satpam.jadwal.index') }}">
            <i class="bi bi-calendar-check"></i> Jadwal Jaga
        </a>
    </li>
    <li>
        <a href="{{ route('satpam.tukar_shift.index') }}" class="active">
            <i class="bi bi-arrow-left-right"></i> Tukar Shift
        </a>
    </li>
@endsection

@section('content')
    <div class="content-card">
        <div class="content-card-header">
            <h5><i class="bi bi-inbox"></i> Permintaan Masuk</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('satpam.tukar_shift.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left-right"></i> Permintaan Saya
                </a>
                <a href="{{ route('satpam.tukar_shift.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Permintaan
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
                    <div class="stat-value">{{ $statusCounts['pending'] ?? 0 }}</div>
                    <div class="stat-label">Menunggu</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $statusCounts['approved'] ?? 0 }}</div>
                    <div class="stat-label">Disetujui</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $statusCounts['rejected'] ?? 0 }}</div>
                    <div class="stat-label">Ditolak</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $permintaanMasuk->total() }}</div>
                    <div class="stat-label">Total</div>
                </div>
            </div>

            <div class="filter-row">
                <select class="form-select" style="width: auto;" id="statusFilter" onchange="filterTable()">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="table" id="permintaanTable">
                    <thead>
                        <tr>
                            <th>Dari</th>
                            <th>Tanggal</th>
                            <th>Shift</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permintaanMasuk as $tukar)
                            <tr data-status="{{ $tukar->status }}">
                                <td>
                                    <strong>{{ $tukar->pengaju?->user?->name ?? '-' }}</strong>
                                </td>
                                <td>
                                    {{ $tukar->jadwal?->tanggal?->locale('id')->translatedFormat('d M Y') ?? '-' }}
                                </td>
                                <td>
                                    {{ ucfirst($tukar->jadwal?->shift ?? '-') }}
                                </td>
                                <td>
                                    @if($tukar->status === 'pending')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif($tukar->status === 'approved')
                                        <span class="badge badge-success">Disetujui</span>
                                    @elseif($tukar->status === 'rejected')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @else
                                        <span class="badge badge-info">{{ ucfirst($tukar->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('satpam.tukar_shift.show', $tukar) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($tukar->status === 'pending')
                                            @php($jadwalSaya = $tukar?->penerima?->jadwalSatpam->where('tanggal', '>=', \Carbon\Carbon::today())->sortBy('tanggal'))
                                            @if($jadwalSaya->isNotEmpty())
                                                <form action="{{ route('satpam.tukar_shift.approve', $tukar) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <select name="jadwal_penerima_id" class="form-select form-select-sm d-inline-block align-middle" style="width:auto;" required title="Pilih jadwal Anda yang diberikan balik">
                                                        <option value="">Jadwal tukar balik</option>
                                                        @foreach($jadwalSaya as $js)
                                                            <option value="{{ $js->id }}">{{ $js->tanggal?->locale('id')->translatedFormat('d M Y') }} — {{ ucfirst($js->shift) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="btn btn-success" onclick="return confirm('Setujui dan tukar shift ini?')">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">Tidak ada jadwal untuk ditukar</span>
                                            @endif
                                            <form action="{{ route('satpam.tukar_shift.reject', $tukar) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak permintaan tukar shift ini?')">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Tidak ada permintaan masuk</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($permintaanMasuk->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $permintaanMasuk->links() }}
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

        .filter-row .form-select {
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
            const statusFilter = document.getElementById('statusFilter').value;
            const table = document.getElementById('permintaanTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                let showRow = true;

                if (statusFilter && showRow) {
                    const rowStatus = row.getAttribute('data-status');
                    if (rowStatus !== statusFilter) showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }
    </script>
@endsection
