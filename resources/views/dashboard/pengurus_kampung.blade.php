@extends('layouts.app')

@section('title', 'Dashboard Pengurus Kampung — Sistem Penjualan Sapi')

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;">🏘️ Pengurus Kampung</span>
    <button class="hamburger" onclick="toggleSidebar()">☰</button>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    @include('dashboard.partials.sidebar_pengurus_kampung')

    <main class="main-content">
        <div class="page-header">
            <h1>Dashboard Pengurus Kampung</h1>
            <p>Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>! Kelola administrasi wilayah Anda.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Peternak</span>
                    <div class="stat-card-icon" style="background: rgba(139,92,246,0.1); color: #c4b5fd;">👥</div>
                </div>
                <div class="stat-card-value">32</div>
                <div class="stat-card-change">Di wilayah ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Verifikasi Pending</span>
                    <div class="stat-card-icon" style="background: rgba(245,158,11,0.1); color: #fcd34d;">⏳</div>
                </div>
                <div class="stat-card-value">5</div>
                <div class="stat-card-change">Menunggu verifikasi</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Transaksi Wilayah</span>
                    <div class="stat-card-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;">💰</div>
                </div>
                <div class="stat-card-value">18</div>
                <div class="stat-card-change">Bulan ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Laporan Dibuat</span>
                    <div class="stat-card-icon" style="background: rgba(59,130,246,0.1); color: #93c5fd;">📋</div>
                </div>
                <div class="stat-card-value">7</div>
                <div class="stat-card-change">Bulan ini</div>
            </div>
        </div>

        <div class="content-card">
            <h3>✅ Verifikasi Terbaru</h3>
            <p style="color: #94a3b8; font-size: 0.9rem;">Daftar verifikasi akan segera tampil di sini. Data akan muncul setelah fitur lengkap diimplementasikan.</p>
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
