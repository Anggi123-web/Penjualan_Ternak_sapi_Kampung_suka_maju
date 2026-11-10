@extends('layouts.app')

@section('title', 'Kelola Iklan Carousel — ' . (auth()->user()->role === 'peternak' ? 'Panel Peternak' : 'Pengurus Kampung'))

@section('styles')
<style>
    .iklan-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .btn-create-iklan {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.4rem;
        background: linear-gradient(135deg, #00A740, #008f38);
        color: #ffffff !important;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0, 167, 64, 0.25);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-create-iklan:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 167, 64, 0.35);
        color: #ffffff !important;
    }

    .iklan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .iklan-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        box-shadow: var(--card-shadow);
    }

    .iklan-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(16, 185, 129, 0.3);
    }

    .iklan-media-wrap {
        position: relative;
        width: 100%;
        height: 190px;
        background: var(--bg-muted);
        overflow: hidden;
    }

    .iklan-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .iklan-card:hover .iklan-img {
        transform: scale(1.03);
    }

    .iklan-badge-top {
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 999px;
        backdrop-filter: blur(8px);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .iklan-uploader-tag {
        position: absolute;
        bottom: 10px;
        left: 12px;
        background: rgba(15, 23, 42, 0.75);
        color: #f8fafc;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 6px;
        backdrop-filter: blur(4px);
    }

    .iklan-body {
        padding: 1.25rem 1.4rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .iklan-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-heading);
        margin: 0 0 0.5rem 0;
        line-height: 1.4;
    }

    .iklan-meta-row {
        font-size: 0.82rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 0.35rem;
    }

    .iklan-footer-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
        gap: 0.75rem;
    }

    .btn-delete-iklan {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: var(--accent-red-bg);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: var(--accent-red-text);
        padding: 0.45rem 0.9rem;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-delete-iklan:hover {
        background: rgba(239, 68, 68, 0.25);
        border-color: rgba(239, 68, 68, 0.5);
    }

    .approve-box {
        margin-top: 1rem;
        padding: 0.85rem 1rem;
        background: var(--bg-muted);
        border: 1px solid var(--border-color);
        border-radius: 10px;
    }

    .approve-box-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        display: block;
    }

    .approve-input-group {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .input-durasi {
        flex: 1;
        padding: 0.55rem 0.75rem;
        background: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--text-primary);
        border-radius: 8px;
        font-size: 0.85rem;
        outline: none;
    }

    .input-durasi:focus {
        border-color: var(--green-brand);
    }

    .btn-approve {
        padding: 0.55rem 1rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: transform 0.2s ease;
    }

    .btn-approve:hover {
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<div class="mobile-header">
    <div style="display: flex; align-items: center; gap: 8px;">
        <img src="{{ asset('images/sipeter_logo.png') }}" class="app-sidebar-logo" alt="Logo" style="height: 28px; width: auto; object-fit: contain;">
        <span style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary);">
            {{ auth()->user()->role === 'peternak' ? 'Panel Peternak' : 'Pengurus Kampung' }}
        </span>
    </div>
    <div style="display: flex; align-items: center; gap: 8px;">
        @include('partials.theme_toggle', ['id' => 'iklanMobileThemeToggle', 'iconOnly' => true])
        <button class="hamburger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    </div>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    @if(auth()->user()->role === 'peternak')
        @include('dashboard.partials.sidebar_peternak')
    @else
        @include('dashboard.partials.sidebar_pengurus_kampung')
    @endif

    <main class="main-content">
        <div class="iklan-header-flex">
            <div>
                <h1><i class="bi bi-image" style="color: var(--green-brand); margin-right: 0.35rem;"></i> Kelola Iklan Carousel</h1>
                <p style="color: var(--text-secondary); margin: 0.25rem 0 0 0;">
                    Unggah dan kelola gambar iklan promosi banner yang akan ditampilkan di halaman depan beranda.
                </p>
            </div>
            <a href="{{ route('iklan.create') }}" class="btn-create-iklan">
                <i class="bi bi-cloud-arrow-up-fill"></i> + Unggah Iklan Baru
            </a>
        </div>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.12); border-left: 4px solid var(--green-brand); color: var(--green-brand); padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.6rem;">
                <i class="bi bi-check-circle-fill" style="font-size: 1.1rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="iklan-grid">
            @forelse($iklans as $iklan)
                @php
                    $statusMeta = match($iklan->status) {
                        'aktif' => [
                            'bg' => 'var(--green-subtle)',
                            'border' => 'rgba(16, 185, 129, 0.4)',
                            'color' => 'var(--green-brand)',
                            'icon' => 'bi-check-circle-fill',
                            'label' => 'Aktif Tayang'
                        ],
                        'pending' => [
                            'bg' => 'var(--accent-amber-bg)',
                            'border' => 'rgba(245, 158, 11, 0.4)',
                            'color' => 'var(--accent-amber-text)',
                            'icon' => 'bi-hourglass-split',
                            'label' => 'Menunggu Persetujuan'
                        ],
                        'ditolak' => [
                            'bg' => 'var(--accent-red-bg)',
                            'border' => 'rgba(239, 68, 68, 0.4)',
                            'color' => 'var(--accent-red-text)',
                            'icon' => 'bi-x-circle-fill',
                            'label' => 'Ditolak'
                        ],
                        'selesai' => [
                            'bg' => 'var(--bg-muted)',
                            'border' => 'var(--border-color)',
                            'color' => 'var(--text-secondary)',
                            'icon' => 'bi-clock-history',
                            'label' => 'Selesai / Kedaluwarsa'
                        ],
                        default => [
                            'bg' => 'var(--bg-muted)',
                            'border' => 'var(--border-color)',
                            'color' => 'var(--text-secondary)',
                            'icon' => 'bi-info-circle',
                            'label' => ucfirst($iklan->status)
                        ],
                    };
                @endphp
                <div class="iklan-card">
                    <div class="iklan-media-wrap">
                        <img src="{{ asset('storage/' . $iklan->gambar) }}" alt="{{ $iklan->judul }}" class="iklan-img">
                        <span class="iklan-badge-top" style="background: {{ $statusMeta['bg'] }}; border: 1px solid {{ $statusMeta['border'] }}; color: {{ $statusMeta['color'] }};">
                            <i class="bi {{ $statusMeta['icon'] }}"></i> {{ $statusMeta['label'] }}
                        </span>
                        @if($iklan->user)
                            <span class="iklan-uploader-tag">
                                <i class="bi bi-person-fill"></i> {{ $iklan->user->name }}
                            </span>
                        @endif
                    </div>
                    <div class="iklan-body">
                        <h4 class="iklan-title">{{ $iklan->judul ?: 'Iklan Promosi Tanpa Judul' }}</h4>
                        
                        <div class="iklan-meta-row">
                            <i class="bi bi-calendar3"></i> Diunggah: {{ $iklan->created_at->format('d M Y') }}
                        </div>

                        @if($iklan->expires_at)
                            <div class="iklan-meta-row" style="color: {{ $iklan->expires_at->isPast() ? 'var(--accent-red-text)' : 'var(--accent-amber-text)' }}; font-weight: 600;">
                                <i class="bi bi-clock-history"></i> Tayang s/d: {{ $iklan->expires_at->format('d M Y, H:i') }}
                                @if($iklan->expires_at->isPast())
                                    <span>(Expired)</span>
                                @endif
                            </div>
                        @endif

                        @if(auth()->user()->role === 'pengurus_kampung' && $iklan->status === 'pending')
                            <div class="approve-box">
                                <span class="approve-box-label"><i class="bi bi-shield-check"></i> Setujui Penayangan Iklan:</span>
                                <form action="{{ route('iklan.approve', $iklan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="approve-input-group">
                                        <input type="number" name="durasi_hari" placeholder="Hari tayang" value="30" required min="1" max="365" class="input-durasi" title="Durasi penayangan dalam satuan hari">
                                        <button type="submit" class="btn-approve">
                                            <i class="bi bi-check-lg"></i> Setujui
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <div class="iklan-footer-actions">
                            <span style="font-size: 0.78rem; color: var(--text-secondary);">
                                ID: #{{ $iklan->id }}
                            </span>
                            @if($iklan->user_id === auth()->id() || auth()->user()->role === 'pengurus_kampung')
                                <form action="{{ route('iklan.destroy', $iklan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus iklan banner ini?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-iklan">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="content-card" style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem;">
                    <div style="font-size: 3.5rem; margin-bottom: 1rem; color: var(--text-secondary); opacity: 0.5;">
                        <i class="bi bi-images"></i>
                    </div>
                    <h3 style="margin-bottom: 0.5rem; color: var(--text-heading);">Belum Ada Iklan</h3>
                    <p style="color: var(--text-secondary); max-width: 480px; margin: 0 auto 1.5rem auto;">
                        Belum ada banner iklan carousel yang terdaftar. Klik tombol di bawah untuk mengunggah iklan promosi pertama Anda.
                    </p>
                    <a href="{{ route('iklan.create') }}" class="btn-create-iklan" style="display: inline-flex;">
                        <i class="bi bi-cloud-arrow-up-fill"></i> Unggah Iklan Sekarang
                    </a>
                </div>
            @endforelse
        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('open');
    }
</script>

@if(auth()->user()->role === 'peternak')
    @include('partials.chat_box')
@endif
@endsection
