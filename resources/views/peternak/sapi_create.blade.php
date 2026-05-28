@extends('layouts.peternak', ['title' => 'Tambah Data Sapi — Sistem Penjualan Sapi'])

@section('page-styles')
<style>
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

    .back-link:hover {
        color: #f1f5f9;
    }

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

    .form-full {
        grid-column: 1 / -1;
    }

    .form-group {
        margin-bottom: 0;
    }

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

    .form-select option {
        background: #1e293b;
        color: #f1f5f9;
    }

    .form-input::placeholder {
        color: #475569;
    }

    .form-input:focus, .form-select:focus {
        border-color: rgba(16, 185, 129, 0.4);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.08);
    }

    .form-hint {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.35rem;
    }

    .input-group {
        position: relative;
    }

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

    .form-input.has-prefix {
        padding-left: 2.5rem;
    }

    .form-input.has-suffix {
        padding-right: 3rem;
    }

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

    .file-upload-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }

    .file-upload-text {
        font-size: 0.85rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .file-upload-hint {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.25rem;
    }

    .file-preview {
        margin-top: 0.75rem;
        display: none;
    }

    .file-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        object-fit: cover;
    }

    .file-preview video {
        max-width: 100%;
        max-height: 200px;
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
        background: linear-gradient(135deg, #10b981, #059669);
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
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.3);
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

    .btn-cancel:hover {
        color: #f1f5f9;
        border-color: rgba(148, 163, 184, 0.3);
    }

    /* Error */
    .form-error-list {
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 12px;
        padding: 0.85rem 1rem;
        margin-bottom: 1.5rem;
        list-style: none;
    }

    .form-error-list li {
        font-size: 0.85rem;
        color: #fca5a5;
        line-height: 1.6;
    }

    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-card {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('page-content')
<a href="{{ route('peternak.penjualan') }}" class="back-link">
    ← Kembali ke Penjualan
</a>

<div class="page-header">
    <h1>Tambah Data Sapi</h1>
    <p>Isi data sapi yang ingin Anda jual.</p>
</div>

@if ($errors->any())
    <ul class="form-error-list">
        @foreach ($errors->all() as $error)
            <li>⚠️ {{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('peternak.sapi.store') }}" enctype="multipart/form-data" id="form-tambah-sapi">
    @csrf

    <div class="form-card">
        <h3>🐮 Informasi Sapi</h3>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="jenis">Jenis Sapi</label>
                <select id="jenis" name="jenis" class="form-select" required>
                    <option value="" disabled {{ old('jenis') ? '' : 'selected' }}>— Pilih jenis —</option>
                    <option value="Limosin" {{ old('jenis') === 'Limosin' ? 'selected' : '' }}>Limosin</option>
                    <option value="Simental" {{ old('jenis') === 'Simental' ? 'selected' : '' }}>Simental</option>
                    <option value="Brahman" {{ old('jenis') === 'Brahman' ? 'selected' : '' }}>Brahman</option>
                    <option value="Bali" {{ old('jenis') === 'Bali' ? 'selected' : '' }}>Bali</option>
                    <option value="Madura" {{ old('jenis') === 'Madura' ? 'selected' : '' }}>Madura</option>
                    <option value="PO (Peranakan Ongole)" {{ old('jenis') === 'PO (Peranakan Ongole)' ? 'selected' : '' }}>PO (Peranakan Ongole)</option>
                    <option value="Angus" {{ old('jenis') === 'Angus' ? 'selected' : '' }}>Angus</option>
                    <option value="Hereford" {{ old('jenis') === 'Hereford' ? 'selected' : '' }}>Hereford</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="umur">Umur</label>
                <div class="input-group">
                    <input type="number" id="umur" name="umur" class="form-input has-suffix" placeholder="Contoh: 24" value="{{ old('umur') }}" min="1" required>
                    <span class="input-suffix">bulan</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="bobot">Bobot</label>
                <div class="input-group">
                    <input type="number" id="bobot" name="bobot" class="form-input has-suffix" placeholder="Contoh: 450" value="{{ old('bobot') }}" min="1" step="0.01" required>
                    <span class="input-suffix">kg</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="harga">Harga</label>
                <div class="input-group">
                    <span class="input-prefix">Rp</span>
                    <input type="number" id="harga" name="harga" class="form-input has-prefix" placeholder="Contoh: 15000000" value="{{ old('harga') }}" min="1" required>
                </div>
            </div>
        </div>
    </div>

    <div class="form-card" style="margin-top: 1.5rem;">
        <h3>📸 Foto & Video</h3>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Foto Sapi</label>
                <div class="file-upload" id="foto-upload-area">
                    <input type="file" name="foto" accept="image/*" id="foto-input" onchange="previewFile(this, 'foto-preview', 'image')">
                    <div class="file-upload-icon">📷</div>
                    <div class="file-upload-text">Klik atau seret foto ke sini</div>
                    <div class="file-upload-hint">JPG, PNG, WebP — Maks 5MB</div>
                </div>
                <div class="file-preview" id="foto-preview"></div>
            </div>

            <div class="form-group">
                <label class="form-label">Video Sapi</label>
                <div class="file-upload" id="video-upload-area">
                    <input type="file" name="video" accept="video/*" id="video-input" onchange="previewFile(this, 'video-preview', 'video')">
                    <div class="file-upload-icon">🎥</div>
                    <div class="file-upload-text">Klik atau seret video ke sini</div>
                    <div class="file-upload-hint">MP4, MOV, AVI, WebM — Maks 50MB</div>
                </div>
                <div class="file-preview" id="video-preview"></div>
            </div>
        </div>
    </div>

    <div class="form-card" style="margin-top: 1.5rem;">
        <h3>🩺 Riwayat Kesehatan</h3>
        <div style="background: rgba(245,158,11,0.06); border: 1px solid rgba(245,158,11,0.15); border-radius: 10px; padding: 1rem; display: flex; align-items: center; gap: 0.75rem;">
            <span style="font-size: 1.25rem;">⏳</span>
            <div>
                <div style="font-size: 0.85rem; font-weight: 600; color: #fcd34d;">Belum Diperiksa</div>
                <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.15rem;">Riwayat kesehatan akan diisi dan diverifikasi oleh Mantri Hewan.</div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-submit" id="btn-simpan-sapi">
            💾 Simpan Data Sapi
        </button>
        <a href="{{ route('peternak.penjualan') }}" class="btn-cancel">
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
                html += '<div class="file-preview-name">✅ ' + file.name + '</div>';
                preview.innerHTML = html;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
