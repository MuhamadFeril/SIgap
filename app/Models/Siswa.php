<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[Hidden(['user_id'])]
class Siswa extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'kelas',
        'nomor_absen',
        'foto_profil_path',
        'nis',
        'no_telepon',
        'alamat',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function izinKeluar()
    {
        return $this->hasMany(IzinKeluar::class);
    }
}
