@extends('layouts.app')

@section('title', 'Surat Keterangan & Monitoring — Pengurus Kampung')

@section('styles')
<style>
    .monitoring-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .monitoring-stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .monitoring-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }

    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .filter-tab {
        padding: 0.6rem 1.15rem;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .filter-tab:hover {
        background: rgba(139, 92, 246, 0.12);
        color: #6d28d9;
        border-color: #8b5cf6;
    }
    [data-theme="dark"] .filter-tab:hover {
        background: rgba(139, 92, 246, 0.2);
        color: #c4b5fd;
    }

    .filter-tab.active {
        background: #ede9fe;
        color: #6d28d9;
        border-color: #8b5cf6;
        font-weight: 700;
    }
    [data-theme="dark"] .filter-tab.active {
        background: rgba(139, 92, 246, 0.25);
        color: #c4b5fd;
    }

    .order-box-aparat {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .order-box-aparat:hover {
        border-color: rgba(139, 92, 246, 0.35);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .order-header-aparat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.08);
        margin-bottom: 1.25rem;
    }

    .order-body-aparat {
        display: grid;
        grid-template-columns: 1fr 1fr 1.3fr;
        gap: 1.5rem;
    }

    @media (max-width: 991px) {
        .order-body-aparat {
            grid-template-columns: 1fr;
        }
    }

    .field-lbl {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .field-val {
        font-size: 0.92rem;
        color: var(--text-primary);
        font-weight: 600;
    }

    .order-subcard {
        background: var(--bg-muted, #f8fafc);
        border: 1px solid var(--border-color, #e2e8f0);
        padding: 1.1rem;
        border-radius: 12px;
    }

    [data-theme="dark"] .order-subcard {
        background: rgba(15, 23, 42, 0.5);
        border-color: rgba(148, 163, 184, 0.15);
    }

    .btn-action-outline {
        background: var(--bg-muted);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        padding: 0.6rem 0.9rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
    }

    .btn-action-outline:hover {
        background: var(--border-color);
    }

    .btn-release-surat {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.6rem 1.2rem;
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }

    [data-theme="dark"] .btn-release-surat {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .btn-release-surat:hover {
        opacity: 0.92;
        transform: translateY(-1px);
        color: white;
    }

    .modal-aparat {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.65);
        backdrop-filter: blur(4px);
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-aparat.open {
        display: flex;
    }

    .modal-aparat-card {
        background: var(--bg-card, #ffffff);
        border: 1px solid var(--border-color, #cbd5e1);
        border-radius: 16px;
        max-width: 560px;
        width: 100%;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    }

    [data-theme="dark"] .modal-aparat-card {
        background: #1e293b;
        border-color: rgba(148, 163, 184, 0.25);
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.6);
    }
</style>
@endsection

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;"><i class="bi bi-houses"></i> Pengurus Kampung</span>
    <div style="display: flex; align-items: center; gap: 8px;">
        @include('partials.theme_toggle', ['id' => 'monitoringMobileThemeToggle', 'iconOnly' => true])
        <button class="hamburger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    </div>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    @include('dashboard.partials.sidebar_pengurus_kampung')

    <main class="main-content">
        <div class="page-header">
            <h1>Surat Keterangan & Monitoring Pemesanan</h1>
            <p>Terbitkan Surat Keterangan Pembelian Sapi resmi dari Aparat Kampung untuk transaksi warga dan pantau status pengiriman ternak.</p>
        </div>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.15); border-left: 4px solid #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; color: var(--green-brand); display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Stat Cards --}}
        <div class="monitoring-grid">
            <div class="monitoring-stat-card">
                <div class="monitoring-stat-icon" style="background: var(--accent-purple-bg, rgba(139, 92, 246, 0.15)); color: var(--accent-purple, #8b5cf6);">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="field-lbl">Total Transaksi</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-heading);">{{ $counts['semua'] }}</div>
                </div>
            </div>
            <div class="monitoring-stat-card">
                <div class="monitoring-stat-icon" style="background: var(--accent-amber-bg, rgba(245, 158, 11, 0.15)); color: var(--accent-amber, #d97706);">
                    <i class="bi bi-file-earmark-medical"></i>
                </div>
                <div>
                    <div class="field-lbl">Perlu Surat Keterangan</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--accent-amber-text, #92400e);">{{ $counts['perlu_surat'] }}</div>
                </div>
            </div>
            <div class="monitoring-stat-card">
                <div class="monitoring-stat-icon" style="background: var(--green-subtle); color: var(--green-brand);">
                    <i class="bi bi-file-earmark-check-fill"></i>
                </div>
                <div>
                    <div class="field-lbl">Surat Telah Dirilis</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--green-brand);">{{ $counts['surat_rilis'] }}</div>
                </div>
            </div>
            <div class="monitoring-stat-card">
                <div class="monitoring-stat-icon" style="background: var(--accent-blue-bg, rgba(59, 130, 246, 0.15)); color: var(--accent-blue, #2563eb);">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div>
                    <div class="field-lbl">Pesanan Selesai</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--accent-blue-text, #1d4ed8);">{{ $counts['selesai'] }}</div>
                </div>
            </div>
        </div>

        {{-- Tabs Filter --}}
        <div class="filter-tabs">
            <a href="{{ route('pengurus_kampung.monitoring.index', ['tab' => 'semua']) }}" class="filter-tab {{ $tab === 'semua' ? 'active' : '' }}">
                <i class="bi bi-grid"></i> Semua Transaksi
                <span style="background: var(--border-color); color: var(--text-primary); padding: 2px 6px; border-radius: 999px; font-size: 0.75rem; font-weight: 700;">{{ $counts['semua'] }}</span>
            </a>
            <a href="{{ route('pengurus_kampung.monitoring.index', ['tab' => 'perlu_surat']) }}" class="filter-tab {{ $tab === 'perlu_surat' ? 'active' : '' }}">
                <i class="bi bi-hourglass-split"></i> Perlu Rilis Surat
                <span style="background: var(--accent-amber-bg, rgba(245, 158, 11, 0.25)); color: var(--accent-amber-text, #92400e); padding: 2px 6px; border-radius: 999px; font-size: 0.75rem; font-weight: 700;">{{ $counts['perlu_surat'] }}</span>
            </a>
            <a href="{{ route('pengurus_kampung.monitoring.index', ['tab' => 'surat_rilis']) }}" class="filter-tab {{ $tab === 'surat_rilis' ? 'active' : '' }}">
                <i class="bi bi-file-earmark-check"></i> Surat Sudah Dirilis
                <span style="background: var(--green-subtle); color: var(--green-brand); padding: 2px 6px; border-radius: 999px; font-size: 0.75rem; font-weight: 700;">{{ $counts['surat_rilis'] }}</span>
            </a>
            <a href="{{ route('pengurus_kampung.monitoring.index', ['tab' => 'selesai']) }}" class="filter-tab {{ $tab === 'selesai' ? 'active' : '' }}">
                <i class="bi bi-check-circle"></i> Selesai
                <span style="background: var(--border-color); color: var(--text-primary); padding: 2px 6px; border-radius: 999px; font-size: 0.75rem; font-weight: 700;">{{ $counts['selesai'] }}</span>
            </a>
        </div>

        {{-- Orders List --}}
        @if($orders->count() > 0)
            @foreach($orders as $order)
                @php
                    $meta = $order->status_meta;
                    $sapi = $order->sapi;
                    $pembeli = $order->pembeli;
                    $peternak = $sapi->peternak ?? null;
                    $hasSurat = !empty($order->surat_released_at);
                @endphp
                <div class="order-box-aparat">
                    {{-- Card Header --}}
                    <div class="order-header-aparat">
                        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                            <span style="color: var(--accent-purple-text, #6d28d9); font-weight: 700; font-family: monospace; font-size: 1rem;">
                                <i class="bi bi-receipt"></i> {{ $order->kode_transaksi }}
                            </span>
                            <span style="color: var(--text-secondary); font-size: 0.85rem;">
                                <i class="bi bi-calendar3"></i> {{ $order->created_at->format('d M Y, H:i') }}
                            </span>
                            <span style="background: var(--bg-muted); color: var(--text-primary); border: 1px solid var(--border-color); font-size: 0.75rem; font-weight: 700; padding: 2px 8px; border-radius: 4px;">
                                {{ strtoupper($order->tipe_penjualan) }}
                            </span>
                        </div>

                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            @if($hasSurat)
                                <span style="background: var(--green-subtle); color: var(--green-brand); border: 1px solid rgba(0, 167, 64, 0.3); padding: 4px 10px; border-radius: 999px; font-size: 0.78rem; font-weight: 700;">
                                    <i class="bi bi-patch-check-fill"></i> Surat Dirilis
                                </span>
                            @else
                                <span style="background: var(--accent-amber-bg, rgba(245, 158, 11, 0.15)); color: var(--accent-amber-text, #92400e); border: 1px solid rgba(245, 158, 11, 0.3); padding: 4px 10px; border-radius: 999px; font-size: 0.78rem; font-weight: 700;">
                                    <i class="bi bi-hourglass"></i> Belum Rilis Surat
                                </span>
                            @endif

                            <span class="badge-status-p" style="background: {{ $meta['bg'] }}; color: {{ $meta['color'] }}; border: 1px solid {{ $meta['border'] }};">
                                <i class="bi {{ $meta['icon'] }}"></i> {{ $meta['label'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="order-body-aparat">
                        {{-- 1. Cattle & Farmer --}}
                        <div class="order-subcard">
                            <div class="field-lbl"><i class="bi bi-piggy-bank"></i> Sapi & Peternak Wilayah</div>
                            <div style="font-size: 1.05rem; font-weight: 700; color: var(--text-heading); margin-bottom: 0.4rem;">
                                Sapi {{ $sapi->jenis ?? 'Ternak' }}
                            </div>
                            <div style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.6;">
                                Bobot: <strong style="color: var(--text-heading);">{{ $sapi->bobot ?? '-' }} kg</strong> | Umur: <strong style="color: var(--text-heading);">{{ $sapi->umur ?? '-' }} Bln</strong><br>
                                Peternak: <strong style="color: var(--green-brand);">{{ $peternak->name ?? '-' }}</strong><br>
                                Lokasi: {{ $sapi->lokasi ?? ($peternak->alamat ?? 'Kampung Suka Maju') }}
                            </div>
                        </div>

                        {{-- 2. Buyer & Transaction --}}
                        <div class="order-subcard">
                            <div class="field-lbl"><i class="bi bi-person"></i> Pembeli & Nilai Transaksi</div>
                            <div style="font-size: 1.05rem; font-weight: 700; color: var(--text-heading); margin-bottom: 0.4rem;">
                                {{ $pembeli->name ?? 'Pembeli' }}
                            </div>
                            <div style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.6;">
                                Kontak: <strong style="color: var(--text-heading);">{{ $pembeli->no_telepon ?? '-' }}</strong><br>
                                Nilai: <strong style="color: var(--green-brand);">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong> ({{ strtoupper($order->metode_pembayaran) }})<br>
                                @if($order->is_preorder)
                                    <span style="color: var(--accent-amber-text, #92400e); font-size: 0.8rem; font-weight: 600;">
                                        Pre-Order: DP Rp {{ number_format($order->dp, 0, ',', '.') }} &bull; 
                                        @if($order->is_lunas)
                                            <strong style="color: var(--green-brand);">LUNAS</strong>
                                        @else
                                            Sisa: Rp {{ number_format($order->sisa_pembayaran, 0, ',', '.') }}
                                        @endif
                                    </span><br>
                                @endif
                                Pengantaran: {{ $order->is_pengantaran ? 'Diantar ke ' . $order->detail_lokasi : 'Ambil di Kandang' }}
                            </div>
                        </div>

                        {{-- 3. Surat Keterangan Action & Status --}}
                        <div class="order-subcard" style="display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <div class="field-lbl"><i class="bi bi-file-earmark-text"></i> Administrasi Surat Aparat</div>
                                @if($hasSurat)
                                    <div style="background: var(--green-subtle); border: 1px solid rgba(0, 167, 64, 0.25); border-radius: 8px; padding: 0.65rem 0.85rem; margin-top: 4px;">
                                        <div style="font-size: 0.82rem; color: var(--green-brand); font-weight: 700;">
                                            <i class="bi bi-check-circle"></i> No: {{ $order->nomor_surat }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px;">
                                            Dirilis: {{ $order->surat_released_at->format('d/m/Y H:i') }} oleh {{ $order->aparat->name ?? 'Aparat Kampung' }}
                                        </div>
                                        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 6px;">
                                            <a href="{{ route('pesanan.surat_pdf', $order->id) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; background: rgba(0, 167, 64, 0.15); color: var(--green-brand); border: 1px solid rgba(0, 167, 64, 0.35); padding: 3px 8px; border-radius: 6px; font-size: 0.76rem; text-decoration: none; font-weight: 700;">
                                                <i class="bi bi-file-earmark-pdf-fill"></i> Cetak / Unduh PDF Resmi
                                            </a>
                                            @if($order->surat_keterangan && !str_ends_with($order->surat_keterangan, '.pdf'))
                                                <a href="{{ asset('storage/' . $order->surat_keterangan) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; color: var(--accent-blue-text, #1d4ed8); font-size: 0.76rem; text-decoration: none; font-weight: 600; padding: 3px 4px;">
                                                    <i class="bi bi-paperclip"></i> Berkas Scan
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div style="background: var(--accent-amber-bg, rgba(245, 158, 11, 0.08)); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 8px; padding: 0.65rem 0.85rem; margin-top: 4px; font-size: 0.8rem; color: var(--accent-amber-text, #92400e); font-weight: 600;">
                                        <i class="bi bi-exclamation-triangle"></i> Belum ada Surat Keterangan yang dirilis untuk transaksi ini.
                                    </div>
                                @endif
                            </div>

                            <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 8px;">
                                @php
                                    $romawiList = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                                    $romBulan = $romawiList[(int)date('n')] ?? 'XI';
                                    $defaultNomorSurat = '140 / ' . str_pad($order->id, 3, '0', STR_PAD_LEFT) . ' / SKMJ / ' . $romBulan . ' / ' . date('Y');
                                @endphp
                                <button type="button" class="btn-release-surat" onclick="openReleaseModal({{ $order->id }}, '{{ $order->kode_transaksi }}', '{{ $order->nomor_surat ?? $defaultNomorSurat }}', '{{ $pembeli->name }}', '{{ $sapi->jenis }}')">
                                    <i class="bi bi-file-earmark-plus"></i> {{ $hasSurat ? 'Update Berkas Surat' : 'Rilis Surat Keterangan Jalan Ternak' }}
                                </button>
                                
                                <button type="button" class="btn-action-outline" onclick="openUpdateModal({{ $order->id }}, '{{ $order->kode_transaksi }}', '{{ $order->status }}')">
                                    <i class="bi bi-pencil-square"></i> Catatan Monitoring
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Current note preview --}}
                    @if($order->catatan_status)
                        <div style="margin-top: 1rem; padding: 0.75rem 1rem; background: var(--bg-muted); border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.82rem; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-chat-left-text" style="color: var(--accent-purple, #8b5cf6);"></i>
                            <span><strong>Status Monitoring Terkini:</strong> {{ $order->catatan_status }}</span>
                        </div>
                    @endif
                </div>
            @endforeach

            <div style="margin-top: 1.5rem;">
                {{ $orders->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 4rem 2rem; background: var(--bg-card); border-radius: 16px; border: 1px dashed var(--border-color);">
                <i class="bi bi-inbox" style="font-size: 2.5rem; color: var(--text-muted);"></i>
                <h3 style="color: var(--text-heading); margin-top: 1rem; font-size: 1.15rem;">Tidak ada data pada filter ini</h3>
                <p style="color: var(--text-secondary); font-size: 0.9rem;">Transaksi yang telah dikonfirmasi akan muncul di sini untuk diterbitkan Surat Keterangannya.</p>
            </div>
        @endif
    </main>
</div>

{{-- Modal Upload & Rilis Surat Keterangan --}}
<div class="modal-aparat" id="modalReleaseSurat" onclick="closeReleaseModal(event)">
    <div class="modal-aparat-card" onclick="event.stopPropagation()">
        <form id="formReleaseSurat" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 0; color: var(--text-heading); font-size: 1.1rem; font-weight: 700;">
                    <i class="bi bi-file-earmark-check-fill" style="color: var(--accent-purple, #8b5cf6);"></i> Rilis Surat Keterangan Jalan Ternak
                </h4>
                <button type="button" onclick="closeReleaseModal()" style="background: none; border: none; color: var(--text-muted); font-size: 1.4rem; cursor: pointer;">&times;</button>
            </div>
            <div style="padding: 1.5rem;">
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0; margin-bottom: 1.25rem; line-height: 1.5;">
                    Surat Keterangan Jalan Ternak diterbitkan secara resmi oleh Kepala Kampung Sukamaju sebagai bukti legalitas kepemilikan dan lalu lintas pengangkutan ternak sapi kepada pembeli <strong id="modalBuyerName" style="color: var(--text-heading);"></strong> untuk <strong id="modalCattleBreed" style="color: var(--text-heading);"></strong>.
                </p>

                <div style="margin-bottom: 1rem;">
                    <label class="field-lbl">Nomor Surat Resmi <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="nomor_surat" id="modalNomorSurat" required style="width: 100%; padding: 0.6rem 0.85rem; background: var(--input-bg); border: 1px solid var(--input-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; outline: none;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label class="field-lbl">Unggah Berkas Scan Fisik (Opsional)</label>
                    <input type="file" name="surat_file" accept=".pdf,.jpg,.jpeg,.png,.webp" style="width: 100%; padding: 0.5rem; background: var(--input-bg); border: 1px solid var(--input-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem;">
                    <span style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px; display: block; line-height: 1.4;">
                        <i class="bi bi-info-circle" style="color: var(--accent-blue, #2563eb);"></i> Jika tidak diunggah, sistem otomatis men-generate dokumen PDF resmi ber-kop Surat Pemerintah Kampung Suka Maju secara digital.
                    </span>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label class="field-lbl">Catatan Tambahan Aparat (Opsional)</label>
                    <textarea name="catatan_aparat" rows="2" placeholder="Catatan ke pembeli & peternak..." style="width: 100%; padding: 0.6rem 0.85rem; background: var(--input-bg); border: 1px solid var(--input-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; outline: none;"></textarea>
                </div>
            </div>
            <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem; background: var(--bg-muted);">
                <button type="button" onclick="closeReleaseModal()" style="background: var(--bg-card); color: var(--text-secondary); border: 1px solid var(--border-color); padding: 0.6rem 1.2rem; border-radius: 8px; cursor: pointer; font-weight: 600;">Batal</button>
                <button type="submit" class="btn-release-surat">
                    <i class="bi bi-check2-circle"></i> Terbitkan & Rilis Surat
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Update Catatan Monitoring --}}
<div class="modal-aparat" id="modalUpdateMonitoring" onclick="closeUpdateModal(event)">
    <div class="modal-aparat-card" onclick="event.stopPropagation()">
        <form id="formUpdateMonitoring" method="POST">
            @csrf
            @method('PUT')
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 0; color: var(--text-heading); font-size: 1.1rem; font-weight: 700;">
                    <i class="bi bi-pencil-square" style="color: var(--accent-blue, #2563eb);"></i> Perbarui Monitoring Pesanan
                </h4>
                <button type="button" onclick="closeUpdateModal()" style="background: none; border: none; color: var(--text-muted); font-size: 1.4rem; cursor: pointer;">&times;</button>
            </div>
            <div style="padding: 1.5rem;">
                <div style="margin-bottom: 1rem;">
                    <label class="field-lbl">Status Pesanan</label>
                    <select name="status" id="modalStatusSelect" style="width: 100%; padding: 0.6rem 0.85rem; background: var(--input-bg); border: 1px solid var(--input-border); border-radius: 8px; color: var(--text-primary); font-size: 0.9rem; outline: none;">
                        <option value="diproses">Pembayaran Terkonfirmasi & Diproses</option>
                        <option value="dikirim">Pengiriman Armada / Siap Diambil</option>
                        <option value="selesai">Pesanan Selesai</option>
                    </select>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label class="field-lbl">Catatan Monitoring Wilayah <span style="color: #ef4444;">*</span></label>
                    <textarea name="catatan_status" rows="3" required placeholder="Tuliskan catatan perkembangan pengantaran / ternak sapi..." style="width: 100%; padding: 0.6rem 0.85rem; background: var(--input-bg); border: 1px solid var(--input-border); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; outline: none;"></textarea>
                </div>
            </div>
            <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem; background: var(--bg-muted);">
                <button type="button" onclick="closeUpdateModal()" style="background: var(--bg-card); color: var(--text-secondary); border: 1px solid var(--border-color); padding: 0.6rem 1.2rem; border-radius: 8px; cursor: pointer; font-weight: 600;">Batal</button>
                <button type="submit" style="background: var(--accent-blue, #2563eb); color: #ffffff; font-weight: 700; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; cursor: pointer;">
                    <i class="bi bi-save"></i> Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('open');
    }

    function openReleaseModal(id, kode, nomor, buyer, breed) {
        document.getElementById('modalBuyerName').innerText = buyer;
        document.getElementById('modalCattleBreed').innerText = 'Sapi ' + breed;
        document.getElementById('modalNomorSurat').value = nomor;
        document.getElementById('formReleaseSurat').action = '/pengurus-kampung/monitoring/' + id + '/surat';
        document.getElementById('modalReleaseSurat').classList.add('open');
    }

    function closeReleaseModal(e) {
        if (!e || e.target.id === 'modalReleaseSurat') {
            document.getElementById('modalReleaseSurat').classList.remove('open');
        }
    }

    function openUpdateModal(id, kode, currentStatus) {
        document.getElementById('modalStatusSelect').value = currentStatus;
        document.getElementById('formUpdateMonitoring').action = '/pengurus-kampung/monitoring/' + id + '/update';
        document.getElementById('modalUpdateMonitoring').classList.add('open');
    }

    function closeUpdateModal(e) {
        if (!e || e.target.id === 'modalUpdateMonitoring') {
            document.getElementById('modalUpdateMonitoring').classList.remove('open');
        }
    }
</script>
@endsection
