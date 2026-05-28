@extends('layouts.app')

@section('title', 'Manajemen Iklan Carousel — Sistem Penjualan Sapi')

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;">🖼️ Kelola Iklan</span>
    <button class="hamburger" onclick="toggleSidebar()">☰</button>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    <aside class="sidebar" id="sidebar">
        <!-- Reusing sidebar layout for the user role -->
        @if(auth()->user()->role === 'peternak')
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;">🐄</div>
                <div class="sidebar-logo-text">
                    <h2>Peternak</h2>
                    <span>Sistem Penjualan Sapi</span>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('peternak.dashboard') }}">
                    <span class="nav-icon">📊</span> Dashboard
                </a>
                <a href="{{ route('peternak.penjualan') }}">
                    <span class="nav-icon">💰</span> Penjualan
                </a>
                <a href="{{ route('peternak.laporan') }}">
                    <span class="nav-icon">📋</span> Laporan
                </a>
                <a href="{{ route('iklan.index') }}" class="active">
                    <span class="nav-icon">🖼️</span> Kelola Iklan
                </a>
                <a href="{{ route('peternak.akun') }}">
                    <span class="nav-icon">👤</span> Akun Saya
                </a>
            </nav>
        @else
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon" style="background: rgba(139,92,246,0.1); color: #c4b5fd;">🏘️</div>
                <div class="sidebar-logo-text">
                    <h2>Pengurus Kampung</h2>
                    <span>Sistem Penjualan Sapi</span>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('pengurus_kampung.dashboard') }}">
                    <span class="nav-icon">📊</span> Dashboard
                </a>
                <a href="{{ route('iklan.index') }}" class="active">
                    <span class="nav-icon">🖼️</span> Kelola Iklan
                </a>
                <a href="#">
                    <span class="nav-icon">⚙️</span> Pengaturan
                </a>
            </nav>
        @endif
        
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
                <button type="submit" class="btn-logout">🚪 Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>Kelola Iklan Carousel</h1>
                <p>Unggah dan kelola gambar iklan yang akan ditampilkan di beranda.</p>
            </div>
            <a href="{{ route('iklan.create') }}" class="btn-logout" style="width: auto; background: var(--peternak); color: white; border: none; padding: 0.75rem 1.5rem;">
                + Unggah Iklan Baru
            </a>
        </div>

        @if(session('success'))
            <div style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #34d399; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif

        <div class="stats-grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
            @forelse($iklans as $iklan)
                <div class="stat-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                    <img src="{{ asset('storage/' . $iklan->gambar) }}" alt="{{ $iklan->judul }}" style="width: 100%; height: 180px; object-fit: cover;">
                    <div style="padding: 1.5rem;">
                        <h4 style="margin-bottom: 0.5rem;">{{ $iklan->judul ?: 'Iklan Tanpa Judul' }}</h4>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                            @php
                                $statusColor = match($iklan->status) {
                                    'pending' => ['bg' => 'rgba(245,158,11,0.1)', 'text' => '#fcd34d', 'label' => 'Menunggu Konfirmasi'],
                                    'aktif' => ['bg' => 'rgba(16,185,129,0.1)', 'text' => '#34d399', 'label' => 'Aktif'],
                                    'ditolak' => ['bg' => 'rgba(239,68,68,0.1)', 'text' => '#f87171', 'label' => 'Ditolak'],
                                    'selesai' => ['bg' => 'rgba(148,163,184,0.1)', 'text' => '#94a3b8', 'label' => 'Selesai/Expired'],
                                    default => ['bg' => 'rgba(245,158,11,0.1)', 'text' => '#fcd34d', 'label' => ucfirst($iklan->status)],
                                };
                            @endphp
                            <span style="font-size: 0.8rem; padding: 0.25rem 0.75rem; border-radius: 50px; background: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }};">
                                {{ $statusColor['label'] }}
                            </span>
                            
                            <div style="display: flex; gap: 0.5rem;">
                                @if($iklan->user_id === auth()->id())
                                    <form action="{{ route('iklan.destroy', $iklan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus iklan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #f87171; padding: 0.4rem 0.75rem; border-radius: 6px; cursor: pointer;">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        @if($iklan->expires_at)
                            <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">
                                Sampai: {{ $iklan->expires_at->format('d M Y, H:i') }}
                            </div>
                        @endif

                        @if(auth()->user()->role === 'pengurus_kampung' && $iklan->status === 'pending')
                            <form action="{{ route('iklan.approve', $iklan->id) }}" method="POST" style="margin-top: 1rem; border-top: 1px solid var(--border-color); padding-top: 1rem;">
                                @csrf
                                @method('PUT')
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="number" name="durasi_hari" placeholder="Hari tayang" required min="1" max="365" style="width: 100px; padding: 0.4rem; background: rgba(0,0,0,0.2); border: 1px solid var(--border-color); color: white; border-radius: 6px; font-size: 0.85rem;">
                                    <button type="submit" style="background: var(--peternak); color: white; border: none; padding: 0.4rem 0.75rem; border-radius: 6px; cursor: pointer; flex: 1; font-size: 0.85rem; font-weight: 600;">Setujui Iklan</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="content-card" style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;">🖼️</div>
                    <h3 style="margin-bottom: 0.5rem;">Belum ada iklan</h3>
                    <p style="color: var(--text-secondary);">Anda belum mengunggah iklan carousel apapun.</p>
                </div>
            @endforelse
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
