<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


#[Fillable(['name', 'email', 'password', 'role', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids ;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function siswa(): HasOne
    {
        return $this->hasOne(Siswa::class);
    }

    public function guru(): HasOne
    {
        return $this->hasOne(Guru::class);
    }

    public function satpam(): HasOne
    {
        return $this->hasOne(Satpam::class);
    }

    public function izinKeluarDisetujui()
    {
        return $this->hasMany(IzinKeluar::class, 'disetujui_oleh');
    }

    public function izinKeluarDicatatKeluar()
    {
        return $this->hasMany(IzinKeluar::class, 'dicatat_keluar_oleh');
    }

    public function izinKeluarDicatatKembali()
    {
        return $this->hasMany(IzinKeluar::class, 'dicatat_kembali_oleh');
    }

    public function tukarShiftDisetujui()
    {
        return $this->hasMany(TukarShift::class, 'disetujui_oleh');
    }

    public function logGerbang()
    {
        return $this->hasMany(LogGerbang::class, 'dicatat_oleh');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSatpam(): bool
    {
        return $this->role === 'satpam';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }
}
