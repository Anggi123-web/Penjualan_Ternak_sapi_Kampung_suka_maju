@extends('layouts.peternak', ['title' => 'Penjualan — Sistem Penjualan Sapi'])

@section('page-styles')
<style>
    .page-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .toolbar-info {
        font-size: 0.9rem;
        color: #94a3b8;
    }

    .toolbar-info strong {
        color: #f1f5f9;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.25rem;
        background: linear-gradient(135deg, #10b981, #059669);
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

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.3);
        color: white;
    }

    /* Sapi Cards Grid */
    .sapi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .sapi-card {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(148, 163, 184, 0.08);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .sapi-card:hover {
        transform: translateY(-4px);
        border-color: rgba(148, 163, 184, 0.15);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
    }

    .sapi-card-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: rgba(15, 23, 42, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sapi-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sapi-card-img-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        opacity: 0.4;
    }

    .sapi-card-body {
        padding: 1.25rem;
    }

    .sapi-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }

    .sapi-card-jenis {
        font-size: 1.1rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #f1f5f9;
    }

    .sapi-card-harga {
        font-size: 1rem;
        font-weight: 800;
        color: #6ee7b7;
    }

    .sapi-card-details {
        display: flex;
        gap: 1.25rem;
        margin-bottom: 0.85rem;
    }

    .sapi-detail-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .sapi-detail-item strong {
        color: #cbd5e1;
    }

    /* Health Badge */
    .health-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
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

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 1.5rem;
        color: #64748b;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1.25rem;
        opacity: 0.4;
    }

    .empty-state h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #94a3b8;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 0.9rem;
        max-width: 420px;
        margin: 0 auto 1.5rem;
        line-height: 1.6;
    }

    /* Alert */
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

    @media (max-width: 640px) {
        .sapi-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('page-content')
<div class="page-header">
    <h1>Penjualan</h1>
    <p>Kelola data sapi Anda untuk dijual.</p>
</div>

@if (session('success'))
    <div class="alert-success">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="page-toolbar">
    <div class="toolbar-info">
        Total: <strong>{{ $sapis->count() }}</strong> sapi
    </div>
    <a href="{{ route('peternak.sapi.create') }}" class="btn-primary" id="btn-tambah-sapi">
        <span>＋</span> Tambah Data Sapi
    </a>
</div>

@if ($sapis->isEmpty())
    <div class="content-card">
        <div class="empty-state">
            <div class="empty-state-icon">🐄</div>
            <h3>Belum Ada Data Sapi</h3>
            <p>Mulai tambahkan data sapi Anda untuk dijual. Klik tombol "Tambah Data Sapi" di atas.</p>
            <a href="{{ route('peternak.sapi.create') }}" class="btn-primary">
                <span>＋</span> Tambah Data Sapi
            </a>
        </div>
    </div>
@else
    <div class="sapi-grid">
        @foreach ($sapis as $sapi)
            <a href="{{ route('peternak.sapi.show', $sapi->id) }}" class="sapi-card" id="sapi-card-{{ $sapi->id }}">
                @if ($sapi->foto)
                    <div class="sapi-card-img">
                        <img src="{{ asset('storage/' . $sapi->foto) }}" alt="Foto {{ $sapi->jenis }}" loading="lazy">
                    </div>
                @else
                    <div class="sapi-card-img-placeholder">🐮</div>
                @endif

                <div class="sapi-card-body">
                    <div class="sapi-card-header">
                        <div class="sapi-card-jenis">{{ $sapi->jenis }}</div>
                        <div class="sapi-card-harga">{{ $sapi->harga_formatted }}</div>
                    </div>

                    <div class="sapi-card-details">
                        <div class="sapi-detail-item">
                            📅 <strong>{{ $sapi->umur_formatted }}</strong>
                        </div>
                        <div class="sapi-detail-item">
                            ⚖️ <strong>{{ number_format($sapi->bobot, 0) }} kg</strong>
                        </div>
                    </div>

                    @if ($sapi->status_kesehatan === 'sehat')
                        <span class="health-badge health-sehat">✅ Terverifikasi Sehat</span>
                    @elseif ($sapi->status_kesehatan === 'tidak_sehat')
                        <span class="health-badge health-tidak-sehat">❌ Tidak Sehat</span>
                    @else
                        <span class="health-badge health-belum">⏳ Belum Diperiksa</span>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
@endif
@endsection
