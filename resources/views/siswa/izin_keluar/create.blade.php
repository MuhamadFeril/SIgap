@extends('layouts.app')

@section('title', 'Buat Izin Keluar')
@section('user-role', $siswa->kelas ?? 'Siswa')

@section('sidebar')
    <li>
        <a href="{{ route('siswa.dashboard') }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('siswa.izin_keluar.index') }}" class="active">
            <i class="bi bi-box-arrow-right"></i> Izin Keluar
        </a>
    </li>
@endsection

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5><i class="bi bi-plus-circle"></i> Buat Permohonan Izin Keluar</h5>
                        <a href="{{ route('siswa.izin_keluar.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="content-card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('siswa.izin_keluar.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="alasan" class="form-label">Alasan Keluar <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="alasan" name="alasan" rows="4" required placeholder="Jelaskan alasan Anda ingin keluar dari sekolah...">{{ old('alasan') }}</textarea>
                                <div class="help-text">Jelaskan secara singkat dan jelas alasan izin keluar Anda</div>
                            </div>

                            <div class="mb-4">
                                <label for="jam_keluar_rencana" class="form-label">Jam Keluar Rencana <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="jam_keluar_rencana" name="jam_keluar_rencana" required value="{{ old('jam_keluar_rencana') }}">
                                <div class="help-text">Pilih jam rencana keluar Anda</div>
                            </div>

                            <div class="mb-4">
                                <label for="jam_kembali_rencana" class="form-label">Jam Kembali Rencana <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="jam_kembali_rencana" name="jam_kembali_rencana" required value="{{ old('jam_kembali_rencana') }}">
                                <div class="help-text">Pilih jam rencana kembali. Jika melebihi ini, akan dicatat sebagai "Telat".</div>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label">Deskripsi Tambahan</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Keterangan tambahan (opsional)">{{ old('deskripsi') }}</textarea>
                                <div class="help-text">Tambahkan keterangan jika diperlukan</div>
                            </div>

                            <div class="mb-4">
                                <label for="bukti" class="form-label">Foto Bukti</label>
                                <input type="file" class="form-control" id="bukti" name="bukti" accept="image/*" onchange="if(this.files.length){document.getElementById('preview').src=URL.createObjectURL(this.files[0]);document.getElementById('preview').style.display='block';}">
                                <div class="help-text">Unggah foto sebagai bukti izin (mis. surat orang tua), opsional</div>
                                <img id="preview" src="#" alt="Pratinjau bukti" style="display:none; margin-top:12px; max-width:220px; border-radius:10px; border:1px solid var(--line);">
                            </div>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> <strong>Informasi:</strong> Permohonan izin keluar akan disetujui oleh guru dan dicatat oleh satpam saat Anda keluar dan kembali.
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Kirim Permohonan
                                </button>
                                <a href="{{ route('siswa.izin_keluar.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
