@extends('layouts.app')

@section('title', 'Sampah Katalog Penjualan — Aparat Kampung')

@section('content')
<div class="mobile-header">
    <span style="font-weight: 700;">🏘️ Pengurus Kampung</span>
    <button class="hamburger" onclick="toggleSidebar()">☰</button>
</div>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="dashboard-layout">
    @include('dashboard.partials.sidebar_pengurus_kampung')

    <main class="main-content">
        <style>
            .back-nav {
                margin-bottom: 1.25rem;
            }

            .back-nav-link {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                color: #94a3b8;
                text-decoration: none;
                font-size: 0.85rem;
                font-weight: 600;
                transition: color 0.2s;
            }

            .back-nav-link:hover {
                color: #f1f5f9;
            }

            .notice-box {
                background: rgba(239, 68, 68, 0.08);
                border: 1px solid rgba(239, 68, 68, 0.25);
                border-radius: 12px;
                padding: 1rem 1.25rem;
                margin-bottom: 1.75rem;
                color: #fca5a5;
                font-size: 0.88rem;
                line-height: 1.5;
                display: flex;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .table-container {
                background: var(--bg-card);
                border: 1px solid var(--border-color);
                border-radius: 16px;
                overflow: hidden;
                backdrop-filter: blur(20px);
            }

            .sampah-table {
                width: 100%;
                border-collapse: collapse;
                text-align: left;
                font-size: 0.9rem;
            }

            .sampah-table th {
                background: rgba(15, 23, 42, 0.5);
                padding: 1rem 1.25rem;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #94a3b8;
                border-bottom: 1px solid var(--border-color);
            }

            .sampah-table td {
                padding: 1.15rem 1.25rem;
                border-bottom: 1px solid rgba(148, 163, 184, 0.06);
                vertical-align: middle;
            }

            .sampah-table tr:last-child td {
                border-bottom: none;
            }

            .sampah-table tr:hover td {
                background: rgba(148, 163, 184, 0.02);
            }

            .sapi-item-info {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .sapi-thumb {
                width: 58px;
                height: 58px;
                border-radius: 10px;
                overflow: hidden;
                background: rgba(15, 23, 42, 0.6);
                flex-shrink: 0;
                border: 1px solid rgba(148, 163, 184, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .sapi-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .sapi-title-text {
                font-weight: 700;
                color: #f1f5f9;
                font-size: 0.95rem;
                margin-bottom: 0.2rem;
            }

            .sapi-specs-text {
                font-size: 0.8rem;
                color: #94a3b8;
                display: flex;
                gap: 0.75rem;
            }

            .btn-action-small {
                display: inline-flex;
                align-items: center;
                gap: 0.35rem;
                padding: 0.5rem 0.85rem;
                border-radius: 8px;
                font-size: 0.82rem;
                font-weight: 600;
                font-family: inherit;
                cursor: pointer;
                transition: all 0.2s ease;
                border: 1px solid transparent;
                white-space: nowrap;
            }

            .btn-restore {
                background: rgba(16, 185, 129, 0.15);
                color: #6ee7b7;
                border-color: rgba(16, 185, 129, 0.3);
            }

            .btn-restore:hover {
                background: rgba(16, 185, 129, 0.25);
                color: #34d399;
                border-color: rgba(16, 185, 129, 0.5);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            }

            .btn-force-delete {
                background: rgba(239, 68, 68, 0.15);
                color: #fca5a5;
                border-color: rgba(239, 68, 68, 0.35);
            }

            .btn-force-delete:hover {
                background: rgba(239, 68, 68, 0.3);
                color: #ffffff;
                border-color: rgba(239, 68, 68, 0.6);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            }

            .alert-success {
                background: rgba(16, 185, 129, 0.08);
                border: 1px solid rgba(16, 185, 129, 0.25);
                border-radius: 12px;
                padding: 0.9rem 1.25rem;
                margin-bottom: 1.5rem;
                font-size: 0.9rem;
                color: #6ee7b7;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            @media (max-width: 900px) {
                .table-container {
                    overflow-x: auto;
                }
                .sampah-table {
                    min-width: 750px;
                }
            }
        </style>

        <div class="back-nav">
            <a href="{{ route('pengurus_kampung.katalog.index') }}" class="back-nav-link">
                ← Kembali ke Katalog Penjualan
            </a>
        </div>

        <div class="page-header">
            <h1>🗑️ Sampah Katalog Penjualan</h1>
            <p>Daftar katalog sapi yang dihapus sementara. Anda dapat memulihkannya kembali atau menghapusnya secara permanen.</p>
        </div>

        @if(session('success'))
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="notice-box">
            <span style="font-size: 1.25rem; line-height: 1;">⚠️</span>
            <div>
                <strong>Informasi Sampah:</strong><br>
                Katalog di halaman ini disembunyikan dari publik. Memulihkan (<strong>Pulihkan</strong>) akan mengembalikan sapi ke katalog aktif. Menghapus permanen (<strong>Hapus Permanen</strong>) akan menghapus data beserta berkas foto dan video dari server secara permanen.
            </div>
        </div>

        <div class="table-container">
            @if($sapis->isEmpty())
                <div style="text-align: center; padding: 4.5rem 2rem; color: #64748b;">
                    <div style="font-size: 3.5rem; margin-bottom: 1rem; opacity: 0.4;">✨</div>
                    <h3 style="color: #94a3b8; font-size: 1.15rem; margin-bottom: 0.5rem;">Sampah Kosong</h3>
                    <p style="font-size: 0.9rem;">Tidak ada katalog sapi yang berada di dalam sampah saat ini.</p>
                    <div style="margin-top: 1.5rem;">
                        <a href="{{ route('pengurus_kampung.katalog.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.25rem; background: rgba(139,92,246,0.15); color: #c4b5fd; border: 1px solid rgba(139,92,246,0.3); border-radius: 10px; font-size: 0.85rem; font-weight: 600; text-decoration: none;">
                            Kembali ke Katalog
                        </a>
                    </div>
                </div>
            @else
                <table class="sampah-table">
                    <thead>
                        <tr>
                            <th>Data Ternak</th>
                            <th>Pemilik / Peternak</th>
                            <th>Harga</th>
                            <th>Waktu Masuk Sampah</th>
                            <th style="text-align: right;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sapis as $sapi)
                            <tr id="sampah-row-{{ $sapi->id }}">
                                <td>
                                    <div class="sapi-item-info">
                                        <div class="sapi-thumb">
                                            @if($sapi->first_foto)
                                                <img src="{{ asset('storage/' . $sapi->first_foto) }}" alt="Foto {{ $sapi->jenis }}">
                                            @else
                                                <span style="font-size: 1.8rem; opacity: 0.4;">🐮</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="sapi-title-text">{{ $sapi->jenis }}</div>
                                            <div class="sapi-specs-text">
                                                <span>📅 {{ $sapi->umur_formatted }}</span>
                                                <span>⚖️ {{ number_format($sapi->bobot, 0) }} kg</span>
                                                <span style="font-weight: 700; color: {{ $sapi->is_preorder ? '#fbbf24' : '#6ee7b7' }};">
                                                    {{ $sapi->tipe_penjualan_label }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #f1f5f9;">{{ $sapi->peternak->name ?? '-' }}</div>
                                    <div style="font-size: 0.8rem; color: #94a3b8;">{{ $sapi->peternak->email ?? '-' }}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #6ee7b7;">{{ $sapi->harga_formatted }}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #f1f5f9;">{{ $sapi->deleted_at->format('d M Y, H:i') }}</div>
                                    <div style="font-size: 0.75rem; color: #94a3b8;">{{ $sapi->deleted_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.5rem;">
                                        {{-- Pulihkan --}}
                                        <form method="POST" action="{{ route('pengurus_kampung.katalog.restore', $sapi->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-action-small btn-restore" title="Pulihkan kembali ke katalog aktif">
                                                <span>♻️</span> Pulihkan
                                            </button>
                                        </form>

                                        {{-- Hapus Permanen --}}
                                        <form method="POST" action="{{ route('pengurus_kampung.katalog.force_delete', $sapi->id) }}" onsubmit="return confirm('PERINGATAN: Sapi {{ $sapi->jenis }} (Milik {{ $sapi->peternak->name ?? 'Peternak' }}) akan DIHAPUS PERMANEN beserta semua berkas fotonya dari server. Tindakan ini TIDAK DAPAT DIBATALKAN. Lanjutkan?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-small btn-force-delete" title="Hapus Permanen dari Database dan Storage">
                                                <span>⚠️</span> Hapus Permanen
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($sapis->hasPages())
                    <div style="padding: 1.25rem; border-top: 1px solid var(--border-color);">
                        {{ $sapis->links() }}
                    </div>
                @endif
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
