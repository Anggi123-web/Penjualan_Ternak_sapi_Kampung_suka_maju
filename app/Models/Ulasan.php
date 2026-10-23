<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ulasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'pembeli_id',
        'peternak_id',
        'sapi_id',
        'rating',
        'komentar',
        'kategori',
        'foto',
        'balasan_peternak',
        'balasan_at',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'kategori' => 'array',
            'balasan_at' => 'datetime',
        ];
    }

    /**
     * Transaksi terkait
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    /**
     * Pembeli yang memberikan ulasan
     */
    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }

    /**
     * Peternak yang diulas
     */
    public function peternak(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peternak_id');
    }

    /**
     * Sapi yang dibeli
     */
    public function sapi(): BelongsTo
    {
        return $this->belongsTo(Sapi::class, 'sapi_id')->withTrashed();
    }
}
