@extends('layouts.app')

@section('title', 'Tukar Shift')

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
            <h5><i class="bi bi-arrow-left-right"></i> Permintaan Tukar Shift</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('satpam.tukar_shift.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Permintaan
                </a>
                <a href="{{ route('satpam.tukar_shift.permintaan_masuk') }}" class="btn btn-outline-primary">
                    <i class="bi bi-inbox"></i> Permintaan Masuk
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

            <div class="filter-row">
                <select class="form-select" style="width: auto;" id="statusFilter" onchange="filterTable()">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="table" id="tukarTable">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Shift Saya</th>
                            <th>Tukar Dengan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tukarShifts as $tukar)
                            <tr data-status="{{ $tukar->status }}">
                                <td>
                                    <strong>{{ $tukar->jadwal?->tanggal?->locale('id')->translatedFormat('d M Y') ?? '-' }}</strong>
                                </td>
                                <td>
                                    {{ ucfirst($tukar->jadwal?->shift ?? '-') }}
                                </td>
                                <td>
                                    @if($tukar->penerima)
                                        <strong>{{ $tukar?->penerima?->user?->name ?? '-' }}</strong>
                                    @else
                                        <span class="text-muted">Belum dipilih</span>
                                    @endif
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
                                            <form action="{{ route('satpam.tukar_shift.destroy', $tukar) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Batalkan permintaan tukar shift ini?')">
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
                                        <p>Belum ada permintaan tukar shift</p>
                                        <a href="{{ route('satpam.tukar_shift.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> Buat Permintaan
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tukarShifts->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $tukarShifts->links() }}
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
    </style>
@endsection

@section('scripts')
    <script>
        function filterTable() {
            const statusFilter = document.getElementById('statusFilter').value;
            const table = document.getElementById('tukarTable');
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
