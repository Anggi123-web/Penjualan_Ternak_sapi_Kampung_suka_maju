@extends('layouts.mantri_hewan', ['title' => 'Dashboard & Pemeriksaan Hewan — Sistem Penjualan Sapi', 'menungguCount' => $menungguPemeriksaan])

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

    .alert-success {
        background: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.25);
        color: #34d399;
        border-radius: 12px;
        padding: 0.9rem 1.25rem;
        margin-bottom: 1.5rem;
        font-size: 0.88rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    /* ═══ Stats Grid ═══ */
    .mantri-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card-custom {
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

    .stat-card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .stat-card-custom-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }

    .stat-card-custom-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .stat-card-custom-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .stat-card-custom-val {
        font-size: 1.75rem;
        font-weight: 900;
        color: var(--text-heading);
        line-height: 1.2;
        font-family: var(--font-montserrat, sans-serif);
    }

    .stat-card-custom-sub {
        font-size: 0.76rem;
        color: var(--text-secondary);
        margin-top: 0.4rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ═══ Table Styles ═══ */
    .content-box-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.35rem 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .box-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .box-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--text-heading);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-montserrat, sans-serif);
    }

    .box-subtitle {
        color: var(--text-secondary);
        font-size: 0.82rem;
        margin: 3px 0 0 0;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .data-table-clean {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.86rem;
        text-align: left;
    }

    .data-table-clean th {
        padding: 0.75rem 1rem;
        font-weight: 700;
        font-size: 0.74rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-muted);
    }

    .data-table-clean td {
        padding: 0.95rem 1rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
        vertical-align: middle;
    }

    .data-table-clean tr:last-child td {
        border-bottom: none;
    }

    .data-table-clean tr:hover td {
        background: rgba(245, 158, 11, 0.03);
    }

    .table-sapi-info {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .table-sapi-thumb {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid var(--border-color);
        flex-shrink: 0;
    }

    .table-sapi-thumb-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: var(--bg-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        border: 1px solid var(--border-color);
        flex-shrink: 0;
    }

    .btn-periksa-now {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1.05rem;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #ffffff !important;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
        white-space: nowrap;
    }

    .btn-periksa-now:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
        color: #ffffff !important;
    }

    .health-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 0.74rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .health-badge-belum {
        background: rgba(245, 158, 11, 0.12);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #f59e0b;
    }

    .health-badge-sehat {
        background: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981;
    }

    .health-badge-tidak-sehat {
        background: rgba(239, 68, 68, 0.12);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ef4444;
    }

    .empty-state-card {
        padding: 3rem 1.5rem;
        text-align: center;
        color: var(--text-secondary);
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 0.75rem;
        color: #10b981;
        opacity: 0.85;
    }
</style>
@endsection

@section('page-content')
{{-- Header Halaman --}}
<div class="dashboard-header-flex">
    <div>
        <h1 style="font-size: clamp(1.4rem, 3vw, 1.85rem); font-weight: 800; color: var(--text-heading); margin: 0; font-family: var(--font-montserrat, sans-serif);">
            Dashboard & Pemeriksaan Hewan
        </h1>
        <p style="color: var(--text-secondary); font-size: 0.88rem; margin-top: 4px; margin-bottom: 0;">
            Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>! Kelola pemeriksaan fisik, status kelayakan klinis, dan dokumen kesehatan ternak sapi.
        </p>
    </div>
    <div>
        <span style="background: rgba(245, 158, 11, 0.12); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); font-size: 0.8rem; font-weight: 700; padding: 6px 14px; border-radius: 999px; display: inline-flex; align-items: center; gap: 6px;">
            <i class="bi bi-shield-check"></i> Petugas Mantri Hewan Aktif
        </span>
    </div>
</div>

@if (session('success'))
    <div class="alert-success">
        <i class="bi bi-check-circle-fill" style="font-size: 1.15rem; flex-shrink: 0;"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

{{-- ═══ STATS GRID (4 Cards) ═══ --}}
<div class="mantri-stats-grid">
    {{-- Card 1: Menunggu Pemeriksaan --}}
    <div class="stat-card-custom">
        <div class="stat-card-custom-header">
            <span class="stat-card-custom-title">Menunggu Pemeriksaan</span>
            <div class="stat-card-custom-icon" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
        <div class="stat-card-custom-val" style="color: {{ $menungguPemeriksaan > 0 ? '#f59e0b' : 'var(--text-heading)' }};">
            {{ $menungguPemeriksaan }}
        </div>
        <div class="stat-card-custom-sub" style="color: {{ $menungguPemeriksaan > 0 ? '#f59e0b' : '#10b981' }}; font-weight: 600;">
            <i class="bi {{ $menungguPemeriksaan > 0 ? 'bi-exclamation-circle-fill' : 'bi-check-circle-fill' }}"></i>
            {{ $menungguPemeriksaan > 0 ? 'Perlu tindakan pemeriksaan' : 'Semua sudah diperiksa' }}
        </div>
    </div>

    {{-- Card 2: Terverifikasi Sehat Bulan Ini --}}
    <div class="stat-card-custom">
        <div class="stat-card-custom-header">
            <span class="stat-card-custom-title">Terverifikasi Sehat</span>
            <div class="stat-card-custom-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
        </div>
        <div class="stat-card-custom-val" style="color: #10b981;">
            {{ $verifikasiSehatBulanIni }}
        </div>
        <div class="stat-card-custom-sub">
            <i class="bi bi-calendar-check"></i> Bulan {{ now()->locale('id')->translatedFormat('F Y') }}
        </div>
    </div>

    {{-- Card 3: Tidak Sehat Bulan Ini --}}
    <div class="stat-card-custom">
        <div class="stat-card-custom-header">
            <span class="stat-card-custom-title">Tidak Sehat</span>
            <div class="stat-card-custom-icon" style="background: rgba(239, 68, 68, 0.15); color: #ef4444;">
                <i class="bi bi-x-circle-fill"></i>
            </div>
        </div>
        <div class="stat-card-custom-val" style="color: {{ $tidakSehatBulanIni > 0 ? '#ef4444' : 'var(--text-heading)' }};">
            {{ $tidakSehatBulanIni }}
        </div>
        <div class="stat-card-custom-sub" style="color: {{ $tidakSehatBulanIni > 0 ? '#ef4444' : 'var(--text-secondary)' }};">
            <i class="bi {{ $tidakSehatBulanIni > 0 ? 'bi-heartbreak-fill' : 'bi-dash-circle' }}"></i>
            {{ $tidakSehatBulanIni > 0 ? 'Perlu isolasi / rawat' : 'Nol kasus bulan ini' }}
        </div>
    </div>

    {{-- Card 4: Total Diperiksa --}}
    <div class="stat-card-custom">
        <div class="stat-card-custom-header">
            <span class="stat-card-custom-title">Total Riwayat Diperiksa</span>
            <div class="stat-card-custom-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;">
                <i class="bi bi-clipboard-check-fill"></i>
            </div>
        </div>
        <div class="stat-card-custom-val" style="color: #3b82f6;">
            {{ $totalDiperiksa }}
        </div>
        <div class="stat-card-custom-sub">
            <i class="bi bi-archive-fill"></i> Keseluruhan Ternak
        </div>
    </div>
</div>

{{-- ═══ SECTION PEMERIKSAAN SAPI (DIMASUKKAN LANGSUNG KE DASHBOARD) ═══ --}}
<div class="content-box-card" id="antrean-pemeriksaan">
    <div class="box-header-flex">
        <div>
            <h2 class="box-title">
                <i class="bi bi-search" style="color: #f59e0b;"></i> Antrean Pemeriksaan Sapi Ternak
            </h2>
            <p class="box-subtitle">
                Daftar sapi yang baru didaftarkan oleh peternak dan menunggu pemeriksaan fisik sebelum dipublikasikan ke katalog.
            </p>
        </div>
        <div>
            <span style="font-size: 0.8rem; font-weight: 700; background: rgba(245, 158, 11, 0.12); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); padding: 5px 12px; border-radius: 999px; display: inline-flex; align-items: center; gap: 5px;">
                <i class="bi bi-hourglass-split"></i> Menunggu: {{ $sapis->count() }} Ekor
            </span>
        </div>
    </div>

    @if ($sapis->count() > 0)
        <div class="table-responsive">
            <table class="data-table-clean">
                <thead>
                    <tr>
                        <th>Sapi & Peternak</th>
                        <th>Umur</th>
                        <th>Bobot</th>
                        <th>Harga</th>
                        <th>Tipe Penjualan</th>
                        <th>Didaftarkan</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
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
                                        <div style="font-weight: 700; color: var(--text-heading); font-size: 0.92rem;">
                                            {{ $sapi->jenis }}
                                        </div>
                                        <div style="font-size: 0.76rem; color: var(--text-secondary); margin-top: 2px;">
                                            Peternak: <strong>{{ $sapi->peternak->name ?? '-' }}</strong>
                                            @if($sapi->lokasi)
                                                &bull; <span title="Lokasi Kandang">{{ $sapi->lokasi }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600;">{{ $sapi->umur_formatted }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: var(--text-heading);">{{ number_format($sapi->bobot, 0) }} kg</span>
                            </td>
                            <td>
                                <strong style="color: var(--green-brand);">{{ $sapi->harga_formatted }}</strong>
                            </td>
                            <td>
                                @if($sapi->is_preorder)
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
                                <div style="font-size: 0.8rem; color: var(--text-secondary);">
                                    {{ $sapi->created_at->format('d M Y') }}
                                </div>
                                <div style="font-size: 0.72rem; color: var(--text-muted, #94a3b8);">
                                    {{ $sapi->created_at->format('H:i') }} WIB
                                </div>
                            </td>
                            <td>
                                <span class="health-badge health-badge-belum">
                                    <i class="bi bi-hourglass-split"></i> Belum Diperiksa
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('mantri_hewan.pemeriksaan.show', $sapi->id) }}" class="btn-periksa-now" id="btn-periksa-{{ $sapi->id }}">
                                    <i class="bi bi-search"></i> Periksa Sekarang
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state-card">
            <div class="empty-state-icon">
                <i class="bi bi-patch-check-fill"></i>
            </div>
            <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text-heading); margin-bottom: 0.35rem;">
                Tidak Ada Sapi Menunggu Pemeriksaan
            </h3>
            <p style="font-size: 0.88rem; max-width: 460px; margin: 0 auto; line-height: 1.5;">
                Semua data sapi ternak dari peternak telah selesai diverifikasi. Jika ada peternak yang mendaftarkan sapi baru, datanya akan otomatis muncul di antrean ini.
            </p>
            <div style="margin-top: 1.25rem;">
                <a href="{{ route('mantri_hewan.riwayat') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 0.55rem 1.1rem; background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.82rem; font-weight: 600; text-decoration: none;">
                    <i class="bi bi-clipboard-data"></i> Lihat Riwayat Verifikasi
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
