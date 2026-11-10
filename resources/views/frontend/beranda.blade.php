@extends('layouts.frontend')

@section('title', 'Beranda — Sistem Penjualan Sapi')

@section('content')
    {{-- ═══ Hero Static Section ═══ --}}
    <section class="hero-static-section" id="home">
        <div class="hero-static-inner">
            <div class="hero-static-image">
                <img src="{{ file_exists(public_path('storage/iklan/foto/sapihero.png')) ? asset('storage/iklan/foto/sapihero.png') : asset('images/sapihero.png') }}"
                     onerror="this.onerror=null; this.src='{{ asset('images/sapihero.png') }}';"
                     alt="Sapi Hero">
            </div>
            <div class="hero-static-content">
                <h1 class="hero-static-title">
                    Dari Peternak<br>
                    Untuk Kebutuhan<br>
                    <span>Terbaik</span> Anda.
                </h1>
                <p class="hero-static-subtitle">
                    Nikmati kemudahan bertransaksi sapi pilihan yang dirawat dengan sepenuh hati oleh peternak lokal terbaik.
                </p>
            </div>
        </div>
    </section>

    {{-- ═══ Marketplace Trust & Value Proposition Bar ═══ --}}
    <section class="trust-bar-section" style="padding: 1.5rem 2rem 0; background-color: var(--bg-body, #fafbfc);">
        <div style="max-width: 1400px; margin: 0 auto;">
            <div class="trust-bar-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; background: var(--bg-card, #ffffff); padding: 1.25rem 1.75rem; border-radius: 16px; border: 1px solid var(--border-color, #eef2f6); box-shadow: var(--card-shadow, 0 4px 20px rgba(0,0,0,0.03));">
                <div style="display: flex; align-items: center; gap: 0.85rem;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); color: #059669; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; flex-shrink: 0;">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 0.9rem; font-weight: 700; color: var(--text-heading, #1e293b);">100% Tersertifikasi</h4>
                        <p style="margin: 0.15rem 0 0; font-size: 0.78rem; color: var(--text-secondary, #64748b);">Uji kesehatan Mantri Hewan</p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 0.85rem;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(59, 130, 246, 0.12); color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; flex-shrink: 0;">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 0.9rem; font-weight: 700; color: var(--text-heading, #1e293b);">Langsung dari Peternak</h4>
                        <p style="margin: 0.15rem 0 0; font-size: 0.78rem; color: var(--text-secondary, #64748b);">Tanpa calo, harga kandang</p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 0.85rem;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(245, 158, 11, 0.12); color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; flex-shrink: 0;">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 0.9rem; font-weight: 700; color: var(--text-heading, #1e293b);">Garansi Pengantaran</h4>
                        <p style="margin: 0.15rem 0 0; font-size: 0.78rem; color: var(--text-secondary, #64748b);">Sapi selamat sampai alamat</p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 0.85rem;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(139, 92, 246, 0.12); color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; flex-shrink: 0;">
                        <i class="bi bi-credit-card-2-front-fill"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 0.9rem; font-weight: 700; color: var(--text-heading, #1e293b);">Transaksi Aman & DP</h4>
                        <p style="margin: 0.15rem 0 0; font-size: 0.78rem; color: var(--text-secondary, #64748b);">Tersedia skema Pre-Order DP</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ Quick Category Bar ═══ --}}
    <section class="quick-categories-section" style="padding: 2rem 2rem 0.5rem; background-color: var(--bg-body, #fafbfc);">
        <div style="max-width: 1400px; margin: 0 auto;">
            <style>
                .category-pill-item {
                    display: flex;
                    align-items: center;
                    gap: 0.6rem;
                    padding: 0.65rem 1.15rem;
                    background: var(--bg-card, #ffffff);
                    border: 1px solid var(--border-color, #e2e8f0);
                    border-radius: 999px;
                    text-decoration: none;
                    color: var(--text-heading, #1e293b);
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
                .category-pill-item .category-icon {
                    font-size: 1.2rem;
                    line-height: 1;
                }
                @media (max-width: 992px) {
                    .trust-bar-grid {
                        grid-template-columns: repeat(2, 1fr) !important;
                    }
                }
                @media (max-width: 576px) {
                    .trust-bar-grid {
                        grid-template-columns: 1fr !important;
                    }
                }
            </style>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <div>
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: var(--text-heading, #1e293b);">Pilihan Kategori Ternak</h3>
                    <p style="margin: 0.2rem 0 0; font-size: 0.85rem; color: var(--text-secondary, #64748b);">Jelajahi sapi pilihan berdasarkan jenis ras dan tipe pemesanan</p>
                </div>
                <a href="{{ route('katalog.index') }}" style="font-size: 0.82rem; font-weight: 700; color: var(--green-brand, #059669); text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div style="display: flex; gap: 0.75rem; overflow-x: auto; padding-bottom: 0.75rem; scrollbar-width: none;">
                <a href="{{ route('katalog.index', ['jenis' => 'Limosin']) }}" class="category-pill-item">
                    <i class="bi bi-tag-fill category-icon"></i>
                    <span>Sapi Limosin</span>
                </a>
                <a href="{{ route('katalog.index', ['jenis' => 'Simental']) }}" class="category-pill-item">
                    <i class="bi bi-tag-fill category-icon"></i>
                    <span>Sapi Simental</span>
                </a>
                <a href="{{ route('katalog.index', ['jenis' => 'Brahman']) }}" class="category-pill-item">
                    <i class="bi bi-tag-fill category-icon"></i>
                    <span>Sapi Brahman</span>
                </a>
                <a href="{{ route('katalog.index', ['jenis' => 'Bali']) }}" class="category-pill-item">
                    <i class="bi bi-tag-fill category-icon"></i>
                    <span>Sapi Bali</span>
                </a>
                <a href="{{ route('katalog.index', ['jenis' => 'PO']) }}" class="category-pill-item">
                    <i class="bi bi-tags-fill category-icon"></i>
                    <span>Sapi PO</span>
                </a>
                <a href="{{ route('katalog.index', ['tipe_penjualan' => 'pre_order']) }}" class="category-pill-item" style="border-color: rgba(239, 68, 68, 0.3); background: #fff5f5;">
                    <i class="bi bi-hourglass-split category-icon" style="color: #dc2626;"></i>
                    <span style="color: #dc2626;">Sapi Pre-Order</span>
                </a>
                <a href="{{ route('katalog.index', ['tipe_penjualan' => 'order']) }}" class="category-pill-item" style="border-color: rgba(16, 185, 129, 0.3); background: #f0fdf4;">
                    <i class="bi bi-lightning-charge-fill category-icon" style="color: #059669;"></i>
                    <span style="color: #059669;">Siap Kirim</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ═══ Update Sapi Terbaru Section ═══ --}}
    @if($sapis->count() > 0)
    <section class="sapi-update-section">
        <div class="sapi-update-inner">
            <div class="sapi-update-header">
                <div class="sapi-update-header-left">
                    <h2>Update Sapi Terbaru</h2>
                    <p>Lihat sapi-sapi terbaru yang diunggah dalam 1 minggu terakhir.</p>
                </div>
                <a href="{{ route('katalog.index') }}" class="btn-selengkapnya">Selengkapnya</a>
            </div>

            <div class="sapi-cards-grid">
                @foreach($sapis as $sapi)
                <div class="sapi-card-new">
                    {{-- Badge Order/Pre-Order --}}
                    <span class="sapi-card-new-badge {{ $sapi->is_preorder ? 'preorder' : 'order' }}">
                        {{ $sapi->tipe_penjualan_label }}
                    </span>

                    {{-- Badge Sertifikasi Kesehatan --}}
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
                                <div class="sapi-card-placeholder-icon"><i class="bi bi-image" style="font-size: 3rem; color: #a5d6a7;"></i></div>
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

                    {{-- Footer --}}
                    <div class="sapi-card-new-footer">
                        <div class="sapi-card-new-peternak" style="display: flex; align-items: center; gap: 4px;">
                            by <a href="#">{{ $sapi->peternak->name ?? 'Peternak' }}</a>
                            <i class="bi bi-patch-check-fill" style="color: #10b981; font-size: 0.85rem;" title="Peternak Terverifikasi"></i>
                        </div>
                        <div class="sapi-card-new-actions">
                            <a href="{{ route('katalog.show', $sapi->id) }}" class="btn-beli-sekarang" style="display: inline-flex; align-items: center; justify-content: center; gap: 5px;">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            @if(!auth()->check())
                                <a href="{{ route('login') }}" class="btn-keranjang-icon" title="Keranjang" onclick="alert('Silakan login terlebih dahulu untuk menambahkan ternak ke keranjang belanja.');">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                </a>
                            @elseif(auth()->user()->role === 'pembeli')
                                <form action="{{ route('pembeli.keranjang.store') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="sapi_id" value="{{ $sapi->id }}">
                                    <button type="submit" class="btn-keranjang-icon" title="Keranjang">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif


    {{-- ═══ Katalog Sapi Pre-Order Section ═══ --}}
    <section class="sapi-update-section" id="katalog-preorder" style="padding-top: 3rem; background-color: #fafbfc; border-top: 1px solid #f1f5f9;">
        <div class="sapi-update-inner">
            <div class="sapi-update-header">
                <div class="sapi-update-header-left">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                        <span style="display: inline-flex; align-items: center; gap: 0.35rem; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;">
                            <i class="bi bi-hourglass-split"></i> Pre-Order
                        </span>
                    </div>
                    <h2>Katalog Sapi Pre-Order</h2>
                    <p>Pesan sapi lebih awal untuk kebutuhan qurban, aqiqah, atau hajatan mendatang langsung dari peternak terpercaya.</p>
                </div>
                <a href="{{ route('katalog.index', ['tipe_penjualan' => 'pre_order']) }}" class="btn-selengkapnya">Selengkapnya</a>
            </div>

            @if($sapiPreorder->count() > 0)
            <div class="sapi-cards-grid">
                @foreach($sapiPreorder as $sapi)
                <div class="sapi-card-new">
                    {{-- Badge Pre-Order --}}
                    <span class="sapi-card-new-badge preorder">
                        {{ $sapi->tipe_penjualan_label }}
                    </span>

                    {{-- Badge Sertifikasi Kesehatan --}}
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
                                <div class="sapi-card-placeholder-icon"><i class="bi bi-image" style="font-size: 3rem; color: #a5d6a7;"></i></div>
                            @endif

                            {{-- Pre-Order Label Overlay --}}
                            @if($sapi->preorder_bulan)
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

                    {{-- Footer --}}
                    <div class="sapi-card-new-footer">
                        <div class="sapi-card-new-peternak" style="display: flex; align-items: center; gap: 4px;">
                            by <a href="#">{{ $sapi->peternak->name ?? 'Peternak' }}</a>
                            <i class="bi bi-patch-check-fill" style="color: #10b981; font-size: 0.85rem;" title="Peternak Terverifikasi"></i>
                        </div>
                        <div class="sapi-card-new-actions">
                            <a href="{{ route('katalog.show', $sapi->id) }}" class="btn-beli-sekarang" style="display: inline-flex; align-items: center; justify-content: center; gap: 5px; background: linear-gradient(135deg, #ef4444, #dc2626);">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            @if(!auth()->check())
                                <a href="{{ route('login') }}" class="btn-keranjang-icon" title="Keranjang" onclick="alert('Silakan login terlebih dahulu untuk menambahkan ternak ke keranjang belanja.');">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                </a>
                            @elseif(auth()->user()->role === 'pembeli')
                                <form action="{{ route('pembeli.keranjang.store') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="sapi_id" value="{{ $sapi->id }}">
                                    <button type="submit" class="btn-keranjang-icon" title="Keranjang">
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
            <div style="text-align: center; padding: 3rem 1.5rem; background: var(--bg-card, #ffffff); border-radius: 1rem; border: 1px dashed var(--border-color, #cbd5e1); margin-top: 1rem;">
                <i class="bi bi-hourglass-split" style="font-size: 2.75rem; color: #f59e0b; display: block; margin-bottom: 0.5rem;"></i>
                <h4 style="font-size: 1.1rem; color: var(--text-heading, #334155); margin: 0 0 0.4rem 0; font-weight: 700;">Belum Ada Sapi Pre-Order</h4>
                <p style="color: var(--text-secondary, #64748b); font-size: 0.9rem; margin: 0;">Saat ini belum ada ternak dalam kategori Pre-Order yang tersedia.</p>
            </div>
            @endif
        </div>
    </section>

    {{-- ═══ Section Iklan di Sela-Sela Katalog (Tanpa Teks/Kalimat Apapun) ═══ --}}
    @if(isset($iklans) && $iklans->count() > 0)
    <section class="iklan-sela-katalog-section" style="padding: 2rem 2rem; background-color: var(--bg-body, #f8fafc); border-top: 1px solid var(--border-color, #f1f5f9);">
        <div style="max-width: 1400px; margin: 0 auto;">
            <div class="carousel-container" style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.06);">
                <div class="carousel-track" id="carouselTrack">
                    @foreach($iklans as $iklan)
                    <div class="carousel-slide">
                        <img src="{{ asset('storage/' . $iklan->gambar) }}" alt="" style="width: 100%; aspect-ratio: 1638 / 500; object-fit: cover; border-radius: 20px; display: block;">
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
    </section>
    @endif

    {{-- ═══ Katalog Sapi Pesan Biasa Section ═══ --}}
    <section class="sapi-update-section" id="katalog-biasa" style="padding-top: 3rem; padding-bottom: 4rem; background-color: var(--bg-card, #ffffff); border-top: 1px solid var(--border-color, #f1f5f9);">
        <div class="sapi-update-inner">
            <div class="sapi-update-header">
                <div class="sapi-update-header-left">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                        <span style="display: inline-flex; align-items: center; gap: 0.35rem; background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;">
                            <i class="bi bi-lightning-charge-fill"></i> Ready Stock
                        </span>
                    </div>
                    <h2>Katalog Sapi Pesan Biasa</h2>
                    <p>Pilihan sapi sehat berkualitas yang siap langsung dipesan dan dikirim ke lokasi Anda.</p>
                </div>
                <a href="{{ route('katalog.index', ['tipe_penjualan' => 'order']) }}" class="btn-selengkapnya">Selengkapnya</a>
            </div>

            @if($sapiBiasa->count() > 0)
            <div class="sapi-cards-grid">
                @foreach($sapiBiasa as $sapi)
                <div class="sapi-card-new">
                    {{-- Badge Order --}}
                    <span class="sapi-card-new-badge order">
                        {{ $sapi->tipe_penjualan_label }}
                    </span>

                    {{-- Badge Sertifikasi Kesehatan --}}
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
                                <div class="sapi-card-placeholder-icon"><i class="bi bi-image" style="font-size: 3rem; color: #a5d6a7;"></i></div>
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

                    {{-- Footer --}}
                    <div class="sapi-card-new-footer">
                        <div class="sapi-card-new-peternak" style="display: flex; align-items: center; gap: 4px;">
                            by <a href="#">{{ $sapi->peternak->name ?? 'Peternak' }}</a>
                            <i class="bi bi-patch-check-fill" style="color: #10b981; font-size: 0.85rem;" title="Peternak Terverifikasi"></i>
                        </div>
                        <div class="sapi-card-new-actions">
                            <a href="{{ route('katalog.show', $sapi->id) }}" class="btn-beli-sekarang" style="display: inline-flex; align-items: center; justify-content: center; gap: 5px;">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            @if(!auth()->check())
                                <a href="{{ route('login') }}" class="btn-keranjang-icon" title="Keranjang" onclick="alert('Silakan login terlebih dahulu untuk menambahkan ternak ke keranjang belanja.');">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                </a>
                            @elseif(auth()->user()->role === 'pembeli')
                                <form action="{{ route('pembeli.keranjang.store') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="sapi_id" value="{{ $sapi->id }}">
                                    <button type="submit" class="btn-keranjang-icon" title="Keranjang">
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
            <div style="text-align: center; padding: 3rem 1.5rem; background: var(--bg-card, #f8fafc); border-radius: 1rem; border: 1px dashed var(--border-color, #cbd5e1); margin-top: 1rem;">
                <i class="bi bi-box-seam" style="font-size: 2.75rem; color: #10b981; display: block; margin-bottom: 0.5rem;"></i>
                <h4 style="font-size: 1.1rem; color: var(--text-heading, #334155); margin: 0 0 0.4rem 0; font-weight: 700;">Belum Ada Sapi Pesan Biasa</h4>
                <p style="color: var(--text-secondary, #64748b); font-size: 0.9rem; margin: 0;">Saat ini belum ada ternak dalam kategori pesan biasa yang tersedia.</p>
            </div>
            @endif

            {{-- Tombol Lihat Semua Katalog --}}
            <div style="text-align: center; margin-top: 3.5rem;">
                <a href="{{ route('katalog.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.85rem 2.2rem; background: linear-gradient(135deg, #10b981, #059669); color: white; text-decoration: none; border-radius: 999px; font-weight: 700; font-size: 1rem; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3); transition: all 0.3s;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(16, 185, 129, 0.4)';"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(16, 185, 129, 0.3)';">
                    Lihat Semua Katalog Sapi
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
    </section>
@endsection
