@extends('layouts.frontend')

@section('title', 'Tentang Kami — Sistem Penjualan Sapi')

@section('content')
    {{-- ═══ About Us Section ═══ --}}
    <section class="about-section" id="about-us" style="padding-top: 140px;">
        <div class="about-container">
            <div class="about-content">
                <span class="section-tag" style="display: inline-block;">Tentang Kami</span>
                <h2 class="about-title">SIPETER: Menghubungkan Peternak Lokal dan Pembeli</h2>
                <p class="about-text">
                    SIPETER (Sistem Penjualan Ternak Sapi) adalah platform digital modern yang dirancang untuk mendukung ekosistem peternak sapi lokal Indonesia. Kami mempermudah transaksi jual-beli sapi secara transparan, aman, dan didukung oleh jaminan kelayakan dari Mantri Hewan bersertifikasi.
                </p>
                
                <div class="about-features">
                    <div class="about-feature-item">
                        <div class="about-feature-icon">🛡️</div>
                        <h4 class="about-feature-title">Terverifikasi Sehat</h4>
                        <p class="about-feature-desc">Setiap sapi yang berlabel Layak Budidaya telah melalui pengecekan kesehatan langsung oleh Mantri Hewan.</p>
                    </div>
                    <div class="about-feature-item">
                        <div class="about-feature-icon">🤝</div>
                        <h4 class="about-feature-title">Hubungan Langsung</h4>
                        <p class="about-feature-desc">Membeli langsung dari peternak lokal terbaik, membantu meningkatkan perekonomian daerah.</p>
                    </div>
                    <div class="about-feature-item">
                        <div class="about-feature-icon">📈</div>
                        <h4 class="about-feature-title">Harga Transparan</h4>
                        <p class="about-feature-desc">Informasi bobot, umur, dan harga tercantum dengan jelas tanpa biaya tersembunyi.</p>
                    </div>
                    <div class="about-feature-item">
                        <div class="about-feature-icon">✨</div>
                        <h4 class="about-feature-title">Kemudahan Transaksi</h4>
                        <p class="about-feature-desc">Platform digital yang memudahkan pemantauan dan pencarian hewan ternak terbaik Anda.</p>
                    </div>
                </div>
            </div>

            <div class="about-image-wrapper">
                <img src="{{ asset('images/cows_hero_bg.png') }}" alt="SIPETER Cattle Farm">
            </div>
        </div>
    </section>
@endsection
