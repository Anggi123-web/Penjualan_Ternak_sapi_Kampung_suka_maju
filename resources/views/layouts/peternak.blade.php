@extends('layouts.app')

@section('title', $title ?? 'Peternak — Sistem Penjualan Sapi')

@section('styles')
<style>
    .sidebar-nav a.active {
        background: rgba(16, 185, 129, 0.12) !important;
        color: #047857 !important;
        font-weight: 700;
    }
    [data-theme="dark"] .sidebar-nav a.active {
        background: rgba(16, 185, 129, 0.18) !important;
        color: #6ee7b7 !important;
    }
</style>
@yield('page-styles')
@endsection

@section('content')
<div class="mobile-header">
    <div style="display: flex; align-items: center; gap: 8px;">
        <img src="{{ asset('images/sipeter_logo.png') }}" class="app-sidebar-logo" alt="Logo" style="height: 28px; width: auto; object-fit: contain;">
        <span style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary);">Peternak</span>
    </div>
    <div style="display: flex; align-items: center; gap: 8px;">
        @include('partials.theme_toggle', ['id' => 'peternakMobileThemeToggle', 'iconOnly' => true])
        <button class="hamburger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    </div>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    @include('dashboard.partials.sidebar_peternak')

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
@include('partials.chat_box')
@endsection

