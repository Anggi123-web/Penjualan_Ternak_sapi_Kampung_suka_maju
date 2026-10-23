@extends('layouts.app')

@section('title', 'Direktori Data Peternak — Pengurus Kampung')

@section('styles')
<style>
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
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(148, 163, 184, 0.15);
        border-radius: 12px;
        padding: 0.55rem 1rem;
        gap: 0.75rem;
        flex: 1;
        min-width: 260px;
    }

    .search-input-group input {
        background: transparent;
        border: none;
        outline: none;
        color: #f1f5f9;
        font-size: 0.9rem;
        width: 100%;
    }

    .search-input-group input::placeholder {
        color: #64748b;
    }

    /* List Table Card */
    .peternak-list-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.3);
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
        background: rgba(15, 23, 42, 0.6);
        color: #94a3b8;
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid rgba(148, 163, 184, 0.15);
        white-space: nowrap;
    }

    .peternak-table td {
        padding: 1rem 1rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.06);
        color: #cbd5e1;
        vertical-align: middle;
    }

    .peternak-table tr:hover td {
        background: rgba(139, 92, 246, 0.05);
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
        background: linear-gradient(135deg, rgba(139,92,246,0.35), rgba(124,58,237,0.25));
        border: 1px solid rgba(139,92,246,0.4);
        color: #c4b5fd;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        flex-shrink: 0;
    }

    .nik-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(148, 163, 184, 0.1);
        border: 1px solid rgba(148, 163, 184, 0.15);
        color: #94a3b8;
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
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.35);
        color: #6ee7b7;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-top: 4px;
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
        background: rgba(30, 41, 59, 0.8);
        border: 1px solid rgba(148, 163, 184, 0.15);
        border-radius: 8px;
        color: #cbd5e1;
        font-size: 0.74rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .doc-btn-sm:hover {
        background: rgba(139, 92, 246, 0.25);
        border-color: rgba(139, 92, 246, 0.4);
        color: #c4b5fd;
    }

    .btn-action-view {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.55rem 1rem;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: #ffffff;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .btn-action-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px -2px rgba(139, 92, 246, 0.5);
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
            <p>Daftar seluruh peternak di wilayah binaan Kampung Suka Maju, Distrik Malind.</p>
        </div>

        <!-- Metric KPI Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Peternak</span>
                    <div class="stat-card-icon" style="background: rgba(139,92,246,0.1); color: #c4b5fd;"><i class="bi bi-people"></i></div>
                </div>
                <div class="stat-card-value">{{ $totalPeternak }}</div>
                <div class="stat-card-change">Terdaftar di sistem</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Peternak Aktif</span>
                    <div class="stat-card-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;"><i class="bi bi-person-check"></i></div>
                </div>
                <div class="stat-card-value">{{ $peternakAktif }}</div>
                <div class="stat-card-change" style="color: #6ee7b7;">Memiliki sapi siap jual</div>
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
                    <div class="stat-card-icon" style="background: rgba(245,158,11,0.1); color: #fcd34d;"><i class="bi bi-cash-coin"></i></div>
                </div>
                <div class="stat-card-value" style="font-size: 1.45rem;">Rp {{ number_format($totalOmsetWilayah, 0, ',', '.') }}</div>
                <div class="stat-card-change" style="color: #fcd34d;">Total perputaran wilayah</div>
            </div>
        </div>

        <!-- Filter & Pencarian Bar -->
        <form method="GET" action="{{ route('pengurus_kampung.peternak.index') }}" class="filter-panel">
            <div class="search-input-group">
                <i class="bi bi-search" style="color: #64748b;"></i>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama peternak, NIK, alamat, atau no. telepon...">
            </div>

            <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                <select name="status" onchange="this.form.submit()" style="padding: 0.6rem 1rem; background: rgba(15,23,42,0.7); border: 1px solid rgba(148,163,184,0.15); border-radius: 12px; color: #f1f5f9; font-size: 0.88rem; outline: none; cursor: pointer;">
                    <option value="semua" {{ $filterStatus === 'semua' ? 'selected' : '' }}>Semua Peternak</option>
                    <option value="ada_sapi" {{ $filterStatus === 'ada_sapi' ? 'selected' : '' }}>Ada Sapi Dijual</option>
                    <option value="belum_ada_sapi" {{ $filterStatus === 'belum_ada_sapi' ? 'selected' : '' }}>Belum Ada Sapi</option>
                </select>

                <button type="submit" style="padding: 0.6rem 1.25rem; background: rgba(139,92,246,0.2); border: 1px solid rgba(139,92,246,0.4); color: #c4b5fd; border-radius: 12px; font-weight: 700; font-size: 0.88rem; cursor: pointer;">
                    <i class="bi bi-filter"></i> Filter
                </button>

                @if($search || $filterStatus !== 'semua')
                    <a href="{{ route('pengurus_kampung.peternak.index') }}" style="padding: 0.6rem 1rem; background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; border-radius: 12px; font-size: 0.85rem; font-weight: 600; text-decoration: none;">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Tabel List Peternak -->
        <div class="peternak-list-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-card-list" style="color: #c4b5fd;"></i> Daftar Peternak Wilayah
                </h3>
                <span style="font-size: 0.82rem; color: #94a3b8;">Menampilkan {{ $peternaks->total() }} Peternak</span>
            </div>

            @if($peternaks->count() > 0)
                <div class="table-responsive">
                    <table class="peternak-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Peternak</th>
                                <th>Kontak & WhatsApp</th>
                                <th>Alamat & Kandang</th>
                                <th>Rekening Bank</th>
                                <th>Dokumen KTP</th>
                                <th style="text-align: center;">Populasi Sapi</th>
                                <th style="text-align: center; width: 120px;">Aksi</th>
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
                                            <div class="peternak-avatar-sm">
                                                {{ strtoupper(substr($p->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <strong style="color: #f8fafc; font-size: 0.95rem; display: block; margin-bottom: 2px;">
                                                    {{ $p->name }}
                                                </strong>
                                                <div class="nik-badge">
                                                    <i class="bi bi-card-heading"></i> {{ $p->nik ?: 'NIK belum ada' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.85rem; color: #f1f5f9;">
                                            <i class="bi bi-telephone" style="color: #a78bfa; margin-right: 4px;"></i>
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
                                        <div style="max-width: 220px; font-size: 0.83rem; line-height: 1.35; color: #cbd5e1;">
                                            {{ Str::limit($p->alamat ?: 'Alamat belum diatur', 45) }}
                                        </div>
                                        @if($p->latitude && $p->longitude)
                                            <a href="https://www.google.com/maps?q={{ $p->latitude }},{{ $p->longitude }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.74rem; color: #93c5fd; text-decoration: none; margin-top: 3px;">
                                                <i class="bi bi-pin-map-fill"></i> Peta Kandang <i class="bi bi-box-arrow-up-right" style="font-size: 0.65rem;"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->nomor_rekening)
                                            <div style="font-weight: 700; color: #f1f5f9; font-size: 0.85rem;">{{ $p->jenis_bank ?: 'Bank' }}</div>
                                            <div style="font-family: monospace; font-size: 0.8rem; color: #6ee7b7;">{{ $p->nomor_rekening }}</div>
                                        @else
                                            <span style="color: #64748b; font-size: 0.8rem;">-</span>
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
                                        <span style="font-weight: 800; font-size: 0.95rem; color: #c4b5fd;">{{ $p->sapi_aktif_count }} Aktif</span>
                                        <div style="font-size: 0.75rem; color: #94a3b8;">
                                            {{ $p->total_sapi }} Total &bull; <span style="color: #6ee7b7; font-weight: 600;">{{ $p->transaksi_selesai_count }} Terjual</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('pengurus_kampung.peternak.show', $p->id) }}" class="btn-action-view">
                                            <span>Detail</span>
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
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
                    <i class="bi bi-person-x" style="font-size: 3rem; color: #64748b; margin-bottom: 0.75rem; display: block;"></i>
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #f1f5f9; margin-bottom: 0.4rem;">Tidak Ada Data Peternak Ditemukan</h3>
                    <p style="color: #94a3b8; font-size: 0.88rem; max-width: 420px; margin: 0 auto 1.25rem auto;">
                        Tidak ada data peternak yang cocok dengan pencarian atau filter yang dipilih.
                    </p>
                    <a href="{{ route('pengurus_kampung.peternak.index') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.6rem 1.2rem; background: rgba(139,92,246,0.2); border: 1px solid rgba(139,92,246,0.4); color: #c4b5fd; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.85rem;">
                        <i class="bi bi-arrow-clockwise"></i> Reset Filter
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
            <h4 id="docModalTitle">Pratinjau Dokumen</h4>
            <button type="button" class="modal-close-btn" onclick="closeDocModal()">&times;</button>
        </div>
        <div class="modal-body-box">
            <img id="docModalImg" src="" alt="Pratinjau Dokumen">
        </div>
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

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDocModal();
        }
    });
</script>
@endsection
