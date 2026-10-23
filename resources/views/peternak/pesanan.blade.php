@extends('layouts.peternak', ['title' => 'Pesanan Masuk — Sistem Penjualan Sapi'])

@section('page-styles')
<style>
    .pesanan-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .pesanan-filter-tabs {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .filter-tab-item {
        padding: 0.55rem 1rem;
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 10px;
        color: #94a3b8;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .filter-tab-item:hover {
        background: rgba(16, 185, 129, 0.1);
        color: #6ee7b7;
        border-color: rgba(16, 185, 129, 0.3);
    }

    .filter-tab-item.active {
        background: rgba(16, 185, 129, 0.2);
        color: #6ee7b7;
        border-color: #10b981;
    }

    .tab-counter {
        background: rgba(255, 255, 255, 0.1);
        padding: 2px 7px;
        border-radius: 999px;
        font-size: 0.75rem;
    }

    .order-card-peternak {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .order-card-peternak:hover {
        border-color: rgba(16, 185, 129, 0.3);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    }

    .order-top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.08);
        margin-bottom: 1.25rem;
    }

    .order-main-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1.2fr;
        gap: 1.5rem;
    }

    @media (max-width: 991px) {
        .order-main-grid {
            grid-template-columns: 1fr;
        }
    }

    .info-label {
        font-size: 0.75rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 0.95rem;
        color: #f1f5f9;
        font-weight: 600;
    }

    .badge-status-p {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .btn-update-status {
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-update-status:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .modal-proof-dark {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.8);
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-proof-dark.open {
        display: flex;
    }

    .modal-proof-dark-content {
        background: #1e293b;
        border: 1px solid rgba(148, 163, 184, 0.2);
        border-radius: 16px;
        max-width: 500px;
        width: 100%;
        overflow: hidden;
    }
</style>
@endsection

@section('page-content')
<div class="page-header">
    <h1>Pesanan Masuk</h1>
    <p>Kelola pesanan sapi dari pembeli, verifikasi pembayaran, dan perbarui status pengiriman.</p>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.15); border-left: 4px solid #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; color: #6ee7b7; display: flex; align-items: center; gap: 8px;">
        <i class="bi bi-check-circle-fill"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

{{-- Filter Tabs --}}
<div class="pesanan-filter-tabs">
    <a href="{{ route('peternak.pesanan', ['tab' => 'semua']) }}" class="filter-tab-item {{ $tab === 'semua' ? 'active' : '' }}">
        <i class="bi bi-grid"></i> Semua
        <span class="tab-counter">{{ $counts['semua'] }}</span>
    </a>
    <a href="{{ route('peternak.pesanan', ['tab' => 'menunggu_verifikasi']) }}" class="filter-tab-item {{ $tab === 'menunggu_verifikasi' ? 'active' : '' }}">
        <i class="bi bi-hourglass-split"></i> Perlu Verifikasi
        <span class="tab-counter" style="background: rgba(59, 130, 246, 0.3); color: #93c5fd;">{{ $counts['menunggu_verifikasi'] }}</span>
    </a>
    <a href="{{ route('peternak.pesanan', ['tab' => 'diproses']) }}" class="filter-tab-item {{ $tab === 'diproses' ? 'active' : '' }}">
        <i class="bi bi-gear-fill"></i> Sedang Diproses
        <span class="tab-counter">{{ $counts['diproses'] }}</span>
    </a>
    <a href="{{ route('peternak.pesanan', ['tab' => 'dikirim']) }}" class="filter-tab-item {{ $tab === 'dikirim' ? 'active' : '' }}">
        <i class="bi bi-truck"></i> Pengiriman
        <span class="tab-counter">{{ $counts['dikirim'] }}</span>
    </a>
    <a href="{{ route('peternak.pesanan', ['tab' => 'selesai']) }}" class="filter-tab-item {{ $tab === 'selesai' ? 'active' : '' }}">
        <i class="bi bi-check-circle-fill"></i> Selesai
        <span class="tab-counter">{{ $counts['selesai'] }}</span>
    </a>
</div>

{{-- Orders List --}}
@if($orders->count() > 0)
    @foreach($orders as $order)
        @php
            $meta = $order->status_meta;
            $sapi = $order->sapi;
            $pembeli = $order->pembeli;
        @endphp
        <div class="order-card-peternak">
            <div class="order-top-row">
                <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                    <span style="color: #6ee7b7; font-weight: 700; font-family: monospace; font-size: 1rem;">
                        <i class="bi bi-receipt"></i> {{ $order->kode_transaksi }}
                    </span>
                    <span style="color: #94a3b8; font-size: 0.85rem;">
                        <i class="bi bi-clock"></i> {{ $order->created_at->format('d M Y, H:i') }}
                    </span>
                    <span style="background: rgba(255,255,255,0.05); color: #cbd5e1; font-size: 0.75rem; padding: 2px 8px; border-radius: 4px;">
                        Tipe: {{ strtoupper($order->tipe_penjualan) }}
                    </span>
                </div>

                <div>
                    <span class="badge-status-p" style="background: {{ $meta['bg'] }}; color: {{ $meta['color'] }}; border: 1px solid {{ $meta['border'] }};">
                        <i class="bi {{ $meta['icon'] }}"></i> {{ $meta['label'] }}
                    </span>
                </div>
            </div>

            <div class="order-main-grid">
                {{-- Col 1: Sapi Info --}}
                <div style="background: rgba(15, 23, 42, 0.4); padding: 1rem; border-radius: 12px;">
                    <div class="info-label"><i class="bi bi-piggy-bank"></i> Informasi Hewan Sapi</div>
                    <div style="font-size: 1.05rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.5rem;">
                        Sapi {{ $sapi->jenis ?? 'Ternak' }}
                    </div>
                    <div style="font-size: 0.85rem; color: #94a3b8; line-height: 1.6;">
                        Bobot: <strong style="color: #f1f5f9;">{{ $sapi->bobot ?? '-' }} kg</strong><br>
                        Umur: <strong style="color: #f1f5f9;">{{ $sapi->umur ?? '-' }} Bulan</strong><br>
                        Harga Sapi: <strong style="color: #6ee7b7;">Rp {{ number_format($order->harga_sapi, 0, ',', '.') }}</strong>
                    </div>
                </div>

                {{-- Col 2: Buyer & Delivery --}}
                <div style="background: rgba(15, 23, 42, 0.4); padding: 1rem; border-radius: 12px; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div class="info-label"><i class="bi bi-person"></i> Data Pembeli & Pengiriman</div>
                        <div style="font-size: 1.05rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.25rem;">
                            {{ $pembeli->name ?? 'Pembeli' }}
                        </div>
                        <div style="font-size: 0.85rem; color: #94a3b8; line-height: 1.5;">
                            <i class="bi bi-telephone"></i> {{ $pembeli->no_telepon ?? '-' }}<br>
                            <i class="bi bi-truck"></i> {{ $order->is_pengantaran ? 'Diantar ke Lokasi' : 'Ambil di Kandang' }}<br>
                            @if($order->tanggal_pengambilan)
                                <span style="color: #f59e0b; font-weight: 700;">
                                    <i class="bi bi-calendar-event"></i> Jadwal: {{ \Carbon\Carbon::parse($order->tanggal_pengambilan)->translatedFormat('d M Y') }} ({{ $order->durasi_perawatan_hari }} Hari PO)
                                </span><br>
                            @endif
                            @if($order->biaya_perawatan > 0)
                                <span style="color: #fbbf24;">Biaya Rawat: Rp {{ number_format($order->biaya_perawatan, 0, ',', '.') }}</span><br>
                            @endif
                            @if($order->is_pengantaran)
                                <span style="color: #cbd5e1;">Tujuan: {{ $order->detail_lokasi }} ({{ $order->jarak_km }} km)</span><br>
                                <span style="color: #6ee7b7;">Ongkir: Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                    @if($pembeli)
                        <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid rgba(148, 163, 184, 0.1);">
                            <button type="button" onclick="openChatWith({{ $pembeli->id }}, '{{ addslashes($pembeli->name) }}', 'Pembeli', {{ $order->id }}, {{ $order->sapi_id ?? 'null' }}, 'Sapi {{ addslashes($sapi->jenis ?? 'Ternak') }} ({{ $order->kode_transaksi }})', '{{ $sapi && !empty($sapi->foto) ? (is_array($sapi->foto) ? asset('storage/'.$sapi->foto[0]) : asset('storage/'.json_decode($sapi->foto, true)[0])) : asset('images/default_sapi.jpg') }}')" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 7px 12px; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; width: 100%; justify-content: center; transition: all 0.2s;">
                                <i class="bi bi-chat-dots-fill"></i> Chat Pembeli
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Col 3: Payment & Status Update Action --}}
                <div style="background: rgba(15, 23, 42, 0.4); padding: 1rem; border-radius: 12px; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div class="info-label"><i class="bi bi-wallet2"></i> Status Pembayaran</div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 4px;">
                            <span style="color: #94a3b8;">Total Tagihan:</span>
                            <strong style="color: #6ee7b7;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                        </div>
                        @if($order->is_preorder)
                            <div style="display: flex; justify-content: space-between; font-size: 0.82rem; margin-bottom: 3px;">
                                <span style="color: #94a3b8;">DP (Tahap 1):</span>
                                <strong style="color: #34d399;">Rp {{ number_format($order->dp, 0, ',', '.') }}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.82rem; margin-bottom: 4px;">
                                <span style="color: #94a3b8;">Sisa Pelunasan:</span>
                                <strong style="color: {{ $order->is_lunas ? '#6ee7b7' : '#fbbf24' }};">
                                    {{ $order->is_lunas ? 'Rp 0 (Lunas)' : 'Rp ' . number_format($order->sisa_pembayaran, 0, ',', '.') }}
                                </strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.82rem; margin-bottom: 6px;">
                                <span style="color: #94a3b8;">Status Bayar:</span>
                                @if($order->is_lunas)
                                    <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 1px 8px; border-radius: 4px; font-weight: 700; font-size: 0.75rem;">
                                        <i class="bi bi-patch-check-fill"></i> LUNAS 100%
                                    </span>
                                @elseif($order->bukti_pelunasan)
                                    <span style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; padding: 1px 8px; border-radius: 4px; font-weight: 700; font-size: 0.75rem;">
                                        <i class="bi bi-hourglass-split"></i> Verifikasi Pelunasan
                                    </span>
                                @else
                                    <span style="background: rgba(239, 68, 68, 0.15); color: #f87171; padding: 1px 8px; border-radius: 4px; font-weight: 600; font-size: 0.75rem;">
                                        Belum Lunas
                                    </span>
                                @endif
                            </div>
                        @else
                            <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 4px;">
                                <span style="color: #94a3b8;">Metode:</span>
                                <span style="color: #f1f5f9;">{{ strtoupper($order->metode_pembayaran) }}</span>
                            </div>
                        @endif

                        <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 4px;">
                            @if($order->bukti_pembayaran)
                                <button type="button" onclick="openProofModalPeternak('{{ asset('storage/' . $order->bukti_pembayaran) }}')" style="background: rgba(59, 130, 246, 0.15); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3); padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="bi bi-image"></i> {{ $order->is_preorder ? 'Bukti DP' : 'Bukti Bayar' }}
                                </button>
                            @endif

                            @if($order->bukti_pelunasan)
                                <button type="button" onclick="openProofModalPeternak('{{ asset('storage/' . $order->bukti_pelunasan) }}')" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="bi bi-receipt-cutoff"></i> Bukti Pelunasan
                                </button>
                            @endif
                        </div>

                        {{-- Tombol Konfirmasi Pelunasan Cepat untuk Pre-Order --}}
                        @if($order->is_preorder && !$order->is_lunas)
                            <form action="{{ route('peternak.pesanan.konfirmasi_pelunasan', $order->id) }}" method="POST" style="margin-top: 8px;" onsubmit="return confirm('Konfirmasi bahwa sisa pembayaran sebesar Rp {{ number_format($order->sisa_pembayaran, 0, ',', '.') }} telah diterima dan pesanan ini berstatus LUNAS?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" style="width: 100%; padding: 0.45rem; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 6px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 4px; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);">
                                    <i class="bi bi-check-circle-fill"></i> Konfirmasi Pelunasan Lunas
                                </button>
                            </form>
                        @endif

                        {{-- Status Surat Keterangan dari Aparat --}}
                        <div style="margin-top: 0.65rem; padding-top: 0.65rem; border-top: 1px solid rgba(148, 163, 184, 0.08);">
                            <div class="info-label"><i class="bi bi-file-earmark-check"></i> Surat Keterangan Aparat</div>
                            @if($order->surat_released_at)
                                <div style="color: #6ee7b7; font-size: 0.8rem; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                    <i class="bi bi-patch-check-fill"></i> Rilis (No: {{ $order->nomor_surat }})
                                </div>
                                <a href="{{ route('pesanan.surat_pdf', $order->id) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; color: #38bdf8; font-size: 0.78rem; text-decoration: none; margin-top: 4px; font-weight: 600;">
                                    <i class="bi bi-file-earmark-pdf-fill"></i> Cetak / Unduh PDF Surat
                                </a>
                            @else
                                <div style="color: #fcd34d; font-size: 0.8rem; display: flex; align-items: center; gap: 4px;">
                                    <i class="bi bi-hourglass-split"></i> Menunggu Rilis Aparat
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Status Change Form --}}
                    <div style="margin-top: 1rem; padding-top: 0.75rem; border-top: 1px solid rgba(148, 163, 184, 0.1);">
                        <form action="{{ route('peternak.pesanan.update_status', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div style="display: flex; gap: 6px; margin-bottom: 6px;">
                                <select name="status" style="flex: 1; padding: 0.5rem; background: #0f172a; border: 1px solid rgba(148, 163, 184, 0.2); border-radius: 8px; color: #f1f5f9; font-size: 0.85rem; outline: none;">
                                    <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Konfirmasi / Diproses</option>
                                    <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Kirim Sapi / Siap Ambil</option>
                                    <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Pesanan Selesai</option>
                                    <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Batalkan Pesanan</option>
                                </select>
                                <button type="submit" class="btn-update-status">
                                    <i class="bi bi-check2"></i> Simpan
                                </button>
                            </div>
                            <input type="text" name="catatan_status" value="{{ $order->catatan_status }}" placeholder="Catatan ke pembeli (opsional)..." style="width: 100%; padding: 0.4rem 0.6rem; background: #0f172a; border: 1px solid rgba(148, 163, 184, 0.15); border-radius: 6px; color: #cbd5e1; font-size: 0.8rem; outline: none;">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div style="margin-top: 1.5rem;">
        {{ $orders->links() }}
    </div>
@else
    <div style="text-align: center; padding: 4rem 2rem; background: rgba(30, 41, 59, 0.5); border-radius: 16px; border: 1px dashed rgba(148, 163, 184, 0.1);">
        <i class="bi bi-inbox" style="font-size: 2.5rem; color: #64748b;"></i>
        <h3 style="color: #f1f5f9; margin-top: 1rem; font-size: 1.15rem;">Belum ada pesanan pada filter ini</h3>
        <p style="color: #94a3b8; font-size: 0.9rem;">Pesanan baru dari pembeli akan muncul di sini secara otomatis.</p>
    </div>
@endif

{{-- Modal Proof Peternak --}}
<div class="modal-proof-dark" id="proofModalPeternak" onclick="closeProofModalPeternak(event)">
    <div class="modal-proof-dark-content" onclick="event.stopPropagation()">
        <div style="padding: 1rem 1.25rem; border-bottom: 1px solid rgba(148, 163, 184, 0.1); display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0; color: #f1f5f9; font-size: 1rem;">Bukti Transfer Pembayaran</h4>
            <button type="button" onclick="closeProofModalPeternak()" style="background: none; border: none; color: #94a3b8; font-size: 1.25rem; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 1rem; text-align: center; max-height: 70vh; overflow-y: auto;">
            <img id="imgProofPeternak" src="" alt="Bukti Transfer" style="max-width: 100%; height: auto; border-radius: 8px;">
        </div>
        <div style="padding: 0.75rem 1.25rem; border-top: 1px solid rgba(148, 163, 184, 0.1); text-align: right;">
            <button type="button" onclick="closeProofModalPeternak()" style="background: rgba(148, 163, 184, 0.15); color: #f1f5f9; border: none; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer;">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openProofModalPeternak(src) {
        document.getElementById('imgProofPeternak').src = src;
        document.getElementById('proofModalPeternak').classList.add('open');
    }

    function closeProofModalPeternak(e) {
        if (!e || e.target.id === 'proofModalPeternak') {
            document.getElementById('proofModalPeternak').classList.remove('open');
        }
    }
</script>
@endsection
