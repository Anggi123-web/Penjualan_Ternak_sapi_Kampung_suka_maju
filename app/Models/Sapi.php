<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sapi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis',
        'umur',
        'bobot',
        'harga',
        'foto',
        'video',
        'catatan_kesehatan',
        'status_kesehatan',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'bobot' => 'decimal:2',
            'harga' => 'integer',
            'umur' => 'integer',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Peternak pemilik sapi
     */
    public function peternak(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mantri Hewan yang memverifikasi
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Format harga ke Rupiah
     */
    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Format umur ke teks
     */
    public function getUmurFormattedAttribute(): string
    {
        if ($this->umur >= 12) {
            $tahun = floor($this->umur / 12);
            $bulan = $this->umur % 12;
            return $bulan > 0 ? "{$tahun} tahun {$bulan} bulan" : "{$tahun} tahun";
        }
        return "{$this->umur} bulan";
    }
}
