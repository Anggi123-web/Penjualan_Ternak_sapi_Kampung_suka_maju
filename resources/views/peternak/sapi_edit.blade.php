@extends('layouts.peternak', ['title' => 'Edit Data Sapi — Sistem Penjualan Sapi'])

@section('page-styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map {
        height: 320px;
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.1);
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        z-index: 1;
    }
    .gps-btn {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.2s ease;
    }
    .gps-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
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

    .form-card {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(148, 163, 184, 0.08);
        border-radius: 16px;
        padding: 2rem;
    }

    .form-card h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        letter-spacing: -0.02em;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.15rem;
    }

    .form-group { margin-bottom: 0; }

    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #94a3b8;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 0.8rem 1rem;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 10px;
        color: #f1f5f9;
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s ease;
        outline: none;
    }

    .form-select {
        appearance: none;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        padding-right: 2.25rem;
    }

    .form-select option { background: #1e293b; color: #f1f5f9; }

    .form-input::placeholder { color: #475569; }

    .form-input:focus, .form-select:focus {
        border-color: rgba(16, 185, 129, 0.4);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.08);
    }

    .input-group { position: relative; }

    .input-suffix {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
        pointer-events: none;
    }

    .input-prefix {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        pointer-events: none;
    }

    .form-input.has-prefix { padding-left: 2.5rem; }
    .form-input.has-suffix { padding-right: 3rem; }

    /* File Upload */
    .file-upload {
        position: relative;
        border: 2px dashed rgba(148, 163, 184, 0.15);
        border-radius: 12px;
        padding: 1.75rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: rgba(15, 23, 42, 0.3);
    }

    .file-upload:hover {
        border-color: rgba(16, 185, 129, 0.3);
        background: rgba(16, 185, 129, 0.03);
    }

    .file-upload input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-icon { font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.5; }
    .file-upload-text { font-size: 0.85rem; color: #94a3b8; font-weight: 500; }
    .file-upload-hint { font-size: 0.75rem; color: #64748b; margin-top: 0.25rem; }

    .current-file {
        margin-top: 0.75rem;
        padding: 0.75rem;
        background: rgba(15, 23, 42, 0.4);
        border-radius: 8px;
    }

    .current-file img {
        max-width: 100%;
        max-height: 180px;
        border-radius: 6px;
        object-fit: cover;
    }

    .current-file video {
        max-width: 100%;
        max-height: 180px;
        border-radius: 6px;
    }

    .current-file-label {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 0.5rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .file-preview {
        margin-top: 0.75rem;
        display: none;
    }

    .file-preview img {
        max-width: 100%;
        max-height: 180px;
        border-radius: 8px;
        object-fit: cover;
    }

    .file-preview video {
        max-width: 100%;
        max-height: 180px;
        border-radius: 8px;
    }

    .file-preview-name {
        font-size: 0.8rem;
        color: #6ee7b7;
        font-weight: 600;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    /* Buttons */
    .form-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.75rem;
    }

    .btn-submit {
        padding: 0.8rem 2rem;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
    }

    .btn-cancel {
        padding: 0.8rem 1.5rem;
        background: transparent;
        color: #94a3b8;
        border: 1px solid rgba(148, 163, 184, 0.15);
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-cancel:hover { color: #f1f5f9; border-color: rgba(148, 163, 184, 0.3); }

    /* Error */
    .form-error-list {
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 12px;
        padding: 0.85rem 1rem;
        margin-bottom: 1.5rem;
        list-style: none;
    }

    .form-error-list li { font-size: 0.85rem; color: #fca5a5; line-height: 1.6; }

    /* Tipe Penjualan Toggle */
    .tipe-toggle {
        display: flex;
        gap: 0.75rem;
    }

    .tipe-option {
        flex: 1;
        cursor: pointer;
    }

    .tipe-option input[type="radio"] {
        display: none;
    }

    .tipe-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.8rem 1rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid rgba(148, 163, 184, 0.1);
        background: rgba(15, 23, 42, 0.4);
        color: #94a3b8;
    }

    .tipe-option input[type="radio"]:checked + .tipe-order {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
        color: #6ee7b7;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.08);
    }

    .tipe-option input[type="radio"]:checked + .tipe-preorder {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.1);
        color: #fcd34d;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.08);
    }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-card { padding: 1.5rem; }
    }
</style>
@endsection

@section('page-content')
<a href="{{ route('peternak.sapi.show', $sapi->id) }}" class="back-link">
    ← Kembali ke Detail
</a>

<div class="page-header">
    <h1>Edit Data Sapi</h1>
    <p>Perbarui informasi sapi <strong>{{ $sapi->jenis }}</strong>.</p>
</div>

@if ($errors->any())
    <ul class="form-error-list">
        @foreach ($errors->all() as $error)
            <li>⚠️ {{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('peternak.sapi.update', $sapi->id) }}" enctype="multipart/form-data" id="form-edit-sapi">
    @csrf
    @method('PUT')

    <div class="form-card">
        <h3>🐮 Informasi Sapi</h3>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="jenis">Jenis Sapi</label>
                <select id="jenis" name="jenis" class="form-select" required>
                    @foreach (['Limosin', 'Simental', 'Brahman', 'Bali', 'Madura', 'PO (Peranakan Ongole)', 'Angus', 'Hereford'] as $jenis)
                        <option value="{{ $jenis }}" {{ old('jenis', $sapi->jenis) === $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="umur">Umur</label>
                <div class="input-group">
                    <input type="number" id="umur" name="umur" class="form-input has-suffix" value="{{ old('umur', $sapi->umur) }}" min="1" required>
                    <span class="input-suffix">bulan</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="bobot">Bobot</label>
                <div class="input-group">
                    <input type="number" id="bobot" name="bobot" class="form-input has-suffix" value="{{ old('bobot', $sapi->bobot) }}" min="1" step="0.01" required>
                    <span class="input-suffix">kg</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="harga">Harga</label>
                <div class="input-group">
                    <span class="input-prefix">Rp</span>
                    <input type="number" id="harga" name="harga" class="form-input has-prefix" value="{{ old('harga', $sapi->harga) }}" min="1" required>
                </div>
            </div>

            <div class="form-group form-full">
                <label class="form-label">Tipe Penjualan</label>
                <div class="tipe-toggle">
                    <label class="tipe-option">
                        <input type="radio" name="tipe_penjualan" value="order" {{ old('tipe_penjualan', $sapi->tipe_penjualan) === 'order' ? 'checked' : '' }} onchange="togglePreorder()">
                        <span class="tipe-label tipe-order">🛒 Order</span>
                    </label>
                    <label class="tipe-option">
                        <input type="radio" name="tipe_penjualan" value="pre_order" {{ old('tipe_penjualan', $sapi->tipe_penjualan) === 'pre_order' ? 'checked' : '' }} onchange="togglePreorder()">
                        <span class="tipe-label tipe-preorder">📋 Pre-Order</span>
                    </label>
                </div>
            </div>

            <div class="form-group" id="preorder-bulan-group" style="display: none;">
                <label class="form-label" for="preorder_bulan">Bulan Pre-Order</label>
                <select id="preorder_bulan" name="preorder_bulan" class="form-select">
                    <option value="" disabled {{ old('preorder_bulan', $sapi->preorder_bulan) ? '' : 'selected' }}>— Pilih bulan —</option>
                    @foreach (['1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'] as $num => $nama)
                        <option value="{{ $num }}" {{ old('preorder_bulan', $sapi->preorder_bulan) == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="preorder-tahun-group" style="display: none;">
                <label class="form-label" for="preorder_tahun">Tahun Pre-Order</label>
                <select id="preorder_tahun" name="preorder_tahun" class="form-select">
                    <option value="" disabled {{ old('preorder_tahun', $sapi->preorder_tahun) ? '' : 'selected' }}>— Pilih tahun —</option>
                    @for ($y = date('Y'); $y <= date('Y') + 5; $y++)
                        <option value="{{ $y }}" {{ old('preorder_tahun', $sapi->preorder_tahun) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group form-full" id="preorder-biaya-group" style="display: none;">
                <label class="form-label" for="biaya_perawatan_harian">Biaya Perawatan Harian (Rp / Hari)</label>
                <div class="input-wrapper">
                    <span class="input-prefix">Rp</span>
                    <input type="number" id="biaya_perawatan_harian" name="biaya_perawatan_harian" class="form-input has-prefix" placeholder="Contoh: 25000" value="{{ old('biaya_perawatan_harian', $sapi->biaya_perawatan_harian ?: 25000) }}" min="0">
                </div>
                <div class="form-hint">Biaya pakan, suplemen, dan perawatan harian selama sapi dititipkan di kandang Anda (default: Rp 25.000 / hari). Biaya ini akan dihitung otomatis saat pembeli memilih tanggal penjemputan/pengantaran.</div>
            </div>
        </div>
    </div>

    <div class="form-card" style="margin-top: 1.5rem;">
        <h3>📸 Foto & Video</h3>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Foto Sapi</label>
                @php
                    $fotos = is_array($sapi->foto) ? $sapi->foto : ($sapi->foto ? [$sapi->foto] : []);
                @endphp
                @if (count($fotos) > 0)
                    <div class="current-file-label">Foto saat ini (Klik ✕ untuk menghapus):</div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 0.75rem; margin-bottom: 1rem; margin-top: 0.5rem;">
                        @foreach ($fotos as $path)
                            <div class="existing-media-item" id="foto-item-{{ md5($path) }}" style="position: relative; border-radius: 8px; overflow: hidden; border: 1px solid rgba(148, 163, 184, 0.1);">
                                <img src="{{ asset('storage/' . $path) }}" style="width: 100%; height: 80px; object-fit: cover;">
                                <button type="button" onclick="deleteExistingMedia('foto', '{{ $path }}', '{{ md5($path) }}')" style="position: absolute; top: 4px; right: 4px; background: rgba(239, 68, 68, 0.85); color: white; border: none; width: 22px; height: 22px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'" onmouseout="this.style.background='rgba(239, 68, 68, 0.85)'">
                                    ✕
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div id="deleted-fotos-container"></div>

                <div class="file-upload" style="margin-top: 0.75rem;">
                    <input type="file" name="foto[]" accept="image/*" id="foto-input" multiple onchange="handleFotoUpload(this)">
                    <div class="file-upload-icon">📷</div>
                    <div class="file-upload-text">Unggah foto baru</div>
                    <div class="file-upload-hint">Format: JPG, PNG, WebP (Kompresi otomatis aktif)</div>
                </div>
                <div id="foto-preview" style="display: none; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 1rem; margin-top: 1rem;"></div>
            </div>

            <div class="form-group">
                <label class="form-label">Video Sapi</label>
                @php
                    $videos = is_array($sapi->video) ? $sapi->video : ($sapi->video ? [$sapi->video] : []);
                @endphp
                @if (count($videos) > 0)
                    <div class="current-file-label">Video saat ini (Klik ✕ untuk menghapus):</div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 0.75rem; margin-bottom: 1rem; margin-top: 0.5rem;">
                        @foreach ($videos as $path)
                            <div class="existing-media-item" id="video-item-{{ md5($path) }}" style="position: relative; border-radius: 8px; overflow: hidden; padding: 0.5rem; background: rgba(15,23,42,0.4); border: 1px solid rgba(148,163,184,0.1);">
                                <div style="font-size: 0.75rem; font-weight: 600; color: #3b82f6; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding-right: 20px;">🎥 Video</div>
                                <div style="font-size: 0.65rem; color: #94a3b8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ basename($path) }}">{{ basename($path) }}</div>
                                <button type="button" onclick="deleteExistingMedia('video', '{{ $path }}', '{{ md5($path) }}')" style="position: absolute; top: 4px; right: 4px; background: rgba(239, 68, 68, 0.85); color: white; border: none; width: 20px; height: 20px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: bold; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'" onmouseout="this.style.background='rgba(239, 68, 68, 0.85)'">
                                    ✕
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div id="deleted-videos-container"></div>

                <div class="file-upload" style="margin-top: 0.75rem;">
                    <input type="file" name="video[]" accept="video/*" id="video-input" multiple onchange="handleVideoUpload(this)">
                    <div class="file-upload-icon">🎥</div>
                    <div class="file-upload-text">Unggah video baru</div>
                    <div class="file-upload-hint">MP4, MOV, AVI, WebM — Maks 100MB per berkas</div>
                </div>
                <div id="video-preview" style="display: none; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; margin-top: 1rem;"></div>
            </div>
        </div>
    </div>

    <div class="form-card" style="margin-top: 1.5rem;">
        <h3>📍 Lokasi Kandang / Sapi</h3>
        <div class="form-grid">
            <div class="form-group form-full">
                <label class="form-label">Cari & Tentukan Lokasi Pada Peta</label>
                <div id="map"></div>
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                    <span class="form-hint">Geser penanda merah ke lokasi kandang atau klik langsung pada peta.</span>
                    <button type="button" class="gps-btn" onclick="getCurrentLocation()">
                        🛰️ Gunakan Lokasi GPS Saya
                    </button>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="latitude">Latitude</label>
                <input type="text" id="latitude" name="latitude" class="form-input" placeholder="Klik pada peta..." value="{{ old('latitude', $sapi->latitude) }}" readonly required>
            </div>

            <div class="form-group">
                <label class="form-label" for="longitude">Longitude</label>
                <input type="text" id="longitude" name="longitude" class="form-input" placeholder="Klik pada peta..." value="{{ old('longitude', $sapi->longitude) }}" readonly required>
            </div>

            <div class="form-group form-full">
                <label class="form-label">Keterangan Alamat Kandang (Dari Profil Anda)</label>
                <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 0.85rem 1rem; font-size: 0.9rem; color: #cbd5e1; line-height: 1.5;">
                    🏡 {{ auth()->user()->alamat ?? 'Alamat belum diatur di profil Anda.' }}
                </div>
                <input type="hidden" name="lokasi" value="{{ auth()->user()->alamat }}">
                <div class="form-hint" style="margin-top: 0.35rem;">Alamat ini diambil otomatis dari profil pendaftaran Anda agar Anda tidak perlu menginputnya kembali.</div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-submit" id="btn-update-sapi">
            💾 Simpan Perubahan
        </button>
        <a href="{{ route('peternak.sapi.show', $sapi->id) }}" class="btn-cancel">
            Batal
        </a>
    </div>
</form>

<script>
    function previewFile(input, previewId, type) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let html = '';
                if (type === 'image') {
                    html = '<img src="' + e.target.result + '" alt="Preview">';
                } else {
                    html = '<video src="' + e.target.result + '" controls></video>';
                }
                html += '<div class="file-preview-name">✅ File baru: ' + file.name + '</div>';
                preview.innerHTML = html;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    function togglePreorder() {
        const tipe = document.querySelector('input[name="tipe_penjualan"]:checked');
        const bulanGroup = document.getElementById('preorder-bulan-group');
        const tahunGroup = document.getElementById('preorder-tahun-group');
        const biayaGroup = document.getElementById('preorder-biaya-group');

        if (tipe && tipe.value === 'pre_order') {
            bulanGroup.style.display = 'block';
            tahunGroup.style.display = 'block';
            if (biayaGroup) biayaGroup.style.display = 'block';
        } else {
            bulanGroup.style.display = 'none';
            tahunGroup.style.display = 'none';
            if (biayaGroup) biayaGroup.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', togglePreorder);
</script>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    let map, marker;
    const defaultLat = {{ auth()->user()->latitude ?? -6.2088 }};
    const defaultLng = {{ auth()->user()->longitude ?? 106.8456 }};

    document.addEventListener('DOMContentLoaded', function() {
        const oldLat = document.getElementById('latitude').value;
        const oldLng = document.getElementById('longitude').value;
        
        // If there's an existing lat/lng, center map there. Otherwise, default.
        const startLat = oldLat ? parseFloat(oldLat) : defaultLat;
        const startLng = oldLng ? parseFloat(oldLng) : defaultLng;
        const zoomLevel = oldLat ? 16 : 10;

        // Initialize map
        map = L.map('map').setView([startLat, startLng], zoomLevel);

        // Google Satellite Hybrid tile layer
        L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps Satelit'
        }).addTo(map);

        // Create marker
        marker = L.marker([startLat, startLng], {
            draggable: true
        }).addTo(map);

        // If coordinates were already filled, keep them. Otherwise, wait for user click/drag
        if (oldLat && oldLng) {
            // already filled
        } else {
            // set values on map marker load
            updateCoordinates(startLat, startLng);
        }

        // Event: Marker dragged
        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            updateCoordinates(position.lat, position.lng);
        });

        // Event: Map clicked
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            marker.setLatLng([lat, lng]);
            updateCoordinates(lat, lng);
        });
    });

    function updateCoordinates(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(8);
        document.getElementById('longitude').value = lng.toFixed(8);
    }

    function updateMarkerAndMap(lat, lng, zoom = 16) {
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], zoom);
        updateCoordinates(lat, lng);
    }

    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                updateMarkerAndMap(lat, lng, 16);
            }, function(error) {
                alert('Gagal mengambil lokasi GPS Anda. Pastikan izin lokasi diaktifkan di browser.');
            });
        } else {
            alert('Browser Anda tidak mendukung layanan lokasi GPS.');
        }
    }

    function deleteExistingMedia(type, path, hash) {
        const item = document.getElementById(`${type}-item-${hash}`);
        if (item) {
            item.style.opacity = '0.25';
            item.style.pointerEvents = 'none';
            item.style.border = '1px solid rgba(239, 68, 68, 0.4)';
            
            // Add hidden input to form
            const container = document.getElementById(`deleted-${type}s-container`);
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `deleted_${type}s[]`;
            input.value = path;
            container.appendChild(input);
        }
    }

    async function compressImageFile(file, maxDimension = 1200, quality = 0.7) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(event) {
                const img = new Image();
                img.src = event.target.result;
                img.onload = function() {
                    let width = img.width;
                    let height = img.height;

                    if (width > maxDimension || height > maxDimension) {
                        if (width > height) {
                            height = Math.round((height * maxDimension) / width);
                            width = maxDimension;
                        } else {
                            width = Math.round((width * maxDimension) / height);
                            height = maxDimension;
                        }
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob((blob) => {
                        const compressedFile = new File([blob], file.name.replace(/\.[^/.]+$/, "") + ".jpg", {
                            type: "image/jpeg",
                            lastModified: Date.now()
                        });
                        resolve(compressedFile);
                    }, 'image/jpeg', quality);
                };
            };
        });
    }

    async function handleFotoUpload(input) {
        const previewContainer = document.getElementById('foto-preview');
        previewContainer.innerHTML = '';
        previewContainer.style.display = 'grid';

        const files = input.files;
        if (!files.length) return;

        const dt = new DataTransfer();
        
        const loadingIndicator = document.createElement('div');
        loadingIndicator.style.gridColumn = '1 / -1';
        loadingIndicator.style.fontSize = '0.8rem';
        loadingIndicator.style.color = '#10b981';
        loadingIndicator.style.fontWeight = '600';
        loadingIndicator.innerText = '⏳ Sedang mengompres gambar...';
        previewContainer.appendChild(loadingIndicator);

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file.type.startsWith('image/')) {
                try {
                    const compressedFile = await compressImageFile(file);
                    dt.items.add(compressedFile);

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.style.position = 'relative';
                        previewItem.style.borderRadius = '8px';
                        previewItem.style.overflow = 'hidden';
                        previewItem.style.border = '1px solid rgba(148,163,184,0.1)';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100%';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        
                        const sizeBadge = document.createElement('div');
                        sizeBadge.style.position = 'absolute';
                        sizeBadge.style.bottom = '4px';
                        sizeBadge.style.left = '4px';
                        sizeBadge.style.background = 'rgba(15,23,42,0.85)';
                        sizeBadge.style.color = '#6ee7b7';
                        sizeBadge.style.fontSize = '9px';
                        sizeBadge.style.padding = '2px 4px';
                        sizeBadge.style.borderRadius = '4px';
                        sizeBadge.style.fontWeight = '600';
                        
                        const originalKB = (file.size / 1024).toFixed(0);
                        const compressedKB = (compressedFile.size / 1024).toFixed(0);
                        sizeBadge.innerText = `${compressedKB} KB`;
                        sizeBadge.title = `Original: ${originalKB} KB`;

                        previewItem.appendChild(img);
                        previewItem.appendChild(sizeBadge);
                        previewContainer.appendChild(previewItem);
                    };
                    reader.readAsDataURL(compressedFile);
                } catch (e) {
                    console.error(e);
                    dt.items.add(file);
                }
            } else {
                dt.items.add(file);
            }
        }

        loadingIndicator.remove();
        input.files = dt.files;
    }

    function handleVideoUpload(input) {
        const previewContainer = document.getElementById('video-preview');
        previewContainer.innerHTML = '';
        previewContainer.style.display = 'grid';

        const files = input.files;
        if (!files.length) return;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            const previewItem = document.createElement('div');
            previewItem.style.position = 'relative';
            previewItem.style.borderRadius = '8px';
            previewItem.style.overflow = 'hidden';
            previewItem.style.padding = '0.5rem';
            previewItem.style.background = 'rgba(15,23,42,0.4)';
            previewItem.style.border = '1px solid rgba(148,163,184,0.1)';
            
            const videoIcon = document.createElement('div');
            videoIcon.innerText = '🎥 Video';
            videoIcon.style.fontSize = '0.8rem';
            videoIcon.style.fontWeight = '600';
            videoIcon.style.color = '#3b82f6';
            videoIcon.style.marginBottom = '4px';

            const nameLabel = document.createElement('div');
            nameLabel.innerText = file.name;
            nameLabel.style.fontSize = '0.7rem';
            nameLabel.style.color = '#94a3b8';
            nameLabel.style.whiteSpace = 'nowrap';
            nameLabel.style.overflow = 'hidden';
            nameLabel.style.textOverflow = 'ellipsis';

            const sizeLabel = document.createElement('div');
            sizeLabel.innerText = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
            sizeLabel.style.fontSize = '0.7rem';
            sizeLabel.style.color = '#64748b';

            previewItem.appendChild(videoIcon);
            previewItem.appendChild(nameLabel);
            previewItem.appendChild(sizeLabel);
            previewContainer.appendChild(previewItem);
        }
    }
</script>
@endsection
