@extends('layouts.app')

@section('title', 'Unggah Iklan Carousel — Sistem Penjualan Sapi')

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;">🖼️ Kelola Iklan</span>
    <button class="hamburger" onclick="toggleSidebar()">☰</button>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    <!-- Reusing sidebar logic briefly for create form -->
    <aside class="sidebar" id="sidebar">
        @if(auth()->user()->role === 'peternak')
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;">🐄</div>
                <div class="sidebar-logo-text">
                    <h2>Peternak</h2>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('peternak.dashboard') }}"><span class="nav-icon">📊</span> Dashboard</a>
                <a href="{{ route('iklan.index') }}" class="active"><span class="nav-icon">🖼️</span> Kelola Iklan</a>
            </nav>
        @else
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon" style="background: rgba(139,92,246,0.1); color: #c4b5fd;">🏘️</div>
                <div class="sidebar-logo-text">
                    <h2>Pengurus Kampung</h2>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('pengurus_kampung.dashboard') }}"><span class="nav-icon">📊</span> Dashboard</a>
                <a href="{{ route('iklan.index') }}" class="active"><span class="nav-icon">🖼️</span> Kelola Iklan</a>
            </nav>
        @endif
    </aside>

    <main class="main-content">
        <div class="page-header">
            <a href="{{ route('iklan.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.9rem;">&larr; Kembali</a>
            <h1 style="margin-top: 1rem;">Unggah Iklan Baru</h1>
            <p>Pilih gambar dengan resolusi yang baik untuk ditampilkan di carousel beranda.</p>
        </div>

        <div class="content-card" style="max-width: 600px;">
            <form action="{{ route('iklan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary); font-size: 0.9rem;">Judul Iklan (Opsional)</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" style="width: 100%; padding: 0.75rem; background: rgba(0,0,0,0.2); border: 1px solid var(--border-color); color: white; border-radius: 8px;">
                    @error('judul')
                        <span style="color: #f87171; font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary); font-size: 0.9rem;">Gambar Iklan</label>
                    <input type="file" name="gambar" required accept="image/*" style="width: 100%; padding: 0.75rem; background: rgba(0,0,0,0.2); border: 1px solid var(--border-color); color: white; border-radius: 8px;">
                    <small style="color: var(--text-secondary); display: block; margin-top: 0.5rem;">Format JPG/PNG, Maksimal 10MB. Disarankan ukuran proporsional <strong>1638 x 500 pixel</strong> (landscape).</small>
                    @error('gambar')
                        <span style="color: #f87171; font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" style="width: 100%; background: var(--peternak); color: white; border: none; padding: 1rem; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Unggah Iklan
                </button>
            </form>
        </div>
    </main>
</div>
@endsection
