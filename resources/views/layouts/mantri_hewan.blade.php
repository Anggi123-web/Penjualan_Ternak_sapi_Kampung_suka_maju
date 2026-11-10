@extends('layouts.app')

@section('title', $title ?? 'Mantri Hewan — Sistem Penjualan Sapi')

@section('styles')
<style>
    .sidebar-nav a.active {
        background: rgba(245, 158, 11, 0.12) !important;
        color: #b45309 !important;
        font-weight: 700;
    }
    [data-theme="dark"] .sidebar-nav a.active {
        background: rgba(245, 158, 11, 0.18) !important;
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
    <div style="display: flex; align-items: center; gap: 8px;">
        <img src="{{ asset('images/sipeter_logo.png') }}" class="app-sidebar-logo" alt="Logo" style="height: 28px; width: auto; object-fit: contain;">
        <span style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary);">Mantri Hewan</span>
    </div>
    <div style="display: flex; align-items: center; gap: 8px;">
        @include('partials.theme_toggle', ['id' => 'mantriMobileThemeToggle', 'iconOnly' => true])
        <button class="hamburger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    </div>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand-header" style="padding-bottom: 1.25rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--border-color); text-align: center;">
            <a href="{{ url('/') }}" title="Lihat Beranda" style="display: block; text-decoration: none;">
                <img src="{{ asset('images/sipeter_logo.png') }}" class="app-sidebar-logo" alt="Logo" style="max-height: 46px; width: auto; max-width: 100%; object-fit: contain; margin: 0 auto 0.4rem auto; display: block;">
            </a>
            <div style="display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.72rem; font-weight: 700; color: #f59e0b; text-transform: uppercase; letter-spacing: 0.06em; background: rgba(245, 158, 11, 0.12); padding: 3px 10px; border-radius: 999px;">
                <i class="bi bi-heart-pulse"></i> Panel Mantri Hewan
            </div>
        </div>

        <nav class="sidebar-nav">
            @php
                $menungguCountBadge = $menungguCount ?? \App\Models\Sapi::where('status_kesehatan', 'belum_diperiksa')->count();
            @endphp
            <a href="{{ route('mantri_hewan.dashboard') }}" class="{{ request()->routeIs('mantri_hewan.dashboard') ? 'active' : '' }}" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span class="nav-icon"><i class="bi bi-bar-chart-line"></i></span>
                    Dashboard
                </div>
                @if($menungguCountBadge > 0)
                    <span class="badge-count" style="margin-left: 0;" title="{{ $menungguCountBadge }} sapi menunggu pemeriksaan">{{ $menungguCountBadge }}</span>
                @endif
            </a>
            <a href="{{ route('mantri_hewan.riwayat') }}" class="{{ request()->routeIs('mantri_hewan.riwayat') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-clipboard-data"></i></span>
                Riwayat Verifikasi
            </a>
        </nav>

        <div class="sidebar-footer">
            <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                @include('partials.theme_toggle', ['id' => 'mantriSidebarThemeToggle'])
            </div>
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

