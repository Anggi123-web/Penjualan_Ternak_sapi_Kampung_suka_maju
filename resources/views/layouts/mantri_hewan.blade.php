@extends('layouts.app')

@section('title', $title ?? 'Mantri Hewan — Sistem Penjualan Sapi')

@section('styles')
<style>
    .sidebar-nav a.active {
        background: rgba(245, 158, 11, 0.1) !important;
        color: #fcd34d !important;
    }

    .badge-count {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.15rem 0.45rem;
        border-radius: 50px;
        margin-left: auto;
        min-width: 20px;
        text-align: center;
        animation: pulse-badge 2s ease-in-out infinite;
    }

    @keyframes pulse-badge {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
</style>
@yield('page-styles')
@endsection

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;"><i class="bi bi-heart-pulse"></i> Mantri Hewan</span>
    <button class="hamburger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon" style="background: rgba(245,158,11,0.1); color: #fcd34d;"><i class="bi bi-heart-pulse"></i></div>
            <div class="sidebar-logo-text">
                <h2>Mantri Hewan</h2>
                <span>Sistem Penjualan Sapi</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('mantri_hewan.dashboard') }}" class="{{ request()->routeIs('mantri_hewan.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-bar-chart-line"></i></span>
                Dashboard
            </a>
            <a href="{{ route('mantri_hewan.pemeriksaan') }}" class="{{ request()->routeIs('mantri_hewan.pemeriksaan*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-search"></i></span>
                Pemeriksaan
                @if(isset($menungguCount) && $menungguCount > 0)
                    <span class="badge-count">{{ $menungguCount }}</span>
                @endif
            </a>
            <a href="{{ route('mantri_hewan.riwayat') }}" class="{{ request()->routeIs('mantri_hewan.riwayat') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-clipboard-data"></i></span>
                Riwayat Verifikasi
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="user-details">
                    <h4>{{ auth()->user()->name }}</h4>
                    <span>{{ auth()->user()->email }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        @yield('page-content')
    </main>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('open');
    }
</script>
@endsection

