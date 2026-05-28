<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon" style="background: rgba(139,92,246,0.1); color: #c4b5fd;">🏘️</div>
        <div class="sidebar-logo-text">
            <h2>Pengurus Kampung</h2>
            <span>Sistem Penjualan Sapi</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('pengurus_kampung.dashboard') }}" class="{{ request()->routeIs('pengurus_kampung.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span>
            Dashboard
        </a>
        <a href="#">
            <span class="nav-icon">👥</span>
            Data Peternak
        </a>
        <a href="#">
            <span class="nav-icon">✅</span>
            Verifikasi
        </a>
        <a href="#">
            <span class="nav-icon">📋</span>
            Laporan Wilayah
        </a>
        <a href="{{ route('iklan.index') }}" class="{{ request()->routeIs('iklan.*') && !request()->routeIs('pengurus_kampung.edukasi.*') ? 'active' : '' }}">
            <span class="nav-icon">🖼️</span>
            Kelola Iklan
        </a>
        <a href="{{ route('pengurus_kampung.edukasi.index') }}" class="{{ request()->routeIs('pengurus_kampung.edukasi.*') ? 'active' : '' }}">
            <span class="nav-icon">📚</span>
            Edukasi & Info
        </a>
        <a href="#">
            <span class="nav-icon">⚙️</span>
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
                🚪 Keluar
            </button>
        </form>
    </div>
</aside>
