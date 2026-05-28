@extends('layouts.frontend')

@section('title', 'Katalog Sapi — Sistem Penjualan Sapi')

@section('content')
    {{-- ═══ Catalog Section ═══ --}}
    <section class="catalog-section" id="catalog" style="padding-top: 140px;">
        <div class="section-header">
            <span class="section-tag">Daftar Ternak</span>
            <h2 class="section-title">Katalog Sapi Digital</h2>
        </div>

        {{-- Filters Bar --}}
        <div class="filter-card">
            <form class="filter-form" method="GET" action="{{ route('katalog.index') }}">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <div class="filter-group">
                    <label class="filter-label">Jenis Sapi</label>
                    <select name="jenis" class="filter-input">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenisList as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Harga Minimal (Rp)</label>
                    <input type="number" name="harga_min" class="filter-input" placeholder="Contoh: 10000000" value="{{ request('harga_min') }}">
                </div>

                <div class="filter-group">
                    <label class="filter-label">Harga Maksimal (Rp)</label>
                    <input type="number" name="harga_max" class="filter-input" placeholder="Contoh: 40000000" value="{{ request('harga_max') }}">
                </div>

                <div class="filter-group">
                    <label class="filter-label">Sertifikasi Kesehatan</label>
                    <select name="sertifikasi" class="filter-input">
                        <option value="">Semua</option>
                        <option value="tersertifikasi" {{ request('sertifikasi') === 'tersertifikasi' ? 'selected' : '' }}>Layak Budidaya (Sehat)</option>
                    </select>
                </div>

                <div class="filter-group">
                    <div class="filter-buttons-wrapper">
                        <button type="submit" class="btn-search-apply">Terapkan Filter</button>
                        <a href="{{ route('katalog.index') }}" class="btn-search-reset">Reset</a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Results Info --}}
        <div class="results-count">
            Ditemukan: <strong>{{ $sapis->count() }}</strong> ekor sapi
            @if(request('search'))
                untuk pencarian "<strong>{{ request('search') }}</strong>"
            @endif
        </div>

        {{-- Grid --}}
        <div class="sapi-grid">
            @forelse ($sapis as $sapi)
                <div class="sapi-card" id="katalog-sapi-{{ $sapi->id }}">
                    <a href="{{ route('katalog.show', $sapi->id) }}" style="text-decoration: none; color: inherit; flex-grow: 1; display: flex; flex-direction: column;">
                        <div class="sapi-card-img-wrapper">
                            @if ($sapi->foto)
                                <img src="{{ asset('storage/' . $sapi->foto) }}" alt="Foto Sapi {{ $sapi->jenis }}" loading="lazy">
                            @else
                                <div class="sapi-card-placeholder">🐮</div>
                            @endif

                            {{-- Certificate Badge --}}
                            @if ($sapi->status_kesehatan === 'sehat')
                                <div class="badge-certified">
                                    <div class="badge-certified-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </div>
                                    <span>Layak Budidaya</span>
                                </div>
                            @endif
                        </div>

                        <div class="sapi-card-body" style="padding-bottom: 0.5rem;">
                            <div class="sapi-card-title-row">
                                <span class="sapi-card-jenis">{{ $sapi->jenis }}</span>
                                <span class="sapi-card-harga">{{ $sapi->harga_formatted }}</span>
                            </div>

                            <div class="sapi-card-specs">
                                <div class="sapi-spec-item">
                                    📅 <span>Umur: <strong>{{ $sapi->umur_formatted }}</strong></span>
                                </div>
                                <div class="sapi-spec-item">
                                    ⚖️ <span>Bobot: <strong>{{ number_format($sapi->bobot, 0, ',', '.') }} kg</strong></span>
                                </div>
                            </div>

                            <div class="sapi-card-footer">
                                <div class="sapi-peternak">
                                    🧑‍🌾 <span>{{ $sapi->peternak->name ?? 'Peternak Lokal' }}</span>
                                </div>
                                <span>{{ $sapi->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </a>
                    
                    <div style="padding: 1rem 1.5rem; border-top: 1px solid rgba(0,0,0,0.05); display: flex; gap: 0.5rem;">
                        @if(!auth()->check())
                            <a href="{{ route('login') }}" style="flex: 1; text-align: center; padding: 0.6rem; background: var(--green-brand); color: white; border: none; border-radius: 6px; font-weight: 600; text-decoration: none; font-family: var(--font-inter); transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='var(--green-hover)'" onmouseout="this.style.backgroundColor='var(--green-brand)'">
                                💳 Beli
                            </a>
                            <a href="{{ route('login') }}" style="flex: 1; text-align: center; padding: 0.6rem; background: rgba(0, 167, 64, 0.1); color: var(--green-brand); border: 1px solid rgba(0, 167, 64, 0.2); border-radius: 6px; font-weight: 600; text-decoration: none; font-family: var(--font-inter); transition: all 0.2s;" onmouseover="this.style.background='var(--green-brand)'; this.style.color='white';" onmouseout="this.style.background='rgba(0, 167, 64, 0.1)'; this.style.color='var(--green-brand)';">
                                🛒 Keranjang
                            </a>
                        @elseif(auth()->user()->role === 'pembeli')
                            <button type="button" onclick="alert('Fitur Pembelian Langsung sedang dalam tahap pengembangan.')" style="flex: 1; padding: 0.6rem; background: var(--green-brand); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-family: var(--font-inter); transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='var(--green-hover)'" onmouseout="this.style.backgroundColor='var(--green-brand)'">
                                💳 Beli
                            </button>
                            <form action="{{ route('pembeli.keranjang.store') }}" method="POST" style="flex: 1; margin: 0;">
                                @csrf
                                <input type="hidden" name="sapi_id" value="{{ $sapi->id }}">
                                <button type="submit" style="width: 100%; padding: 0.6rem; background: rgba(0, 167, 64, 0.1); color: var(--green-brand); border: 1px solid rgba(0, 167, 64, 0.2); border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: var(--font-inter);" onmouseover="this.style.background='var(--green-brand)'; this.style.color='white';" onmouseout="this.style.background='rgba(0, 167, 64, 0.1)'; this.style.color='var(--green-brand)';">
                                    🛒 Keranjang
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-catalog">
                    <div class="empty-icon">🐮</div>
                    <h3 class="empty-title">Tidak Ada Sapi Ditemukan</h3>
                    <p class="empty-desc">
                        Maaf, kami tidak menemukan sapi yang sesuai dengan pencarian Anda. Silakan ubah kata kunci atau setelan filter Anda.
                    </p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
