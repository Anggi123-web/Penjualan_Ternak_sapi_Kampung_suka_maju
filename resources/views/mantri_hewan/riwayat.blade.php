@extends('layouts.mantri_hewan', ['title' => 'Riwayat Verifikasi — Mantri Hewan'])

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
        color: var(--text-secondary);
    }

    .toolbar-info strong {
        color: var(--text-heading);
    }

    .filter-group {
        display: flex;
        gap: 0.5rem;
    }

    .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid var(--border-color);
        background: var(--bg-card);
        color: var(--text-secondary);
        font-family: 'Inter', sans-serif;
        cursor: pointer;
    }

    .filter-btn:hover {
        border-color: var(--text-secondary);
        color: var(--text-heading);
    }

    .filter-btn.active {
        background: rgba(245, 158, 11, 0.15);
        border-color: rgba(245, 158, 11, 0.35);
        color: var(--accent-amber-text);
    }

    /* Table Styles */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .data-table thead th {
        background: var(--bg-muted);
        color: var(--text-secondary);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.85rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
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
        background: rgba(255, 255, 255, 0.04);
    }

    .data-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.88rem;
        color: var(--text-primary);
        vertical-align: middle;
    }

    .table-sapi-info {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .table-sapi-thumb {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid var(--border-color);
    }

    .table-sapi-thumb-placeholder {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: var(--bg-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        opacity: 0.6;
    }

    .table-sapi-name {
        font-weight: 700;
        color: var(--text-heading);
        font-size: 0.88rem;
    }

    .table-sapi-peternak {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.1rem;
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

    .health-sehat {
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: var(--green-brand);
    }

    .health-tidak-sehat {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #dc2626;
    }
    [data-theme="dark"] .health-tidak-sehat {
        color: #fca5a5;
    }

    .catatan-cell {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: var(--text-secondary);
        font-size: 0.82rem;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        background: rgba(59, 130, 246, 0.12);
        border: 1px solid rgba(59, 130, 246, 0.25);
        color: var(--accent-blue-text);
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-detail:hover {
        background: rgba(59, 130, 246, 0.22);
        border-color: rgba(59, 130, 246, 0.4);
        color: var(--accent-blue-text);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 1.5rem;
        color: var(--text-secondary);
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1.25rem;
        opacity: 0.4;
    }

    .empty-state h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-heading);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 0.9rem;
        max-width: 420px;
        margin: 0 auto;
        line-height: 1.6;
        color: var(--text-secondary);
    }

    @media (max-width: 768px) {
        .data-table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .data-table {
            min-width: 700px;
        }

        .page-toolbar {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('page-content')
<div class="page-header">
    <h1>📋 Riwayat Verifikasi</h1>
    <p>Daftar sapi yang sudah diverifikasi oleh Mantri Hewan.</p>
</div>

<div class="page-toolbar">
    <div class="toolbar-info">
        Total: <strong>{{ $sapis->count() }}</strong> sapi terverifikasi
    </div>
    <div class="filter-group">
        <a href="{{ route('mantri_hewan.riwayat') }}" class="filter-btn {{ !$filterStatus ? 'active' : '' }}">Semua</a>
        <a href="{{ route('mantri_hewan.riwayat', ['status' => 'sehat']) }}" class="filter-btn {{ $filterStatus === 'sehat' ? 'active' : '' }}">✅ Sehat</a>
        <a href="{{ route('mantri_hewan.riwayat', ['status' => 'tidak_sehat']) }}" class="filter-btn {{ $filterStatus === 'tidak_sehat' ? 'active' : '' }}">❌ Tidak Sehat</a>
    </div>
</div>

@if ($sapis->isEmpty())
    <div class="content-card">
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h3>Belum Ada Riwayat</h3>
            <p>Belum ada sapi yang diverifikasi. Mulai periksa sapi dari halaman Pemeriksaan.</p>
        </div>
    </div>
@else
    <div class="content-card">
        <div class="data-table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Sapi</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Diverifikasi Oleh</th>
                        <th>Tanggal</th>
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
                            <td>
                                @if ($sapi->status_kesehatan === 'sehat')
                                    <span class="health-badge health-sehat">✅ Sehat</span>
                                @else
                                    <span class="health-badge health-tidak-sehat">❌ Tidak Sehat</span>
                                @endif
                            </td>
                            <td>
                                <div class="catatan-cell" title="{{ $sapi->catatan_kesehatan }}">
                                    {{ $sapi->catatan_kesehatan ?? '-' }}
                                </div>
                            </td>
                            <td>{{ $sapi->verifier->name ?? '-' }}</td>
                            <td>{{ $sapi->verified_at ? $sapi->verified_at->format('d M Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('mantri_hewan.pemeriksaan.show', $sapi->id) }}" class="btn-detail">
                                    👁️ Detail
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
