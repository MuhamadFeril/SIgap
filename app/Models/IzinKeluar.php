<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[Hidden(['siswa_id', 'disetujui_oleh', 'dicatat_keluar_oleh', 'dicatat_kembali_oleh'])]
class IzinKeluar extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'izin_keluar';

    protected $fillable = [
        'siswa_id',
        'alasan',
        'deskripsi',
        'bukti_path',
        'jam_keluar_rencana',
        'status',
        'disetujui_oleh',
        'waktu_keputusan',
        'jam_keluar_aktual',
        'jam_kembali_aktual',
        'foto_keluar_path',
        'foto_kembali_path',
        'dicatat_keluar_oleh',
        'dicatat_kembali_oleh',
    ];

    protected $casts = [
        'jam_keluar_rencana' => 'datetime:H:i:s',
        'waktu_keputusan' => 'datetime',
        'jam_keluar_aktual' => 'datetime',
        'jam_kembali_aktual' => 'datetime',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function disetujuiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function dicatatKeluarOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_keluar_oleh');
    }

    public function dicatatKembaliOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_kembali_oleh');
    }

    public function logGerbang()
    {
        return $this->hasMany(LogGerbang::class, 'izin_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}