<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand-header" style="padding-bottom: 1.25rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--border-color); text-align: center;">
        <a href="{{ url('/') }}" title="Lihat Beranda" style="display: block; text-decoration: none;">
            <img src="{{ asset('images/sipeter_logo.png') }}" class="app-sidebar-logo" alt="Logo" style="max-height: 46px; width: auto; max-width: 100%; object-fit: contain; margin: 0 auto 0.4rem auto; display: block;">
        </a>
        <div style="display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.72rem; font-weight: 700; color: #10b981; text-transform: uppercase; letter-spacing: 0.06em; background: rgba(16, 185, 129, 0.12); padding: 3px 10px; border-radius: 999px;">
            <i class="bi bi-piggy-bank"></i> Panel Peternak
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
        <a href="{{ route('peternak.ulasan') }}" class="{{ request()->routeIs('peternak.ulasan*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-star"></i></span>
            Ulasan Pembeli
        </a>
        <a href="{{ route('peternak.sapi.sampah') }}" class="{{ request()->routeIs('peternak.sapi.sampah') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-trash3"></i></span>
            Sampah
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
        <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
            @include('partials.theme_toggle', ['id' => 'peternakSidebarThemeToggle'])
        </div>
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
