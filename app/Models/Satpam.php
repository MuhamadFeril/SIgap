<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[Hidden(['user_id'])]
class Satpam extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'satpam';

    protected $fillable = [
        'user_id',
        'nip',
        'no_telepon',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalSatpam()
    {
        return $this->hasMany(JadwalSatpam::class);
    }

    public function tukarShiftPengaju()
    {
        return $this->hasMany(TukarShift::class, 'pengaju_id');
    }

    public function tukarShiftPenerima()
    {
        return $this->hasMany(TukarShift::class, 'penerima_id');
    }

    public function izinKeluarDicatatKeluar()
    {
        return $this->hasMany(IzinKeluar::class, 'dicatat_keluar_oleh', 'user_id');
    }

    public function izinKeluarDicatatKembali()
    {
        return $this->hasMany(IzinKeluar::class, 'dicatat_kembali_oleh', 'user_id');
    }

    public function logGerbang()
    {
        return $this->hasMany(LogGerbang::class, 'dicatat_oleh', 'user_id');
    }
}