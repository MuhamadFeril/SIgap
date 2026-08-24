<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[Hidden(['user_id'])]
class Guru extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'guru';

    protected $fillable = [
        'user_id',
        'mapel',
        'nip',
        'no_telepon',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function izinKeluarDisetujui()
    {
        return $this->hasMany(IzinKeluar::class, 'disetujui_oleh', 'user_id');
    }

    public function tukarShiftDisetujui()
    {
        return $this->hasMany(TukarShift::class, 'disetujui_oleh', 'user_id');
    }
}