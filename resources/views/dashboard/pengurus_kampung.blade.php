@extends('layouts.app')

@section('title', 'Dashboard Pengurus Kampung — Sistem Penjualan Sapi')

@section('styles')
<style>
    .quick-actions-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .quick-action-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .quick-action-card:hover {
        border-color: rgba(139, 92, 246, 0.4);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.25);
    }

    .quick-action-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .quick-action-info h4 {
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
    }

    .quick-action-info p {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin: 0;
    }

    .dashboard-two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-top: 2rem;
    }

    @media (max-width: 991px) {
        .dashboard-two-col {
            grid-template-columns: 1fr;
        }
    }

    .section-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 1.5rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.08);
    }

    .section-header h3 {
        font-size: 1.05rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .btn-link-all {
        color: #c4b5fd;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: color 0.2s ease;
    }

    .btn-link-all:hover {
        color: #ffffff;
    }

    .item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.85rem 0;
        border-bottom: 1px solid rgba(148, 163, 184, 0.05);
    }

    .item-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .item-row:first-child {
        padding-top: 0;
    }

    .user-pill {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .user-avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(139,92,246,0.3), rgba(124,58,237,0.3));
        border: 1px solid rgba(139,92,246,0.3);
        color: #c4b5fd;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }

    .trx-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.25rem 0.65rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
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
            <h1>Dashboard Pengurus Kampung</h1>
            <p>Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>! Kelola data wilayah, peternak, dan laporan penjualan.</p>
        </div>

        <!-- Quick Access Banner Cards -->
        <div class="quick-actions-bar">
            <a href="{{ route('pengurus_kampung.peternak.index') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: rgba(139,92,246,0.15); color: #c4b5fd;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="quick-action-info">
                    <h4>Direktori Peternak</h4>
                    <p>{{ $totalPeternak }} peternak terdaftar</p>
                </div>
            </a>
            <a href="{{ route('pengurus_kampung.laporan.index') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: rgba(16,185,129,0.15); color: #6ee7b7;">
                    <i class="bi bi-bar-chart-fill"></i>
                </div>
                <div class="quick-action-info">
                    <h4>Laporan Penjualan</h4>
                    <p>Rekapitulasi per triwulan</p>
                </div>
            </a>
            <a href="{{ route('pengurus_kampung.monitoring.index') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: rgba(245,158,11,0.15); color: #fcd34d;">
                    <i class="bi bi-file-earmark-check-fill"></i>
                </div>
                <div class="quick-action-info">
                    <h4>Surat & Monitoring</h4>
                    <p>{{ $pendingSurat }} menunggu rilis</p>
                </div>
            </a>
        </div>

        <!-- Metric KPI Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Peternak</span>
                    <div class="stat-card-icon" style="background: rgba(139,92,246,0.1); color: #c4b5fd;"><i class="bi bi-people"></i></div>
                </div>
                <div class="stat-card-value">{{ $totalPeternak }}</div>
                <div class="stat-card-change" style="color: #c4b5fd;">{{ $peternakAktif }} aktif menjual ternak</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Surat Pending</span>
                    <div class="stat-card-icon" style="background: rgba(245,158,11,0.1); color: #fcd34d;"><i class="bi bi-hourglass-split"></i></div>
                </div>
                <div class="stat-card-value">{{ $pendingSurat }}</div>
                <div class="stat-card-change" style="color: {{ $pendingSurat > 0 ? '#fcd34d' : '#94a3b8' }};">
                    {{ $pendingSurat > 0 ? 'Perlu diterbitkan segera' : 'Semua surat telah dirilis' }}
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Sapi Wilayah</span>
                    <div class="stat-card-icon" style="background: rgba(59,130,246,0.1); color: #93c5fd;"><i class="bi bi-piggy-bank"></i></div>
                </div>
                <div class="stat-card-value">{{ $totalSapi }}</div>
                <div class="stat-card-change">Ekor dalam katalog</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Omset Triwulan {{ $currentQuarter }}</span>
                    <div class="stat-card-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;"><i class="bi bi-cash-stack"></i></div>
                </div>
                <div class="stat-card-value" style="font-size: 1.45rem;">Rp {{ number_format($omsetTriwulan, 0, ',', '.') }}</div>
                <div class="stat-card-change" style="color: #6ee7b7;">Penjualan sukses triwulan ini</div>
            </div>
        </div>

        <!-- 2 Column Section: Peternak Terbaru & Transaksi Terkini -->
        <div class="dashboard-two-col">
            <!-- Peternak Terdaftar Terbaru -->
            <div class="section-card">
                <div class="section-header">
                    <h3><i class="bi bi-person-badge-fill" style="color: #c4b5fd;"></i> Peternak Terdaftar</h3>
                    <a href="{{ route('pengurus_kampung.peternak.index') }}" class="btn-link-all">Lihat Semua <i class="bi bi-chevron-right"></i></a>
                </div>

                @forelse($recentPeternaks as $p)
                    <div class="item-row">
                        <div class="user-pill">
                            <div class="user-avatar-sm">
                                {{ strtoupper(substr($p->name, 0, 2)) }}
                            </div>
                            <div>
                                <h4 style="font-size: 0.92rem; font-weight: 700; margin-bottom: 0.15rem;">{{ $p->name }}</h4>
                                <span style="font-size: 0.78rem; color: #94a3b8;">
                                    <i class="bi bi-geo-alt"></i> {{ Str::limit($p->alamat ?: 'Alamat belum diatur', 30) }}
                                </span>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 0.8rem; font-weight: 700; color: #c4b5fd; background: rgba(139,92,246,0.12); padding: 3px 8px; border-radius: 6px;">
                                {{ $p->sapis_count }} Sapi
                            </span>
                            <a href="{{ route('pengurus_kampung.peternak.show', $p->id) }}" style="display: block; font-size: 0.75rem; color: #94a3b8; margin-top: 4px; text-decoration: none;">
                                Detail <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <p style="color: #94a3b8; font-size: 0.88rem; text-align: center; padding: 1.5rem 0;">Belum ada peternak terdaftar.</p>
                @endforelse
            </div>

            <!-- Transaksi Penjualan Terkini -->
            <div class="section-card">
                <div class="section-header">
                    <h3><i class="bi bi-cart-check-fill" style="color: #6ee7b7;"></i> Transaksi Wilayah Terkini</h3>
                    <a href="{{ route('pengurus_kampung.laporan.index') }}" class="btn-link-all">Laporan Triwulan <i class="bi bi-chevron-right"></i></a>
                </div>

                @forelse($recentTransaksis as $trx)
                    <div class="item-row">
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 0.2rem;">
                                <span style="font-family: monospace; font-size: 0.82rem; font-weight: 700; color: #f1f5f9;">{{ $trx->kode_transaksi }}</span>
                                <span class="trx-badge" style="background: {{ $trx->status_meta['bg'] }}; color: {{ $trx->status_meta['color'] }}; border: 1px solid {{ $trx->status_meta['border'] }};">
                                    {{ $trx->status_meta['label'] }}
                                </span>
                            </div>
                            <span style="font-size: 0.78rem; color: #94a3b8;">
                                Peternak: <strong>{{ $trx->sapi?->peternak?->name ?? 'Peternak' }}</strong> &bull; {{ $trx->sapi?->jenis ?? 'Sapi' }}
                            </span>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 0.92rem; font-weight: 700; color: #6ee7b7;">
                                {{ $trx->total_harga_formatted }}
                            </div>
                            <span style="font-size: 0.75rem; color: #64748b;">
                                {{ $trx->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p style="color: #94a3b8; font-size: 0.88rem; text-align: center; padding: 1.5rem 0;">Belum ada transaksi di wilayah ini.</p>
                @endforelse
            </div>
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
