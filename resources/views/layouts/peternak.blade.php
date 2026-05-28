@extends('layouts.app')

@section('title', $title ?? 'Peternak — Sistem Penjualan Sapi')

@section('styles')
<style>
    .sidebar-nav a.active {
        background: rgba(16, 185, 129, 0.1) !important;
        color: #6ee7b7 !important;
    }
</style>
@yield('page-styles')
@endsection

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;">🐄 Peternak</span>
    <button class="hamburger" onclick="toggleSidebar()">☰</button>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;">🐄</div>
            <div class="sidebar-logo-text">
                <h2>Peternak</h2>
                <span>Sistem Penjualan Sapi</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('peternak.dashboard') }}" class="{{ request()->routeIs('peternak.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">📊</span>
                Dashboard
            </a>
            <a href="{{ route('peternak.penjualan') }}" class="{{ request()->routeIs('peternak.penjualan') ? 'active' : '' }}">
                <span class="nav-icon">💰</span>
                Penjualan
            </a>
            <a href="{{ route('peternak.laporan') }}" class="{{ request()->routeIs('peternak.laporan') ? 'active' : '' }}">
                <span class="nav-icon">📋</span>
                Laporan
            </a>
            <a href="{{ route('iklan.index') }}" class="{{ request()->routeIs('iklan.*') ? 'active' : '' }}">
                <span class="nav-icon">🖼️</span>
                Kelola Iklan
            </a>
            <a href="{{ route('peternak.akun') }}" class="{{ request()->routeIs('peternak.akun') ? 'active' : '' }}">
                <span class="nav-icon">👤</span>
                Akun Saya
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar" style="background: linear-gradient(135deg, #10b981, #059669);">
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
                    🚪 Keluar
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
