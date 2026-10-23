<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon" style="background: rgba(139,92,246,0.1); color: #c4b5fd;"><i class="bi bi-houses"></i></div>
        <div class="sidebar-logo-text">
            <h2>Pengurus Kampung</h2>
            <span>Sistem Penjualan Sapi</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('pengurus_kampung.dashboard') }}" class="{{ request()->routeIs('pengurus_kampung.dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-bar-chart-line"></i></span>
            Dashboard
        </a>
        <a href="{{ route('pengurus_kampung.katalog.index') }}" class="{{ request()->routeIs('pengurus_kampung.katalog.index') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-piggy-bank"></i></span>
            Katalog Penjualan
        </a>
        <a href="{{ route('pengurus_kampung.katalog.sampah') }}" class="{{ request()->routeIs('pengurus_kampung.katalog.sampah') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-trash3"></i></span>
            Sampah Katalog
        </a>
        <a href="{{ route('pengurus_kampung.peternak.index') }}" class="{{ request()->routeIs('pengurus_kampung.peternak.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-people"></i></span>
            Data Peternak
        </a>
        @php
            $pendingSuratCount = \App\Models\Transaksi::whereIn('status', ['diproses', 'dikirim'])
                ->whereNull('surat_released_at')
                ->count();
        @endphp
        <a href="{{ route('pengurus_kampung.monitoring.index') }}" class="{{ request()->routeIs('pengurus_kampung.monitoring.*') ? 'active' : '' }}" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span class="nav-icon"><i class="bi bi-file-earmark-check"></i></span>
                Surat & Monitoring
            </div>
            @if($pendingSuratCount > 0)
                <span style="background: #f59e0b; color: #0f172a; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 999px;">{{ $pendingSuratCount }}</span>
            @endif
        </a>
        <a href="{{ route('pengurus_kampung.laporan.index') }}" class="{{ request()->routeIs('pengurus_kampung.laporan.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-clipboard-data"></i></span>
            Laporan Triwulan
        </a>
        <a href="{{ route('iklan.index') }}" class="{{ request()->routeIs('iklan.*') && !request()->routeIs('pengurus_kampung.edukasi.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-image"></i></span>
            Kelola Iklan
        </a>
        <a href="{{ route('pengurus_kampung.edukasi.index') }}" class="{{ request()->routeIs('pengurus_kampung.edukasi.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-book"></i></span>
            Edukasi & Info
        </a>
        <a href="#">
            <span class="nav-icon"><i class="bi bi-gear"></i></span>
            Pengaturan
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
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

