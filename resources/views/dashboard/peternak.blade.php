@extends('layouts.peternak', ['title' => 'Dashboard & Laporan Penjualan — Sistem Penjualan Sapi'])

@section('page-styles')
<style>
    .dashboard-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .dashboard-actions {
        display: flex;
        gap: 0.65rem;
        flex-wrap: wrap;
    }

    .btn-dash-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.15rem;
        background: linear-gradient(135deg, var(--green-brand, #10b981), #059669);
        color: #ffffff !important;
        border: none;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    }

    .btn-dash-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
        color: #ffffff !important;
    }

    .btn-dash-outline {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.15rem;
        background: var(--bg-card);
        color: var(--text-primary) !important;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-dash-outline:hover {
        background: var(--bg-muted);
        border-color: var(--green-brand);
        color: var(--green-brand) !important;
    }

    /* ═══ Stats Grid (6 Cards) ═══ */
    .dashboard-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .dash-stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .dash-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .dash-stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }

    .dash-stat-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .dash-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .dash-stat-val {
        font-size: 1.65rem;
        font-weight: 900;
        color: var(--text-heading);
        line-height: 1.2;
        font-family: var(--font-montserrat, sans-serif);
    }

    .dash-stat-sub {
        font-size: 0.76rem;
        color: var(--text-secondary);
        margin-top: 0.4rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ═══ Section Laporan & Grafik ═══ */
    .section-laporan {
        margin-bottom: 2rem;
    }

    .section-title-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .section-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-heading);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-subtitle {
        color: var(--text-secondary);
        font-size: 0.82rem;
        margin: 2px 0 0 0;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.25rem;
    }

    @media (max-width: 991px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.35rem 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
    }

    .chart-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .chart-card-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-heading);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .chart-canvas-wrapper {
        position: relative;
        flex: 1;
        min-height: 270px;
        width: 100%;
    }

    /* ═══ Recent Orders Table ═══ */
    .recent-orders-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.35rem 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .dash-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
        text-align: left;
    }

    .dash-table th {
        padding: 0.75rem 1rem;
        font-weight: 700;
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-muted);
    }

    .dash-table td {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
        vertical-align: middle;
    }

    .dash-table tr:last-child td {
        border-bottom: none;
    }

    .dash-table tr:hover td {
        background: rgba(16, 185, 129, 0.03);
    }

    .badge-status-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 999px;
        white-space: nowrap;
    }

    .empty-state-dash {
        padding: 2.5rem 1rem;
        text-align: center;
        color: var(--text-secondary);
    }

    .empty-state-dash i {
        font-size: 2.5rem;
        opacity: 0.4;
        display: block;
        margin-bottom: 0.5rem;
    }
</style>
@endsection

@section('page-content')
{{-- Header Dashboard & Aksi Cepat --}}
<div class="dashboard-header-flex">
    <div>
        <h1 style="font-size: clamp(1.4rem, 3vw, 1.85rem); font-weight: 800; color: var(--text-heading); margin: 0; font-family: var(--font-montserrat, sans-serif);">
            Dashboard Peternak
        </h1>
        <p style="color: var(--text-secondary); font-size: 0.88rem; margin-top: 4px; margin-bottom: 0;">
            Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>! Berikut laporan performa peternakan dan penjualan Anda.
        </p>
    </div>
    <div class="dashboard-actions">
        <a href="{{ route('peternak.sapi.create') }}" class="btn-dash-primary">
            <i class="bi bi-plus-circle-fill"></i> + Tambah Data Sapi
        </a>
        <a href="{{ route('peternak.pesanan') }}" class="btn-dash-outline">
            <i class="bi bi-box-seam"></i> Pesanan Masuk
            @if(isset($pesananDiproses) && $pesananDiproses > 0)
                <span style="background: #3b82f6; color: white; font-size: 10px; font-weight: 800; padding: 1px 6px; border-radius: 999px;">{{ $pesananDiproses }}</span>
            @endif
        </a>
    </div>
</div>

{{-- ═══ STATS GRID (6 Cards: Inventaris & Laporan Penjualan) ═══ --}}
<div class="dashboard-stats-grid">
    {{-- 1. Total Sapi --}}
    <div class="dash-stat-card">
        <div class="dash-stat-header">
            <span class="dash-stat-title">Total Sapi Ternak</span>
            <div class="dash-stat-icon" style="background: rgba(16, 185, 129, 0.12); color: var(--green-brand);">
                <i class="bi bi-piggy-bank"></i>
            </div>
        </div>
        <div class="dash-stat-val">{{ $totalSapi }}</div>
        <div class="dash-stat-sub">
            <span>{{ $totalSapi - $sapiTerjual }} Tersedia</span> &bull; 
            <span style="color: #10b981; font-weight: 600;">{{ $sapiTerjual }} Terjual</span>
        </div>
    </div>

    {{-- 2. Terverifikasi Sehat --}}
    <div class="dash-stat-card">
        <div class="dash-stat-header">
            <span class="dash-stat-title">Terverifikasi Sehat</span>
            <div class="dash-stat-icon" style="background: rgba(59, 130, 246, 0.12); color: #3b82f6;">
                <i class="bi bi-patch-check-fill"></i>
            </div>
        </div>
        <div class="dash-stat-val">{{ $sapiSehat }}</div>
        <div class="dash-stat-sub" style="color: #3b82f6; font-weight: 600;">
            <i class="bi bi-shield-check"></i> Lolos Uji Mantri
        </div>
    </div>

    {{-- 3. Belum Diperiksa Mantri --}}
    <div class="dash-stat-card">
        <div class="dash-stat-header">
            <span class="dash-stat-title">Belum Diperiksa</span>
            <div class="dash-stat-icon" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
        <div class="dash-stat-val">{{ $sapiBelumDiperiksa }}</div>
        <div class="dash-stat-sub" style="color: #f59e0b; font-weight: 600;">
            <i class="bi bi-clock"></i> Menunggu Pemeriksaan
        </div>
    </div>

    {{-- 4. Total Transaksi Selesai --}}
    <div class="dash-stat-card">
        <div class="dash-stat-header">
            <span class="dash-stat-title">Total Penjualan</span>
            <div class="dash-stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>
        <div class="dash-stat-val">{{ $totalPenjualan }}</div>
        <div class="dash-stat-sub" style="color: #10b981; font-weight: 600;">
            <i class="bi bi-check2-circle"></i> Transaksi Berhasil
        </div>
    </div>

    {{-- 5. Total Pendapatan (Omzet) --}}
    <div class="dash-stat-card">
        <div class="dash-stat-header">
            <span class="dash-stat-title">Total Pendapatan</span>
            <div class="dash-stat-icon" style="background: rgba(139, 92, 246, 0.12); color: #8b5cf6;">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
        </div>
        <div class="dash-stat-val" style="font-size: 1.35rem; color: #8b5cf6;">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </div>
        <div class="dash-stat-sub">
            <i class="bi bi-wallet2"></i> Omzet Pesanan Selesai
        </div>
    </div>

    {{-- 6. Rata-rata Harga per Ekor --}}
    <div class="dash-stat-card">
        <div class="dash-stat-header">
            <span class="dash-stat-title">Rata-rata Harga</span>
            <div class="dash-stat-icon" style="background: rgba(14, 165, 233, 0.12); color: #0ea5e9;">
                <i class="bi bi-tag-fill"></i>
            </div>
        </div>
        <div class="dash-stat-val" style="font-size: 1.35rem;">
            Rp {{ number_format($rataRataHarga, 0, ',', '.') }}
        </div>
        <div class="dash-stat-sub">
            <i class="bi bi-bar-chart-line"></i> Nilai per Ekor Sapi
        </div>
    </div>
</div>

{{-- ═══ SECTION LAPORAN & GRAFIK PENJUALAN ═══ --}}
<div class="section-laporan">
    <div class="section-title-wrap">
        <div>
            <h2 class="section-title">
                <i class="bi bi-bar-chart-line-fill" style="color: var(--green-brand);"></i> Laporan & Grafik Penjualan
            </h2>
            <p class="section-subtitle">
                Analisis tren omzet, volume transaksi bulanan, serta komposisi jenis sapi yang terjual.
            </p>
        </div>
        <div>
            <span style="font-size: 0.78rem; font-weight: 700; color: var(--text-secondary); background: var(--bg-card); border: 1px solid var(--border-color); padding: 5px 12px; border-radius: 999px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="bi bi-calendar-event"></i> Periode: 6 Bulan Terakhir
            </span>
        </div>
    </div>

    <div class="charts-grid">
        {{-- Grafik 1: Tren Penjualan & Pendapatan Bulanan --}}
        <div class="chart-card">
            <div class="chart-card-header">
                <h3 class="chart-card-title">
                    <i class="bi bi-graph-up" style="color: #10b981;"></i> Tren Penjualan & Pendapatan Bulanan
                </h3>
                <div style="font-size: 0.75rem; color: var(--text-secondary);">
                    Batang: Jumlah Transaksi &bull; Garis: Pendapatan (Juta Rp)
                </div>
            </div>
            <div class="chart-canvas-wrapper">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>

        {{-- Grafik 2: Komposisi Jenis Sapi --}}
        <div class="chart-card">
            <div class="chart-card-header">
                <h3 class="chart-card-title">
                    <i class="bi bi-pie-chart-fill" style="color: #3b82f6;"></i> 
                    {{ $isJenisTerjual ? 'Distribusi Jenis Terjual' : 'Distribusi Populasi Sapi' }}
                </h3>
                <div style="font-size: 0.75rem; color: var(--text-secondary);">
                    {{ $isJenisTerjual ? 'Berdasarkan transaksi' : 'Berdasarkan stok kandang' }}
                </div>
            </div>
            <div class="chart-canvas-wrapper" style="display: flex; align-items: center; justify-content: center;">
                @if(count($jenisCounts) > 0 && array_sum($jenisCounts) > 0)
                    <canvas id="breedSalesChart"></canvas>
                @else
                    <div class="empty-state-dash">
                        <i class="bi bi-pie-chart"></i>
                        <p style="margin: 0; font-size: 0.85rem;">Belum ada data sapi untuk divisualisasikan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ═══ SECTION PESANAN & AKTIVITAS TERBARU ═══ --}}
<div class="recent-orders-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.5rem;">
        <div>
            <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-heading); margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-clock-history" style="color: #3b82f6;"></i> Aktivitas & Pesanan Terbaru
            </h3>
            <p style="color: var(--text-secondary); font-size: 0.8rem; margin: 2px 0 0 0;">
                Daftar 5 pesanan sapi terakhir yang masuk ke peternakan Anda.
            </p>
        </div>
        <a href="{{ route('peternak.pesanan') }}" style="font-size: 0.82rem; font-weight: 700; color: var(--green-brand); text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
            Lihat Semua Pesanan <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    @if($pesananTerbaru->count() > 0)
        <div class="table-responsive">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Kode & Tanggal</th>
                        <th>Pembeli</th>
                        <th>Sapi Dipesan</th>
                        <th>Tipe</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesananTerbaru as $trx)
                        <tr>
                            <td>
                                <strong style="color: var(--text-heading); font-family: monospace;">{{ $trx->kode_transaksi }}</strong>
                                <div style="font-size: 0.72rem; color: var(--text-secondary); margin-top: 2px;">
                                    {{ $trx->created_at->format('d M Y, H:i') }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--text-heading);">
                                    {{ $trx->pembeli->name ?? 'Pembeli' }}
                                </div>
                                <div style="font-size: 0.74rem; color: var(--text-secondary);">
                                    {{ $trx->pembeli->no_telepon ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    @php
                                        $sapiFoto = $trx->sapi && is_array($trx->sapi->foto) && count($trx->sapi->foto) > 0 ? $trx->sapi->foto[0] : null;
                                    @endphp
                                    @if($sapiFoto)
                                        <img src="{{ asset('storage/' . $sapiFoto) }}" alt="Sapi" style="width: 38px; height: 38px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border-color);">
                                    @else
                                        <div style="width: 38px; height: 38px; border-radius: 8px; background: var(--bg-muted); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); font-size: 1.1rem;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong style="color: var(--text-heading); font-size: 0.85rem;">{{ $trx->sapi->jenis ?? 'Sapi Ternak' }}</strong>
                                        <div style="font-size: 0.72rem; color: var(--text-secondary);">
                                            Bobot: {{ $trx->sapi->bobot ?? '-' }} kg
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($trx->is_preorder)
                                    <span style="background: rgba(139, 92, 246, 0.12); color: #8b5cf6; font-size: 0.72rem; font-weight: 700; padding: 2px 8px; border-radius: 999px; border: 1px solid rgba(139, 92, 246, 0.25);">
                                        Pre-Order
                                    </span>
                                @else
                                    <span style="background: rgba(59, 130, 246, 0.12); color: #3b82f6; font-size: 0.72rem; font-weight: 700; padding: 2px 8px; border-radius: 999px; border: 1px solid rgba(59, 130, 246, 0.25);">
                                        Reguler
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong style="color: var(--green-brand);">{{ $trx->total_harga_formatted }}</strong>
                                @if($trx->is_preorder)
                                    <div style="font-size: 0.7rem; color: var(--text-secondary);">
                                        DP: {{ $trx->dp_formatted }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @php
                                    $meta = $trx->status_meta;
                                @endphp
                                <span class="badge-status-chip" style="background: {{ $meta['bg'] }}; color: {{ $meta['color'] }}; border: 1px solid {{ $meta['border'] }};">
                                    <i class="bi {{ $meta['icon'] }}"></i> {{ $meta['label'] }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('peternak.pesanan', ['tab' => $trx->status]) }}" class="btn-dash-outline" style="padding: 0.35rem 0.75rem; font-size: 0.76rem;">
                                    Kelola <i class="bi bi-chevron-right"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state-dash">
            <i class="bi bi-inbox"></i>
            <h4 style="font-size: 1rem; font-weight: 700; color: var(--text-heading); margin-bottom: 0.25rem;">Belum Ada Pesanan Masuk</h4>
            <p style="font-size: 0.82rem; margin: 0; max-width: 400px; margin: 0 auto;">
                Saat pembeli memesan sapi Anda dari katalog, data pesanan dan rincian transaksi akan tampil secara otomatis di sini.
            </p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
{{-- Chart.js via CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const textColor = isDark ? '#cbd5e1' : '#475569';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.06)';

        // 1. Grafik Tren Penjualan & Pendapatan Bulanan
        const monthlyCtx = document.getElementById('monthlySalesChart');
        if (monthlyCtx) {
            const labels = @json($bulanLabels ?? []);
            const salesData = @json($penjualanBulanan ?? []);
            const revenueData = @json($pendapatanBulanan ?? []);

            new Chart(monthlyCtx, {
                data: {
                    labels: labels,
                    datasets: [
                        {
                            type: 'bar',
                            label: 'Jumlah Terjual (Ekor)',
                            data: salesData,
                            backgroundColor: 'rgba(16, 185, 129, 0.75)',
                            borderColor: '#10b981',
                            borderWidth: 1.5,
                            borderRadius: 6,
                            yAxisID: 'yCount',
                            order: 2
                        },
                        {
                            type: 'line',
                            label: 'Pendapatan (Juta Rp)',
                            data: revenueData,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.15)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.35,
                            pointBackgroundColor: '#3b82f6',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            yAxisID: 'yRevenue',
                            order: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: textColor,
                                font: { family: 'Inter', size: 12, weight: 600 },
                                usePointStyle: true,
                                boxWidth: 8
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if (context.dataset.yAxisID === 'yRevenue') {
                                        return context.dataset.label + ': Rp ' + (context.raw * 1000000).toLocaleString('id-ID');
                                    }
                                    return context.dataset.label + ': ' + context.raw + ' Ekor';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: gridColor },
                            ticks: { color: textColor, font: { family: 'Inter', size: 11 } }
                        },
                        yCount: {
                            type: 'linear',
                            position: 'left',
                            beginAtZero: true,
                            ticks: {
                                color: textColor,
                                stepSize: 1,
                                font: { family: 'Inter', size: 11 }
                            },
                            grid: { color: gridColor },
                            title: {
                                display: true,
                                text: 'Ekor',
                                color: textColor,
                                font: { family: 'Inter', size: 11, weight: 600 }
                            }
                        },
                        yRevenue: {
                            type: 'linear',
                            position: 'right',
                            beginAtZero: true,
                            grid: { drawOnChartArea: false },
                            ticks: {
                                color: textColor,
                                font: { family: 'Inter', size: 11 },
                                callback: function(val) {
                                    return val + ' jt';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Juta Rp',
                                color: textColor,
                                font: { family: 'Inter', size: 11, weight: 600 }
                            }
                        }
                    }
                }
            });
        }

        // 2. Grafik Distribusi Jenis Sapi (Doughnut Chart)
        const breedCtx = document.getElementById('breedSalesChart');
        if (breedCtx) {
            const breedLabels = @json($jenisLabels ?? []);
            const breedCounts = @json($jenisCounts ?? []);

            const palette = [
                '#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', 
                '#ec4899', '#06b6d4', '#14b8a6', '#f97316'
            ];

            new Chart(breedCtx, {
                type: 'doughnut',
                data: {
                    labels: breedLabels,
                    datasets: [{
                        data: breedCounts,
                        backgroundColor: palette.slice(0, breedLabels.length),
                        borderColor: isDark ? '#1e293b' : '#ffffff',
                        borderWidth: 2,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: textColor,
                                font: { family: 'Inter', size: 11, weight: 500 },
                                usePointStyle: true,
                                padding: 12
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.raw || 0;
                                    const pct = total > 0 ? Math.round((value / total) * 100) : 0;
                                    return ' ' + context.label + ': ' + value + ' ekor (' + pct + '%)';
                                }
                            }
                        }
                    },
                    cutout: '62%'
                }
            });
        }
    });
</script>
@endsection
