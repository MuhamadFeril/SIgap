<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[Hidden(['jadwal_id', 'jadwal_penerima_id', 'pengaju_id', 'penerima_id', 'disetujui_oleh'])]
class TukarShift extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tukar_shift';

    protected $fillable = [
        'jadwal_id',
        'jadwal_penerima_id',
        'pengaju_id',
        'penerima_id',
        'status',
        'disetujui_oleh',
    ];

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalSatpam::class, 'jadwal_id');
    }

    public function jadwalPenerima(): BelongsTo
    {
        return $this->belongsTo(JadwalSatpam::class, 'jadwal_penerima_id');
    }

    public function pengaju(): BelongsTo
    {
        return $this->belongsTo(Satpam::class, 'pengaju_id');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(Satpam::class, 'penerima_id');
    }

    public function disetujuiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
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