@extends('layouts.app')

@section('title', 'Tambah Edukasi — Pengurus Kampung')

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;">🏘️ Pengurus Kampung</span>
    <button class="hamburger" onclick="toggleSidebar()">☰</button>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    @include('dashboard.partials.sidebar_pengurus_kampung')

    <main class="main-content">
        <div class="page-header">
            <h1>Tambah Pamflet Edukasi</h1>
            <p>Unggah pamflet edukasi baru untuk ditampilkan di beranda.</p>
        </div>

        <div class="content-card" style="max-width: 800px;">
            <form action="{{ route('pengurus_kampung.edukasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="judul" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #334155;">Judul Edukasi</label>
                    <input type="text" name="judul" id="judul" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem;" required>
                    @error('judul')
                        <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="gambar" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #334155;">Gambar Pamflet Utama (Banner)</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem;" required>
                    <small style="color: #64748b; font-size: 0.85rem; display: block; margin-top: 0.25rem;">Format didukung: JPG, PNG, JPEG. Ukuran maks: 5MB. Direkomendasikan: 629 x 192 px.</small>
                    @error('gambar')
                        <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="deskripsi" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #334155;">Keterangan / Deskripsi Awal</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem;" placeholder="Tuliskan keterangan singkat..."></textarea>
                    @error('deskripsi')
                        <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>

                <hr style="margin: 2rem 0; border: none; border-top: 1px solid #e2e8f0;">

                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1e293b; margin-bottom: 1rem;">Susun Konten Edukasi</h3>
                    <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 1.5rem;">Tambahkan poin-poin penjelasan atau gambar tambahan untuk menyusun informasi secara berurutan.</p>

                    <div id="dynamic-blocks-container">
                        <!-- Dynamic blocks will be appended here -->
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                        <button type="button" onclick="addBlock('poin')" style="padding: 0.5rem 1rem; border-radius: 0.5rem; background: #f1f5f9; color: #3b82f6; border: 1px dashed #3b82f6; cursor: pointer; font-weight: 600;">+ Tambah Poin</button>
                        <button type="button" onclick="addBlock('gambar')" style="padding: 0.5rem 1rem; border-radius: 0.5rem; background: #f1f5f9; color: #10b981; border: 1px dashed #10b981; cursor: pointer; font-weight: 600;">+ Tambah Gambar</button>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <a href="{{ route('pengurus_kampung.edukasi.index') }}" class="btn-secondary" style="padding: 0.75rem 1.5rem; border-radius: 0.5rem; background: #f1f5f9; color: #475569; text-decoration: none; border: 1px solid #cbd5e1;">Batal</a>
                    <button type="submit" class="btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 0.5rem; background: #8b5cf6; color: white; border: none; cursor: pointer;">Simpan Edukasi</button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    let blockIndex = 0;

    function addBlock(type) {
        const container = document.getElementById('dynamic-blocks-container');
        const blockDiv = document.createElement('div');
        blockDiv.className = 'dynamic-block';
        blockDiv.style.cssText = 'padding: 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.5rem; margin-bottom: 1rem; position: relative;';
        
        // Remove button
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.innerHTML = '×';
        removeBtn.style.cssText = 'position: absolute; top: 0.5rem; right: 0.5rem; background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer; line-height: 1;';
        removeBtn.onclick = function() { blockDiv.remove(); };
        blockDiv.appendChild(removeBtn);

        // Hidden input for type
        const typeInput = document.createElement('input');
        typeInput.type = 'hidden';
        typeInput.name = `blocks[${blockIndex}][type]`;
        typeInput.value = type;
        blockDiv.appendChild(typeInput);

        // Label
        const label = document.createElement('label');
        label.style.cssText = 'display: block; margin-bottom: 0.5rem; font-weight: 600; color: #334155;';

        if (type === 'poin') {
            label.innerText = 'Teks Poin (Bullet)';
            const input = document.createElement('textarea');
            input.name = `blocks[${blockIndex}][content]`;
            input.rows = 2;
            input.className = 'form-control';
            input.style.cssText = 'width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; resize: vertical;';
            input.required = true;
            input.placeholder = 'Tuliskan poin penjelasan...';
            
            blockDiv.appendChild(label);
            blockDiv.appendChild(input);
        } else if (type === 'gambar') {
            label.innerText = 'Gambar Tambahan';
            const input = document.createElement('input');
            input.type = 'file';
            input.name = `blocks[${blockIndex}][file]`; // Controller looks for [file]
            input.accept = 'image/*';
            input.className = 'form-control';
            input.style.cssText = 'width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; background: white;';
            input.required = true;

            blockDiv.appendChild(label);
            blockDiv.appendChild(input);
        }

        container.appendChild(blockDiv);
        blockIndex++;
    }

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('open');
    }
</script>
@endsection
