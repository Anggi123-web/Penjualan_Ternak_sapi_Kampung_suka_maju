@extends('layouts.mantri_hewan', ['title' => 'Pemeriksaan ' . $sapi->jenis . ' — Mantri Hewan'])

@section('page-styles')
    <style>
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.2s ease;
            margin-bottom: 1.5rem;
        }

        .back-link:hover {
            color: var(--text-heading);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .detail-media {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .detail-media img {
            width: 100%;
            height: 350px;
            object-fit: cover;
        }

        .detail-media-placeholder {
            width: 100%;
            height: 350px;
            background: var(--bg-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 6rem;
            opacity: 0.3;
        }

        .detail-media video {
            width: 100%;
            max-height: 350px;
            border-radius: 0 0 16px 16px;
            background: #000;
        }

        .info-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            color: var(--text-primary);
        }

        .info-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            letter-spacing: -0.02em;
            color: var(--text-heading);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .info-value {
            color: var(--text-heading);
            font-size: 0.92rem;
            font-weight: 600;
            text-align: right;
        }

        .info-value.harga {
            color: var(--green-brand);
            font-size: 1.05rem;
            font-weight: 800;
        }

        .peternak-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.15);
            border-radius: 10px;
            padding: 0.5rem 0.85rem;
            font-size: 0.82rem;
            color: #6ee7b7;
        }

        .health-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.65rem;
            border-radius: 8px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .health-belum {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: #fcd34d;
        }

        .health-sehat {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .health-tidak-sehat {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        /* Form Verifikasi */
        .verifikasi-form {
            margin-top: 1.5rem;
        }

        .verifikasi-form h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            letter-spacing: -0.02em;
        }


        .radio-group {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .radio-option {
            flex: 1;
            position: relative;
        }

        .radio-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .radio-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem;
            border-radius: 12px;
            border: 2px solid rgba(148, 163, 184, 0.15);
            background: rgba(15, 23, 42, 0.5);
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .radio-option label:hover {
            border-color: rgba(148, 163, 184, 0.3);
            background: rgba(15, 23, 42, 0.8);
        }

        .radio-option input[type="radio"]:checked+label.label-sehat {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
            color: #6ee7b7;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.15);
        }

        .radio-option input[type="radio"]:checked+label.label-tidak-sehat {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.15);
        }
        [data-theme="dark"] .radio-option input[type="radio"]:checked+label.label-tidak-sehat {
            color: #fca5a5;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-group textarea {
            width: 100%;
            padding: 0.85rem 1rem;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 10px;
            color: var(--text-primary);
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            resize: vertical;
            min-height: 120px;
            transition: border-color 0.2s ease;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .form-group textarea::placeholder {
            color: var(--text-muted);
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 1.5rem;
            background: linear-gradient(135deg, #f59e0b, #d97706);
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
            box-shadow: 0 6px 20px rgba(217, 119, 6, 0.3);
        }

        .form-error {
            color: #fca5a5;
            font-size: 0.8rem;
            margin-top: 0.35rem;
        }

        @media (max-width: 768px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .radio-group {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('page-content')
    <a href="{{ route('mantri_hewan.dashboard') }}" class="back-link">
        ← Kembali ke Dashboard Mantri
    </a>

    <div class="page-header">
        <h1>🔬 Pemeriksaan: {{ $sapi->jenis }}</h1>
        <p>Periksa dan verifikasi kelayakan sapi untuk masuk katalog pembeli.</p>
    </div>

    <div class="detail-grid">
        {{-- Foto & Video --}}
        <div>
            @php
                $fotos = is_array($sapi->foto) ? $sapi->foto : ($sapi->foto ? [$sapi->foto] : []);
                $videos = is_array($sapi->video) ? $sapi->video : ($sapi->video ? [$sapi->video] : []);
            @endphp

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 0.75rem;">
                @forelse ($fotos as $fPath)
                    <div class="detail-media" style="height: 100px;">
                        <a href="{{ asset('storage/' . $fPath) }}" target="_blank">
                            <img src="{{ asset('storage/' . $fPath) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                        </a>
                    </div>
                @empty
                    <div class="detail-media" style="grid-column: 1 / -1;">
                        <div class="detail-media-placeholder">🐮</div>
                    </div>
                @endforelse
            </div>

            @if (count($videos) > 0)
                <div style="margin-top: 1.5rem;">
                    @foreach ($videos as $vPath)
                        <div class="detail-media" style="margin-top: 0.75rem; border-radius: 12px; overflow: hidden;">
                            <video controls style="width: 100%; background: black;">
                                <source src="{{ asset('storage/' . $vPath) }}" type="video/mp4">
                                Browser Anda tidak mendukung pemutaran video.
                            </video>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Info Sapi --}}
        <div>
            <div class="info-card">
                <h3>📋 Informasi Sapi</h3>
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
                    <span class="info-value">{{ number_format($sapi->bobot, 0) }} kg</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Harga</span>
                    <span class="info-value harga">{{ $sapi->harga_formatted }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if ($sapi->status_kesehatan === 'sehat')
                            <span class="health-badge health-sehat">✅ Sehat</span>
                        @elseif ($sapi->status_kesehatan === 'tidak_sehat')
                            <span class="health-badge health-tidak-sehat">❌ Tidak Sehat</span>
                        @else
                            <span class="health-badge health-belum">⏳ Belum Diperiksa</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Didaftarkan</span>
                    <span class="info-value">{{ $sapi->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            <div class="info-card" style="margin-top: 1rem;">
                <h3>👤 Pemilik (Peternak)</h3>
                <div class="info-row">
                    <span class="info-label">Nama</span>
                    <span class="peternak-badge">🐄 {{ $sapi->peternak->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $sapi->peternak->email ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Verifikasi --}}
    @if ($sapi->status_kesehatan === 'belum_diperiksa')
        <div class="content-card verifikasi-form">
            <h3>📝 Form Verifikasi Kesehatan</h3>
            <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 1.5rem;">
                Berikan hasil pemeriksaan kesehatan untuk sapi ini. Hanya sapi yang dinyatakan <strong
                    style="color: #6ee7b7;">sehat</strong> yang akan tampil di katalog pembeli.
            </p>

            <form action="{{ route('mantri_hewan.verifikasi', $sapi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Status Kesehatan *</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" name="status_kesehatan" id="status-sehat" value="sehat"
                                {{ old('status_kesehatan') === 'sehat' ? 'checked' : '' }}>
                            <label for="status-sehat" class="label-sehat">✅ Sehat — Layak Dijual</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" name="status_kesehatan" id="status-tidak-sehat" value="tidak_sehat"
                                {{ old('status_kesehatan') === 'tidak_sehat' ? 'checked' : '' }}>
                            <label for="status-tidak-sehat" class="label-tidak-sehat">❌ Tidak Sehat — Ditolak</label>
                        </div>
                    </div>
                    @error('status_kesehatan')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="catatan_kesehatan">Catatan Kesehatan *</label>
                    <textarea name="catatan_kesehatan" id="catatan_kesehatan"
                        placeholder="Tuliskan hasil pemeriksaan, kondisi fisik, riwayat vaksinasi, dan catatan lainnya...">{{ old('catatan_kesehatan') }}</textarea>
                    @error('catatan_kesehatan')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="dokumen_pemeriksaan">Upload Dokumen Pemeriksaan (PDF)</label>
                    <input type="file" name="dokumen_pemeriksaan" id="dokumen_pemeriksaan" accept=".pdf"
                        style="width: 100%; padding: 0.75rem 1rem; background: var(--input-bg); border: 1px solid var(--input-border); border-radius: 10px; color: var(--text-primary); font-size: 0.9rem;">
                    <span style="display: block; color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.35rem;">* Format file: PDF (Maksimal 10 MB)</span>
                    @error('dokumen_pemeriksaan')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-submit" id="btn-submit-verifikasi">
                    📋 Submit Verifikasi
                </button>
            </form>
        </div>
    @else
        <div class="content-card">
            <h3>📋 Hasil Verifikasi</h3>
            <div class="info-row">
                <span class="info-label">Diverifikasi oleh</span>
                <span class="info-value">{{ $sapi->verifier->name ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Verifikasi</span>
                <span class="info-value">{{ $sapi->verified_at ? $sapi->verified_at->format('d M Y, H:i') : '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Catatan</span>
                <span class="info-value"
                    style="max-width: 60%; text-align: right; line-height: 1.5;">{{ $sapi->catatan_kesehatan ?? '-' }}</span>
            </div>
            @if($sapi->dokumen_pemeriksaan)
                <div class="info-row">
                    <span class="info-label">Dokumen Pemeriksaan</span>
                    <span class="info-value">
                        <a href="{{ asset('storage/' . $sapi->dokumen_pemeriksaan) }}" target="_blank"
                           style="color: #6ee7b7; text-decoration: underline; display: inline-flex; align-items: center; gap: 0.4rem;">
                            📄 Unduh Dokumen (PDF)
                        </a>
                    </span>
                </div>
            @endif
        </div>
    @endif
@endsection
