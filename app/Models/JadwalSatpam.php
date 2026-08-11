<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[Hidden(['satpam_id'])]
class JadwalSatpam extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jadwal_satpam';

    protected $fillable = [
        'satpam_id',
        'tanggal',
        'shift',
        'status_hadir',
        'jam_masuk',
        'jam_pulang',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime',
    ];

    public function satpam(): BelongsTo
    {
        return $this->belongsTo(Satpam::class);
    }

    public function tukarShift()
    {
        return $this->hasMany(TukarShift::class, 'jadwal_id');
    }

    public function scopePagi($query)
    {
        return $query->where('shift', 'pagi');
    }

    public function scopeSiang($query)
    {
        return $query->where('shift', 'siang');
    }

    public function scopeMalam($query)
    {
        return $query->where('shift', 'malam');
    }

    public function scopeHadir($query)
    {
        return $query->where('status_hadir', 'hadir');
    }

    public function scopeBelumPresensi($query)
    {
        return $query->where('status_hadir', 'belum_presensi');
    }
}