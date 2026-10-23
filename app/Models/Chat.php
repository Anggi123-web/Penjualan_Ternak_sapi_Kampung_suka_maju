<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengirim_id',
        'penerima_id',
        'transaksi_id',
        'sapi_id',
        'pesan',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function sapi(): BelongsTo
    {
        return $this->belongsTo(Sapi::class, 'sapi_id')->withTrashed();
    }

    /**
     * Scope percakapan antara dua pengguna
     */
    public function scopeBetweenUsers($query, $user1, $user2)
    {
        return $query->where(function ($q) use ($user1, $user2) {
            $q->where('pengirim_id', $user1)->where('penerima_id', $user2);
        })->orWhere(function ($q) use ($user1, $user2) {
            $q->where('pengirim_id', $user2)->where('penerima_id', $user1);
        });
    }

    public function getWaktuFormattedAttribute(): string
    {
        if ($this->created_at->isToday()) {
            return $this->created_at->format('H:i');
        } elseif ($this->created_at->isYesterday()) {
            return 'Kemarin, ' . $this->created_at->format('H:i');
        }
        return $this->created_at->format('d M, H:i');
    }
}
