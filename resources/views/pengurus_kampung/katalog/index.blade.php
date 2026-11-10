@extends('layouts.app')

@section('title', 'Katalog Penjualan — Aparat Kampung')

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;">🏘️ Pengurus Kampung</span>
    <div style="display: flex; align-items: center; gap: 8px;">
        @include('partials.theme_toggle', ['id' => 'pengurusKatalogMobileThemeToggle', 'iconOnly' => true])
        <button class="hamburger" onclick="toggleSidebar()">☰</button>
    </div>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    @include('dashboard.partials.sidebar_pengurus_kampung')

    <main class="main-content">
        <style>
            .page-header-flex {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 1rem;
                margin-bottom: 1.5rem;
            }

            .btn-sampah-top {
                display: inline-flex;
                align-items: center;
                gap: 0.6rem;
                padding: 0.75rem 1.4rem;
                background: rgba(239, 68, 68, 0.1);
                border: 1px solid rgba(239, 68, 68, 0.3);
                color: #b91c1c;
                border-radius: 12px;
                font-weight: 700;
                font-size: 0.9rem;
                text-decoration: none;
                transition: all 0.25s ease;
            }

            [data-theme="dark"] .btn-sampah-top {
                color: #fca5a5;
                background: rgba(239, 68, 68, 0.15);
            }

            .btn-sampah-top:hover {
                background: rgba(239, 68, 68, 0.22);
                border-color: rgba(239, 68, 68, 0.5);
                color: #ffffff;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(239, 68, 68, 0.2);
            }

            .badge-sampah-count {
                background: #ef4444;
                color: #ffffff;
                font-size: 0.75rem;
                font-weight: 800;
                padding: 0.2rem 0.55rem;
                border-radius: 20px;
                line-height: 1;
            }

            /* Filter Bar */
            .filter-panel {
                background: var(--bg-card);
                border: 1px solid var(--border-color);
                border-radius: 16px;
                padding: 1.25rem 1.5rem;
                margin-bottom: 1.75rem;
                backdrop-filter: blur(20px);
            }

            .filter-form {
                display: flex;
                gap: 1rem;
                flex-wrap: wrap;
                align-items: center;
            }

            .filter-input-group {
                flex: 1;
                min-width: 200px;
            }

            .filter-input, .filter-select {
                width: 100%;
                padding: 0.7rem 1rem;
                background: var(--input-bg);
                border: 1px solid var(--input-border);
                border-radius: 10px;
                color: var(--text-primary);
                font-size: 0.85rem;
                font-family: inherit;
                outline: none;
                transition: all 0.2s;
            }

            .filter-select option {
                background: var(--bg-card);
                color: var(--text-primary);
            }

            .filter-input:focus, .filter-select:focus {
                border-color: var(--green-brand);
                box-shadow: 0 0 0 3px var(--input-focus-ring);
            }

            .btn-filter-apply {
                padding: 0.7rem 1.25rem;
                background: linear-gradient(135deg, var(--green-brand), var(--green-hover));
                color: white;
                border: none;
                border-radius: 10px;
                font-weight: 600;
                font-size: 0.85rem;
                cursor: pointer;
                transition: all 0.2s;
            }

            .btn-filter-apply:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 15px var(--green-glow);
            }

            .btn-filter-reset {
                padding: 0.7rem 1rem;
                background: var(--bg-muted);
                border: 1px solid var(--border-color);
                color: var(--text-secondary);
                border-radius: 10px;
                font-weight: 600;
                font-size: 0.85rem;
                text-decoration: none;
                transition: all 0.2s;
            }

            .btn-filter-reset:hover {
                color: var(--text-primary);
                border-color: var(--green-brand);
            }

            /* Custom Table */
            .table-container {
                background: var(--bg-card);
                border: 1px solid var(--border-color);
                border-radius: 16px;
                overflow: hidden;
                backdrop-filter: blur(20px);
            }

            .katalog-table {
                width: 100%;
                border-collapse: collapse;
                text-align: left;
                font-size: 0.9rem;
            }

            .katalog-table th {
                background: var(--bg-muted);
                padding: 1rem 1.25rem;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: var(--text-secondary);
                border-bottom: 2px solid var(--border-color);
            }

            .katalog-table td {
                padding: 1.15rem 1.25rem;
                border-bottom: 1px solid var(--border-color);
                color: var(--text-primary);
                vertical-align: middle;
            }

            .katalog-table tr:last-child td {
                border-bottom: none;
            }

            .katalog-table tr:hover td {
                background: var(--bg-muted);
            }

            .sapi-item-info {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .sapi-thumb {
                width: 58px;
                height: 58px;
                border-radius: 10px;
                overflow: hidden;
                background: rgba(15, 23, 42, 0.6);
                flex-shrink: 0;
                border: 1px solid rgba(148, 163, 184, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .sapi-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .sapi-title-text {
                font-weight: 700;
                color: var(--text-heading);
                font-size: 0.95rem;
                margin-bottom: 0.2rem;
            }

            .sapi-specs-text {
                font-size: 0.8rem;
                color: var(--text-secondary);
                display: flex;
                gap: 0.75rem;
            }

            /* Badges */
            .badge {
                display: inline-flex;
                align-items: center;
                gap: 0.35rem;
                padding: 0.3rem 0.65rem;
                border-radius: 6px;
                font-size: 0.75rem;
                font-weight: 700;
            }

            .badge-aktif {
                background: rgba(16, 185, 129, 0.12);
                border: 1px solid rgba(16, 185, 129, 0.25);
                color: #6ee7b7;
            }

            .badge-nonaktif {
                background: rgba(239, 68, 68, 0.12);
                border: 1px solid rgba(239, 68, 68, 0.25);
                color: #fca5a5;
            }

            .badge-sehat {
                background: rgba(16, 185, 129, 0.1);
                border: 1px solid rgba(16, 185, 129, 0.2);
                color: #6ee7b7;
            }

            .badge-tidak-sehat {
                background: rgba(239, 68, 68, 0.1);
                border: 1px solid rgba(239, 68, 68, 0.2);
                color: #fca5a5;
            }

            .badge-belum {
                background: rgba(245, 158, 11, 0.1);
                border: 1px solid rgba(245, 158, 11, 0.2);
                color: #fcd34d;
            }

            /* Action buttons */
            .action-btn-group {
                display: flex;
                align-items: center;
                gap: 0.4rem;
                flex-wrap: nowrap;
            }

            .btn-action-small {
                display: inline-flex;
                align-items: center;
                gap: 0.3rem;
                padding: 0.45rem 0.75rem;
                border-radius: 8px;
                font-size: 0.8rem;
                font-weight: 600;
                font-family: inherit;
                cursor: pointer;
                transition: all 0.2s ease;
                text-decoration: none;
                border: 1px solid transparent;
                white-space: nowrap;
            }

            .btn-toggle-deactivate {
                background: rgba(245, 158, 11, 0.12);
                color: #fcd34d;
                border-color: rgba(245, 158, 11, 0.25);
            }

            .btn-toggle-deactivate:hover {
                background: rgba(245, 158, 11, 0.22);
                border-color: rgba(245, 158, 11, 0.4);
                color: #fbbf24;
                transform: translateY(-1px);
            }

            .btn-toggle-activate {
                background: rgba(16, 185, 129, 0.12);
                color: #6ee7b7;
                border-color: rgba(16, 185, 129, 0.25);
            }

            .btn-toggle-activate:hover {
                background: rgba(16, 185, 129, 0.22);
                border-color: rgba(16, 185, 129, 0.4);
                color: #34d399;
                transform: translateY(-1px);
            }

            .btn-soft-delete {
                background: rgba(239, 68, 68, 0.1);
                color: #fca5a5;
                border-color: rgba(239, 68, 68, 0.25);
            }

            .btn-soft-delete:hover {
                background: rgba(239, 68, 68, 0.22);
                border-color: rgba(239, 68, 68, 0.45);
                color: #f87171;
                transform: translateY(-1px);
            }

            .btn-view-detail {
                background: rgba(148, 163, 184, 0.08);
                color: #cbd5e1;
                border-color: rgba(148, 163, 184, 0.15);
            }

            .btn-view-detail:hover {
                background: rgba(148, 163, 184, 0.18);
                color: #ffffff;
                border-color: rgba(148, 163, 184, 0.3);
                transform: translateY(-1px);
            }

            /* Alert notification */
            .alert-success {
                background: rgba(16, 185, 129, 0.08);
                border: 1px solid rgba(16, 185, 129, 0.25);
                border-radius: 12px;
                padding: 0.9rem 1.25rem;
                margin-bottom: 1.5rem;
                font-size: 0.9rem;
                color: #6ee7b7;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            @media (max-width: 900px) {
                .table-container {
                    overflow-x: auto;
                }
                .katalog-table {
                    min-width: 800px;
                }
            }
        </style>

        {{-- Header --}}
        <div class="page-header-flex">
            <div>
                <h1>Katalog Penjualan Sapi</h1>
                <p>Moderasi katalog penjualan: nonaktifkan sementara, aktifkan kembali, atau hapus ke Sampah.</p>
            </div>
            <a href="{{ route('pengurus_kampung.katalog.sampah') }}" class="btn-sampah-top" id="btn-sampah-nav">
                <span>🗑️</span>
                <span>Sampah</span>
                <span class="badge-sampah-count" id="badge-sampah-count">{{ $totalSampah }}</span>
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Stats Grid --}}
        <div class="stats-grid" style="margin-bottom: 1.75rem;">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Katalog</span>
                    <div class="stat-card-icon" style="background: rgba(139,92,246,0.1); color: #c4b5fd;">🐮</div>
                </div>
                <div class="stat-card-value">{{ $totalSapi }}</div>
                <div class="stat-card-change">Terdaftar di sistem</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Aktif Tayang</span>
                    <div class="stat-card-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;">🟢</div>
                </div>
                <div class="stat-card-value">{{ $totalAktif }}</div>
                <div class="stat-card-change">Tampil di publik</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Dinonaktifkan</span>
                    <div class="stat-card-icon" style="background: rgba(245,158,11,0.1); color: #fcd34d;">⏸️</div>
                </div>
                <div class="stat-card-value">{{ $totalNonaktif }}</div>
                <div class="stat-card-change">Disembunyikan sementara</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Di Dalam Sampah</span>
                    <div class="stat-card-icon" style="background: rgba(239,68,68,0.1); color: #fca5a5;">🗑️</div>
                </div>
                <div class="stat-card-value">{{ $totalSampah }}</div>
                <div class="stat-card-change">Menunggu dipulihkan / dihapus permanen</div>
            </div>
        </div>

        {{-- Filter Panel --}}
        <div class="filter-panel">
            <form method="GET" action="{{ route('pengurus_kampung.katalog.index') }}" class="filter-form">
                <div class="filter-input-group" style="flex: 2;">
                    <input type="text" name="search" class="filter-input" placeholder="🔍 Cari jenis sapi, nama peternak, atau lokasi..." value="{{ request('search') }}">
                </div>

                <div class="filter-input-group">
                    <select name="status" class="filter-select">
                        <option value="">Semua Status Tayang</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>🟢 Aktif Saja</option>
                        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>🔴 Nonaktif Saja</option>
                    </select>
                </div>

                <div class="filter-input-group">
                    <select name="kesehatan" class="filter-select">
                        <option value="">Semua Status Kesehatan</option>
                        <option value="sehat" {{ request('kesehatan') === 'sehat' ? 'selected' : '' }}>✅ Layak Budidaya (Sehat)</option>
                        <option value="tidak_sehat" {{ request('kesehatan') === 'tidak_sehat' ? 'selected' : '' }}>❌ Tidak Sehat</option>
                        <option value="belum_diperiksa" {{ request('kesehatan') === 'belum_diperiksa' ? 'selected' : '' }}>⏳ Belum Diperiksa</option>
                    </select>
                </div>

                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn-filter-apply">Terapkan</button>
                    <a href="{{ route('pengurus_kampung.katalog.index') }}" class="btn-filter-reset">Reset</a>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="table-container">
            @if($sapis->isEmpty())
                <div style="text-align: center; padding: 4rem 2rem; color: var(--text-secondary);">
                    <div style="font-size: 3.5rem; margin-bottom: 1rem; opacity: 0.5;">🐮</div>
                    <h3 style="color: var(--text-heading); font-size: 1.15rem; margin-bottom: 0.5rem;">Tidak Ada Data Katalog</h3>
                    <p style="font-size: 0.9rem; color: var(--text-secondary);">Tidak ditemukan data sapi yang sesuai dengan filter pencarian.</p>
                </div>
            @else
                <table class="katalog-table">
                    <thead>
                        <tr>
                            <th>Data Ternak</th>
                            <th>Pemilik / Peternak</th>
                            <th>Harga</th>
                            <th>Kesehatan</th>
                            <th>Status Tayang</th>
                            <th style="text-align: right;">Aksi Moderasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sapis as $sapi)
                            <tr id="sapi-row-{{ $sapi->id }}">
                                <td>
                                    <div class="sapi-item-info">
                                        <div class="sapi-thumb">
                                            @if($sapi->first_foto)
                                                <img src="{{ asset('storage/' . $sapi->first_foto) }}" alt="Foto {{ $sapi->jenis }}">
                                            @else
                                                <span style="font-size: 1.8rem; opacity: 0.4;">🐮</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="sapi-title-text">{{ $sapi->jenis }}</div>
                                            <div class="sapi-specs-text">
                                                <span>📅 {{ $sapi->umur_formatted }}</span>
                                                <span>⚖️ {{ number_format($sapi->bobot, 0) }} kg</span>
                                                <span style="font-weight: 700; color: {{ $sapi->is_preorder ? 'var(--accent-amber-text, #92400e)' : 'var(--green-brand)' }};">
                                                    {{ $sapi->tipe_penjualan_label }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--text-heading);">{{ $sapi->peternak->name ?? '-' }}</div>
                                    <div style="font-size: 0.8rem; color: var(--text-secondary);">{{ $sapi->peternak->email ?? '-' }}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: var(--green-brand);">{{ $sapi->harga_formatted }}</div>
                                </td>
                                <td>
                                    @if($sapi->status_kesehatan === 'sehat')
                                        <span class="badge badge-sehat">✅ Layak Budidaya</span>
                                    @elseif($sapi->status_kesehatan === 'tidak_sehat')
                                        <span class="badge badge-tidak-sehat">❌ Tidak Sehat</span>
                                    @else
                                        <span class="badge badge-belum">⏳ Belum Diperiksa</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sapi->is_active)
                                        <span class="badge badge-aktif">🟢 Aktif</span>
                                    @else
                                        <span class="badge badge-nonaktif">🔴 Dinonaktifkan</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-btn-group" style="justify-content: flex-end;">
                                        {{-- Toggle Status --}}
                                        <form method="POST" action="{{ route('pengurus_kampung.katalog.toggle', $sapi->id) }}" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            @if($sapi->is_active)
                                                <button type="submit" class="btn-action-small btn-toggle-deactivate" title="Nonaktifkan katalog dari publik sementara">
                                                    <span>⏸️</span> Nonaktifkan
                                                </button>
                                            @else
                                                <button type="submit" class="btn-action-small btn-toggle-activate" title="Aktifkan kembali katalog ke publik">
                                                    <span>▶️</span> Aktifkan
                                                </button>
                                            @endif
                                        </form>

                                        {{-- Detail Link --}}
                                        <a href="{{ route('katalog.show', $sapi->id) }}" target="_blank" class="btn-action-small btn-view-detail" title="Lihat di katalog publik">
                                            <span>👁️</span> Detail
                                        </a>

                                        {{-- Soft Delete (Sampah) --}}
                                        <form method="POST" action="{{ route('pengurus_kampung.katalog.soft_delete', $sapi->id) }}" onsubmit="return confirm('Pindahkan katalog sapi ini ke Sampah?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-small btn-soft-delete" title="Pindahkan katalog ini ke Sampah">
                                                <span>🗑️</span> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($sapis->hasPages())
                    <div style="padding: 1.25rem; border-top: 1px solid var(--border-color);">
                        {{ $sapis->links() }}
                    </div>
                @endif
            @endif
        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('open');
    }
</script>
@endsection
