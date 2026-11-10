@extends('layouts.peternak', ['title' => 'Sampah Sapi — Sistem Penjualan Sapi'])

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

    .back-link:hover { color: var(--text-heading); }

    .notice-box {
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.25);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.75rem;
        color: #dc2626;
        font-size: 0.88rem;
        line-height: 1.5;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }
    [data-theme="dark"] .notice-box {
        color: #fca5a5;
    }

    .sapi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .sapi-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        color: var(--text-primary);
    }

    .sapi-card-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: rgba(15, 23, 42, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .sapi-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: grayscale(40%);
    }

    .sapi-card-img-placeholder {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        opacity: 0.4;
        position: relative;
    }

    .sapi-card-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex: 1;
    }

    .sapi-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .sapi-card-jenis {
        font-size: 1.1rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--text-heading);
    }

    .sapi-card-harga {
        font-size: 1rem;
        font-weight: 800;
        color: var(--green-brand);
    }

    .sapi-card-details {
        display: flex;
        gap: 1.25rem;
        margin-bottom: 0.85rem;
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    .deleted-time-text {
        font-size: 0.78rem;
        color: #dc2626;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    [data-theme="dark"] .deleted-time-text {
        color: #f87171;
    }

    .sapi-card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .btn-restore {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        padding: 0.55rem 0.5rem;
        background: rgba(16, 185, 129, 0.15);
        color: var(--green-brand);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        font-family: inherit;
    }

    .btn-restore:hover {
        background: rgba(16, 185, 129, 0.25);
        color: var(--green-brand);
        border-color: rgba(16, 185, 129, 0.5);
        transform: translateY(-1px);
    }

    .btn-force-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        padding: 0.55rem 0.5rem;
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        font-family: inherit;
    }
    [data-theme="dark"] .btn-force-delete {
        color: #fca5a5;
    }

    .btn-force-delete:hover {
        background: rgba(239, 68, 68, 0.25);
        color: #b91c1c;
        border-color: rgba(239, 68, 68, 0.5);
        transform: translateY(-1px);
    }
    [data-theme="dark"] .btn-force-delete:hover {
        color: #f87171;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.08);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 12px;
        padding: 0.85rem 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
        color: var(--green-brand);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>
@endsection

@section('page-content')
<a href="{{ route('peternak.penjualan') }}" class="back-link">
    ← Kembali ke Penjualan
</a>

<div class="page-header">
    <h1>🗑️ Sampah Sapi</h1>
    <p>Data sapi yang telah Anda hapus. Anda dapat memulihkannya kembali atau menghapusnya secara permanen.</p>
</div>

@if (session('success'))
    <div class="alert-success">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="notice-box">
    <span style="font-size: 1.25rem; line-height: 1;">ℹ️</span>
    <div>
        <strong>Petunjuk Sampah:</strong><br>
        Sapi di halaman ini tidak terlihat oleh pembeli di katalog publik. Klik <strong>Pulihkan</strong> untuk mengembalikan sapi ke katalog penjualan Anda, atau <strong>Hapus Permanen</strong> untuk menghapusnya selamanya dari server.
    </div>
</div>

@if ($sapis->isEmpty())
    <div class="content-card">
        <div style="text-align: center; padding: 4rem 1.5rem; color: #64748b;">
            <div style="font-size: 3.5rem; margin-bottom: 1.25rem; opacity: 0.4;">✨</div>
            <h3 style="color: #94a3b8; font-size: 1.15rem; margin-bottom: 0.5rem;">Sampah Anda Kosong</h3>
            <p style="font-size: 0.9rem; max-width: 420px; margin: 0 auto 1.5rem;">Tidak ada data sapi yang berada di dalam sampah saat ini.</p>
            <a href="{{ route('peternak.penjualan') }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.25rem; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 600; text-decoration: none;">
                Kembali ke Penjualan
            </a>
        </div>
    </div>
@else
    <div class="sapi-grid">
        @foreach ($sapis as $sapi)
            <div class="sapi-card" id="sapi-card-{{ $sapi->id }}">
                @if ($sapi->first_foto)
                    <div class="sapi-card-img">
                        <img src="{{ asset('storage/' . $sapi->first_foto) }}" alt="Foto {{ $sapi->jenis }}" loading="lazy">
                        <span style="position: absolute; top: 0.75rem; right: 0.75rem; background: rgba(239, 68, 68, 0.9); color: #fff; padding: 0.25rem 0.6rem; border-radius: 6px; font-size: 0.7rem; font-weight: 700;">
                            Di Sampah
                        </span>
                    </div>
                @else
                    <div class="sapi-card-img-placeholder">🐮
                        <span style="position: absolute; top: 0.75rem; right: 0.75rem; background: rgba(239, 68, 68, 0.9); color: #fff; padding: 0.25rem 0.6rem; border-radius: 6px; font-size: 0.7rem; font-weight: 700;">
                            Di Sampah
                        </span>
                    </div>
                @endif

                <div class="sapi-card-body">
                    <div>
                        <div class="sapi-card-header">
                            <div class="sapi-card-jenis">{{ $sapi->jenis }}</div>
                            <div class="sapi-card-harga">{{ $sapi->harga_formatted }}</div>
                        </div>

                        <div class="sapi-card-details">
                            <div>📅 {{ $sapi->umur_formatted }}</div>
                            <div>⚖️ {{ number_format($sapi->bobot, 0) }} kg</div>
                        </div>

                        <div class="deleted-time-text">
                            <span>🗑️ Dihapus: {{ $sapi->deleted_at->format('d M Y, H:i') }} ({{ $sapi->deleted_at->diffForHumans() }})</span>
                        </div>
                    </div>

                    <div class="sapi-card-actions">
                        {{-- Pulihkan --}}
                        <form method="POST" action="{{ route('peternak.sapi.restore', $sapi->id) }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn-restore" title="Pulihkan kembali sapi ini">
                                <span>♻️</span> Pulihkan
                            </button>
                        </form>

                        {{-- Hapus Permanen --}}
                        <form method="POST" action="{{ route('peternak.sapi.force_delete', $sapi->id) }}" onsubmit="return confirm('PERINGATAN: Sapi {{ $sapi->jenis }} akan DIHAPUS PERMANEN beserta seluruh berkas fotonya dari server. Data tidak dapat dikembalikan. Lanjutkan?')" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-force-delete" title="Hapus Permanen">
                                <span>⚠️</span> Hapus Selamanya
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
