@extends('layouts.mantri_hewan', ['title' => 'Pemeriksaan — Mantri Hewan', 'menungguCount' => $sapis->count()])

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
        color: #fcd34d;
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

    /* Table Styles */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .data-table thead th {
        background: rgba(15, 23, 42, 0.5);
        color: #94a3b8;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.85rem 1rem;
        text-align: left;
        border-bottom: 1px solid rgba(148, 163, 184, 0.1);
    }

    .data-table thead th:first-child {
        border-radius: 10px 0 0 0;
    }

    .data-table thead th:last-child {
        border-radius: 0 10px 0 0;
    }

    .data-table tbody tr {
        transition: background 0.2s ease;
    }

    .data-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    .data-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.06);
        font-size: 0.88rem;
        color: #e2e8f0;
        vertical-align: middle;
    }

    .table-sapi-info {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .table-sapi-thumb {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid rgba(148, 163, 184, 0.1);
    }

    .table-sapi-thumb-placeholder {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        opacity: 0.5;
    }

    .table-sapi-name {
        font-weight: 700;
        color: #f1f5f9;
        font-size: 0.92rem;
    }

    .table-sapi-peternak {
        font-size: 0.78rem;
        color: #64748b;
        margin-top: 0.15rem;
    }

    .btn-periksa {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
    }

    .btn-periksa:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
        color: white;
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
        margin: 0 auto;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .data-table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .data-table {
            min-width: 600px;
        }
    }
</style>
@endsection

@section('page-content')
<div class="page-header">
    <h1>🔬 Pemeriksaan Sapi</h1>
    <p>Daftar sapi yang menunggu pemeriksaan kesehatan.</p>
</div>

@if (session('success'))
    <div class="alert-success">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="page-toolbar">
    <div class="toolbar-info">
        Menunggu pemeriksaan: <strong>{{ $sapis->count() }}</strong> sapi
    </div>
</div>

@if ($sapis->isEmpty())
    <div class="content-card">
        <div class="empty-state">
            <div class="empty-state-icon">✅</div>
            <h3>Tidak Ada Sapi Menunggu</h3>
            <p>Semua data sapi sudah diperiksa. Sapi baru dari peternak akan muncul di sini secara otomatis.</p>
        </div>
    </div>
@else
    <div class="content-card">
        <div class="data-table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Sapi</th>
                        <th>Umur</th>
                        <th>Bobot</th>
                        <th>Harga</th>
                        <th>Didaftarkan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sapis as $sapi)
                        <tr>
                            <td>
                                <div class="table-sapi-info">
                                    @if ($sapi->first_foto)
                                        <img src="{{ asset('storage/' . $sapi->first_foto) }}" alt="{{ $sapi->jenis }}" class="table-sapi-thumb">
                                    @else
                                        <div class="table-sapi-thumb-placeholder">🐮</div>
                                    @endif
                                    <div>
                                        <div class="table-sapi-name">{{ $sapi->jenis }}</div>
                                        <div class="table-sapi-peternak">oleh {{ $sapi->peternak->name ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $sapi->umur_formatted }}</td>
                            <td>{{ number_format($sapi->bobot, 0) }} kg</td>
                            <td>{{ $sapi->harga_formatted }}</td>
                            <td>{{ $sapi->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="health-badge health-belum">⏳ Belum Diperiksa</span>
                            </td>
                            <td>
                                <a href="{{ route('mantri_hewan.pemeriksaan.show', $sapi->id) }}" class="btn-periksa" id="btn-periksa-{{ $sapi->id }}">
                                    🔬 Periksa
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
