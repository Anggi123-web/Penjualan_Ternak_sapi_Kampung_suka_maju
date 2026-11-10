<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand-header" style="padding-bottom: 1.25rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--border-color); text-align: center;">
        <a href="{{ url('/') }}" title="Lihat Beranda" style="display: block; text-decoration: none;">
            <img src="{{ asset('images/sipeter_logo.png') }}" class="app-sidebar-logo" alt="Logo" style="max-height: 46px; width: auto; max-width: 100%; object-fit: contain; margin: 0 auto 0.4rem auto; display: block;">
        </a>
        <div style="display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.72rem; font-weight: 700; color: #8b5cf6; text-transform: uppercase; letter-spacing: 0.06em; background: rgba(139, 92, 246, 0.12); padding: 3px 10px; border-radius: 999px;">
            <i class="bi bi-houses"></i> Pengurus Kampung
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
        @php
            $pendingPeternakCount = \App\Models\User::where('role', 'peternak')->where('status_verifikasi', 'menunggu_verifikasi')->count();
        @endphp
        <a href="{{ route('pengurus_kampung.peternak.index') }}" class="{{ request()->routeIs('pengurus_kampung.peternak.*') ? 'active' : '' }}" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span class="nav-icon"><i class="bi bi-people"></i></span>
                Data Peternak
            </div>
            @if($pendingPeternakCount > 0)
                <span style="background: #f59e0b; color: #0f172a; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 999px;" title="{{ $pendingPeternakCount }} pendaftar peternak menunggu verifikasi">{{ $pendingPeternakCount }} baru</span>
            @endif
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
        <a href="{{ route('iklan.index') }}" class="{{ request()->routeIs('iklan.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-image"></i></span>
            Kelola Iklan
        </a>
    </nav>

    <div class="sidebar-footer">
        <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
            @include('partials.theme_toggle', ['id' => 'pengurusSidebarThemeToggle'])
        </div>
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

