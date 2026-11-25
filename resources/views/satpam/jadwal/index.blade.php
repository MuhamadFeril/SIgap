@extends('layouts.app')

@section('title', 'Jadwal Jaga')

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
            <h5><i class="bi bi-calendar-check"></i> Jadwal Jaga</h5>
            <a href="{{ route('satpam.jadwal.riwayat') }}" class="btn btn-outline-primary">
                <i class="bi bi-clock-history"></i> Riwayat Presensi
            </a>
        </div>
        <div class="content-card-body">
            <div class="week-navigator">
                <button onclick="changeWeek(-1)">
                    <i class="bi bi-chevron-left"></i> Minggu Lalu
                </button>
                <span class="week-range" id="weekRange">
                    {{ $startDate->locale('id')->translatedFormat('d M Y') }} - {{ $endDate->locale('id')->translatedFormat('d M Y') }}
                </span>
                <button onclick="changeWeek(1)">
                    Minggu Depan <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            @forelse($jadwalSatpam as $jadwal)
                <div class="shift-card {{ $jadwal->tanggal->isToday() ? 'today' : '' }} {{ $jadwal->waktu_pulang ? 'completed' : '' }}">
                    <div class="shift-header">
                        <div>
                            <div class="shift-day">
                                {{ $jadwal->tanggal->locale('id')->translatedFormat('l') }}
                                @if($jadwal->tanggal->isToday())
                                    <span class="badge badge-warning ms-2">Hari Ini</span>
                                @endif
                            </div>
                            <div class="shift-date">{{ $jadwal->tanggal->locale('id')->translatedFormat('d F Y') }}</div>
                        </div>
                        <div>
                            @if($jadwal->shift)
                                <span class="badge badge-info">{{ ucfirst($jadwal->shift) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="shift-time">
                        <i class="bi bi-clock"></i>
                        <span>{{ $jadwal->jam_masuk?->format('H:i') ?? '-' }} - {{ $jadwal->jam_pulang?->format('H:i') ?? '-' }}</span>
                    </div>

                    <div class="shift-status">
                        @if($jadwal->waktu_masuk && $jadwal->waktu_pulang)
                            <span class="badge badge-success">
                                <i class="bi bi-check-circle"></i> Selesai
                            </span>
                        @elseif($jadwal->waktu_masuk)
                            <span class="badge badge-info">
                                <i class="bi bi-circle"></i> Sedang Bertugas
                            </span>
                        @elseif($jadwal->tanggal->isPast())
                            <span class="badge badge-danger">
                                <i class="bi bi-x-circle"></i> Tidak Hadir
                            </span>
                        @elseif($jadwal->tanggal->isToday())
                            <span class="badge badge-warning">
                                <i class="bi bi-clock"></i> Belum Presensi
                            </span>
                        @else
                            <span class="badge badge-secondary">
                                <i class="bi bi-calendar"></i> Akan Datang
                            </span>
                        @endif
                    </div>

                    @if($jadwal->tanggal->isToday() || $jadwal->tanggal->isPast())
                        <div class="d-flex gap-2">
                            @if(!$jadwal->waktu_masuk)
                                <form action="{{ route('satpam.jadwal.presensi_masuk', $jadwal) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" {{ $jadwal->tanggal->isPast() ? 'disabled' : '' }} onclick="return confirm('Presensi masuk untuk shift ini?')">
                                        <i class="bi bi-box-arrow-in-right"></i> Presensi Masuk
                                    </button>
                                </form>
                            @elseif(!$jadwal->waktu_pulang)
                                @php
                                    $bisaPulang = !$jadwal->jam_pulang || now()->gte($jadwal->jam_pulang);
                                @endphp
                                <form action="{{ route('satpam.jadwal.presensi_pulang', $jadwal) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm" {{ !$bisaPulang ? 'disabled' : '' }} onclick="return confirm('Presensi pulang untuk shift ini?')">
                                        <i class="bi bi-box-arrow-right"></i> Presensi Pulang
                                    </button>
                                </form>
                                @if(!$bisaPulang && $jadwal->jam_pulang)
                                    <small class="text-muted d-block mt-1"><i class="bi bi-info-circle me-1"></i>Belum waktunya pulang (jam {{ $jadwal->jam_pulang->format('H:i') }})</small>
                                @endif
                            @endif
                        </div>
                    @endif

                    @if($jadwal->waktu_masuk)
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-clock-history"></i> Masuk: {{ $jadwal->waktu_masuk->format('H:i') }}
                                @if($jadwal->waktu_pulang)
                                    | Pulang: {{ $jadwal->waktu_pulang->format('H:i') }}
                                @endif
                            </small>
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <p>Tidak ada jadwal jaga untuk minggu ini</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .shift-card {
            background: var(--mint);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            border-left: 4px solid var(--pine);
        }

        .shift-card.today {
            border-left-color: var(--amber);
            background: #fef3e7;
        }

        .shift-card.completed {
            border-left-color: var(--pine);
            opacity: 0.7;
        }

        .shift-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .shift-day {
            font-weight: 600;
            color: var(--ink);
            font-size: 16px;
        }

        .shift-date {
            font-size: 12px;
            color: var(--ink-soft);
        }

        .shift-time {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .shift-time i {
            color: var(--pine);
        }

        .shift-status {
            font-size: 13px;
            margin-bottom: 12px;
        }

        .week-navigator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .week-navigator button {
            background: var(--surface);
            border: 1px solid var(--line);
            padding: 8px 16px;
            border-radius: 8px;
            color: var(--ink);
            font-weight: 500;
        }

        .week-navigator button:hover {
            border-color: var(--pine);
            color: var(--pine);
        }

        .week-range {
            font-weight: 600;
            color: var(--ink);
        }
    </style>
@endsection

@section('scripts')
    <script>
        function changeWeek(direction) {
            const currentUrl = new URL(window.location.href);
            const currentOffset = parseInt(currentUrl.searchParams.get('week_offset') || '0');
            const newOffset = currentOffset + direction;
            currentUrl.searchParams.set('week_offset', newOffset);
            window.location.href = currentUrl.toString();
        }
    </script>
@endsection
