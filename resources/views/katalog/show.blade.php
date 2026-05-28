<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $sapi->jenis }} — Sapi {{ $sapi->status_kesehatan === 'sehat' ? 'tersertifikasi sehat' : '' }} | {{ $sapi->harga_formatted }}">
    <title>{{ $sapi->jenis }} — Katalog Penjualan Sapi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #f1f5f9;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Background */
        .bg-gradient {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .bg-gradient::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
            top: -200px;
            left: -100px;
            animation: float 15s ease-in-out infinite;
        }

        .bg-gradient::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            bottom: -150px;
            right: -100px;
            animation: float 18s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }

        .grid-pattern {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 1;
        }

        /* Navbar */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.08);
            padding: 0 2rem;
        }

        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            color: #f1f5f9;
        }

        .navbar-brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(16, 185, 129, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .navbar-brand h2 {
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .navbar-brand span {
            font-size: 0.72rem;
            color: #64748b;
            font-weight: 500;
            display: block;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1.15rem;
            background: transparent;
            border: 1px solid rgba(148, 163, 184, 0.2);
            color: #94a3b8;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            border-color: rgba(148, 163, 184, 0.4);
            color: #f1f5f9;
            background: rgba(148, 163, 184, 0.05);
        }

        .btn-register-nav {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1.15rem;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-register-nav:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
            color: white;
        }

        .user-menu-dropdown:hover .dropdown-content {
            display: block !important;
        }

        /* Page Container */
        .page-container {
            position: relative;
            z-index: 10;
            max-width: 1080px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Back Link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.2s ease;
            margin-bottom: 1.5rem;
        }

        .back-link:hover {
            color: #f1f5f9;
        }

        /* ═══ Detail Layout ═══ */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Media */
        .detail-media {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, 0.1);
            position: relative;
        }

        .detail-media img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .detail-media-placeholder {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7rem;
            opacity: 0.25;
        }

        .detail-media video {
            width: 100%;
            max-height: 350px;
            background: #000;
        }

        /* Sertifikasi Badge on Detail */
        .detail-sertifikasi {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 5;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(16, 185, 129, 0.92);
            backdrop-filter: blur(8px);
            border-radius: 50px;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }

        .detail-sertifikasi .check-circle {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .detail-sertifikasi .check-circle svg {
            width: 14px;
            height: 14px;
        }

        .detail-sertifikasi span {
            font-size: 0.8rem;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .detail-belum {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 5;
            padding: 0.45rem 0.9rem;
            background: rgba(245, 158, 11, 0.9);
            backdrop-filter: blur(8px);
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 700;
            color: white;
        }

        .detail-tidak-sehat {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 5;
            padding: 0.45rem 0.9rem;
            background: rgba(239, 68, 68, 0.9);
            backdrop-filter: blur(8px);
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 700;
            color: white;
        }

        /* Info Cards */
        .info-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 18px;
            padding: 1.5rem;
        }

        .info-card h3 {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 1.15rem;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.7rem 0;
            border-bottom: 1px solid rgba(148, 163, 184, 0.06);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .info-value {
            color: #f1f5f9;
            font-size: 0.92rem;
            font-weight: 600;
            text-align: right;
        }

        .info-value.harga {
            color: #6ee7b7;
            font-size: 1.2rem;
            font-weight: 800;
        }

        .peternak-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.15);
            border-radius: 10px;
            padding: 0.45rem 0.85rem;
            font-size: 0.82rem;
            color: #6ee7b7;
            font-weight: 600;
        }

        /* ═══ Riwayat Kelayakan Budidaya ═══ */
        .riwayat-section {
            grid-column: 1 / -1;
            margin-top: 0.5rem;
        }

        .riwayat-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 18px;
            padding: 1.75rem;
            position: relative;
            overflow: hidden;
        }

        .riwayat-card h3 {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 2.5rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, rgba(148, 163, 184, 0.15), transparent);
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.75rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -2.5rem;
            top: 2px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            z-index: 2;
        }

        .timeline-dot-green {
            background: rgba(16, 185, 129, 0.15);
            border: 2px solid #10b981;
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.2);
        }

        .timeline-dot-red {
            background: rgba(239, 68, 68, 0.15);
            border: 2px solid #ef4444;
            box-shadow: 0 0 12px rgba(239, 68, 68, 0.2);
        }

        .timeline-dot-yellow {
            background: rgba(245, 158, 11, 0.15);
            border: 2px solid #f59e0b;
            box-shadow: 0 0 12px rgba(245, 158, 11, 0.2);
        }

        .timeline-dot-blue {
            background: rgba(59, 130, 246, 0.15);
            border: 2px solid #3b82f6;
            box-shadow: 0 0 12px rgba(59, 130, 246, 0.2);
        }

        .timeline-content {
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(148, 163, 184, 0.06);
            border-radius: 14px;
            padding: 1.15rem;
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .timeline-title {
            font-size: 0.92rem;
            font-weight: 700;
            color: #f1f5f9;
        }

        .timeline-date {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 500;
        }

        .timeline-desc {
            font-size: 0.85rem;
            color: #94a3b8;
            line-height: 1.6;
        }

        .timeline-verifier {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            margin-top: 0.6rem;
            font-size: 0.78rem;
            color: #64748b;
            padding: 0.3rem 0.65rem;
            background: rgba(148, 163, 184, 0.05);
            border-radius: 6px;
        }

        .catatan-box {
            margin-top: 0.75rem;
            padding: 0.85rem;
            background: rgba(15, 23, 42, 0.5);
            border-radius: 10px;
            border-left: 3px solid;
            font-size: 0.85rem;
            color: #cbd5e1;
            line-height: 1.7;
        }

        .catatan-box.sehat {
            border-left-color: #10b981;
        }

        .catatan-box.tidak-sehat {
            border-left-color: #ef4444;
        }

        /* Status Chips */
        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .status-chip-sehat {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .status-chip-tidak {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .status-chip-belum {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: #fcd34d;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem 0;
            border-top: 1px solid rgba(148, 163, 184, 0.06);
            margin-top: 2rem;
        }

        .footer p {
            font-size: 0.8rem;
            color: #475569;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .page-container {
                padding: 1.25rem;
            }

            .riwayat-section {
                grid-column: 1;
            }

            .navbar-brand span {
                display: none;
            }
        }

        /* Fade in animation */
        .fade-in {
            opacity: 0;
            transform: translateY(15px);
            animation: fadeIn 0.5s ease forwards;
        }

        .fade-in:nth-child(2) { animation-delay: 0.1s; }
        .fade-in:nth-child(3) { animation-delay: 0.2s; }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="bg-gradient"></div>
    <div class="grid-pattern"></div>

    {{-- Navbar --}}
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="{{ route('katalog.index') }}" class="navbar-brand">
                <div class="navbar-brand-icon">🐄</div>
                <div>
                    <h2>Penjualan Sapi</h2>
                    <span>Sistem Katalog Digital</span>
                </div>
            </a>
            <div class="navbar-actions">
                @auth
                    @if(auth()->user()->role === 'pembeli')
                        @php
                            $keranjangCount = \App\Models\Keranjang::where('user_id', auth()->id())->count();
                        @endphp
                        <a href="{{ route('pembeli.keranjang.index') }}" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); border-radius: 8px; position: relative; text-decoration: none; color: #10b981; transition: background-color 0.2s ease;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                            @if($keranjangCount > 0)
                                <span style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; font-size: 10px; font-weight: bold; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">{{ $keranjangCount }}</span>
                            @endif
                        </a>
                        <div class="user-menu-dropdown" style="position: relative; display: inline-block;">
                            <a href="{{ route('pembeli.dashboard') }}" class="btn-login" style="cursor: pointer; text-decoration: none;">👤 Akun Saya</a>
                            <div class="dropdown-content" style="display: none; position: absolute; right: 0; padding-top: 8px; min-width: 160px; z-index: 10;">
                                <div style="background-color: #1e293b; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.5); border-radius: 8px; overflow: hidden; border: 1px solid rgba(148,163,184,0.1);">
                                    <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                                        @csrf
                                        <button type="submit" style="width: 100%; text-align: left; padding: 12px 16px; border: none; background: transparent; cursor: pointer; color: #ef4444; font-weight: bold; font-family: 'Inter', sans-serif; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.1)'" onmouseout="this.style.backgroundColor='transparent'">Keluar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        @php
                            $dashboardRoute = match(auth()->user()->role) {
                                'peternak' => route('peternak.dashboard'),
                                'mantri_hewan' => route('mantri_hewan.dashboard'),
                                'pengurus_kampung' => route('pengurus_kampung.dashboard'),
                                default => '/'
                            };
                        @endphp
                        <a href="{{ $dashboardRoute }}" class="btn-login">📊 Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                            @csrf
                            <button type="submit" class="btn-login" style="border-color: rgba(239, 68, 68, 0.3); color: #fca5a5; margin-left: 0.5rem; cursor: pointer;">Keluar</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-register-nav">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="page-container">
        <a href="{{ route('katalog.index') }}" class="back-link">
            ← Kembali ke Katalog
        </a>

        <div class="detail-grid">
            {{-- ═══ Media ═══ --}}
            <div class="fade-in">
                <div class="detail-media">
                    @if ($sapi->foto)
                        <img src="{{ asset('storage/' . $sapi->foto) }}" alt="Foto {{ $sapi->jenis }}">
                    @else
                        <div class="detail-media-placeholder">🐮</div>
                    @endif

                    @if ($sapi->status_kesehatan === 'sehat')
                        <div class="detail-sertifikasi">
                            <div class="check-circle">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span>Tersertifikasi Sehat</span>
                        </div>
                    @elseif ($sapi->status_kesehatan === 'tidak_sehat')
                        <div class="detail-tidak-sehat">❌ Tidak Lolos Verifikasi</div>
                    @else
                        <div class="detail-belum">⏳ Menunggu Verifikasi</div>
                    @endif
                </div>

                @if ($sapi->video)
                    <div class="detail-media" style="margin-top: 1rem;">
                        <video controls>
                            <source src="{{ asset('storage/' . $sapi->video) }}" type="video/mp4">
                            Browser Anda tidak mendukung pemutaran video.
                        </video>
                    </div>
                @endif
            </div>

            {{-- ═══ Info ═══ --}}
            <div class="fade-in">
                <div class="info-card">
                    <h3>📋 Informasi Sapi</h3>
                    <div class="info-row">
                        <span class="info-label">Jenis</span>
                        <span class="info-value">{{ $sapi->jenis }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Umur</span>
                        <span class="info-value">{{ $sapi->umur_formatted }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Bobot</span>
                        <span class="info-value">{{ number_format($sapi->bobot, 0) }} kg</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Harga</span>
                        <span class="info-value harga">{{ $sapi->harga_formatted }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="info-value">
                            @if ($sapi->status_kesehatan === 'sehat')
                                <span class="status-chip status-chip-sehat">✅ Tersertifikasi Sehat</span>
                            @elseif ($sapi->status_kesehatan === 'tidak_sehat')
                                <span class="status-chip status-chip-tidak">❌ Tidak Lolos</span>
                            @else
                                <span class="status-chip status-chip-belum">⏳ Menunggu Verifikasi</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Didaftarkan</span>
                        <span class="info-value">{{ $sapi->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="info-card" style="margin-top: 1rem;">
                    <h3>👤 Peternak</h3>
                    <div class="info-row">
                        <span class="info-label">Nama</span>
                        <span class="peternak-badge">🐄 {{ $sapi->peternak->name ?? '-' }}</span>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    @if(!auth()->check())
                        <a href="{{ route('login') }}" style="flex: 1; text-align: center; display: flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 1rem; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 14px; font-size: 1.05rem; font-weight: 700; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(16, 185, 129, 0.25);">
                            💳 Beli Langsung
                        </a>
                        <a href="{{ route('login') }}" style="flex: 1; display: flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 1rem; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 14px; font-size: 1.05rem; font-weight: 700; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='#10b981'; this.style.color='white';" onmouseout="this.style.background='rgba(16, 185, 129, 0.1)'; this.style.color='#10b981';">
                            🛒 Keranjang
                        </a>
                    @elseif(auth()->user()->role === 'pembeli')
                        <button type="button" onclick="alert('Fitur Pembelian Langsung sedang dalam tahap pengembangan.')" style="flex: 1; display: flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 1rem; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 14px; font-size: 1.05rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(16, 185, 129, 0.25);">
                            💳 Beli Langsung
                        </button>
                        <form action="{{ route('pembeli.keranjang.store') }}" method="POST" style="flex: 1; margin: 0;">
                            @csrf
                            <input type="hidden" name="sapi_id" value="{{ $sapi->id }}">
                            <button type="submit" style="width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 1rem; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 14px; font-size: 1.05rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.background='#10b981'; this.style.color='white';" onmouseout="this.style.background='rgba(16, 185, 129, 0.1)'; this.style.color='#10b981';">
                                🛒 Keranjang
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- ═══ Riwayat Kelayakan Budidaya ═══ --}}
            <div class="riwayat-section fade-in">
                <div class="riwayat-card">
                    <h3>📜 Riwayat Kelayakan Budidaya</h3>

                    <div class="timeline">
                        {{-- Step 1: Pendaftaran Sapi --}}
                        <div class="timeline-item">
                            <div class="timeline-dot timeline-dot-blue">📝</div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <span class="timeline-title">Sapi Didaftarkan</span>
                                    <span class="timeline-date">{{ $sapi->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <p class="timeline-desc">
                                    Data sapi <strong>{{ $sapi->jenis }}</strong> didaftarkan oleh peternak <strong>{{ $sapi->peternak->name ?? '-' }}</strong> ke dalam sistem.
                                    Sapi memiliki bobot {{ number_format($sapi->bobot, 0) }} kg, umur {{ $sapi->umur_formatted }}, dan dipasarkan dengan harga {{ $sapi->harga_formatted }}.
                                </p>
                            </div>
                        </div>

                        {{-- Step 2: Menunggu Pemeriksaan --}}
                        @if ($sapi->status_kesehatan === 'belum_diperiksa')
                            <div class="timeline-item">
                                <div class="timeline-dot timeline-dot-yellow">⏳</div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <span class="timeline-title">Menunggu Pemeriksaan Mantri Hewan</span>
                                        <span class="timeline-date">Belum diperiksa</span>
                                    </div>
                                    <p class="timeline-desc">
                                        Sapi ini sedang menunggu pemeriksaan kesehatan oleh Mantri Hewan. Hasil verifikasi akan menentukan kelayakan sapi untuk diperdagangkan.
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- Step 3: Hasil Verifikasi --}}
                        @if ($sapi->status_kesehatan === 'sehat')
                            <div class="timeline-item">
                                <div class="timeline-dot timeline-dot-green">✅</div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <span class="timeline-title">Dinyatakan Layak — Tersertifikasi Sehat</span>
                                        <span class="timeline-date">{{ $sapi->verified_at ? $sapi->verified_at->format('d M Y, H:i') : '-' }}</span>
                                    </div>
                                    <p class="timeline-desc">
                                        Setelah melalui pemeriksaan menyeluruh, sapi ini dinyatakan <strong style="color: #6ee7b7;">sehat dan layak untuk budidaya/perdagangan</strong>.
                                    </p>

                                    @if ($sapi->catatan_kesehatan)
                                        <div class="catatan-box sehat">
                                            <strong>📋 Catatan Pemeriksaan:</strong><br>
                                            {{ $sapi->catatan_kesehatan }}
                                        </div>
                                    @endif

                                    @if ($sapi->verifier)
                                        <div class="timeline-verifier">
                                            🩺 Diverifikasi oleh: <strong>{{ $sapi->verifier->name }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @elseif ($sapi->status_kesehatan === 'tidak_sehat')
                            <div class="timeline-item">
                                <div class="timeline-dot timeline-dot-red">❌</div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <span class="timeline-title">Tidak Lolos Verifikasi — Tidak Layak</span>
                                        <span class="timeline-date">{{ $sapi->verified_at ? $sapi->verified_at->format('d M Y, H:i') : '-' }}</span>
                                    </div>
                                    <p class="timeline-desc">
                                        Setelah pemeriksaan, sapi ini dinyatakan <strong style="color: #fca5a5;">tidak sehat dan tidak layak untuk budidaya/perdagangan</strong> saat ini.
                                    </p>

                                    @if ($sapi->catatan_kesehatan)
                                        <div class="catatan-box tidak-sehat">
                                            <strong>📋 Catatan Pemeriksaan:</strong><br>
                                            {{ $sapi->catatan_kesehatan }}
                                        </div>
                                    @endif

                                    @if ($sapi->verifier)
                                        <div class="timeline-verifier">
                                            🩺 Diverifikasi oleh: <strong>{{ $sapi->verifier->name }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sistem Penjualan Sapi. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
