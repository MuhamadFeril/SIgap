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
        'jam_kembali_rencana',
        'status',
        'disetujui_oleh',
        'waktu_keputusan',
        'jam_keluar_aktual',
        'jam_kembali_aktual',
        'terlambat',
        'foto_keluar_path',
        'foto_kembali_path',
        'dicatat_keluar_oleh',
        'dicatat_kembali_oleh',
    ];

    protected $casts = [
        'jam_keluar_rencana' => 'datetime:H:i:s',
        'jam_kembali_rencana' => 'datetime:H:i:s',
        'waktu_keputusan' => 'datetime',
        'jam_keluar_aktual' => 'datetime',
        'jam_kembali_aktual' => 'datetime',
        'terlambat' => 'boolean',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_SAKIT = 'sakit';

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_APPROVED,
            self::STATUS_REJECTED,
            self::STATUS_SAKIT,
        ];
    }

    public function isTerlambat(): bool
    {
        if (!$this->jam_kembali_rencana || !$this->jam_kembali_aktual) {
            return false;
        }

        return $this->jam_kembali_aktual->format('H:i:s') > $this->jam_kembali_rencana->format('H:i:s');
    }

    public function hitungTerlambat(): bool
    {
        $terlambat = $this->isTerlambat();
        if ($this->terlambat !== $terlambat) {
            $this->terlambat = $terlambat;
            $this->saveQuietly();
        }

        return $terlambat;
    }

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