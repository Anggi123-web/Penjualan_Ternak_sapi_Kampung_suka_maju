<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis',
        'judul',
        'gambar',
        'deskripsi',
        'konten_edukasi',
        'is_active',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'konten_edukasi' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
