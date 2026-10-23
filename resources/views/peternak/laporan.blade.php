@extends('layouts.peternak', ['title' => 'Laporan — Sistem Penjualan Sapi'])

@section('page-styles')
<style>
    .filter-bar {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .filter-select {
        padding: 0.6rem 1rem;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 10px;
        color: #f1f5f9;
        font-size: 0.85rem;
        font-family: 'Inter', sans-serif;
        outline: none;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        padding-right: 2.25rem;
        min-width: 160px;
    }

    .filter-select:focus {
        border-color: rgba(16, 185, 129, 0.4);
    }

    .filter-select option {
        background: #1e293b;
        color: #f1f5f9;
    }

    .report-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .report-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .report-card h4 {
        font-size: 0.85rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .report-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0;
        border-bottom: 1px solid rgba(148, 163, 184, 0.06);
    }

    .report-row:last-child {
        border-bottom: none;
    }

    .report-label {
        font-size: 0.85rem;
        color: #94a3b8;
    }

    .report-value {
        font-size: 0.9rem;
        font-weight: 700;
        color: #f1f5f9;
    }

    .report-value.positive {
        color: #6ee7b7;
    }

    .chart-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
        color: #64748b;
        font-size: 0.9rem;
        gap: 0.75rem;
    }

    .chart-placeholder-icon {
        font-size: 2.5rem;
        opacity: 0.4;
    }
</style>
@endsection

@section('page-content')
<div class="page-header">
    <h1>Laporan</h1>
    <p>Lihat ringkasan dan laporan penjualan Anda.</p>
</div>

<div class="filter-bar">
    <select class="filter-select" id="filter-periode">
        <option value="bulan">Bulan Ini</option>
        <option value="minggu">Minggu Ini</option>
        <option value="tahun">Tahun Ini</option>
        <option value="semua">Semua</option>
    </select>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Total Penjualan</span>
            <div class="stat-card-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;"><i class="bi bi-cash-stack"></i></div>
        </div>
        <div class="stat-card-value">0</div>
        <div class="stat-card-change">Transaksi</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Total Pendapatan</span>
            <div class="stat-card-icon" style="background: rgba(59,130,246,0.1); color: #93c5fd;"><i class="bi bi-graph-up-arrow"></i></div>
        </div>
        <div class="stat-card-value">Rp 0</div>
        <div class="stat-card-change">Periode ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Rata-rata Harga</span>
            <div class="stat-card-icon" style="background: rgba(245,158,11,0.1); color: #fcd34d;"><i class="bi bi-bar-chart-line"></i></div>
        </div>
        <div class="stat-card-value">Rp 0</div>
        <div class="stat-card-change">Per ekor</div>
    </div>
</div>

<div class="report-grid">
    <div class="report-card">
        <h4><i class="bi bi-bar-chart-fill"></i> Grafik Penjualan</h4>
        <div class="chart-placeholder">
            <div class="chart-placeholder-icon"><i class="bi bi-graph-down"></i></div>
            <span>Grafik akan tampil saat ada data penjualan</span>
        </div>
    </div>
    <div class="report-card">
        <h4><i class="bi bi-piggy-bank"></i> Penjualan per Jenis</h4>
        <div class="chart-placeholder">
            <div class="chart-placeholder-icon"><i class="bi bi-clipboard-data"></i></div>
            <span>Data akan muncul saat ada penjualan</span>
        </div>
    </div>
</div>
@endsection
