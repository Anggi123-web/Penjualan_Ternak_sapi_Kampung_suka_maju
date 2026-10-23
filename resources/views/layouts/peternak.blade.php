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
    <span style="font-weight: 700;"><i class="bi bi-piggy-bank"></i> Peternak</span>
    <button class="hamburger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;"><i class="bi bi-piggy-bank"></i></div>
            <div class="sidebar-logo-text">
                <h2>Peternak</h2>
                <span>Sistem Penjualan Sapi</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('peternak.dashboard') }}" class="{{ request()->routeIs('peternak.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-bar-chart-line"></i></span>
                Dashboard
            </a>
            <a href="{{ route('peternak.penjualan') }}" class="{{ request()->routeIs('peternak.penjualan') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-currency-dollar"></i></span>
                Penjualan
            </a>
            @php
                $pesananMasukCount = 0;
                if (auth()->check()) {
                    $sapiIdsPeternak = \App\Models\Sapi::withTrashed()->where('user_id', auth()->id())->pluck('id');
                    $pesananMasukCount = \App\Models\Transaksi::whereIn('sapi_id', $sapiIdsPeternak)
                        ->where('status', 'menunggu_verifikasi')
                        ->count();
                }
            @endphp
            <a href="{{ route('peternak.pesanan') }}" class="{{ request()->routeIs('peternak.pesanan') ? 'active' : '' }}" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span class="nav-icon"><i class="bi bi-box-seam"></i></span>
                    Pesanan Masuk
                </div>
                @if($pesananMasukCount > 0)
                    <span style="background: #3b82f6; color: white; font-size: 11px; font-weight: bold; padding: 2px 7px; border-radius: 999px;">{{ $pesananMasukCount }}</span>
                @endif
            </a>
            @php
                $unreadChatPeternak = \App\Models\Chat::where('penerima_id', auth()->id())->where('is_read', false)->count();
            @endphp
            <a href="javascript:void(0)" onclick="toggleChatWindow()" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span class="nav-icon"><i class="bi bi-chat-dots"></i></span>
                    Chat Pembeli
                </div>
                <span class="nav-chat-badge" style="background: #10b981; color: white; font-size: 11px; font-weight: bold; padding: 2px 7px; border-radius: 999px; display: {{ $unreadChatPeternak > 0 ? 'inline-block' : 'none' }};">{{ $unreadChatPeternak }}</span>
            </a>
            <a href="{{ route('peternak.ulasan') }}" class="{{ request()->routeIs('peternak.ulasan*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-star"></i></span>
                Ulasan Pembeli
            </a>
            <a href="{{ route('peternak.sapi.sampah') }}" class="{{ request()->routeIs('peternak.sapi.sampah') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-trash3"></i></span>
                Sampah
            </a>
            <a href="{{ route('peternak.laporan') }}" class="{{ request()->routeIs('peternak.laporan') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-clipboard-data"></i></span>
                Laporan
            </a>
            <a href="{{ route('iklan.index') }}" class="{{ request()->routeIs('iklan.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-image"></i></span>
                Kelola Iklan
            </a>
            <a href="{{ route('peternak.akun') }}" class="{{ request()->routeIs('peternak.akun') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-person-circle"></i></span>
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
@include('partials.chat_box')
@endsection

