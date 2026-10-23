@extends('layouts.peternak', ['title' => 'Detail Sapi — Sistem Penjualan Sapi'])

@section('page-styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map {
        height: 250px;
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.1);
        z-index: 1;
    }
    .lokasi-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        align-items: start;
    }
    @media (max-width: 640px) {
        .lokasi-grid {
            grid-template-columns: 1fr;
        }
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #94a3b8;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
        transition: color 0.2s ease;
    }

    .back-link:hover { color: #f1f5f9; }

    .alert-success {
        background: rgba(16, 185, 129, 0.08);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 12px;
        padding: 0.85rem 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
        color: #6ee7b7;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .detail-card {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(148, 163, 184, 0.08);
        border-radius: 16px;
        overflow: hidden;
    }

    .detail-media {
        grid-column: 1 / -1;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .media-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(148, 163, 184, 0.08);
        border-radius: 16px;
        overflow: hidden;
    }

    .media-card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.06);
        font-size: 0.85rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .media-body {
        padding: 1rem;
    }

    .media-body img {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 10px;
    }

    .media-body video {
        width: 100%;
        max-height: 400px;
        border-radius: 10px;
        background: #000;
    }

    .foto-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 0.75rem;
    }
    
    .foto-grid-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .foto-grid-item img {
        width: 100% !important;
        height: 100% !important;
        max-height: 100% !important;
        object-fit: cover !important;
        transition: transform 0.2s ease;
    }
    
    .foto-grid-item img:hover {
        transform: scale(1.05);
    }
    
    .video-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .video-list-item {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: #000;
    }
    
    .video-list-item video {
        width: 100% !important;
        max-height: 250px !important;
        display: block;
    }

    .media-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
        color: #475569;
        gap: 0.5rem;
    }

    .media-placeholder-icon {
        font-size: 2.5rem;
        opacity: 0.3;
    }

    .media-placeholder-text {
        font-size: 0.85rem;
    }

    /* Info Card */
    .info-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(148, 163, 184, 0.08);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .info-card h3 {
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        letter-spacing: -0.02em;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(148, 163, 184, 0.06);
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        font-size: 0.85rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .info-value {
        font-size: 0.9rem;
        font-weight: 700;
        color: #f1f5f9;
        text-align: right;
    }

    .info-value.price {
        color: #6ee7b7;
        font-size: 1.05rem;
    }

    /* Health Badge */
    .health-badge-lg {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        border-radius: 12px;
        margin-top: 0.5rem;
    }

    .health-belum {
        background: rgba(245, 158, 11, 0.06);
        border: 1px solid rgba(245, 158, 11, 0.15);
    }

    .health-sehat {
        background: rgba(16, 185, 129, 0.06);
        border: 1px solid rgba(16, 185, 129, 0.15);
    }

    .health-tidak-sehat {
        background: rgba(239, 68, 68, 0.06);
        border: 1px solid rgba(239, 68, 68, 0.15);
    }

    .health-icon {
        font-size: 1.5rem;
    }

    .health-info h4 {
        font-size: 0.9rem;
        font-weight: 700;
    }

    .health-belum .health-info h4 { color: #fcd34d; }
    .health-sehat .health-info h4 { color: #6ee7b7; }
    .health-tidak-sehat .health-info h4 { color: #fca5a5; }

    .health-info p {
        font-size: 0.8rem;
        color: #94a3b8;
        margin-top: 0.15rem;
    }

    .health-notes {
        margin-top: 0.75rem;
        padding: 0.85rem;
        background: rgba(15, 23, 42, 0.4);
        border-radius: 8px;
        font-size: 0.85rem;
        color: #cbd5e1;
        line-height: 1.6;
    }

    .health-verifier {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.5rem;
    }

    /* Action Buttons */
    .detail-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.25rem;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-edit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        color: white;
    }

    .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.25rem;
        background: transparent;
        color: #fca5a5;
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.4);
    }

    @media (max-width: 768px) {
        .detail-layout, .detail-media {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('page-content')
<a href="{{ route('peternak.penjualan') }}" class="back-link">
    ← Kembali ke Penjualan
</a>

@if (session('success'))
    <div class="alert-success">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="page-header">
    <h1>{{ $sapi->jenis }}</h1>
    <p>Ditambahkan pada {{ $sapi->created_at->format('d M Y, H:i') }}</p>
</div>

{{-- Media Section --}}
<div class="detail-media">
    <div class="media-card">
        <div class="media-card-header">📷 Foto</div>
        <div class="media-body">
            @if (is_array($sapi->foto) && count($sapi->foto) > 0)
                <div class="foto-grid">
                    @foreach ($sapi->foto as $f)
                        <div class="foto-grid-item">
                            <a href="{{ asset('storage/' . $f) }}" target="_blank">
                                <img src="{{ asset('storage/' . $f) }}" alt="Foto Sapi">
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="media-placeholder">
                    <div class="media-placeholder-icon">📷</div>
                    <div class="media-placeholder-text">Belum ada foto</div>
                </div>
            @endif
        </div>
    </div>

    <div class="media-card">
        <div class="media-card-header">🎥 Video</div>
        <div class="media-body">
            @if (is_array($sapi->video) && count($sapi->video) > 0)
                <div class="video-list">
                    @foreach ($sapi->video as $v)
                        <div class="video-list-item">
                            <video src="{{ asset('storage/' . $v) }}" controls></video>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="media-placeholder">
                    <div class="media-placeholder-icon">🎥</div>
                    <div class="media-placeholder-text">Belum ada video</div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Info Section --}}
<div class="detail-layout" style="margin-top: 1.5rem;">
    <div class="info-card">
        <h3>🐮 Data Sapi</h3>
        <div class="info-row">
            <span class="info-label">Jenis</span>
            <span class="info-value">{{ $sapi->jenis }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Umur</span>
            <span class="info-value">{{ $sapi->umur_formatted }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Bobot</span>
            <span class="info-value">{{ number_format($sapi->bobot, 1) }} kg</span>
        </div>
        <div class="info-row">
            <span class="info-label">Harga</span>
            <span class="info-value price">{{ $sapi->harga_formatted }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tipe Penjualan</span>
            <span class="info-value">
                @if($sapi->is_preorder)
                    <span style="background: rgba(245,158,11,0.15); color: #fbbf24; padding: 0.2rem 0.6rem; border-radius: 6px; font-size: 0.8rem; font-weight: 700;">📋 Pre-Order</span>
                @else
                    <span style="background: rgba(16,185,129,0.15); color: #6ee7b7; padding: 0.2rem 0.6rem; border-radius: 6px; font-size: 0.8rem; font-weight: 700;">🛒 Order</span>
                @endif
            </span>
        </div>
        @if($sapi->is_preorder && $sapi->preorder_bulan)
        <div class="info-row">
            <span class="info-label">Jadwal Pre-Order</span>
            <span class="info-value">{{ $sapi->preorder_label }} {{ $sapi->preorder_tahun }}</span>
        </div>
        @endif
        @if($sapi->is_preorder)
        <div class="info-row">
            <span class="info-label">Biaya Perawatan Harian</span>
            <span class="info-value" style="color: #fbbf24; font-weight: 700;">{{ $sapi->biaya_perawatan_harian_formatted }} / hari</span>
        </div>
        @endif
    </div>

    <div class="info-card">
        <h3>🩺 Riwayat Kesehatan</h3>

        @if ($sapi->status_kesehatan === 'sehat')
            <div class="health-badge-lg health-sehat">
                <span class="health-icon">✅</span>
                <div class="health-info">
                    <h4>Terverifikasi Sehat</h4>
                    <p>Sapi ini telah diperiksa dan dinyatakan sehat.</p>
                </div>
            </div>
        @elseif ($sapi->status_kesehatan === 'tidak_sehat')
            <div class="health-badge-lg health-tidak-sehat">
                <span class="health-icon">❌</span>
                <div class="health-info">
                    <h4>Tidak Sehat</h4>
                    <p>Sapi ini telah diperiksa dan ditemukan masalah kesehatan.</p>
                </div>
            </div>
        @else
            <div class="health-badge-lg health-belum">
                <span class="health-icon">⏳</span>
                <div class="health-info">
                    <h4>Belum Diperiksa</h4>
                    <p>Menunggu pemeriksaan dari Mantri Hewan.</p>
                </div>
            </div>
        @endif

        @if ($sapi->catatan_kesehatan)
            <div class="health-notes">
                <strong>Catatan:</strong><br>
                {{ $sapi->catatan_kesehatan }}
            </div>
        @endif

        @if ($sapi->verifier)
            <div class="health-verifier">
                Diverifikasi oleh: {{ $sapi->verifier->name }} — {{ $sapi->verified_at->format('d M Y, H:i') }}
            </div>
        @endif
    </div>

    @if ($sapi->latitude && $sapi->longitude)
        <div class="info-card" style="grid-column: 1 / -1; margin-top: 1.5rem;">
            <h3>📍 Lokasi Sapi / Kandang</h3>
            <div class="lokasi-grid">
                <div>
                    <div id="map"></div>
                </div>
                <div>
                    <div class="info-row">
                        <span class="info-label">Latitude</span>
                        <span class="info-value">{{ $sapi->latitude }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Longitude</span>
                        <span class="info-value">{{ $sapi->longitude }}</span>
                    </div>
                    <div class="info-row" style="flex-direction: column; align-items: flex-start; gap: 0.25rem;">
                        <span class="info-label">Keterangan Lokasi</span>
                        <span class="info-value" style="text-align: left; font-weight: 500; color: #cbd5e1; margin-top: 0.25rem;">{{ $sapi->lokasi ?? '-' }}</span>
                    </div>
                    <div style="margin-top: 1.25rem;">
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $sapi->latitude }},{{ $sapi->longitude }}" target="_blank" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.75rem; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 10px; color: #60a5fa; font-weight: 600; text-decoration: none; font-size: 0.85rem; transition: all 0.2s;" onmouseover="this.style.background='rgba(59,130,246,0.2)'" onmouseout="this.style.background='rgba(59,130,246,0.1)'">
                            🗺️ Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Actions --}}
<div class="detail-actions">
    <a href="{{ route('peternak.sapi.edit', $sapi->id) }}" class="btn-edit" id="btn-edit-sapi">
        ✏️ Edit Data
    </a>
    <form method="POST" action="{{ route('peternak.sapi.delete', $sapi->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data sapi ini?')" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete" id="btn-hapus-sapi">
            🗑️ Hapus
        </button>
    </form>
</div>
@endsection

@section('scripts')
@if ($sapi->latitude && $sapi->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lat = {{ $sapi->latitude }};
        const lng = {{ $sapi->longitude }};
        
        const map = L.map('map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps Satelit'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map);
    });
</script>
@endif
@endsection
