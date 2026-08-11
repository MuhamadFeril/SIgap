<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[Hidden(['izin_id', 'dicatat_oleh'])]
class LogGerbang extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'log_gerbang';

    protected $fillable = [
        'izin_id',
        'tipe',
        'waktu',
        'dicatat_oleh',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public $timestamps = false;

    public function izin(): BelongsTo
    {
        return $this->belongsTo(IzinKeluar::class, 'izin_id');
    }

    public function dicatatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }

    public function scopeKeluar($query)
    {
        return $query->where('tipe', 'keluar');
    }

    public function scopeKembali($query)
    {
        return $query->where('tipe', 'kembali');
    }
}