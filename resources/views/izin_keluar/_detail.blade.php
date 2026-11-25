<div class="content-card">
    <div class="content-card-header">
        <h5><i class="bi bi-file-text"></i> Detail Izin Keluar</h5>
        @isset($backRoute)
            <a href="{{ route($backRoute) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        @endisset
    </div>
    <div class="content-card-body">
        <div class="row mb-3">
            <div class="col-md-2 text-center">
                @if($izinKeluar->siswa?->foto_profil_path)
                    <img src="{{ asset('storage/' . $izinKeluar->siswa->foto_profil_path) }}" alt="Foto {{ $izinKeluar->siswa?->user?->name ?? 'siswa' }}" width="88" height="88" style="object-fit:cover;border-radius:50%; border:2px solid var(--line);">
                @else
                    <div class="user-avatar mx-auto" style="width:88px;height:88px;font-size:32px;">
                        {{ substr($izinKeluar->siswa?->user?->name ?? '?', 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="col-md-10">
                <h4 style="font-family:'Space Grotesk',sans-serif;font-weight:700;margin:0;">{{ $izinKeluar->siswa?->user?->name ?? '-' }}</h4>
                <div class="text-muted" style="font-size:14px;">
                    Kelas {{ $izinKeluar->siswa?->kelas ?? '-' }}
                    @if($izinKeluar->siswa?->nis) · NIS {{ $izinKeluar->siswa->nis }} @endif
                </div>
                <div class="mt-2">
                    @if($izinKeluar->status === 'pending')
                        <span class="badge badge-warning">Menunggu Persetujuan</span>
                    @elseif($izinKeluar->status === 'approved')
                        <span class="badge badge-success">Disetujui</span>
                    @elseif($izinKeluar->status === 'rejected')
                        <span class="badge badge-danger">Ditolak</span>
                    @else
                        <span class="badge badge-info">{{ ucfirst($izinKeluar->status) }}</span>
                    @endif
                </div>
            </div>
        </div>

        <hr style="border-color: var(--line);">

        <div class="detail-row">
            <div class="detail-label">Alasan</div>
            <div class="detail-value">{{ $izinKeluar->alasan ?? '-' }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Deskripsi</div>
            <div class="detail-value">{{ $izinKeluar->deskripsi ?? '-' }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Jam Keluar Rencana</div>
            <div class="detail-value">{{ $izinKeluar->jam_keluar_rencana?->locale('id')->translatedFormat('d F Y H:i') ?? ($izinKeluar->jam_keluar_rencana ?? '-') }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Jam Kembali Rencana</div>
            <div class="detail-value">{{ $izinKeluar->jam_kembali_rencana?->locale('id')->translatedFormat('d F Y H:i') ?? ($izinKeluar->jam_kembali_rencana?->format('H:i') ?? '-') }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Bukti (Siswa)</div>
            <div class="detail-value">
                @if($izinKeluar->bukti_path)
                    @php($buktiVideo = in_array(strtolower(pathinfo($izinKeluar->bukti_path, PATHINFO_EXTENSION)), ['mp4', 'mov', 'webm']))
                    <a href="{{ asset('storage/' . $izinKeluar->bukti_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-paperclip"></i> {{ $buktiVideo ? 'Putar video bukti' : 'Lihat foto bukti' }}
                    </a>
                @else
                    <span class="text-muted">Tidak ada</span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Disetujui Oleh</div>
            <div class="detail-value">
                @if($izinKeluar->disetujuiOleh)
                    {{ $izinKeluar->disetujuiOleh->name }}
                    @if($izinKeluar->waktu_keputusan)
                        <span class="text-muted">({{ $izinKeluar->waktu_keputusan->locale('id')->translatedFormat('d F Y H:i') }})</span>
                    @endif
                @else
                    <span class="text-muted">-</span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Jam Keluar Aktual</div>
            <div class="detail-value">
                @if($izinKeluar->jam_keluar_aktual)
                    {{ $izinKeluar->jam_keluar_aktual->locale('id')->translatedFormat('d F Y H:i') }}
                    @if($izinKeluar->dicatatKeluarOleh) <span class="text-muted">({{ $izinKeluar->dicatatKeluarOleh->name }})</span> @endif
                @else
                    <span class="text-muted">Belum keluar</span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Jam Kembali Aktual</div>
            <div class="detail-value">
                @if($izinKeluar->jam_kembali_aktual)
                    {{ $izinKeluar->jam_kembali_aktual->locale('id')->translatedFormat('d F Y H:i') }}
                    @if($izinKeluar->dicatatKembaliOleh) <span class="text-muted">({{ $izinKeluar->dicatatKembaliOleh->name }})</span> @endif
                @else
                    <span class="text-muted">Belum kembali</span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Status Keterlambatan</div>
            <div class="detail-value">
                @if(!$izinKeluar->jam_kembali_aktual)
                    <span class="badge badge-warning">Belum Kembali</span>
                @elseif($izinKeluar->terlambat)
                    <span class="badge badge-danger">Telat</span>
                @else
                    <span class="badge badge-success">Tepat Waktu</span>
                @endif
            </div>
        </div>

        <div class="detail-row" style="flex-wrap:wrap; gap:16px;">
            <div class="detail-label" style="width:100%;">Foto Bukti Satpam</div>
            <div class="detail-value d-flex gap-3 flex-wrap">
                @if($izinKeluar->foto_keluar_path)
                    <div>
                        <div class="text-muted mb-1" style="font-size:12px;">Saat Keluar</div>
                        <a href="{{ asset('storage/' . $izinKeluar->foto_keluar_path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $izinKeluar->foto_keluar_path) }}" alt="Bukti keluar" width="140" height="140" style="object-fit:cover;border-radius:10px;border:1px solid var(--line);">
                        </a>
                    </div>
                @endif
                @if($izinKeluar->foto_kembali_path)
                    <div>
                        <div class="text-muted mb-1" style="font-size:12px;">Saat Kembali</div>
                        <a href="{{ asset('storage/' . $izinKeluar->foto_kembali_path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $izinKeluar->foto_kembali_path) }}" alt="Bukti kembali" width="140" height="140" style="object-fit:cover;border-radius:10px;border:1px solid var(--line);">
                        </a>
                    </div>
                @endif
                @if(!$izinKeluar->foto_keluar_path && !$izinKeluar->foto_kembali_path)
                    <span class="text-muted">Belum ada foto bukti dari satpam</span>
                @endif
            </div>
        </div>
    </div>
</div>
