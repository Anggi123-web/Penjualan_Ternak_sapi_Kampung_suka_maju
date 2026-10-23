@extends('layouts.app')

@section('title', 'Profil Peternak: ' . $peternak->name . ' — Pengurus Kampung')

@section('styles')
<!-- Leaflet CSS for maps -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    .profile-layout {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 1.75rem;
        margin-top: 1.5rem;
    }

    @media (max-width: 1080px) {
        .profile-layout {
            grid-template-columns: 1fr;
        }
    }

    .profile-sidebar-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 1.75rem;
        height: fit-content;
    }

    .profile-avatar-large {
        width: 84px;
        height: 84px;
        border-radius: 22px;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        color: #ffffff;
        font-weight: 800;
        font-size: 2.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.4);
    }

    .detail-section-title {
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
        margin-top: 1.5rem;
        margin-bottom: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .data-row {
        display: flex;
        justify-content: space-between;
        padding: 0.65rem 0;
        border-bottom: 1px solid rgba(148, 163, 184, 0.08);
        font-size: 0.88rem;
    }

    .data-row:last-child {
        border-bottom: none;
    }

    .data-label {
        color: #94a3b8;
    }

    .data-value {
        font-weight: 600;
        color: #f1f5f9;
        text-align: right;
    }

    .ktp-preview-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .ktp-thumb {
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(148, 163, 184, 0.15);
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
        aspect-ratio: 16/10;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ktp-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .ktp-thumb:hover img {
        transform: scale(1.05);
    }

    .ktp-label-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(15, 23, 42, 0.85);
        font-size: 0.72rem;
        font-weight: 700;
        color: #c4b5fd;
        text-align: center;
        padding: 3px 0;
    }

    #map-kandang {
        height: 200px;
        border-radius: 14px;
        margin-top: 0.75rem;
        border: 1px solid rgba(148, 163, 184, 0.15);
        z-index: 10;
    }

    /* Right Main Content Tabs */
    .content-box {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 1.75rem;
    }

    .tab-headers {
        display: flex;
        gap: 0.75rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }

    .tab-btn {
        padding: 0.65rem 1.25rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        border: 1px solid transparent;
        background: rgba(30, 41, 59, 0.6);
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .tab-btn:hover {
        color: #c4b5fd;
        background: rgba(139, 92, 246, 0.15);
    }

    .tab-btn.active {
        background: rgba(139, 92, 246, 0.25);
        color: #c4b5fd;
        border-color: #8b5cf6;
    }

    .sapi-list-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.25rem;
    }

    .sapi-card-mini {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.25s ease;
    }

    .sapi-card-mini:hover {
        border-color: rgba(139, 92, 246, 0.35);
        transform: translateY(-2px);
    }

    .sapi-thumb-wrap {
        height: 160px;
        position: relative;
        background: #090d16;
        overflow: hidden;
    }

    .sapi-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sapi-badge-health {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 9px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .sapi-mini-body {
        padding: 1rem;
    }

    .sapi-mini-body h4 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .sapi-spec-row {
        display: flex;
        gap: 1rem;
        font-size: 0.8rem;
        color: #94a3b8;
        margin-bottom: 0.75rem;
    }

    .sapi-price {
        font-size: 1.05rem;
        font-weight: 800;
        color: #6ee7b7;
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(8px);
        z-index: 999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content-box {
        background: #1e293b;
        border: 1px solid rgba(148, 163, 184, 0.2);
        border-radius: 20px;
        max-width: 650px;
        width: 100%;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
    }

    .modal-header-box {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body-box {
        padding: 1.5rem;
        text-align: center;
    }

    .modal-body-box img {
        max-width: 100%;
        max-height: 70vh;
        border-radius: 12px;
        object-fit: contain;
    }
</style>
@endsection

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;"><i class="bi bi-houses"></i> Pengurus Kampung</span>
    <button class="hamburger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    @include('dashboard.partials.sidebar_pengurus_kampung')

    <main class="main-content">
        <!-- Header & Breadcrumbs -->
        <div style="margin-bottom: 1.5rem;">
            <a href="{{ route('pengurus_kampung.peternak.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #c4b5fd; text-decoration: none; font-size: 0.88rem; font-weight: 600; margin-bottom: 0.75rem;">
                <i class="bi bi-arrow-left"></i> Kembali ke Direktori Peternak
            </a>
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h1>{{ $peternak->name }}</h1>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Informasi administrasi kependudukan dan inventaris ternak peternak binaan.</p>
                </div>
                @if($peternak->no_telepon)
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $peternak->no_telepon);
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        }
                    @endphp
                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" style="padding: 0.7rem 1.25rem; background: #10b981; color: #ffffff; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="bi bi-whatsapp"></i> Hubungi WhatsApp
                    </a>
                @endif
            </div>
        </div>

        <!-- 2-Column Layout -->
        <div class="profile-layout">
            <!-- Sidebar Card: Identitas & Dokumen -->
            <div class="profile-sidebar-card">
                <div class="profile-avatar-large">
                    {{ strtoupper(substr($peternak->name, 0, 2)) }}
                </div>
                <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 0.25rem;">{{ $peternak->name }}</h3>
                <span style="display: inline-block; background: rgba(139,92,246,0.15); color: #c4b5fd; padding: 3px 10px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; margin-bottom: 1rem;">
                    Peternak Terverifikasi
                </span>

                <!-- KPI Mini -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                    <div style="background: rgba(15,23,42,0.6); padding: 0.75rem; border-radius: 12px; text-align: center; border: 1px solid rgba(148,163,184,0.08);">
                        <span style="font-size: 1.25rem; font-weight: 800; color: #c4b5fd; display: block;">{{ $stats['total_sapi'] }}</span>
                        <span style="font-size: 0.72rem; color: #94a3b8;">Total Sapi</span>
                    </div>
                    <div style="background: rgba(15,23,42,0.6); padding: 0.75rem; border-radius: 12px; text-align: center; border: 1px solid rgba(148,163,184,0.08);">
                        <span style="font-size: 1.25rem; font-weight: 800; color: #6ee7b7; display: block;">{{ $stats['transaksi_sukses'] }}</span>
                        <span style="font-size: 0.72rem; color: #94a3b8;">Sapi Terjual</span>
                    </div>
                </div>

                <!-- Info Data -->
                <div class="detail-section-title"><i class="bi bi-person-lines-fill"></i> Data Kependudukan</div>
                <div class="data-row">
                    <span class="data-label">NIK</span>
                    <span class="data-value" style="font-family: monospace;">{{ $peternak->nik ?: '-' }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Email</span>
                    <span class="data-value">{{ $peternak->email }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">No. Telepon</span>
                    <span class="data-value">{{ $peternak->no_telepon ?: '-' }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Alamat</span>
                    <span class="data-value">{{ $peternak->alamat ?: '-' }}</span>
                </div>

                <div class="detail-section-title"><i class="bi bi-bank"></i> Rekening Pembayaran</div>
                <div class="data-row">
                    <span class="data-label">Bank</span>
                    <span class="data-value">{{ $peternak->jenis_bank ?: '-' }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">No. Rekening</span>
                    <span class="data-value" style="font-family: monospace; color: #6ee7b7;">{{ $peternak->nomor_rekening ?: '-' }}</span>
                </div>

                <!-- Dokumen KTP -->
                <div class="detail-section-title"><i class="bi bi-card-image"></i> Berkas Identitas KTP</div>
                <div class="ktp-preview-grid">
                    <div class="ktp-thumb" onclick="{{ $peternak->foto_ktp ? "openDocModal('Foto KTP — " . addslashes($peternak->name) . "', '" . asset('storage/' . $peternak->foto_ktp) . "')" : '' }}">
                        @if($peternak->foto_ktp)
                            <img src="{{ asset('storage/' . $peternak->foto_ktp) }}" alt="Foto KTP">
                            <div class="ktp-label-overlay">KTP Asli</div>
                        @else
                            <span style="font-size: 0.75rem; color: #64748b;">KTP Kosong</span>
                        @endif
                    </div>

                    <div class="ktp-thumb" onclick="{{ $peternak->foto_selfie_ktp ? "openDocModal('Foto Selfie KTP — " . addslashes($peternak->name) . "', '" . asset('storage/' . $peternak->foto_selfie_ktp) . "')" : '' }}">
                        @if($peternak->foto_selfie_ktp)
                            <img src="{{ asset('storage/' . $peternak->foto_selfie_ktp) }}" alt="Selfie KTP">
                            <div class="ktp-label-overlay">Selfie KTP</div>
                        @else
                            <span style="font-size: 0.75rem; color: #64748b;">Selfie Kosong</span>
                        @endif
                    </div>
                </div>

                <!-- Peta Lokasi Kandang -->
                @if($peternak->latitude && $peternak->longitude)
                    <div class="detail-section-title"><i class="bi bi-geo-alt"></i> Lokasi Kandang Sapi</div>
                    <div id="map-kandang"></div>
                    <div style="margin-top: 0.5rem; text-align: right;">
                        <a href="https://www.google.com/maps?q={{ $peternak->latitude }},{{ $peternak->longitude }}" target="_blank" style="font-size: 0.78rem; color: #93c5fd; text-decoration: none;">
                            Buka di Google Maps <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Main Content: Daftar Sapi & Histori Penjualan -->
            <div class="content-box">
                <div class="tab-headers">
                    <button type="button" class="tab-btn active" id="tab-btn-sapi" onclick="switchTab('sapi')">
                        <i class="bi bi-piggy-bank"></i> Hewan Ternak Sapi ({{ $sapis->count() }})
                    </button>
                    <button type="button" class="tab-btn" id="tab-btn-transaksi" onclick="switchTab('transaksi')">
                        <i class="bi bi-receipt"></i> Riwayat Penjualan ({{ $transaksis->count() }})
                    </button>
                </div>

                <!-- Tab 1: Sapi Milik Peternak -->
                <div id="tab-content-sapi">
                    @if($sapis->count() > 0)
                        <div class="sapi-list-grid">
                            @foreach($sapis as $sapi)
                                <div class="sapi-card-mini">
                                    <div class="sapi-thumb-wrap">
                                        @if($sapi->first_foto)
                                            <img src="{{ asset('storage/' . $sapi->first_foto) }}" alt="{{ $sapi->jenis }}">
                                        @else
                                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #64748b;">
                                                <i class="bi bi-image" style="font-size: 2.5rem;"></i>
                                            </div>
                                        @endif

                                        <!-- Badge Status Kesehatan -->
                                        @if($sapi->status_kesehatan === 'sehat')
                                            <span class="sapi-badge-health" style="background: rgba(16, 185, 129, 0.9); color: #ffffff;">
                                                <i class="bi bi-patch-check-fill"></i> Sehat
                                            </span>
                                        @elseif($sapi->status_kesehatan === 'sakit')
                                            <span class="sapi-badge-health" style="background: rgba(239, 68, 68, 0.9); color: #ffffff;">
                                                <i class="bi bi-exclamation-triangle-fill"></i> Sakit
                                            </span>
                                        @else
                                            <span class="sapi-badge-health" style="background: rgba(245, 158, 11, 0.9); color: #ffffff;">
                                                <i class="bi bi-clock-history"></i> Belum Diperiksa
                                            </span>
                                        @endif
                                    </div>
                                    <div class="sapi-mini-body">
                                        <h4>{{ $sapi->jenis }}</h4>
                                        <div class="sapi-spec-row">
                                            <span><i class="bi bi-speedometer2"></i> {{ $sapi->bobot }} kg</span>
                                            <span><i class="bi bi-calendar3"></i> {{ $sapi->umur_formatted }}</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div class="sapi-price">{{ $sapi->harga_formatted }}</div>
                                            <span style="font-size: 0.75rem; color: #94a3b8; background: rgba(148,163,184,0.1); padding: 2px 7px; border-radius: 6px;">
                                                {{ $sapi->tipe_penjualan_label }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 3rem; color: #94a3b8;">
                            <i class="bi bi-piggy-bank" style="font-size: 2.5rem; color: #64748b; margin-bottom: 0.75rem; display: block;"></i>
                            <p>Peternak ini belum mengunggah data ternak sapi ke sistem.</p>
                        </div>
                    @endif
                </div>

                <!-- Tab 2: Riwayat Penjualan -->
                <div id="tab-content-transaksi" style="display: none;">
                    @if($transaksis->count() > 0)
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
                                <thead>
                                    <tr style="border-bottom: 1px solid rgba(148,163,184,0.15); color: #94a3b8; font-size: 0.78rem; text-transform: uppercase;">
                                        <th style="padding: 0.75rem 1rem;">No. Transaksi</th>
                                        <th style="padding: 0.75rem 1rem;">Tanggal</th>
                                        <th style="padding: 0.75rem 1rem;">Pembeli</th>
                                        <th style="padding: 0.75rem 1rem;">Sapi</th>
                                        <th style="padding: 0.75rem 1rem;">Total Nilai</th>
                                        <th style="padding: 0.75rem 1rem;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksis as $trx)
                                        <tr style="border-bottom: 1px solid rgba(148,163,184,0.06);">
                                            <td style="padding: 0.85rem 1rem; font-family: monospace; font-weight: 700; color: #f1f5f9;">
                                                {{ $trx->kode_transaksi }}
                                            </td>
                                            <td style="padding: 0.85rem 1rem; color: #94a3b8;">
                                                {{ $trx->created_at->format('d M Y') }}
                                            </td>
                                            <td style="padding: 0.85rem 1rem; font-weight: 600;">
                                                {{ $trx->pembeli?->name ?? 'Pembeli' }}
                                            </td>
                                            <td style="padding: 0.85rem 1rem; color: #c4b5fd;">
                                                {{ $trx->sapi?->jenis ?? 'Sapi' }}
                                            </td>
                                            <td style="padding: 0.85rem 1rem; font-weight: 700; color: #6ee7b7;">
                                                {{ $trx->total_harga_formatted }}
                                            </td>
                                            <td style="padding: 0.85rem 1rem;">
                                                <span style="display: inline-flex; align-items: center; gap: 5px; padding: 2px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; background: {{ $trx->status_meta['bg'] }}; color: {{ $trx->status_meta['color'] }}; border: 1px solid {{ $trx->status_meta['border'] }};">
                                                    {{ $trx->status_meta['label'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div style="text-align: center; padding: 3rem; color: #94a3b8;">
                            <i class="bi bi-receipt" style="font-size: 2.5rem; color: #64748b; margin-bottom: 0.75rem; display: block;"></i>
                            <p>Belum ada transaksi penjualan sapi dari peternak ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal KTP -->
<div class="modal-overlay" id="docModal" onclick="closeDocModal(event)">
    <div class="modal-content-box" onclick="event.stopPropagation()">
        <div class="modal-header-box">
            <h4 id="docModalTitle">Pratinjau Dokumen</h4>
            <button type="button" class="modal-close-btn" onclick="closeDocModal()">&times;</button>
        </div>
        <div class="modal-body-box">
            <img id="docModalImg" src="" alt="Pratinjau Dokumen">
        </div>
    </div>
</div>

<!-- Leaflet JS for Maps -->
@if($peternak->latitude && $peternak->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $peternak->latitude }};
        const lng = {{ $peternak->longitude }};
        const map = L.map('map-kandang').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup('<b>Kandang: {{ addslashes($peternak->name) }}</b><br>{{ addslashes($peternak->alamat ?? "") }}')
            .openPopup();
    });
</script>
@endif

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('open');
    }

    function switchTab(tab) {
        document.getElementById('tab-btn-sapi').classList.remove('active');
        document.getElementById('tab-btn-transaksi').classList.remove('active');
        document.getElementById('tab-content-sapi').style.display = 'none';
        document.getElementById('tab-content-transaksi').style.display = 'none';

        if (tab === 'sapi') {
            document.getElementById('tab-btn-sapi').classList.add('active');
            document.getElementById('tab-content-sapi').style.display = 'block';
        } else {
            document.getElementById('tab-btn-transaksi').classList.add('active');
            document.getElementById('tab-content-transaksi').style.display = 'block';
        }
    }

    function openDocModal(title, imageUrl) {
        document.getElementById('docModalTitle').textContent = title;
        document.getElementById('docModalImg').src = imageUrl;
        document.getElementById('docModal').classList.add('active');
    }

    function closeDocModal() {
        document.getElementById('docModal').classList.remove('active');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDocModal();
    });
</script>
@endsection
