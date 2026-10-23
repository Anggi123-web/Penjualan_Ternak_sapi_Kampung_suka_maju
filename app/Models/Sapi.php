<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sapi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'jenis',
        'umur',
        'bobot',
        'harga',
        'foto',
        'video',
        'tipe_penjualan',
        'status_penjualan',
        'preorder_bulan',
        'preorder_tahun',
        'biaya_perawatan_harian',
        'latitude',
        'longitude',
        'lokasi',
        'catatan_kesehatan',
        'dokumen_pemeriksaan',
        'status_kesehatan',
        'is_active',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'bobot' => 'decimal:2',
            'harga' => 'integer',
            'umur' => 'integer',
            'preorder_bulan' => 'integer',
            'preorder_tahun' => 'integer',
            'biaya_perawatan_harian' => 'integer',
            'is_active' => 'boolean',
            'verified_at' => 'datetime',
            'foto' => 'array',
            'video' => 'array',
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
     * Ulasan yang diterima oleh sapi ini
     */
    public function ulasans(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'sapi_id')->latest();
    }

    /**
     * Transaksi terkait sapi ini
     */
    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'sapi_id');
    }

    /**
     * Transaksi aktif terkait sapi ini (tidak dibatalkan)
     */
    public function transaksiAktif()
    {
        return $this->hasOne(Transaksi::class, 'sapi_id')->where('status', '!=', 'dibatalkan')->latestOfMany();
    }

    /**
     * Scope untuk sapi yang masih tersedia (aktif dan belum terjual/dipesan)
     */
    public function scopeTersedia($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('status_penjualan')
                  ->orWhere('status_penjualan', 'tersedia');
            })
            ->whereDoesntHave('transaksis', function ($tq) {
                $tq->where('status', '!=', 'dibatalkan');
            });
    }

    /**
     * Scope untuk sapi yang sudah terjual / dipesan
     */
    public function scopeTerjual($query)
    {
        return $query->where(function ($q) {
            $q->where('status_penjualan', 'terjual')
              ->orWhereHas('transaksis', function ($tq) {
                  $tq->where('status', '!=', 'dibatalkan');
              });
        });
    }

    /**
     * Cek apakah sapi sudah terjual / sedang dipesan
     */
    public function getIsTerjualAttribute(): bool
    {
        return $this->status_penjualan === 'terjual' 
            || $this->transaksis()->where('status', '!=', 'dibatalkan')->exists();
    }

    /**
     * Cek apakah sapi masih tersedia untuk dibeli
     */
    public function getIsTersediaAttribute(): bool
    {
        return !$this->is_terjual && $this->is_active;
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

    /**
     * Cek apakah tipe penjualan adalah pre-order
     */
    public function getIsPreorderAttribute(): bool
    {
        return $this->tipe_penjualan === 'pre_order';
    }

    /**
     * Label pre-order lengkap, misal "Pre-Order Bulan Juni"
     */
    public function getPreorderLabelAttribute(): string
    {
        if (!$this->is_preorder || !$this->preorder_bulan) {
            return '';
        }

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $bulan = $namaBulan[$this->preorder_bulan] ?? '';
        return "Pre-Order Bulan {$bulan}";
    }

    /**
     * Label tipe penjualan untuk tampilan
     */
    public function getTipePenjualanLabelAttribute(): string
    {
        return $this->tipe_penjualan === 'pre_order' ? 'Pre-Order' : 'Order';
    }

    /**
     * Format biaya perawatan harian ke rupiah
     */
    public function getBiayaPerawatanHarianFormattedAttribute(): string
    {
        $biaya = $this->biaya_perawatan_harian ?: 25000;
        return 'Rp ' . number_format($biaya, 0, ',', '.');
    }

    /**
     * Get the first photo path or null
     */
    public function getFirstFotoAttribute(): ?string
    {
        if (is_array($this->foto)) {
            return count($this->foto) > 0 ? $this->foto[0] : null;
        }
        return $this->foto;
    }

    /**
     * Get the first video path or null
     */
    public function getFirstVideoAttribute(): ?string
    {
        if (is_array($this->video)) {
            return count($this->video) > 0 ? $this->video[0] : null;
        }
        return $this->video;
    }
}
