@extends('layouts.app')

@section('title', 'Unggah Iklan Carousel — ' . (auth()->user()->role === 'peternak' ? 'Panel Peternak' : 'Pengurus Kampung'))

@section('styles')
<style>
    .form-container-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 2rem;
        max-width: 720px;
        box-shadow: var(--card-shadow);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text-heading);
        margin-bottom: 0.5rem;
    }

    .form-input-text {
        width: 100%;
        padding: 0.85rem 1rem;
        background: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--text-primary);
        border-radius: 10px;
        font-size: 0.92rem;
        font-family: 'Inter', sans-serif;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-input-text:focus {
        border-color: var(--green-brand);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }

    .file-drop-area {
        position: relative;
        border: 2px dashed var(--border-strong);
        background: var(--bg-muted);
        border-radius: 14px;
        padding: 2.2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .file-drop-area:hover, .file-drop-area.dragover {
        border-color: var(--green-brand);
        background: var(--green-subtle);
    }

    .file-drop-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .file-drop-icon {
        font-size: 2.5rem;
        color: var(--green-brand);
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .file-drop-text {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .file-drop-hint {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    .preview-box {
        margin-top: 1rem;
        display: none;
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        background: var(--bg-surface);
    }

    .preview-box img {
        width: 100%;
        max-height: 220px;
        object-fit: cover;
        display: block;
    }

    .preview-tag {
        padding: 0.5rem 0.85rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--bg-muted);
        border-top: 1px solid var(--border-color);
    }

    .back-nav-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 0.88rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        transition: color 0.2s ease;
    }

    .back-nav-link:hover {
        color: var(--green-brand);
    }

    .btn-submit-iklan {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        padding: 0.9rem 1.5rem;
        background: linear-gradient(135deg, #00A740, #008f38);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(0, 167, 64, 0.3);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-submit-iklan:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 167, 64, 0.4);
    }

    .info-banner-rekomendasi {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.85rem 1rem;
        background: var(--accent-blue-bg);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        font-size: 0.82rem;
        color: var(--accent-blue-text);
        margin-top: 0.75rem;
        line-height: 1.5;
    }
</style>
@endsection

@section('content')
<div class="mobile-header">
    <div style="display: flex; align-items: center; gap: 8px;">
        <img src="{{ asset('images/sipeter_logo.png') }}" class="app-sidebar-logo" alt="Logo" style="height: 28px; width: auto; object-fit: contain;">
        <span style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary);">
            {{ auth()->user()->role === 'peternak' ? 'Panel Peternak' : 'Pengurus Kampung' }}
        </span>
    </div>
    <div style="display: flex; align-items: center; gap: 8px;">
        @include('partials.theme_toggle', ['id' => 'iklanCreateMobileThemeToggle', 'iconOnly' => true])
        <button class="hamburger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    </div>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    @if(auth()->user()->role === 'peternak')
        @include('dashboard.partials.sidebar_peternak')
    @else
        @include('dashboard.partials.sidebar_pengurus_kampung')
    @endif

    <main class="main-content">
        <a href="{{ route('iklan.index') }}" class="back-nav-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Iklan
        </a>

        <div class="page-header" style="margin-bottom: 1.5rem;">
            <h1><i class="bi bi-cloud-arrow-up" style="color: var(--green-brand); margin-right: 0.35rem;"></i> Unggah Iklan Carousel</h1>
            <p style="color: var(--text-secondary); margin: 0.25rem 0 0 0;">
                Tambahkan materi promosi untuk carousel banner yang tampil di beranda aplikasi.
            </p>
        </div>

        <div class="form-container-card">
            <form action="{{ route('iklan.store') }}" method="POST" enctype="multipart/form-data" id="form-upload-iklan">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="judul">Judul Iklan (Opsional)</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" placeholder="Contoh: Promo Sapi Qurban Idul Adha 1446 H" class="form-input-text">
                    @error('judul')
                        <span style="color: var(--accent-red-text); font-size: 0.82rem; margin-top: 0.35rem; display: block; font-weight: 600;">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Berkas Gambar Banner <span style="color: var(--accent-red-text);">*</span></label>
                    <div class="file-drop-area" id="file-drop-zone">
                        <input type="file" name="gambar" id="gambar-input" required accept="image/jpeg,image/png,image/jpg,image/webp">
                        <div class="file-drop-icon">
                            <i class="bi bi-image"></i>
                        </div>
                        <div class="file-drop-text" id="file-drop-title">Pilih atau Seret Foto Banner ke Sini</div>
                        <div class="file-drop-hint">Format yang didukung: JPG, JPEG, PNG, WebP (Maksimal 10MB)</div>
                    </div>

                    <div class="preview-box" id="preview-container">
                        <img id="preview-image" src="" alt="Pratinjau Banner">
                        <div class="preview-tag">
                            <span id="preview-filename"><i class="bi bi-file-earmark-image"></i> berkas_terpilih.jpg</span>
                            <span style="color: var(--green-brand); font-weight: 700;">Siap Diunggah</span>
                        </div>
                    </div>

                    <div class="info-banner-rekomendasi">
                        <i class="bi bi-info-circle-fill" style="font-size: 1.1rem; flex-shrink: 0; margin-top: 1px;"></i>
                        <div>
                            <strong>Tips Format Banner:</strong> Disarankan menggunakan gambar berorientasi landscape dengan rasio proporsional sekitar <strong>1638 x 500 pixel</strong> agar tampil optimal dan tidak terpotong pada carousel beranda.
                        </div>
                    </div>

                    @error('gambar')
                        <span style="color: var(--accent-red-text); font-size: 0.82rem; margin-top: 0.35rem; display: block; font-weight: 600;">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit-iklan">
                    <i class="bi bi-cloud-arrow-up-fill"></i> Simpan & Unggah Iklan
                </button>
            </form>
        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('open');
    }

    const fileInput = document.getElementById('gambar-input');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const previewFilename = document.getElementById('preview-filename');
    const dropZone = document.getElementById('file-drop-zone');

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    previewImage.src = evt.target.result;
                    previewFilename.innerHTML = '<i class="bi bi-file-earmark-image"></i> ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
        });
    }
</script>

@if(auth()->user()->role === 'peternak')
    @include('partials.chat_box')
@endif
@endsection
