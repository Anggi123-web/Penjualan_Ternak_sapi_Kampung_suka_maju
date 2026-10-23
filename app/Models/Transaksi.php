<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'sapi_id',
        'tipe_penjualan',
        'harga_sapi',
        'dp',
        'fase_pembayaran',
        'is_pengantaran',
        'tanggal_pengambilan',
        'durasi_perawatan_hari',
        'biaya_perawatan',
        'detail_lokasi',
        'latitude',
        'longitude',
        'jarak_km',
        'ongkir',
        'total_harga',
        'dibayarkan',
        'sisa_pembayaran',
        'jumlah_pelunasan',
        'metode_pembayaran',
        'catatan',
        'bukti_pembayaran',
        'bukti_pelunasan',
        'status',
        'status_updated_at',
        'pembeli_read_at',
        'catatan_status',
        'surat_keterangan',
        'nomor_surat',
        'surat_released_at',
        'surat_aparat_id',
    ];

    protected function casts(): array
    {
        return [
            'is_pengantaran' => 'boolean',
            'tanggal_pengambilan' => 'date',
            'durasi_perawatan_hari' => 'integer',
            'biaya_perawatan' => 'integer',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'jarak_km' => 'decimal:2',
            'harga_sapi' => 'integer',
            'dp' => 'integer',
            'ongkir' => 'integer',
            'total_harga' => 'integer',
            'dibayarkan' => 'integer',
            'sisa_pembayaran' => 'integer',
            'jumlah_pelunasan' => 'integer',
            'status_updated_at' => 'datetime',
            'pembeli_read_at' => 'datetime',
            'surat_released_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sapi(): BelongsTo
    {
        return $this->belongsTo(Sapi::class, 'sapi_id')->withTrashed();
    }

    public function aparat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'surat_aparat_id');
    }

    public function ulasan(): HasOne
    {
        return $this->hasOne(Ulasan::class, 'transaksi_id');
    }

    public function getIsReviewedAttribute(): bool
    {
        return $this->ulasan !== null;
    }

    public function getHasSuratAttribute(): bool
    {
        return !empty($this->surat_keterangan) || !empty($this->surat_released_at);
    }

    public function getTotalHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getDibayarkanFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->dibayarkan, 0, ',', '.');
    }

    public function getSisaPembayaranFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->sisa_pembayaran, 0, ',', '.');
    }

    public function getOngkirFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->ongkir, 0, ',', '.');
    }

    public function getDpFormattedAttribute(): string
    {
        return $this->dp ? 'Rp ' . number_format($this->dp, 0, ',', '.') : 'Rp 0';
    }

    public function getJumlahPelunasanFormattedAttribute(): string
    {
        return $this->jumlah_pelunasan ? 'Rp ' . number_format($this->jumlah_pelunasan, 0, ',', '.') : 'Rp 0';
    }

    public function getIsPreorderAttribute(): bool
    {
        return $this->tipe_penjualan === 'pre_order';
    }

    public function getIsLunasAttribute(): bool
    {
        if (!$this->is_preorder) {
            return $this->status !== 'menunggu_pembayaran';
        }
        return $this->fase_pembayaran === 'lunas' || $this->sisa_pembayaran <= 0;
    }

    public function getIsMenungguVerifikasiPelunasanAttribute(): bool
    {
        return $this->is_preorder 
            && $this->sisa_pembayaran > 0 
            && !empty($this->bukti_pelunasan) 
            && $this->fase_pembayaran !== 'lunas';
    }

    public function getCanPelunasanAttribute(): bool
    {
        return $this->is_preorder 
            && $this->sisa_pembayaran > 0 
            && in_array($this->status, ['diproses', 'dikirim']) 
            && empty($this->bukti_pelunasan) 
            && $this->fase_pembayaran !== 'lunas';
    }

    public function getStatusMetaAttribute(): array
    {
        return match ($this->status) {
            'menunggu_pembayaran' => [
                'label' => 'Menunggu Pembayaran',
                'bg' => 'rgba(245, 158, 11, 0.12)',
                'color' => '#d97706',
                'border' => 'rgba(245, 158, 11, 0.3)',
                'icon' => 'bi-clock-history',
                'step' => 2,
                'subtext' => 'Silakan segera transfer dan unggah bukti pembayaran Anda.',
            ],
            'menunggu_verifikasi' => [
                'label' => 'Menunggu Konfirmasi Peternak',
                'bg' => 'rgba(59, 130, 246, 0.12)',
                'color' => '#2563eb',
                'border' => 'rgba(59, 130, 246, 0.3)',
                'icon' => 'bi-hourglass-split',
                'step' => 2,
                'subtext' => 'Bukti pembayaran telah diunggah dan sedang diverifikasi oleh peternak.',
            ],
            'diproses' => [
                'label' => 'Pembayaran Dikonfirmasi & Sedang Diproses',
                'bg' => 'rgba(16, 185, 129, 0.12)',
                'color' => '#059669',
                'border' => 'rgba(16, 185, 129, 0.3)',
                'icon' => 'bi-gear-wide-connected',
                'step' => 3,
                'subtext' => 'Hewan sapi sedang disiapkan dan dicek kesehatannya di kandang peternak.',
            ],
            'dikirim' => [
                'label' => $this->is_pengantaran ? 'Sedang Dikirim ke Lokasi' : 'Siap Diambil di Kandang',
                'bg' => 'rgba(139, 92, 246, 0.12)',
                'color' => '#7c3aed',
                'border' => 'rgba(139, 92, 246, 0.3)',
                'icon' => $this->is_pengantaran ? 'bi-truck' : 'bi-geo-alt-fill',
                'step' => 4,
                'subtext' => $this->is_pengantaran ? 'Hewan ternak dalam perjalanan armada pengantaran.' : 'Hewan ternak telah siap di kandang untuk Anda jemput.',
            ],
            'selesai' => [
                'label' => 'Pesanan Selesai',
                'bg' => 'rgba(16, 185, 129, 0.15)',
                'color' => '#047857',
                'border' => 'rgba(16, 185, 129, 0.35)',
                'icon' => 'bi-check-circle-fill',
                'step' => 5,
                'subtext' => 'Pesanan ternak sapi telah selesai dan diterima dengan baik.',
            ],
            'dibatalkan' => [
                'label' => 'Pesanan Dibatalkan',
                'bg' => 'rgba(239, 68, 68, 0.12)',
                'color' => '#dc2626',
                'border' => 'rgba(239, 68, 68, 0.3)',
                'icon' => 'bi-x-circle-fill',
                'step' => 0,
                'subtext' => 'Pesanan ini telah dibatalkan.',
            ],
            default => [
                'label' => ucfirst($this->status),
                'bg' => '#f1f5f9',
                'color' => '#64748b',
                'border' => '#cbd5e1',
                'icon' => 'bi-info-circle',
                'step' => 1,
                'subtext' => '',
            ]
        };
    }

    public function getIsUnreadForBuyerAttribute(): bool
    {
        if (!$this->pembeli_read_at) {
            return true;
        }
        return $this->status_updated_at && $this->status_updated_at->gt($this->pembeli_read_at);
    }
}
