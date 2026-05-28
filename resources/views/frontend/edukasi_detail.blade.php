@extends('layouts.frontend')

@section('title', $edukasi->judul . ' — Sistem Penjualan Sapi')

@section('content')
<div style="background-color: #f8fafc; padding: 3rem 0; min-height: 100vh;">
    <div style="max-width: 800px; margin: 0 auto; padding: 0 1.5rem;">
        
        <!-- Back Button -->
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('beranda') }}" style="text-decoration: none; color: #64748b; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='#1e293b'" onmouseout="this.style.color='#64748b'">
                ← Kembali ke Beranda
            </a>
        </div>

        <!-- Main Banner -->
        <div style="width: 100%; aspect-ratio: 629/192; overflow: hidden; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 2rem; background: #fff;">
            <img src="{{ asset('storage/' . $edukasi->gambar) }}" alt="{{ $edukasi->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        <!-- Content Area -->
        <div style="background: white; border-radius: 1rem; padding: 2.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            
            <!-- Header -->
            <header style="margin-bottom: 2rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1.5rem;">
                <h1 style="font-size: 2.25rem; font-weight: 700; color: #1e293b; margin: 0 0 0.5rem 0; line-height: 1.2;">
                    {{ $edukasi->judul }}
                </h1>
                <div style="color: #64748b; font-size: 0.95rem; display: flex; align-items: center; gap: 1rem;">
                    <span>Diunggah pada {{ $edukasi->created_at->format('d M Y') }}</span>
                    <span style="background: #e0e7ff; color: #4338ca; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.8rem; font-weight: 600;">Edukasi</span>
                </div>
            </header>

            <!-- Deskripsi Awal -->
            @if($edukasi->deskripsi)
            <div style="font-size: 1.1rem; line-height: 1.7; color: #334155; margin-bottom: 2.5rem;">
                {!! nl2br(e($edukasi->deskripsi)) !!}
            </div>
            @endif

            <!-- Konten Dinamis -->
            @if(is_array($edukasi->konten_edukasi) && count($edukasi->konten_edukasi) > 0)
                <div class="edukasi-content-blocks" style="display: flex; flex-direction: column; gap: 1.5rem;">
                    @foreach($edukasi->konten_edukasi as $block)
                        @if($block['type'] === 'poin')
                            <div style="display: flex; gap: 1rem; align-items: flex-start; background: #f8fafc; padding: 1.5rem; border-radius: 0.75rem; border-left: 4px solid #8b5cf6;">
                                <div style="color: #8b5cf6; font-size: 1.25rem; margin-top: -0.25rem;">•</div>
                                <div style="font-size: 1.05rem; line-height: 1.6; color: #334155;">
                                    {!! nl2br(e($block['content'])) !!}
                                </div>
                            </div>
                        @elseif($block['type'] === 'gambar')
                            <div style="margin: 1rem 0; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 2px 4px -1px rgba(0,0,0,0.1);">
                                <img src="{{ asset('storage/' . $block['content']) }}" alt="Gambar Edukasi Tambahan" style="width: 100%; height: auto; display: block;">
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
