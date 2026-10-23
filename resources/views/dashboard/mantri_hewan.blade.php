@extends('layouts.mantri_hewan', ['title' => 'Dashboard Mantri Hewan — Sistem Penjualan Sapi', 'menungguCount' => $menungguPemeriksaan])

@section('page-content')
<div class="page-header">
    <h1>Dashboard Mantri Hewan</h1>
    <p>Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>! Kelola pemeriksaan kesehatan ternak.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Menunggu Pemeriksaan</span>
            <div class="stat-card-icon" style="background: rgba(245,158,11,0.1); color: #fcd34d;"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="stat-card-value">{{ $menungguPemeriksaan }}</div>
        <div class="stat-card-change" style="color: {{ $menungguPemeriksaan > 0 ? '#fcd34d' : '#34d399' }};">
            {{ $menungguPemeriksaan > 0 ? 'Perlu ditindaklanjuti' : 'Semua sudah diperiksa' }}
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Terverifikasi Sehat</span>
            <div class="stat-card-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $verifikasiSehatBulanIni }}</div>
        <div class="stat-card-change">Bulan ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Tidak Sehat</span>
            <div class="stat-card-icon" style="background: rgba(239,68,68,0.1); color: #fca5a5;"><i class="bi bi-x-circle-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $tidakSehatBulanIni }}</div>
        <div class="stat-card-change" style="color: {{ $tidakSehatBulanIni > 0 ? '#fca5a5' : '#34d399' }};">Bulan ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Total Diperiksa</span>
            <div class="stat-card-icon" style="background: rgba(59,130,246,0.1); color: #93c5fd;"><i class="bi bi-piggy-bank"></i></div>
        </div>
        <div class="stat-card-value">{{ $totalDiperiksa }}</div>
        <div class="stat-card-change">Keseluruhan</div>
    </div>
</div>

@if($menungguPemeriksaan > 0)
<div class="content-card">
    <h3><i class="bi bi-search"></i> Sapi Menunggu Pemeriksaan</h3>
    <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 1rem;">
        Ada <strong style="color: #fcd34d;">{{ $menungguPemeriksaan }}</strong> sapi yang menunggu pemeriksaan kesehatan Anda.
    </p>
    <a href="{{ route('mantri_hewan.pemeriksaan') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.25rem; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(217,119,6,0.3)';" onmouseout="this.style.transform=''; this.style.boxShadow='';">
        <i class="bi bi-search"></i> Mulai Pemeriksaan
    </a>
</div>
@else
<div class="content-card">
    <h3><i class="bi bi-check-circle-fill"></i> Semua Terperiksa</h3>
    <p style="color: #94a3b8; font-size: 0.9rem;">Tidak ada sapi yang menunggu pemeriksaan saat ini. Semua data sudah diverifikasi.</p>
</div>
@endif
@endsection
