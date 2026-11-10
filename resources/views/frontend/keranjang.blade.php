@extends('layouts.frontend')

@section('content')
<div class="catalog-section" style="padding-top: 120px; min-height: calc(100vh - 110px);">
    <div class="section-header" style="margin-bottom: 2rem; text-align: left;">
        <span class="section-tag">Katalog Sapi</span>
        <h2 class="section-title">Keranjang Belanja</h2>
        <p style="color: var(--medium-gray); margin-top: 0.5rem; font-size: 1.05rem;">Daftar sapi yang telah Anda tambahkan ke keranjang.</p>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.12); color: var(--green-brand, #047857); border: 1px solid rgba(16, 185, 129, 0.3); padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 600;">
            {{ session('error') }}
        </div>
    @endif

    <div class="filter-card" style="margin-bottom: 2rem;">
        @if($keranjangs->isEmpty())
            <div class="empty-catalog" style="padding: 4rem 2rem; border: none; box-shadow: none;">
                <div class="empty-icon"><i class="bi bi-cart-x"></i></div>
                <h3 class="empty-title">Keranjang Masih Kosong</h3>
                <p class="empty-desc" style="margin-bottom: 2rem;">Anda belum menambahkan sapi apapun ke dalam keranjang.</p>
                <a href="{{ route('katalog.index') }}" class="btn-login-p" style="margin: 0 auto; width: 200px;">
                    Cari Sapi
                </a>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @php $totalHarga = 0; @endphp
                @foreach($keranjangs as $item)
                    @php $totalHarga += $item->sapi->harga; @endphp
                    <div style="display: flex; gap: 1.5rem; padding: 1.5rem; background: var(--bg-card, #ffffff); border: 1px solid var(--border-color, rgba(0,0,0,0.08)); border-radius: 12px; align-items: center; box-shadow: var(--card-shadow, 0 4px 6px -1px rgba(0,0,0,0.02));">
                        <!-- Foto -->
                        <div style="width: 140px; height: 140px; border-radius: 8px; overflow: hidden; flex-shrink: 0; background: var(--bg-muted, #f1f5f9);">
                            @if($item->sapi->first_foto)
                                <img src="{{ asset('storage/' . $item->sapi->first_foto) }}" alt="{{ $item->sapi->jenis }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: #a5d6a7;"><i class="bi bi-image"></i></div>
                            @endif
                        </div>
                        
                        <!-- Detail -->
                        <div style="flex-grow: 1;">
                            <h4 style="font-family: var(--font-montserrat); font-size: 1.35rem; font-weight: 700; color: var(--black-text); margin: 0 0 0.35rem 0;">{{ $item->sapi->jenis }}</h4>
                            <p style="color: var(--medium-gray); font-size: 0.95rem; margin: 0 0 0.75rem 0;">
                                Umur: <strong>{{ $item->sapi->umur_formatted }}</strong> &nbsp;•&nbsp; Bobot: <strong>{{ number_format($item->sapi->bobot, 0) }} kg</strong>
                            </p>
                            <div style="font-family: var(--font-montserrat); font-size: 1.25rem; font-weight: 800; color: var(--green-brand);">
                                {{ $item->sapi->harga_formatted }}
                            </div>
                        </div>
                        
                        <!-- Action -->
                        <div>
                            <form action="{{ route('pembeli.keranjang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus sapi ini dari keranjang?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); padding: 0.75rem 1.25rem; border-radius: 8px; cursor: pointer; font-weight: 600; font-family: var(--font-inter); transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='white';" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='#ef4444';">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <!-- Total & Checkout -->
                <div style="margin-top: 1.5rem; padding-top: 2rem; border-top: 2px dashed var(--border-color, rgba(0,0,0,0.1)); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="color: var(--medium-gray); font-size: 1.1rem; font-weight: 600;">Total Pembayaran:</span>
                        <div style="font-family: var(--font-montserrat); font-size: 1.8rem; font-weight: 800; color: var(--black-text); margin-top: 0.25rem;">
                            Rp {{ number_format($totalHarga, 0, ',', '.') }}
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('pembayaran.show', $keranjangs->first()->sapi_id) }}" class="btn-login-p" style="width: auto; padding: 0 2rem; height: 50px; font-size: 1.1rem; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                            Lanjut Pembayaran <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
