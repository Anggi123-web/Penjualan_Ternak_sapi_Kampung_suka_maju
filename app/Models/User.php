<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'nik', 'email', 'password', 'role', 'no_telepon', 'alamat', 'latitude', 'longitude', 'nomor_rekening', 'jenis_bank', 'foto_ktp', 'foto_selfie_ktp'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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

    public function isPeternak(): bool
    {
        return $this->role === 'peternak';
    }

    public function isPembeli(): bool
    {
        return $this->role === 'pembeli';
    }

    public function isMantriHewan(): bool
    {
        return $this->role === 'mantri_hewan';
    }

    public function isPengurusKampung(): bool
    {
        return $this->role === 'pengurus_kampung';
    }

    /**
     * Ulasan yang diterima oleh peternak dari pembeli
     */
    public function ulasanDiterima(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'peternak_id')->latest();
    }

    /**
     * Ulasan yang diberikan oleh pembeli
     */
    public function ulasanDiberikan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'pembeli_id')->latest();
    }

    /**
     * Rata-rata bintang ulasan peternak
     */
    public function getAverageRatingAttribute(): float
    {
        return (float) round($this->ulasanDiterima()->avg('rating') ?? 0, 1);
    }

    /**
     * Total jumlah ulasan peternak
     */
    public function getTotalUlasanAttribute(): int
    {
        return (int) $this->ulasanDiterima()->count();
    }

    /**
     * Sapi-sapi yang dimiliki oleh peternak
     */
    public function sapis(): HasMany
    {
        return $this->hasMany(Sapi::class, 'user_id');
    }

    /**
     * Sapi aktif yang siap dipasarkan
     */
    public function sapisAktif(): HasMany
    {
        return $this->hasMany(Sapi::class, 'user_id')->where('is_active', true);
    }

    /**
     * Total jumlah sapi milik peternak
     */
    public function getTotalSapiAttribute(): int
    {
        return $this->sapis()->count();
    }
}


