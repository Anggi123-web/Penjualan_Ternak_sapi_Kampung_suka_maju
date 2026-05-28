@extends('layouts.frontend')

@section('title', 'Beranda — Sistem Penjualan Sapi')

@section('content')
    {{-- ═══ Hero Carousel Section ═══ --}}
    <section class="hero-carousel-section" id="home">
        <div class="carousel-wrapper">
            <div class="carousel-container">
                <div class="carousel-track" id="carouselTrack">
                    @forelse($iklans as $iklan)
                        <div class="carousel-slide">
                            <a href="{{ route('katalog.index') }}"><img src="{{ asset('storage/' . $iklan->gambar) }}" alt="{{ $iklan->judul ?? 'Iklan Carousel' }}"></a>
                        </div>
                    @empty
                        <!-- Default fallback banners if no ads are uploaded -->
                        <div class="carousel-slide">
                            <a href="{{ route('katalog.index') }}"><img src="{{ asset('images/caraousel 1.png') }}" alt="Iklan 1"></a>
                        </div>
                        <div class="carousel-slide">
                            <a href="{{ route('katalog.index') }}"><img src="{{ asset('images/caraousel 2.png') }}" alt="Iklan 2"></a>
                        </div>
                    @endforelse
                </div>
                <!-- Controls -->
                <button class="carousel-btn prev" onclick="moveSlide(-1)">&#10094;</button>
                <button class="carousel-btn next" onclick="moveSlide(1)">&#10095;</button>
                <div class="carousel-dots">
                    @if($iklans->count() > 0)
                        @foreach($iklans as $index => $iklan)
                            <span class="dot {{ $index === 0 ? 'active' : '' }}" onclick="currentSlide({{ $index }})"></span>
                        @endforeach
                    @else
                        <span class="dot active" onclick="currentSlide(0)"></span>
                        <span class="dot" onclick="currentSlide(1)"></span>
                    @endif
                </div>
            </div>
        </div>
    </section>
    {{-- ═══ Sapi Baru Section ═══ --}}
    @if($sapis->count() > 0)
    <section class="section" style="padding: 4rem 2rem; background-color: #f8fafc;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: 2rem; color: #1e293b; margin-bottom: 0.5rem;">Sapi Baru di Katalog</h2>
                <p style="color: #64748b; font-size: 1.1rem;">Lihat sapi-sapi terbaru yang diunggah dalam 1 minggu terakhir.</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
                @foreach($sapis as $sapi)
                <div class="product-card" style="background: white; border-radius: 1rem; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: transform 0.3s;">
                    <div style="position: relative; height: 200px;">
                        <img src="{{ asset('storage/' . $sapi->foto) }}" alt="{{ $sapi->jenis }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 1rem; right: 1rem; background: #8b5cf6; color: white; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.8rem; font-weight: 600;">Baru</span>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                            <div>
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: #1e293b; margin-bottom: 0.25rem;">{{ $sapi->jenis }}</h3>
                                <p style="color: #64748b; font-size: 0.9rem;">{{ $sapi->umur_formatted }} • {{ $sapi->bobot }} kg</p>
                            </div>
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: #8b5cf6; margin-bottom: 1.5rem;">
                            {{ $sapi->harga_formatted }}
                        </div>
                        <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                            @if(!auth()->check())
                                <a href="{{ route('login') }}" style="flex: 1; text-align: center; padding: 0.75rem; border-radius: 0.5rem; background: var(--green-brand, #10b981); color: white; text-decoration: none; font-weight: 500; font-size: 0.95rem;">
                                    💳 Beli
                                </a>
                                <a href="{{ route('login') }}" style="flex: 1; text-align: center; padding: 0.75rem; border-radius: 0.5rem; background: rgba(16, 185, 129, 0.1); color: var(--green-brand, #10b981); border: 1px solid rgba(16, 185, 129, 0.2); text-decoration: none; font-weight: 500; font-size: 0.95rem;">
                                    🛒 Keranjang
                                </a>
                            @elseif(auth()->user()->role === 'pembeli')
                                <button type="button" onclick="alert('Fitur Pembelian Langsung sedang dalam tahap pengembangan.')" style="flex: 1; padding: 0.75rem; border-radius: 0.5rem; background: var(--green-brand, #10b981); color: white; border: none; font-weight: 500; font-size: 0.95rem; cursor: pointer;">
                                    💳 Beli
                                </button>
                                <form action="{{ route('pembeli.keranjang.store') }}" method="POST" style="flex: 1; margin: 0;">
                                    @csrf
                                    <input type="hidden" name="sapi_id" value="{{ $sapi->id }}">
                                    <button type="submit" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(16, 185, 129, 0.1); color: var(--green-brand, #10b981); border: 1px solid rgba(16, 185, 129, 0.2); font-weight: 500; font-size: 0.95rem; cursor: pointer;">
                                        🛒 Keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('katalog.show', $sapi->id) }}" class="btn-primary" style="display: block; text-align: center; width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: #1e293b; color: white; text-decoration: none; font-weight: 500;">
                                    Lihat Detail
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ Edukasi & Info Section ═══ --}}
    @if($edukasis->count() > 0)
    <section class="section" style="padding: 4rem 2rem; background-color: #ffffff;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: 2rem; color: #1e293b; margin-bottom: 0.5rem;">Edukasi & Info</h2>
                <p style="color: #64748b; font-size: 1.1rem;">Informasi seputar perawatan sapi dan regulasi pembelian.</p>
            </div>

            <style>
                .edu-slide {
                    flex: 0 0 calc((100% - 2rem) / 2);
                    box-sizing: border-box;
                }
                @media (max-width: 768px) {
                    .edu-slide {
                        flex: 0 0 100%;
                    }
                }
                .edu-btn {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    z-index: 10;
                    background: #fff;
                    border: 1px solid #e2e8f0;
                    border-radius: 50%;
                    width: 44px;
                    height: 44px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                    color: #1e293b;
                    font-size: 1.2rem;
                    transition: all 0.2s;
                }
                .edu-btn:hover {
                    background: #f8fafc;
                    box-shadow: 0 6px 8px rgba(0,0,0,0.15);
                }
                .edu-btn:disabled {
                    opacity: 0.5;
                    cursor: not-allowed;
                }
            </style>
            
            <div style="position: relative; padding: 1rem 0; overflow: hidden; margin: 0 -1rem;">
                <button id="eduPrev" class="edu-btn" style="left: 1rem;">&#10094;</button>
                <button id="eduNext" class="edu-btn" style="right: 1rem;">&#10095;</button>
                
                <div style="padding: 0 1rem; overflow: hidden;">
                    <div id="edukasiTrack" style="display: flex; gap: 2rem; transition: transform 0.4s ease-in-out;">
                        @foreach($edukasis as $edukasi)
                        <div class="edu-slide">
                            <a href="{{ route('edukasi.show', $edukasi->id) }}" style="text-decoration: none; display: block; width: 100%;">
                                <div style="border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: transform 0.2s; background: #fff;">
                                    <div style="width: 100%; aspect-ratio: 629/192; overflow: hidden; background: #f8fafc;">
                                        <img src="{{ asset('storage/' . $edukasi->gambar) }}" alt="{{ $edukasi->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div style="padding: 1rem; border-top: 1px solid #f1f5f9;">
                                        <h4 style="font-size: 1.1rem; font-weight: 600; color: #334155; margin: 0;">{{ $edukasi->judul }}</h4>
                                        @if($edukasi->deskripsi)
                                            <p style="color: #64748b; font-size: 0.9rem; margin: 0.5rem 0 0 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $edukasi->deskripsi }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const track = document.getElementById('edukasiTrack');
                    const slides = track.querySelectorAll('.edu-slide');
                    const prevBtn = document.getElementById('eduPrev');
                    const nextBtn = document.getElementById('eduNext');
                    
                    if (!track || slides.length === 0) return;

                    let currentIndex = 0;
                    
                    function getItemsToShow() {
                        return window.innerWidth <= 768 ? 1 : 2;
                    }

                    function updateCarousel() {
                        const itemsToShow = getItemsToShow();
                        const slideWidth = slides[0].offsetWidth;
                        const gap = window.innerWidth <= 768 ? 0 : 32; // Assuming gap might wrap differently, but flex gap is 32px
                        
                        // Exact calculation including flex gap (2rem = 32px)
                        const moveAmount = currentIndex * (slideWidth + 32); 
                        track.style.transform = `translateX(-${moveAmount}px)`;
                        
                        const maxIndex = slides.length - itemsToShow;
                        
                        prevBtn.disabled = currentIndex === 0;
                        nextBtn.disabled = currentIndex >= maxIndex;
                        
                        // Hide buttons entirely if total items <= itemsToShow
                        if (slides.length <= itemsToShow) {
                            prevBtn.style.display = 'none';
                            nextBtn.style.display = 'none';
                        } else {
                            prevBtn.style.display = 'flex';
                            nextBtn.style.display = 'flex';
                        }
                    }

                    prevBtn.addEventListener('click', () => {
                        if (currentIndex > 0) {
                            currentIndex--;
                            updateCarousel();
                        }
                    });

                    nextBtn.addEventListener('click', () => {
                        const itemsToShow = getItemsToShow();
                        const maxIndex = slides.length - itemsToShow;
                        if (currentIndex < maxIndex) {
                            currentIndex++;
                            updateCarousel();
                        }
                    });
                    
                    updateCarousel();
                    window.addEventListener('resize', updateCarousel);
                });
            </script>
        </div>
    </section>
    @endif
@endsection
