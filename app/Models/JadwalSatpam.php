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
        'waktu_masuk',
        'waktu_pulang',
        'telat_masuk',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime',
        'waktu_masuk' => 'datetime',
        'waktu_pulang' => 'datetime',
        'telat_masuk' => 'boolean',
    ];

    public function getJamMasukAttribute($value)
    {
        if ($value) {
            return \Carbon\Carbon::parse($value);
        }
        if (!$this->tanggal || !$this->shift) {
            return null;
        }
        $times = [
            'pagi'  => '07:00:00',
            'siang' => '15:00:00',
            'malam' => '23:00:00',
        ];
        $time = $times[strtolower($this->shift)] ?? null;
        return $time ? \Carbon\Carbon::parse($this->tanggal->format('Y-m-d') . ' ' . $time) : null;
    }

    public function getJamPulangAttribute($value)
    {
        if ($value) {
            return \Carbon\Carbon::parse($value);
        }
        if (!$this->tanggal || !$this->shift) {
            return null;
        }
        $shift = strtolower($this->shift);
        if ($shift === 'pagi') {
            return \Carbon\Carbon::parse($this->tanggal->format('Y-m-d') . ' 15:00:00');
        } elseif ($shift === 'siang') {
            return \Carbon\Carbon::parse($this->tanggal->format('Y-m-d') . ' 23:00:00');
        } elseif ($shift === 'malam') {
            return \Carbon\Carbon::parse($this->tanggal->format('Y-m-d') . ' 07:00:00')->addDay();
        }
        return null;
    }

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