@extends('layouts.app')

@section('title', 'Laporan Penjualan Per Triwulan — Pengurus Kampung')

@section('styles')
<style>
    .report-filter-box {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        align-items: flex-end;
    }

    .form-group-filter {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .form-group-filter label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #94a3b8;
    }

    .select-filter-custom {
        padding: 0.65rem 1rem;
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(148, 163, 184, 0.15);
        border-radius: 12px;
        color: #f1f5f9;
        font-size: 0.9rem;
        outline: none;
        cursor: pointer;
        width: 100%;
        transition: border-color 0.2s ease;
    }

    .select-filter-custom:focus {
        border-color: #8b5cf6;
    }

    .select-filter-custom option {
        background: #1e293b;
        color: #f1f5f9;
    }

    .btn-filter-action {
        padding: 0.65rem 1.25rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.88rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-primary-purple {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: #ffffff;
        border: none;
    }

    .btn-primary-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -4px rgba(139, 92, 246, 0.5);
    }

    .btn-outline-print {
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.35);
        color: #6ee7b7;
    }

    .btn-outline-print:hover {
        background: rgba(16, 185, 129, 0.25);
        color: #ffffff;
    }

    .btn-outline-pdf {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.35);
        color: #fca5a5;
    }

    .btn-outline-pdf:hover {
        background: rgba(239, 68, 68, 0.25);
        color: #ffffff;
    }

    /* Comparison Quarter Grid */
    .quarter-comp-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 1024px) {
        .quarter-comp-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .quarter-comp-grid {
            grid-template-columns: 1fr;
        }
    }

    .quarter-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 1.25rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .quarter-card.highlight {
        border-color: #8b5cf6;
        background: rgba(139, 92, 246, 0.12);
        box-shadow: 0 8px 25px -5px rgba(139, 92, 246, 0.25);
    }

    .quarter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .quarter-badge {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        padding: 3px 8px;
        border-radius: 6px;
        background: rgba(148, 163, 184, 0.15);
        color: #cbd5e1;
    }

    .quarter-card.highlight .quarter-badge {
        background: #8b5cf6;
        color: #ffffff;
    }

    .quarter-omset {
        font-size: 1.25rem;
        font-weight: 800;
        color: #f1f5f9;
        margin-bottom: 0.25rem;
    }

    .quarter-sub {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    /* Section Cards */
    .report-table-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
        text-align: left;
    }

    .report-table th {
        padding: 0.85rem 1rem;
        background: rgba(15, 23, 42, 0.5);
        color: #94a3b8;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid rgba(148, 163, 184, 0.15);
    }

    .report-table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.06);
        color: #cbd5e1;
        vertical-align: middle;
    }

    .report-table tr:hover td {
        background: rgba(139, 92, 246, 0.04);
    }

    .percentage-bar-wrap {
        width: 100%;
        height: 6px;
        background: rgba(148, 163, 184, 0.15);
        border-radius: 999px;
        overflow: hidden;
        margin-top: 4px;
    }

    .percentage-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #8b5cf6, #ec4899);
        border-radius: 999px;
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
        <!-- Page Title & Action Bar -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
            <div>
                <h1><i class="bi bi-clipboard2-data-fill" style="color: #c4b5fd;"></i> Laporan Penjualan Per Triwulan</h1>
                <p style="color: #94a3b8; font-size: 0.9rem;">
                    Rekapitulasi penjualan ternak sapi wilayah Kampung Suka Maju periode 
                    <strong>
                        @if($triwulan === 'all')
                            Semua Triwulan (Tahunan)
                        @else
                            Triwulan {{ match($triwulan) { '1' => 'I (Jan - Mar)', '2' => 'II (Apr - Jun)', '3' => 'III (Jul - Sep)', '4' => 'IV (Okt - Des)' } }}
                        @endif
                    </strong> 
                    Tahun <strong>{{ $tahun }}</strong>.
                </p>
            </div>

            <!-- Tombol Cetak & Unduh PDF -->
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                <a href="{{ route('pengurus_kampung.laporan.cetak', request()->query()) }}" target="_blank" class="btn-filter-action btn-outline-print">
                    <i class="bi bi-printer-fill"></i> Cetak Laporan Resmi
                </a>
                <a href="{{ route('pengurus_kampung.laporan.pdf', request()->query()) }}" class="btn-filter-action btn-outline-pdf">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Unduh PDF
                </a>
            </div>
        </div>

        <!-- Filter Panel -->
        <div class="report-filter-box">
            <form method="GET" action="{{ route('pengurus_kampung.laporan.index') }}">
                <div class="filter-grid">
                    <!-- Tahun -->
                    <div class="form-group-filter">
                        <label><i class="bi bi-calendar-event"></i> Tahun</label>
                        <select name="tahun" class="select-filter-custom">
                            @foreach($availableYears as $yr)
                                <option value="{{ $yr }}" {{ $tahun == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Triwulan -->
                    <div class="form-group-filter">
                        <label><i class="bi bi-pie-chart-fill"></i> Triwulan</label>
                        <select name="triwulan" class="select-filter-custom">
                            <option value="all" {{ $triwulan === 'all' ? 'selected' : '' }}>Semua Triwulan (1 Tahun Penuh)</option>
                            <option value="1" {{ $triwulan === '1' ? 'selected' : '' }}>Triwulan I (Januari - Maret)</option>
                            <option value="2" {{ $triwulan === '2' ? 'selected' : '' }}>Triwulan II (April - Juni)</option>
                            <option value="3" {{ $triwulan === '3' ? 'selected' : '' }}>Triwulan III (Juli - September)</option>
                            <option value="4" {{ $triwulan === '4' ? 'selected' : '' }}>Triwulan IV (Oktober - Desember)</option>
                        </select>
                    </div>

                    <!-- Status Transaksi -->
                    <div class="form-group-filter">
                        <label><i class="bi bi-check-circle-fill"></i> Status Transaksi</label>
                        <select name="status" class="select-filter-custom">
                            <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai (Penjualan Berhasil)</option>
                            <option value="semua" {{ $status === 'semua' ? 'selected' : '' }}>Semua Status Transaksi</option>
                        </select>
                    </div>

                    <!-- Filter Peternak -->
                    <div class="form-group-filter">
                        <label><i class="bi bi-person-fill"></i> Peternak</label>
                        <select name="peternak_id" class="select-filter-custom">
                            <option value="all">Semua Peternak Wilayah</option>
                            @foreach($listPeternak as $pt)
                                <option value="{{ $pt->id }}" {{ $peternakId == $pt->id ? 'selected' : '' }}>
                                    {{ $pt->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Submit -->
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="submit" class="btn-filter-action btn-primary-purple" style="flex: 1;">
                            <i class="bi bi-funnel-fill"></i> Terapkan Filter
                        </button>
                        @if($triwulan !== 'all' || $status !== 'selesai' || $peternakId !== 'all' || $tahun != date('Y'))
                            <a href="{{ route('pengurus_kampung.laporan.index') }}" class="btn-filter-action" style="background: rgba(148,163,184,0.15); color: #94a3b8;" title="Reset Filter">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Metric KPI Cards Periode Terpilih -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Omset Penjualan</span>
                    <div class="stat-card-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;"><i class="bi bi-cash-stack"></i></div>
                </div>
                <div class="stat-card-value" style="font-size: 1.45rem;">Rp {{ number_format($totalOmset, 0, ',', '.') }}</div>
                <div class="stat-card-change" style="color: #6ee7b7;">Periode terpilih</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Volume Sapi Terjual</span>
                    <div class="stat-card-icon" style="background: rgba(139,92,246,0.1); color: #c4b5fd;"><i class="bi bi-piggy-bank"></i></div>
                </div>
                <div class="stat-card-value">{{ $totalSapiTerjual }}</div>
                <div class="stat-card-change">Ekor sapi</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Transaksi Selesai</span>
                    <div class="stat-card-icon" style="background: rgba(59,130,246,0.1); color: #93c5fd;"><i class="bi bi-receipt-cutoff"></i></div>
                </div>
                <div class="stat-card-value">{{ $transaksiSelesai }}</div>
                <div class="stat-card-change">Transaksi terkonfirmasi</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Rata-Rata per Ekor</span>
                    <div class="stat-card-icon" style="background: rgba(245,158,11,0.1); color: #fcd34d;"><i class="bi bi-calculator"></i></div>
                </div>
                <div class="stat-card-value" style="font-size: 1.35rem;">Rp {{ number_format($avgHarga, 0, ',', '.') }}</div>
                <div class="stat-card-change">Nilai rata-rata transaksi</div>
            </div>
        </div>

        <!-- Komparasi Performa 4 Triwulan Tahun {{ $tahun }} -->
        <div style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-bar-chart-steps" style="color: #c4b5fd;"></i> Performa Antar-Triwulan Tahun {{ $tahun }}
            </h3>

            <div class="quarter-comp-grid">
                @foreach($quarterComparison as $qKey => $qData)
                    @php
                        $isCurrentSelected = ($triwulan == $qKey);
                    @endphp
                    <div class="quarter-card {{ $isCurrentSelected ? 'highlight' : '' }}">
                        <div class="quarter-header">
                            <span class="quarter-badge">{{ $qData['short'] }}</span>
                            <span style="font-size: 0.75rem; color: #94a3b8;">
                                @if($qKey == 1) Jan - Mar
                                @elseif($qKey == 2) Apr - Jun
                                @elseif($qKey == 3) Jul - Sep
                                @else Okt - Des @endif
                            </span>
                        </div>
                        <div class="quarter-omset">Rp {{ number_format($qData['total_omset'], 0, ',', '.') }}</div>
                        <div class="quarter-sub">
                            <span><i class="bi bi-piggy-bank"></i> {{ $qData['total_sapi'] }} ekor</span> &bull; 
                            <span>{{ $qData['total_transaksi'] }} transaksi</span>
                        </div>
                        @if($isCurrentSelected)
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #8b5cf6;"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tabel Rekapitulasi Penjualan per Peternak -->
        <div class="report-table-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-people-fill" style="color: #6ee7b7;"></i> Rekapitulasi Penjualan Berdasarkan Peternak
                </h3>
                <span style="font-size: 0.8rem; color: #94a3b8;">{{ count($peternakBreakdown) }} Peternak Berkontribusi</span>
            </div>

            @if(count($peternakBreakdown) > 0)
                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Peternak</th>
                                <th>NIK</th>
                                <th>Alamat Kandang</th>
                                <th style="text-align: center;">Sapi Terjual</th>
                                <th style="text-align: right;">Total Penjualan (Omset)</th>
                                <th style="width: 140px; text-align: center;">Kontribusi %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peternakBreakdown as $idx => $pb)
                                @php
                                    $pct = $totalOmset > 0 ? round(($pb['total_omset'] / $totalOmset) * 100, 1) : 0;
                                @endphp
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>
                                        <strong style="color: #f1f5f9;">{{ $pb['name'] }}</strong>
                                    </td>
                                    <td style="font-family: monospace; font-size: 0.82rem;">{{ $pb['nik'] }}</td>
                                    <td style="font-size: 0.82rem;">{{ Str::limit($pb['alamat'], 35) }}</td>
                                    <td style="text-align: center; font-weight: 700; color: #c4b5fd;">
                                        {{ $pb['jumlah_sapi'] }} Ekor
                                    </td>
                                    <td style="text-align: right; font-weight: 800; color: #6ee7b7;">
                                        Rp {{ number_format($pb['total_omset'], 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <div style="text-align: center; font-size: 0.8rem; font-weight: 700; color: #cbd5e1;">{{ $pct }}%</div>
                                        <div class="percentage-bar-wrap">
                                            <div class="percentage-bar-fill" style="width: {{ $pct }}%;"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color: #94a3b8; font-size: 0.9rem; text-align: center; padding: 2rem 0;">
                    Belum ada transaksi penjualan sapi dari peternak pada periode triwulan yang dipilih.
                </p>
            @endif
        </div>

        <!-- Tabel Rincian Transaksi Lengkap -->
        <div class="report-table-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-receipt" style="color: #93c5fd;"></i> Rincian Seluruh Transaksi Penjualan
                </h3>
                <span style="font-size: 0.8rem; color: #94a3b8;">{{ $transaksis->total() }} Transaksi Tercatat</span>
            </div>

            @if($transaksis->count() > 0)
                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Tanggal</th>
                                <th>Peternak</th>
                                <th>Pembeli</th>
                                <th>Sapi (Jenis/Bobot)</th>
                                <th>Tipe & Metode</th>
                                <th>Status</th>
                                <th style="text-align: right;">Total Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $trx)
                                <tr>
                                    <td style="font-family: monospace; font-weight: 700; color: #f1f5f9;">
                                        {{ $trx->kode_transaksi }}
                                    </td>
                                    <td style="font-size: 0.82rem; color: #94a3b8;">
                                        {{ $trx->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        <strong style="color: #f1f5f9;">{{ $trx->sapi?->peternak?->name ?? '-' }}</strong>
                                    </td>
                                    <td>
                                        {{ $trx->pembeli?->name ?? 'Pembeli' }}
                                    </td>
                                    <td>
                                        <span style="color: #c4b5fd; font-weight: 600;">{{ $trx->sapi?->jenis ?? 'Sapi' }}</span>
                                        @if($trx->sapi)
                                            <span style="font-size: 0.75rem; color: #94a3b8; display: block;">{{ $trx->sapi->bobot }} kg &bull; {{ $trx->sapi->umur_formatted }}</span>
                                        @endif
                                    </td>
                                    <td style="font-size: 0.82rem;">
                                        <span style="display: block; font-weight: 600; color: #cbd5e1;">{{ ucfirst($trx->tipe_penjualan) }}</span>
                                        <span style="color: #94a3b8;">{{ ucfirst($trx->metode_pembayaran) }}</span>
                                    </td>
                                    <td>
                                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 7px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; background: {{ $trx->status_meta['bg'] }}; color: {{ $trx->status_meta['color'] }}; border: 1px solid {{ $trx->status_meta['border'] }};">
                                            {{ $trx->status_meta['label'] }}
                                        </span>
                                    </td>
                                    <td style="text-align: right; font-weight: 800; color: #6ee7b7;">
                                        {{ $trx->total_harga_formatted }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 1.5rem;">
                    {{ $transaksis->links() }}
                </div>
            @else
                <p style="color: #94a3b8; font-size: 0.9rem; text-align: center; padding: 2rem 0;">
                    Tidak ada transaksi ditemukan pada filter periode ini.
                </p>
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
