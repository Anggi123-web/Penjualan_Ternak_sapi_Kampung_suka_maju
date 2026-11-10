@extends('layouts.app')

@section('title', 'Direktori Data Peternak — Pengurus Kampung')

@section('styles')
<style>
    /* Filter & Tabs Panel */
    .verif-tabs-bar {
        display: flex;
        gap: 0.6rem;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
    }

    .verif-tab-item {
        padding: 0.6rem 1.15rem;
        border-radius: 12px;
        font-size: 0.86rem;
        font-weight: 700;
        color: var(--text-secondary);
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        transition: all 0.2s ease;
    }

    .verif-tab-item:hover {
        color: var(--text-primary);
        border-color: #8b5cf6;
        transform: translateY(-1px);
    }

    .verif-tab-item.active {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(124, 58, 237, 0.15));
        border-color: #8b5cf6;
        color: #c4b5fd;
    }

    .verif-tab-badge {
        font-size: 0.72rem;
        padding: 2px 7px;
        border-radius: 999px;
        background: rgba(148, 163, 184, 0.18);
        color: #94a3b8;
    }

    .verif-tab-item.active .verif-tab-badge {
        background: #8b5cf6;
        color: #ffffff;
    }

    .badge-pulse-amber {
        background: #f59e0b !important;
        color: #0f172a !important;
        font-weight: 800;
        box-shadow: 0 0 10px rgba(245, 158, 11, 0.5);
    }

    .filter-panel {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .search-input-group {
        display: flex;
        align-items: center;
        background: var(--bg-muted, #f1f5f9);
        border: 1px solid var(--border-color, #cbd5e1);
        border-radius: 12px;
        padding: 0.55rem 1rem;
        gap: 0.75rem;
        flex: 1;
        min-width: 260px;
    }

    [data-theme="dark"] .search-input-group {
        background: rgba(15, 23, 42, 0.7);
        border-color: rgba(148, 163, 184, 0.2);
    }

    .search-input-group input {
        background: transparent;
        border: none;
        outline: none;
        color: var(--text-primary, #0f172a);
        font-size: 0.9rem;
        width: 100%;
    }

    .search-input-group input::placeholder {
        color: var(--text-muted, #64748b);
    }

    /* List Table Card */
    .peternak-list-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .peternak-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
        text-align: left;
    }

    .peternak-table th {
        padding: 0.9rem 1rem;
        background: var(--bg-muted);
        color: var(--text-secondary);
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--border-color);
        white-space: nowrap;
    }

    .peternak-table td {
        padding: 1rem 1rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
        vertical-align: middle;
    }

    .peternak-table tr:hover td {
        background: var(--bg-muted);
    }

    .peternak-table tr:last-child td {
        border-bottom: none;
    }

    .user-info-cell {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .peternak-avatar-sm {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(139,92,246,0.25), rgba(124,58,237,0.2));
        border: 1px solid rgba(139,92,246,0.35);
        color: #7c3aed;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        flex-shrink: 0;
    }
    [data-theme="dark"] .peternak-avatar-sm {
        color: #c4b5fd;
    }

    .nik-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--bg-muted);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        font-size: 0.74rem;
        font-family: monospace;
        padding: 2px 7px;
        border-radius: 6px;
    }

    .btn-wa-sm {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 8px;
        background: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.35);
        color: #065f46;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-top: 4px;
    }
    [data-theme="dark"] .btn-wa-sm {
        color: #6ee7b7;
    }

    .btn-wa-sm:hover {
        background: #10b981;
        color: #ffffff;
    }

    .doc-btn-sm {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        background: var(--bg-muted);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-primary);
        font-size: 0.74rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .doc-btn-sm:hover {
        background: rgba(139, 92, 246, 0.15);
        border-color: #8b5cf6;
        color: #6d28d9;
    }
    [data-theme="dark"] .doc-btn-sm:hover {
        background: rgba(139, 92, 246, 0.25);
        color: #c4b5fd;
    }

    /* Verification Status Badges */
    .badge-status-verif {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-menunggu {
        background: #fef3c7;
        border: 1px solid #f59e0b;
        color: #92400e;
    }
    [data-theme="dark"] .status-menunggu {
        background: rgba(245, 158, 11, 0.15);
        border-color: rgba(245, 158, 11, 0.4);
        color: #fcd34d;
    }

    .status-terverifikasi {
        background: #d1fae5;
        border: 1px solid #10b981;
        color: #065f46;
    }
    [data-theme="dark"] .status-terverifikasi {
        background: rgba(16, 185, 129, 0.15);
        border-color: rgba(16, 185, 129, 0.4);
        color: #6ee7b7;
    }

    .status-ditolak {
        background: #fee2e2;
        border: 1px solid #ef4444;
        color: #991b1b;
    }
    [data-theme="dark"] .status-ditolak {
        background: rgba(239, 68, 68, 0.15);
        border-color: rgba(239, 68, 68, 0.4);
        color: #fca5a5;
    }

    /* Table Action Buttons */
    .action-button-group {
        display: flex;
        align-items: center;
        gap: 6px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-action-approve {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.45rem 0.85rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        border: none;
        border-radius: 9px;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .btn-action-approve:hover {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        color: #ffffff;
    }

    .btn-action-reject {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.45rem 0.75rem;
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.35);
        color: #fca5a5;
        border-radius: 9px;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .btn-action-reject:hover {
        background: #ef4444;
        color: #ffffff;
    }

    .btn-action-wa-send {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.45rem 0.85rem;
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.35);
        color: #6ee7b7;
        border-radius: 9px;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .btn-action-wa-send:hover {
        background: #10b981;
        color: #ffffff;
    }

    .btn-action-view {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.45rem 0.85rem;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: #ffffff;
        border-radius: 9px;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .btn-action-view:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
        color: #ffffff;
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        z-index: 999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content-box {
        background: #1e293b;
        border: 1px solid rgba(148, 163, 184, 0.2);
        border-radius: 20px;
        max-width: 600px;
        width: 100%;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
        animation: popUp 0.25s ease-out;
    }

    @keyframes popUp {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-header-box {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header-box h4 {
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0;
    }

    .modal-close-btn {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 1.5rem;
        cursor: pointer;
        line-height: 1;
    }

    .modal-close-btn:hover {
        color: #ffffff;
    }

    .modal-body-box {
        padding: 1.5rem;
        text-align: center;
    }

    .modal-body-box img {
        max-width: 100%;
        max-height: 70vh;
        border-radius: 12px;
        object-fit: contain;
        border: 1px solid rgba(148, 163, 184, 0.15);
    }
</style>
@endsection

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;"><i class="bi bi-houses"></i> Pengurus Kampung</span>
    <button class="hamburger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    @include('dashboard.partials.sidebar_pengurus_kampung')

    <main class="main-content">
        <div class="page-header">
            <h1><i class="bi bi-people-fill" style="color: #c4b5fd;"></i> Direktori Data Peternak</h1>
            <p>Verifikasi pendaftaran akun peternak baru dan kelola seluruh peternak binaan Kampung Suka Maju.</p>
        </div>

        {{-- WhatsApp Notification Popup Banner upon Verification --}}
        @if(session('wa_url'))
            <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(5, 150, 105, 0.25)); border: 1px solid rgba(16, 185, 129, 0.4); border-radius: 16px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.2);">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0;">
                        <i class="bi bi-whatsapp"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 4px 0; color: #6ee7b7; font-size: 1rem; font-weight: 800;">
                            {{ session('verified_peternak') ? 'Akun Peternak Telah Berhasil Diverifikasi!' : 'Pemberitahuan Akun Peternak' }}
                        </h4>
                        <p style="margin: 0; color: #cbd5e1; font-size: 0.85rem;">
                            @if(session('verified_peternak'))
                                Notifikasi aktivasi akun dan tautan login siap dikirimkan ke WhatsApp <strong>{{ session('verified_peternak') }}</strong> ({{ session('verified_phone') }}).
                            @elseif(session('rejected_peternak'))
                                Catatan penolakan pendaftaran untuk <strong>{{ session('rejected_peternak') }}</strong> siap dikirimkan via WhatsApp.
                            @else
                                Pesan resmi WhatsApp telah disiapkan untuk dikirimkan ke peternak.
                            @endif
                        </p>
                    </div>
                </div>
                <div style="display: flex; gap: 0.6rem; align-items: center;">
                    <a href="{{ session('wa_url') }}" target="_blank" id="btnAutoWa" class="btn-action-approve" style="padding: 0.7rem 1.4rem; font-size: 0.9rem; text-decoration: none;">
                        <i class="bi bi-whatsapp"></i> Buka WhatsApp & Kirim Sekarang
                    </a>
                </div>
            </div>

            <script>
                // Otomatis buka WhatsApp di tab baru saat verifikasi selesai
                document.addEventListener('DOMContentLoaded', function() {
                    const waUrl = @json(session('wa_url'));
                    if (waUrl) {
                        try {
                            const newWin = window.open(waUrl, '_blank');
                            if (!newWin || newWin.closed || typeof newWin.closed === 'undefined') {
                                console.log('Popup blocker prevented automatic tab open. Fallback button is visible.');
                            }
                        } catch (err) {
                            console.log('Auto open error:', err);
                        }
                    }
                });
            </script>
        @endif

        @if(session('success') && !session('wa_url'))
            <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.35); color: #6ee7b7; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                <i class="bi bi-check-circle-fill" style="font-size: 1.2rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('warning') && !session('wa_url'))
            <div style="background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.35); color: #fcd34d; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.2rem;"></i>
                <span>{{ session('warning') }}</span>
            </div>
        @endif

        <!-- Metric KPI Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Perlu Verifikasi</span>
                    <div class="stat-card-icon" style="background: rgba(245,158,11,0.1); color: #fcd34d;"><i class="bi bi-person-badge"></i></div>
                </div>
                <div class="stat-card-value" style="color: {{ $countMenunggu > 0 ? '#fcd34d' : '#94a3b8' }};">{{ $countMenunggu }}</div>
                <div class="stat-card-change" style="color: {{ $countMenunggu > 0 ? '#fcd34d' : '#94a3b8' }};">
                    {{ $countMenunggu > 0 ? 'Pendaftaran baru menunggu aparat' : 'Tidak ada permohonan tertunda' }}
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Peternak Terverifikasi</span>
                    <div class="stat-card-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;"><i class="bi bi-person-check"></i></div>
                </div>
                <div class="stat-card-value">{{ $countTerverifikasi }}</div>
                <div class="stat-card-change" style="color: #6ee7b7;">Akun aktif siap jualan</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Populasi Sapi</span>
                    <div class="stat-card-icon" style="background: rgba(59,130,246,0.1); color: #93c5fd;"><i class="bi bi-piggy-bank"></i></div>
                </div>
                <div class="stat-card-value">{{ $totalSapiWilayah }}</div>
                <div class="stat-card-change">Ekor dalam database</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Omset Penjualan</span>
                    <div class="stat-card-icon" style="background: rgba(139,92,246,0.1); color: #c4b5fd;"><i class="bi bi-cash-coin"></i></div>
                </div>
                <div class="stat-card-value" style="font-size: 1.45rem;">Rp {{ number_format($totalOmsetWilayah, 0, ',', '.') }}</div>
                <div class="stat-card-change" style="color: #c4b5fd;">Total perputaran wilayah</div>
            </div>
        </div>

        <!-- Verification Status Tabs -->
        <div class="verif-tabs-bar">
            <a href="{{ route('pengurus_kampung.peternak.index', array_merge(request()->query(), ['status_verifikasi' => 'menunggu_verifikasi'])) }}"
               class="verif-tab-item {{ $filterVerifikasi === 'menunggu_verifikasi' ? 'active' : '' }}">
                <i class="bi bi-hourglass-split" style="color: #fcd34d;"></i>
                <span>Perlu Verifikasi</span>
                <span class="verif-tab-badge {{ $countMenunggu > 0 ? 'badge-pulse-amber' : '' }}">{{ $countMenunggu }}</span>
            </a>

            <a href="{{ route('pengurus_kampung.peternak.index', array_merge(request()->query(), ['status_verifikasi' => 'terverifikasi'])) }}"
               class="verif-tab-item {{ $filterVerifikasi === 'terverifikasi' ? 'active' : '' }}">
                <i class="bi bi-patch-check-fill" style="color: #6ee7b7;"></i>
                <span>Terverifikasi</span>
                <span class="verif-tab-badge">{{ $countTerverifikasi }}</span>
            </a>

            <a href="{{ route('pengurus_kampung.peternak.index', array_merge(request()->query(), ['status_verifikasi' => 'ditolak'])) }}"
               class="verif-tab-item {{ $filterVerifikasi === 'ditolak' ? 'active' : '' }}">
                <i class="bi bi-x-circle-fill" style="color: #fca5a5;"></i>
                <span>Ditolak</span>
                <span class="verif-tab-badge">{{ $countDitolak }}</span>
            </a>

            <a href="{{ route('pengurus_kampung.peternak.index', array_merge(request()->query(), ['status_verifikasi' => 'semua'])) }}"
               class="verif-tab-item {{ $filterVerifikasi === 'semua' ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Semua Peternak</span>
                <span class="verif-tab-badge">{{ $countSemua }}</span>
            </a>
        </div>

        <!-- Filter & Pencarian Bar -->
        <form method="GET" action="{{ route('pengurus_kampung.peternak.index') }}" class="filter-panel">
            <input type="hidden" name="status_verifikasi" value="{{ $filterVerifikasi }}">

            <div class="search-input-group">
                <i class="bi bi-search" style="color: #64748b;"></i>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama peternak, NIK, alamat, atau no. telepon...">
            </div>

            <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                <select name="status" onchange="this.form.submit()" style="padding: 0.6rem 1rem; background: var(--input-bg); border: 1.5px solid var(--border-color); border-radius: 12px; color: var(--text-primary); font-size: 0.88rem; outline: none; cursor: pointer;">
                    <option value="semua" {{ $filterStatus === 'semua' ? 'selected' : '' }}>Semua Kondisi Ternak</option>
                    <option value="ada_sapi" {{ $filterStatus === 'ada_sapi' ? 'selected' : '' }}>Ada Sapi Dijual</option>
                    <option value="belum_ada_sapi" {{ $filterStatus === 'belum_ada_sapi' ? 'selected' : '' }}>Belum Ada Sapi</option>
                </select>

                <button type="submit" style="padding: 0.6rem 1.25rem; background: var(--green-subtle); border: 1.5px solid var(--green-brand); color: var(--green-brand); border-radius: 12px; font-weight: 700; font-size: 0.88rem; cursor: pointer;">
                    <i class="bi bi-filter"></i> Filter
                </button>

                @if($search || $filterStatus !== 'semua')
                    <a href="{{ route('pengurus_kampung.peternak.index', ['status_verifikasi' => $filterVerifikasi]) }}" style="padding: 0.6rem 1rem; background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #ef4444; border-radius: 12px; font-size: 0.85rem; font-weight: 700; text-decoration: none;">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Tabel List Peternak -->
        <div class="peternak-list-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.5rem;">
                <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-card-list" style="color: #c4b5fd;"></i>
                    @if($filterVerifikasi === 'menunggu_verifikasi')
                        Daftar Calon Peternak (Menunggu Verifikasi Aparat)
                    @elseif($filterVerifikasi === 'terverifikasi')
                        Daftar Peternak Aktif & Terverifikasi
                    @elseif($filterVerifikasi === 'ditolak')
                        Daftar Pendaftaran Ditolak
                    @else
                        Seluruh Direktori Peternak Wilayah
                    @endif
                </h3>
                <span style="font-size: 0.82rem; color: #94a3b8;">Menampilkan {{ $peternaks->total() }} Data</span>
            </div>

            @if($peternaks->count() > 0)
                <div class="table-responsive">
                    <table class="peternak-table">
                        <thead>
                            <tr>
                                <th style="width: 45px;">No</th>
                                <th>Peternak</th>
                                <th>Kontak & WhatsApp</th>
                                <th>Alamat & Kandang</th>
                                <th>Dokumen KTP</th>
                                <th style="text-align: center;">Status Verifikasi</th>
                                <th style="text-align: center;">Populasi Sapi</th>
                                <th style="text-align: center; min-width: 170px;">Aksi Verifikasi & Akun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peternaks as $idx => $p)
                                <tr>
                                    <td style="font-size: 0.85rem; color: #94a3b8; font-weight: 600;">
                                        {{ $peternaks->firstItem() + $idx }}
                                    </td>
                                    <td>
                                        <div class="user-info-cell">
                                            <div class="peternak-avatar-sm" style="{{ $p->isMenungguVerifikasi() ? 'background: linear-gradient(135deg, rgba(245,158,11,0.3), rgba(217,119,6,0.25)); border-color: rgba(245,158,11,0.4); color: #f59e0b;' : '' }}">
                                                {{ strtoupper(substr($p->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <strong style="color: var(--text-heading); font-size: 0.95rem; display: block; margin-bottom: 2px;">
                                                    {{ $p->name }}
                                                </strong>
                                                <div class="nik-badge">
                                                    <i class="bi bi-card-heading"></i> {{ $p->nik ?: 'NIK belum diisi' }}
                                                </div>
                                                <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 2px;">
                                                    <i class="bi bi-calendar3"></i> Daftar: {{ $p->created_at->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.85rem; color: var(--text-primary); font-weight: 600;">
                                            <i class="bi bi-telephone" style="color: var(--green-brand); margin-right: 4px;"></i>
                                            {{ $p->no_telepon ?: '-' }}
                                        </div>
                                        @if($p->no_telepon)
                                            @php
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $p->no_telepon);
                                                if (str_starts_with($cleanPhone, '0')) {
                                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                                }
                                            @endphp
                                            <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="btn-wa-sm">
                                                <i class="bi bi-whatsapp"></i> Chat WA
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="max-width: 200px; font-size: 0.82rem; line-height: 1.35; color: var(--text-secondary);">
                                            {{ Str::limit($p->alamat ?: 'Alamat belum diatur', 40) }}
                                        </div>
                                        @if($p->latitude && $p->longitude)
                                            <a href="https://www.google.com/maps?q={{ $p->latitude }},{{ $p->longitude }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.74rem; color: #3b82f6; text-decoration: none; margin-top: 3px; font-weight: 600;">
                                                <i class="bi bi-pin-map-fill"></i> Peta Kandang <i class="bi bi-box-arrow-up-right" style="font-size: 0.65rem;"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                            @if($p->foto_ktp)
                                                <button type="button" class="doc-btn-sm" onclick="openDocModal('Foto KTP — {{ addslashes($p->name) }}', '{{ asset('storage/' . $p->foto_ktp) }}')" title="Lihat Foto KTP">
                                                    <i class="bi bi-person-vcard"></i> KTP
                                                </button>
                                            @else
                                                <span style="font-size: 0.72rem; color: #64748b;">KTP: -</span>
                                            @endif

                                            @if($p->foto_selfie_ktp)
                                                <button type="button" class="doc-btn-sm" onclick="openDocModal('Selfie KTP — {{ addslashes($p->name) }}', '{{ asset('storage/' . $p->foto_selfie_ktp) }}')" title="Lihat Selfie KTP">
                                                    <i class="bi bi-camera"></i> Selfie
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        @if($p->isMenungguVerifikasi())
                                            <span class="badge-status-verif status-menunggu">
                                                <i class="bi bi-hourglass-split"></i> Menunggu Verifikasi
                                            </span>
                                        @elseif($p->isTerverifikasi())
                                            <span class="badge-status-verif status-terverifikasi">
                                                <i class="bi bi-patch-check-fill"></i> Terverifikasi
                                            </span>
                                            @if($p->diverifikasiOleh)
                                                <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 2px;">
                                                    Oleh: {{ $p->diverifikasiOleh->name }}
                                                </div>
                                            @endif
                                        @elseif($p->isDitolak())
                                            <span class="badge-status-verif status-ditolak" title="{{ $p->alasan_penolakan }}">
                                                <i class="bi bi-x-circle-fill"></i> Ditolak
                                            </span>
                                            @if($p->alasan_penolakan)
                                                <div style="font-size: 0.7rem; color: #fca5a5; max-width: 140px; margin: 2px auto 0 auto; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $p->alasan_penolakan }}">
                                                    "{{ $p->alasan_penolakan }}"
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <span style="font-weight: 800; font-size: 0.95rem; color: #c4b5fd;">{{ $p->sapi_aktif_count }} Aktif</span>
                                        <div style="font-size: 0.75rem; color: #94a3b8;">
                                            {{ $p->total_sapi }} Total &bull; <span style="color: #6ee7b7; font-weight: 600;">{{ $p->transaksi_selesai_count }} Terjual</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="action-button-group">
                                            @if($p->isMenungguVerifikasi())
                                                {{-- Form Setujui & Kirim Akun via WA --}}
                                                <form method="POST" action="{{ route('pengurus_kampung.peternak.verifikasi', $p->id) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin memverifikasi akun peternak {{ addslashes($p->name) }} dan membuka WhatsApp untuk mengirim akun?')">
                                                    @csrf
                                                    <button type="submit" class="btn-action-approve" title="Setujui pendaftaran dan kirimkan info akun via WhatsApp">
                                                        <i class="bi bi-check-circle-fill"></i> Setujui & WA
                                                    </button>
                                                </form>

                                                {{-- Tombol Tolak Pendaftaran --}}
                                                <button type="button" class="btn-action-reject" onclick="openRejectModal('{{ $p->id }}', '{{ addslashes($p->name) }}')" title="Tolak pendaftaran">
                                                    <i class="bi bi-x-circle"></i> Tolak
                                                </button>
                                            @elseif($p->isTerverifikasi())
                                                {{-- Tombol Kirim Ulang WA --}}
                                                <a href="{{ route('pengurus_kampung.peternak.kirim_wa', $p->id) }}" target="_blank" class="btn-action-wa-send" title="Kirim Ulang Info Akun via WhatsApp">
                                                    <i class="bi bi-whatsapp"></i> Kirim WA
                                                </a>
                                            @elseif($p->isDitolak())
                                                {{-- Tombol Kirim Ulang Alasan Penolakan via WA --}}
                                                <a href="{{ route('pengurus_kampung.peternak.kirim_wa', $p->id) }}" target="_blank" class="btn-action-wa-send" style="background: rgba(239,68,68,0.15); border-color: rgba(239,68,68,0.35); color: #fca5a5;" title="Kirim Ulang Alasan Penolakan via WhatsApp">
                                                    <i class="bi bi-whatsapp"></i> Info WA
                                                </a>

                                                {{-- Tombol Verifikasi Kembali jika sebelumnya ditolak keliru --}}
                                                <form method="POST" action="{{ route('pengurus_kampung.peternak.verifikasi', $p->id) }}" style="display: inline;" onsubmit="return confirm('Verifikasi ulang akun peternak ini?')">
                                                    @csrf
                                                    <button type="submit" class="btn-action-approve" style="padding: 0.35rem 0.65rem;" title="Pulihkan & Verifikasi Akun">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('pengurus_kampung.peternak.show', $p->id) }}" class="btn-action-view" title="Lihat Profil Peternak">
                                                <span>Detail</span>
                                                <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 1.5rem;">
                    {{ $peternaks->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 1.5rem;">
                    <i class="bi bi-person-x" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 0.75rem; display: block;"></i>
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-heading); margin-bottom: 0.4rem;">
                        @if($filterVerifikasi === 'menunggu_verifikasi')
                            Tidak Ada Peternak Menunggu Verifikasi
                        @else
                            Tidak Ada Data Peternak Ditemukan
                        @endif
                    </h3>
                    <p style="color: var(--text-secondary); font-size: 0.88rem; max-width: 420px; margin: 0 auto 1.25rem auto;">
                        @if($filterVerifikasi === 'menunggu_verifikasi')
                            Seluruh permohonan pendaftaran peternak dari warga Kampung Suka Maju telah berhasil diproses dan diverifikasi.
                        @else
                            Tidak ada data peternak yang cocok dengan pencarian atau filter yang dipilih.
                        @endif
                    </p>
                    <a href="{{ route('pengurus_kampung.peternak.index', ['status_verifikasi' => 'semua']) }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.6rem 1.2rem; background: var(--green-subtle); border: 1px solid rgba(0, 167, 64, 0.3); color: var(--green-brand); border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 0.85rem;">
                        <i class="bi bi-arrow-clockwise"></i> Tampilkan Semua Peternak
                    </a>
                </div>
            @endif
        </div>
    </main>
</div>

<!-- Modal Peninjauan Dokumen KTP -->
<div class="modal-overlay" id="docModal" onclick="closeDocModal(event)">
    <div class="modal-content-box" onclick="event.stopPropagation()">
        <div class="modal-header-box">
            <h4 id="docModalTitle" style="color: var(--text-heading);">Pratinjau Dokumen</h4>
            <button type="button" class="modal-close-btn" onclick="closeDocModal()">&times;</button>
        </div>
        <div class="modal-body-box">
            <img id="docModalImg" src="" alt="Pratinjau Dokumen">
        </div>
    </div>
</div>

<!-- Modal Tolak Pendaftaran Peternak -->
<div class="modal-overlay" id="rejectModal" onclick="closeRejectModal(event)">
    <div class="modal-content-box" onclick="event.stopPropagation()" style="max-width: 520px;">
        <div class="modal-header-box" style="border-bottom: 1px solid rgba(239,68,68,0.25);">
            <h4 style="color: #dc2626; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-exclamation-triangle-fill"></i> Tolak Pendaftaran Peternak
            </h4>
            <button type="button" class="modal-close-btn" onclick="closeRejectModal()">&times;</button>
        </div>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="modal-body-box" style="text-align: left; padding: 1.5rem;">
                <p style="color: var(--text-secondary); font-size: 0.88rem; margin-bottom: 1rem;">
                    Anda akan menolak pengajuan akun peternak untuk <strong id="rejectPeternakName" style="color: var(--text-heading);"></strong>. Silakan tuliskan alasan penolakan secara jelas agar dapat dikirimkan ke calon peternak via WhatsApp:
                </p>
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.5rem;">
                        Alasan / Catatan Penolakan <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea name="alasan_penolakan" rows="4" required placeholder="Contoh: Foto KTP tidak terbaca jelas atau NIK tidak sesuai domisili Kampung Suka Maju. Silakan daftar ulang dengan foto KTP yang lebih terang." style="width: 100%; padding: 0.75rem 1rem; background: var(--input-bg); border: 1px solid var(--input-border); border-radius: 12px; color: var(--text-primary); font-size: 0.88rem; outline: none; resize: vertical;"></textarea>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" onclick="closeRejectModal()" style="padding: 0.6rem 1.2rem; background: var(--bg-muted); border: 1px solid var(--border-color); color: var(--text-secondary); border-radius: 10px; font-weight: 600; font-size: 0.85rem; cursor: pointer;">
                        Batal
                    </button>
                    <button type="submit" style="padding: 0.6rem 1.3rem; background: linear-gradient(135deg, #ef4444, #dc2626); border: none; color: #ffffff; border-radius: 10px; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="bi bi-x-circle"></i> Tolak & Siapkan WA
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('open');
    }

    function openDocModal(title, imageUrl) {
        document.getElementById('docModalTitle').textContent = title;
        document.getElementById('docModalImg').src = imageUrl;
        document.getElementById('docModal').classList.add('active');
    }

    function closeDocModal() {
        document.getElementById('docModal').classList.remove('active');
    }

    function openRejectModal(id, name) {
        document.getElementById('rejectPeternakName').textContent = name;
        document.getElementById('rejectForm').action = "/pengurus-kampung/peternak/" + id + "/tolak";
        document.getElementById('rejectModal').classList.add('active');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('active');
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDocModal();
            closeRejectModal();
        }
    });
</script>
@endsection
