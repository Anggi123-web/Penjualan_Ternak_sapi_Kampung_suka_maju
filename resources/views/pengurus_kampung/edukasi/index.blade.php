@extends('layouts.app')

@section('title', 'Kelola Edukasi — Pengurus Kampung')

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;">🏘️ Pengurus Kampung</span>
    <button class="hamburger" onclick="toggleSidebar()">☰</button>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    @include('dashboard.partials.sidebar_pengurus_kampung')

    <main class="main-content">
        <div class="page-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1>Kelola Pamflet Edukasi</h1>
                    <p>Kelola pamflet edukasi yang akan ditampilkan di beranda.</p>
                </div>
                <a href="{{ route('pengurus_kampung.edukasi.create') }}" class="btn-primary" style="text-decoration: none;">
                    + Tambah Edukasi
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.1); color: var(--green-brand); border: 1px solid rgba(16, 185, 129, 0.25); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif

        <div class="content-card">
            @if($edukasis->isEmpty())
                <div style="text-align: center; padding: 2rem;">
                    <p style="color: var(--text-secondary); font-size: 1.1rem;">Belum ada pamflet edukasi yang diunggah.</p>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
                    @foreach($edukasis as $edukasi)
                        <div class="edukasi-card" style="border: 1px solid var(--border-color); border-radius: 0.75rem; overflow: hidden; background: var(--bg-card); color: var(--text-primary);">
                            <div style="height: 200px; overflow: hidden; background: var(--bg-muted); display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('storage/' . $edukasi->gambar) }}" alt="{{ $edukasi->judul }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            </div>
                            <div style="padding: 1rem;">
                                <h4 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; color: var(--text-heading);">{{ $edukasi->judul }}</h4>
                                <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 1rem;">Diunggah: {{ $edukasi->created_at->format('d M Y') }}</p>
                                
                                <form action="{{ route('pengurus_kampung.edukasi.destroy', $edukasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus edukasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger" style="width: 100%; padding: 0.5rem; border-radius: 0.375rem; background: #ef4444; color: white; border: none; cursor: pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('open');
    }
</script>
@endsection
