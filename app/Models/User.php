<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'nik', 'email', 'password', 'role', 'status_verifikasi', 'tanggal_verifikasi', 'diverifikasi_oleh', 'alasan_penolakan', 'wa_notifikasi_terkirim_at', 'no_telepon', 'alamat', 'latitude', 'longitude', 'nomor_rekening', 'jenis_bank', 'foto_ktp', 'foto_selfie_ktp'])]
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
            'tanggal_verifikasi' => 'datetime',
            'wa_notifikasi_terkirim_at' => 'datetime',
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

    public function isMenungguVerifikasi(): bool
    {
        return $this->role === 'peternak' && $this->status_verifikasi === 'menunggu_verifikasi';
    }

    public function isTerverifikasi(): bool
    {
        return $this->status_verifikasi === 'terverifikasi';
    }

    public function isDitolak(): bool
    {
        return $this->role === 'peternak' && $this->status_verifikasi === 'ditolak';
    }

    public function diverifikasiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    public function formatNomorWa(): string
    {
        $phone = preg_replace('/[^0-9]/', '', (string)$this->no_telepon);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62') && !empty($phone)) {
            $phone = '62' . $phone;
        }
        return $phone;
    }

    public function generateWhatsAppAktivasiUrl(): string
    {
        $phone = $this->formatNomorWa();
        $loginUrl = url('/login');
        
        $pesan = "📢 *PEMBERITAHUAN AKTIVASI AKUN PETERNAK*\n"
               . "*PEMERINTAHAN KAMPUNG SUKA MAJU*\n"
               . "━━━━━━━━━━━━━━━━━━━━\n\n"
               . "Halo Bpk/Ibu *" . $this->name . "*,\n\n"
               . "Selamat! Pendaftaran akun Peternak Anda di *Sistem Penjualan Ternak Sapi Kampung Suka Maju* telah *DISETUJUI & DIVERIFIKASI* oleh Aparat Pemerintahan Kampung.\n\n"
               . "📋 *Rincian Akun Peternak:*\n"
               . "• Nama: " . $this->name . "\n"
               . "• NIK: " . ($this->nik ?: '-') . "\n"
               . "• Email Login: " . $this->email . "\n"
               . "• No. WhatsApp: " . ($this->no_telepon ?: '-') . "\n"
               . "• Status: ✅ *TERVERIFIKASI & AKTIF*\n\n"
               . "Sekarang Anda dapat masuk ke sistem untuk mendaftarkan dan menjual ternak sapi Anda:\n"
               . "👉 " . $loginUrl . "\n\n"
               . "_Gunakan email dan password yang Anda buat saat registrasi._\n\n"
               . "Jika ada pertanyaan atau kendala, silakan hubungi Kantor Pemerintahan Kampung Suka Maju.\n\n"
               . "Terima kasih,\n"
               . "*Aparat Pemerintahan Kampung Suka Maju*";

        return "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . urlencode($pesan);
    }

    public function generateWhatsAppPenolakanUrl(?string $alasan = null): string
    {
        $phone = $this->formatNomorWa();
        $alasanText = $alasan ?: ($this->alasan_penolakan ?: 'Data pendaftaran belum memenuhi syarat administrasi');

        $pesan = "⚠️ *PEMBERITAHUAN PENDAFTARAN AKUN PETERNAK*\n"
               . "*PEMERINTAHAN KAMPUNG SUKA MAJU*\n"
               . "━━━━━━━━━━━━━━━━━━━━\n\n"
               . "Halo Bpk/Ibu *" . $this->name . "*,\n\n"
               . "Mohon maaf, pendaftaran akun Peternak Anda di Sistem Penjualan Ternak Sapi Kampung Suka Maju saat ini *BELUM DAPAT DISETUJUI*.\n\n"
               . "📌 *Catatan / Alasan:*\n"
               . "{$alasanText}\n\n"
               . "Silakan hubungi Kantor Kampung Suka Maju untuk verifikasi berkas lebih lanjut atau lakukan pendaftaran ulang dengan data yang benar:\n"
               . "👉 " . url('/register') . "\n\n"
               . "Terima kasih,\n"
               . "*Aparat Pemerintahan Kampung Suka Maju*";

        return "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . urlencode($pesan);
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


