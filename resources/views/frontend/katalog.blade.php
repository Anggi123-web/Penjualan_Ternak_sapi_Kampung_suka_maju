@extends('layouts.frontend')

@section('title', 'Katalog Sapi — Sistem Penjualan Sapi')

@section('content')
    {{-- ═══ Styles Kustom Halaman Katalog & Marketing Elements ═══ --}}
    <style>
        .catalog-page-wrapper {
            padding-top: 130px;
            padding-bottom: 5rem;
            background-color: #fafbfc;
        }

        .catalog-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Header Katalog */
        .catalog-hero-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .catalog-hero-header .catalog-tag {
            font-family: var(--font-montserrat);
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--green-brand);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            display: inline-block;
            margin-bottom: 0.4rem;
            background: rgba(16, 185, 129, 0.1);
            padding: 0.35rem 1rem;
            border-radius: 999px;
        }

        .catalog-hero-header h1 {
            font-family: var(--font-montserrat);
            font-size: 2.35rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin: 0 0 0.6rem 0;
        }

        .catalog-hero-header p {
            font-family: var(--font-inter);
            font-size: 1rem;
            color: #64748b;
            max-width: 620px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Trust Bar */
        .catalog-trust-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            background: #ffffff;
            padding: 1.25rem 1.75rem;
            border-radius: 16px;
            border: 1px solid #eef2f6;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            margin-bottom: 2rem;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .trust-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }

        .trust-item h4 {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 700;
            color: #1e293b;
        }

        .trust-item p {
            margin: 0.15rem 0 0;
            font-size: 0.78rem;
            color: #64748b;
        }

        /* Banner Carousel Promo */
        .catalog-banner-section {
            margin-bottom: 2.25rem;
        }

        /* Quick Category Pills */
        .quick-categories-bar {
            margin-bottom: 1.75rem;
        }

        .category-pills-scroll {
            display: flex;
            gap: 0.75rem;
            overflow-x: auto;
            padding-bottom: 0.75rem;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .category-pills-scroll::-webkit-scrollbar {
            display: none;
        }

        .category-pill-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.65rem 1.15rem;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            text-decoration: none;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.88rem;
            white-space: nowrap;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .category-pill-item:hover {
            transform: translateY(-2px);
            border-color: #10b981;
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.12);
            color: #059669;
        }

        .category-pill-item.active {
            background: #ecfdf5;
            border-color: #10b981;
            color: #059669;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
        }

        .category-pill-item .category-icon {
            font-size: 1.15rem;
            line-height: 1;
        }

        /* Detailed Filter Card */
        .catalog-filter-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            border: 1px solid #eef2f6;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            margin-bottom: 2rem;
        }

        .catalog-filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 1.25rem;
            align-items: flex-end;
        }

        .catalog-filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }

        .catalog-filter-label {
            font-family: var(--font-montserrat);
            font-size: 0.8rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .catalog-filter-input {
            width: 100%;
            height: 44px;
            padding: 0 0.9rem;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-family: var(--font-inter);
            font-size: 0.9rem;
            color: #1e293b;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .catalog-filter-input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
        }

        .catalog-filter-actions {
            display: flex;
            gap: 0.75rem;
        }

        .catalog-btn-apply {
            flex: 1;
            height: 44px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-family: var(--font-montserrat);
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
        }

        .catalog-btn-apply:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }

        .catalog-btn-reset {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 44px;
            padding: 0 1.25rem;
            background: #f8fafc;
            color: #64748b;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-family: var(--font-montserrat);
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .catalog-btn-reset:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        /* Results Counter & Chips */
        .catalog-results-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .catalog-results-count {
            font-family: var(--font-inter);
            font-size: 0.95rem;
            color: #64748b;
        }

        .catalog-results-count strong {
            color: #0f172a;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .catalog-trust-bar {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .catalog-page-wrapper {
                padding-top: 110px;
            }
            .catalog-trust-bar {
                grid-template-columns: 1fr;
            }
            .catalog-hero-header h1 {
                font-size: 1.85rem;
            }
        }
    </style>

    <div class="catalog-page-wrapper">
        <div class="catalog-container">

            {{-- ═══ Catalog Hero Header ═══ --}}
            <div class="catalog-hero-header">
                <span class="catalog-tag">Pilihan Ternak Terbaik</span>
                <h1>Katalog Sapi Digital</h1>
                <p>Jelajahi sapi unggul siap kirim maupun pre-order dengan jaminan sehat tersertifikasi mantri hewan langsung dari peternak Kampung Sukamaju.</p>
            </div>

            {{-- ═══ Marketplace Trust & Value Proposition Bar ═══ --}}
            <div class="catalog-trust-bar">
                <div class="trust-item">
                    <div class="trust-icon" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h4>100% Tersertifikasi</h4>
                        <p>Uji kesehatan Mantri Hewan</p>
                    </div>
                </div>

                <div class="trust-item">
                    <div class="trust-icon" style="background: rgba(59, 130, 246, 0.1); color: #2563eb;">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div>
                        <h4>Langsung dari Peternak</h4>
                        <p>Tanpa calo, harga kandang</p>
                    </div>
                </div>

                <div class="trust-item">
                    <div class="trust-icon" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <h4>Garansi Pengantaran</h4>
                        <p>Sapi selamat sampai alamat</p>
                    </div>
                </div>

                <div class="trust-item">
                    <div class="trust-icon" style="background: rgba(139, 92, 246, 0.1); color: #7c3aed;">
                        <i class="bi bi-credit-card-2-front-fill"></i>
                    </div>
                    <div>
                        <h4>Transaksi Aman & DP</h4>
                        <p>Tersedia skema Pre-Order DP</p>
                    </div>
                </div>
            </div>

            {{-- ═══ Banner Promo / Iklan Carousel (Marketing Element) ═══ --}}
            @if(isset($iklans) && $iklans->count() > 0)
            <div class="catalog-banner-section">
                <div class="carousel-container" style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.06);">
                    <div class="carousel-track" id="carouselTrack">
                        @foreach($iklans as $iklan)
                        <div class="carousel-slide">
                            <img src="{{ asset('storage/' . $iklan->gambar) }}" alt="Banner Promo" style="width: 100%; aspect-ratio: 1638 / 500; object-fit: cover; border-radius: 20px; display: block;">
                        </div>
                        @endforeach
                    </div>

                    @if($iklans->count() > 1)
                        <button type="button" class="carousel-btn prev" onclick="moveSlide(-1)" aria-label="Sebelumnya">&#10094;</button>
                        <button type="button" class="carousel-btn next" onclick="moveSlide(1)" aria-label="Selanjutnya">&#10095;</button>

                        <div class="carousel-dots">
                            @foreach($iklans as $index => $iklan)
                                <span class="dot {{ $index === 0 ? 'active' : '' }}" onclick="currentSlide({{ $index }})"></span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- ═══ Quick Category Pills (Marketing & Easy Navigation) ═══ --}}
            <div class="quick-categories-bar">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.85rem;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">
                        Kategori Cepat:
                    </span>
                    @if(request('jenis') || request('tipe_penjualan') || request('sertifikasi') || request('harga_min') || request('harga_max') || request('search'))
                        <a href="{{ route('katalog.index') }}" style="font-size: 0.82rem; font-weight: 700; color: #ef4444; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                            <i class="bi bi-x-circle-fill"></i> Bersihkan Semua Filter
                        </a>
                    @endif
                </div>

                <div class="category-pills-scroll">
                    {{-- Semua Sapi --}}
                    <a href="{{ route('katalog.index') }}" class="category-pill-item {{ (!request('jenis') && !request('tipe_penjualan') && !request('sertifikasi')) ? 'active' : '' }}">
                        <i class="bi bi-grid-fill category-icon"></i>
                        <span>Semua Sapi</span>
                    </a>

                    {{-- Pre-Order Pill --}}
                    <a href="{{ route('katalog.index', ['tipe_penjualan' => 'pre_order']) }}" class="category-pill-item {{ request('tipe_penjualan') === 'pre_order' ? 'active' : '' }}" style="{{ request('tipe_penjualan') === 'pre_order' ? 'background: #fef2f2; border-color: #ef4444; color: #dc2626;' : 'border-color: rgba(239, 68, 68, 0.3); background: #fff5f5;' }}">
                        <i class="bi bi-hourglass-split category-icon" style="color: #dc2626;"></i>
                        <span style="color: #dc2626;">Sapi Pre-Order</span>
                    </a>

                    {{-- Ready Stock / Pesan Biasa Pill --}}
                    <a href="{{ route('katalog.index', ['tipe_penjualan' => 'order']) }}" class="category-pill-item {{ request('tipe_penjualan') === 'order' ? 'active' : '' }}" style="{{ request('tipe_penjualan') === 'order' ? 'background: #f0fdf4; border-color: #10b981; color: #059669;' : 'border-color: rgba(16, 185, 129, 0.3); background: #f0fdf4;' }}">
                        <i class="bi bi-lightning-charge-fill category-icon" style="color: #059669;"></i>
                        <span style="color: #059669;">Siap Kirim</span>
                    </a>

                    {{-- Sapi Tersertifikasi --}}
                    <a href="{{ route('katalog.index', ['sertifikasi' => 'tersertifikasi']) }}" class="category-pill-item {{ request('sertifikasi') === 'tersertifikasi' ? 'active' : '' }}">
                        <i class="bi bi-patch-check-fill category-icon"></i>
                        <span>Layak Budidaya</span>
                    </a>

                    {{-- Ras Sapi --}}
                    <a href="{{ route('katalog.index', ['jenis' => 'Limosin']) }}" class="category-pill-item {{ request('jenis') === 'Limosin' ? 'active' : '' }}">
                        <i class="bi bi-tag-fill category-icon"></i>
                        <span>Limosin</span>
                    </a>
                    <a href="{{ route('katalog.index', ['jenis' => 'Simental']) }}" class="category-pill-item {{ request('jenis') === 'Simental' ? 'active' : '' }}">
                        <i class="bi bi-tag-fill category-icon"></i>
                        <span>Simental</span>
                    </a>
                    <a href="{{ route('katalog.index', ['jenis' => 'Brahman']) }}" class="category-pill-item {{ request('jenis') === 'Brahman' ? 'active' : '' }}">
                        <i class="bi bi-tag-fill category-icon"></i>
                        <span>Brahman</span>
                    </a>
                    <a href="{{ route('katalog.index', ['jenis' => 'Bali']) }}" class="category-pill-item {{ request('jenis') === 'Bali' ? 'active' : '' }}">
                        <i class="bi bi-tag-fill category-icon"></i>
                        <span>Bali</span>
                    </a>
                    <a href="{{ route('katalog.index', ['jenis' => 'PO']) }}" class="category-pill-item {{ request('jenis') === 'PO' ? 'active' : '' }}">
                        <i class="bi bi-tags-fill category-icon"></i>
                        <span>PO (Peranakan Ongole)</span>
                    </a>
                </div>
            </div>

            {{-- ═══ Detailed Filter Card Form ═══ --}}
            <div class="catalog-filter-card">
                <form class="catalog-filter-form" method="GET" action="{{ route('katalog.index') }}">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="catalog-filter-group">
                        <label class="catalog-filter-label">Jenis Sapi</label>
                        <select name="jenis" class="catalog-filter-input">
                            <option value="">Semua Jenis</option>
                            @foreach ($jenisList as $jenis)
                                <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="catalog-filter-group">
                        <label class="catalog-filter-label">Harga Minimal (Rp)</label>
                        <input type="number" name="harga_min" class="catalog-filter-input" placeholder="Min: 10.000.000" value="{{ request('harga_min') }}">
                    </div>

                    <div class="catalog-filter-group">
                        <label class="catalog-filter-label">Harga Maksimal (Rp)</label>
                        <input type="number" name="harga_max" class="catalog-filter-input" placeholder="Maks: 50.000.000" value="{{ request('harga_max') }}">
                    </div>

                    <div class="catalog-filter-group">
                        <label class="catalog-filter-label">Sertifikasi Kesehatan</label>
                        <select name="sertifikasi" class="catalog-filter-input">
                            <option value="">Semua Status</option>
                            <option value="tersertifikasi" {{ request('sertifikasi') === 'tersertifikasi' ? 'selected' : '' }}>Layak Budidaya (Sehat)</option>
                        </select>
                    </div>

                    <div class="catalog-filter-group">
                        <label class="catalog-filter-label">Tipe Pemesanan</label>
                        <select name="tipe_penjualan" class="catalog-filter-input">
                            <option value="">Semua Tipe</option>
                            <option value="order" {{ request('tipe_penjualan') === 'order' ? 'selected' : '' }}>Pesan Biasa (Siap Kirim)</option>
                            <option value="pre_order" {{ request('tipe_penjualan') === 'pre_order' ? 'selected' : '' }}>Pre-Order</option>
                        </select>
                    </div>

                    <div class="catalog-filter-group">
                        <div class="catalog-filter-actions">
                            <button type="submit" class="catalog-btn-apply">Terapkan</button>
                            <a href="{{ route('katalog.index') }}" class="catalog-btn-reset" title="Reset Filter">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ═══ Results Counter & Status Summary ═══ --}}
            <div class="catalog-results-bar">
                <div class="catalog-results-count">
                    Menampilkan: <strong>{{ $sapis->count() }}</strong> ekor sapi
                    @if(request('search'))
                        untuk pencarian "<strong>{{ request('search') }}</strong>"
                    @endif
                    @if(request('jenis'))
                        &bull; Jenis: <strong>{{ request('jenis') }}</strong>
                    @endif
                    @if(request('tipe_penjualan'))
                        &bull; Tipe: <strong>{{ request('tipe_penjualan') === 'pre_order' ? 'Pre-Order' : 'Siap Kirim' }}</strong>
                    @endif
                    @if(request('sertifikasi') === 'tersertifikasi')
                        &bull; <strong>Tersertifikasi Sehat</strong>
                    @endif
                </div>

                <div style="font-size: 0.85rem; color: #64748b;">
                    Total Tersertifikasi Mantri: <strong style="color: #059669;">{{ $totalTersertifikasi }}</strong> ekor
                </div>
            </div>

            {{-- ═══ Modern Cattle Grid (.sapi-cards-grid & .sapi-card-new) ═══ --}}
            @if($sapis->count() > 0)
                <div class="sapi-cards-grid">
                    @foreach ($sapis as $sapi)
                        <div class="sapi-card-new" id="katalog-sapi-{{ $sapi->id }}">
                            {{-- Badge Order / Pre-Order --}}
                            <span class="sapi-card-new-badge {{ $sapi->is_preorder ? 'preorder' : 'order' }}">
                                {{ $sapi->tipe_penjualan_label }}
                            </span>

                            {{-- Badge Sertifikasi Kesehatan (Marketing Trust Signal) --}}
                            @if($sapi->status_kesehatan === 'sehat')
                                <div style="position: absolute; top: 12px; right: 12px; z-index: 5; background: rgba(255, 255, 255, 0.95); color: #16a34a; padding: 3px 8px; border-radius: 6px; font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; gap: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                    <i class="bi bi-check-circle-fill"></i> <span>Layak</span>
                                </div>
                            @endif

                            {{-- Foto Sapi --}}
                            <a href="{{ route('katalog.show', $sapi->id) }}" style="text-decoration: none;">
                                <div class="sapi-card-new-img">
                                    @if($sapi->first_foto)
                                        <img src="{{ asset('storage/' . $sapi->first_foto) }}" alt="{{ $sapi->jenis }}" loading="lazy">
                                    @else
                                        <div class="sapi-card-placeholder-icon"><i class="bi bi-image" style="font-size: 3.5rem; color: #a5d6a7;"></i></div>
                                    @endif

                                    {{-- Pre-Order Label Overlay --}}
                                    @if($sapi->is_preorder && $sapi->preorder_bulan)
                                        <div class="sapi-card-new-preorder-label">{{ $sapi->preorder_label }}</div>
                                    @endif
                                </div>
                            </a>

                            {{-- Info Sapi --}}
                            <div class="sapi-card-new-body">
                                <div class="sapi-card-new-title-row">
                                    <a href="{{ route('katalog.show', $sapi->id) }}" style="text-decoration: none; color: inherit;">
                                        <h3 style="transition: color 0.2s;">{{ $sapi->jenis }}</h3>
                                    </a>
                                    <span class="sapi-card-new-price">{{ $sapi->harga_formatted }}</span>
                                </div>
                                <div class="sapi-card-new-specs">
                                    <span>Umur : {{ $sapi->umur_formatted }}</span>
                                    <span>Bobot : ± {{ number_format($sapi->bobot, 0, ',', '.') }} kg</span>
                                    <span style="color: #64748b; font-size: 0.78rem; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                                        <i class="bi bi-geo-alt-fill" style="color: #ef4444; font-size: 0.82rem;"></i> {{ $sapi->lokasi ?? 'Kampung Sukamaju' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Footer Aksi Konversi --}}
                            <div class="sapi-card-new-footer">
                                <div class="sapi-card-new-peternak" style="display: flex; align-items: center; gap: 4px;">
                                    by <a href="#">{{ $sapi->peternak->name ?? 'Peternak' }}</a>
                                    <i class="bi bi-patch-check-fill" style="color: #10b981; font-size: 0.85rem;" title="Peternak Terverifikasi"></i>
                                </div>
                                <div class="sapi-card-new-actions">
                                    <a href="{{ route('katalog.show', $sapi->id) }}" class="btn-beli-sekarang" style="display: inline-flex; align-items: center; justify-content: center; gap: 5px; {{ $sapi->is_preorder ? 'background: linear-gradient(135deg, #ef4444, #dc2626);' : '' }}">
                                        <i class="bi bi-eye"></i> Lihat Detail
                                    </a>
                                    @if(!auth()->check())
                                        <a href="{{ route('login') }}" class="btn-keranjang-icon" title="Tambah ke Keranjang" onclick="alert('Silakan login terlebih dahulu untuk menambahkan ternak ke keranjang belanja.');">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                        </a>
                                    @elseif(auth()->user()->role === 'pembeli')
                                        <form action="{{ route('pembeli.keranjang.store') }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <input type="hidden" name="sapi_id" value="{{ $sapi->id }}">
                                            <button type="submit" class="btn-keranjang-icon" title="Tambah ke Keranjang">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div style="text-align: center; padding: 4rem 2rem; background: var(--bg-card, #ffffff); border-radius: 16px; border: 1px dashed var(--border-color, #cbd5e1); margin-top: 1.5rem;">
                    <i class="bi bi-search" style="font-size: 3rem; color: var(--text-muted, #94a3b8); display: block; margin-bottom: 0.75rem;"></i>
                    <h3 style="font-size: 1.35rem; font-weight: 700; color: var(--text-heading, #1e293b); margin-bottom: 0.5rem;">Tidak Ada Sapi Ditemukan</h3>
                    <p style="color: var(--text-secondary, #64748b); font-size: 0.95rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                        Maaf, kami tidak menemukan sapi yang sesuai dengan kata kunci atau pengaturan filter Anda. Silakan reset filter untuk melihat semua sapi yang tersedia.
                    </p>
                    <a href="{{ route('katalog.index') }}" class="catalog-btn-apply" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none; padding: 0.75rem 2rem; height: auto;">
                        Reset Semua Filter
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection
