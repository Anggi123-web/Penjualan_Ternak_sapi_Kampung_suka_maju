<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail Ternak {{ $sapi->jenis }} — Sistem Penjualan Sapi Kampung Suka Maju">
    <title>Detail Ternak — {{ $sapi->jenis }}</title>

    <!-- CSRF Token for Chat & AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Leaflet CSS for Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <!-- Unified SIPETER Design System & Dark/Light Mode Theme -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <script src="{{ asset('js/theme-manager.js') }}"></script>

    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-green: var(--green-brand, #00A740);
            --primary-green-hover: var(--green-hover, #008f38);
            --bg-card: var(--bg-surface, #ffffff);
            --bg-card-light: var(--bg-muted, #f8fafc);
            --text-dark: var(--text-primary, #0f172a);
            --text-muted: var(--text-muted, #64748b);
            --border-color: var(--border-color, #e2e8f0);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-page, #f8fafc);
            color: var(--text-primary, #0f172a);
            min-height: 100vh;
            line-height: 1.5;
            transition: var(--theme-transition);
        }

        /* ═══ Header / Navbar ═══ */
        .site-header {
            width: 100%;
            border-bottom: 1px solid #f1f5f9;
            background: #ffffff;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Logo matching brand style */
        .logo-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.25rem 0.5rem;
            background-color: transparent;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .logo-box:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .logo-box img {
            height: 52px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        /* Header Auth Navigation */
        .header-auth {
            display: flex;
            align-items: center;
            gap: 2.25rem;
        }

        .auth-link {
            font-family: 'Inter', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: #111827;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .auth-link:hover {
            color: var(--primary-green);
        }

        .cart-badge-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            text-decoration: none;
            color: #111827;
            padding: 0.4rem;
            border-radius: 8px;
            transition: background-color 0.2s ease;
        }

        .cart-badge-btn:hover {
            background-color: #f3f4f6;
            color: var(--primary-green);
        }

        .cart-badge-count {
            position: absolute;
            top: -6px;
            right: -8px;
            background-color: #ef4444;
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 1rem;
            background: #f3f4f6;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #111827;
            text-decoration: none;
        }

        .btn-logout-header {
            background: none;
            border: none;
            color: #ef4444;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            padding: 0.45rem 0.75rem;
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        .btn-logout-header:hover {
            background-color: #fee2e2;
        }

        /* ═══ Page Main Container ═══ */
        .page-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 2rem 5rem;
        }

        /* Breadcrumb / Back Link */
        .back-nav {
            margin-bottom: 1.25rem;
        }

        .back-nav-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-nav-link:hover {
            color: var(--primary-green);
        }

        /* Page Title matching Wireframe: Detail ternak */
        .page-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.9rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 2rem;
            letter-spacing: -0.02em;
        }

        /* Alert notifications */
        .alert-box {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* ═══ Main Two-Column Grid Layout ═══ */
        .detail-grid-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3.5rem;
            align-items: start;
        }

        /* ══════════════════════════════════════════════════════
           LEFT COLUMN: Media (Foto Ternak & Video Ternak)
        ══════════════════════════════════════════════════════ */
        .media-column {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Media Card Containers */
        .media-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .media-slider-box {
            position: relative;
            width: 100%;
            height: 380px;
            background-color: #d8dbe0;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #cbd5e1;
        }

        /* Carousel Slides */
        .slide-item {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s ease, visibility 0.4s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide-item.active {
            opacity: 1;
            visibility: visible;
        }

        .slide-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .slide-item video {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background-color: #000000;
        }

        /* Placeholder text matching wireframe */
        .media-placeholder-label {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.45rem;
            font-weight: 800;
            color: #1e293b;
            text-align: center;
            pointer-events: none;
            user-select: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        /* Carousel Navigation Arrows */
        .slider-arrow-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.4rem;
            font-weight: 700;
            z-index: 10;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
            user-select: none;
        }

        .slider-arrow-btn:hover {
            background: #ffffff;
            color: #000000;
            transform: translateY(-50%) scale(1.08);
        }

        .slider-arrow-prev {
            left: 14px;
        }

        .slider-arrow-next {
            right: 14px;
        }

        /* Carousel Pagination Indicators (Dash + Dots matching wireframe) */
        .pagination-indicators {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 14px;
        }

        .indicator-dot {
            height: 6px;
            border-radius: 3px;
            background-color: #cbd5e1;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 8px;
        }

        .indicator-dot.active {
            width: 32px;
            background-color: #64748b;
        }

        .indicator-dot:hover {
            background-color: #94a3b8;
        }

        /* Health certification badge overlay */
        .health-badge-overlay {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 5;
            padding: 0.4rem 0.9rem;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(6px);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .health-badge-sehat {
            background-color: rgba(0, 167, 64, 0.92);
            color: #ffffff;
        }

        .health-badge-tidak {
            background-color: rgba(239, 68, 68, 0.92);
            color: #ffffff;
        }

        .health-badge-menunggu {
            background-color: rgba(245, 158, 11, 0.92);
            color: #ffffff;
        }

        /* ══════════════════════════════════════════════════════
           RIGHT COLUMN: Specs, Peternak, Lokasi, Actions
        ══════════════════════════════════════════════════════ */
        .info-column {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* 1. Specifications List */
        .specs-list {
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .spec-item {
            display: grid;
            grid-template-columns: 180px 1fr;
            align-items: baseline;
            gap: 1rem;
            font-size: 1.05rem;
        }

        .spec-label {
            font-weight: 700;
            color: #111827;
            font-family: 'Inter', sans-serif;
        }

        .spec-value {
            font-weight: 500;
            color: #374151;
            word-break: break-word;
        }

        .spec-value.harga-highlight {
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--primary-green);
            font-family: 'Montserrat', sans-serif;
        }

        .spec-badge-sale {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .badge-order {
            background-color: #dcfce7;
            color: #15803d;
        }

        .badge-preorder {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        /* Riwayat Budidaya Details Box */
        .riwayat-box {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .riwayat-status-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 700;
            font-size: 0.92rem;
        }

        .riwayat-status-chip.sehat {
            color: #059669;
        }

        .riwayat-status-chip.tidak-sehat {
            color: #dc2626;
        }

        .riwayat-status-chip.menunggu {
            color: #d97706;
        }

        .riwayat-catatan {
            font-size: 0.88rem;
            color: #4b5563;
            background: #f8fafc;
            padding: 0.5rem 0.75rem;
            border-left: 3px solid #cbd5e1;
            border-radius: 4px;
            margin-top: 0.25rem;
            line-height: 1.4;
        }

        .riwayat-verifier {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.15rem;
        }

        .btn-dokumen-pdf {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.5rem 0.9rem;
            background-color: #f0fdf4;
            color: #166534;
            border: 1.5px solid #86efac;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-top: 0.4rem;
        }

        .btn-dokumen-pdf:hover {
            background-color: #dcfce7;
            border-color: #22c55e;
            color: #14532d;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(34, 197, 94, 0.2);
        }

        .dokumen-pdf-notice {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.75rem;
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.4rem;
            line-height: 1.3;
        }

        /* 2. Nama Peternak Card matching wireframe */
        .peternak-card {
            background-color: #d8dbe0;
            border: 1px solid #cbd5e1;
            border-radius: 16px;
            padding: 1.25rem 1.75rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease;
        }

        .peternak-card:hover {
            transform: translateY(-2px);
        }

        .peternak-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background-color: #ffffff;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 2px solid #e2e8f0;
            overflow: hidden;
            font-size: 2.2rem;
            color: #64748b;
        }

        .peternak-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .peternak-info-block {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .peternak-label-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            color: #111827;
        }

        .peternak-name-value {
            font-size: 1rem;
            font-weight: 600;
            color: #374151;
        }

        .peternak-meta-phone {
            font-size: 0.85rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            margin-top: 0.2rem;
        }

        /* 3. Lokasi Ternak Card matching wireframe */
        .lokasi-card {
            background-color: #d8dbe0;
            border: 1px solid #cbd5e1;
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        }

        .lokasi-card-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: #111827;
            text-align: center;
        }

        .lokasi-address-text {
            font-size: 0.95rem;
            color: #374151;
            line-height: 1.5;
            background: rgba(255, 255, 255, 0.6);
            padding: 0.75rem 1rem;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .map-wrapper {
            width: 100%;
            height: 160px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #cbd5e1;
            position: relative;
            z-index: 1;
        }

        .btn-maps-nav {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            background: #ffffff;
            color: #111827;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            margin-top: 0.25rem;
        }

        .btn-maps-nav:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
            color: #000;
        }

        /* 4. Bottom Action Buttons matching wireframe */
        .actions-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-top: 0.5rem;
        }

        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1.15rem 1.5rem;
            border-radius: 14px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1.15rem;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            border: none;
        }

        /* Masukan Keranjang button */
        .btn-keranjang {
            background-color: #d1d5db;
            color: #111827;
            border: 1px solid #9ca3af;
        }

        .btn-keranjang:hover {
            background-color: #9ca3af;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        }

        /* Beli button */
        .btn-beli {
            background-color: #d1d5db;
            color: #111827;
            border: 1px solid #9ca3af;
        }

        .btn-beli:hover {
            background-color: var(--primary-green);
            color: #ffffff;
            border-color: var(--primary-green);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 167, 64, 0.3);
        }

        /* ═══ Footer ═══ */
        .site-footer {
            border-top: 1px solid #f1f5f9;
            padding: 2.5rem 2rem;
            text-align: center;
            font-size: 0.85rem;
            color: #94a3b8;
        }

        /* ═══ Responsive Media Queries ═══ */
        @media (max-width: 900px) {
            .detail-grid-layout {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .header-container {
                padding: 1rem 1.25rem;
            }

            .page-main {
                padding: 1.5rem 1.25rem 3.5rem;
            }

            .page-title {
                font-size: 1.6rem;
            }

            .media-slider-box {
                height: 320px;
            }

            .spec-item {
                grid-template-columns: 140px 1fr;
                font-size: 0.98rem;
            }

            .actions-row {
                grid-template-columns: 1fr;
            }
        }

        /* ═══ Section Ulasan & Reputasi Peternak ═══ */
        .ulasan-section-box {
            margin-top: 3rem;
            background: var(--bg-card, #ffffff);
            border: 1px solid var(--border-color, #e2e8f0);
            border-radius: 20px;
            padding: 2.25rem;
            box-shadow: var(--card-shadow, 0 4px 20px rgba(0,0,0,0.04));
        }

        .ulasan-section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 1.25rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border-color, #f1f5f9);
            padding-bottom: 1.5rem;
        }

        .ulasan-score-pill {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.35);
            padding: 0.65rem 1.15rem;
            border-radius: 14px;
        }

        .ulasan-score-num {
            font-size: 2rem;
            font-weight: 900;
            color: #b45309;
            line-height: 1;
        }

        .ulasan-score-label {
            font-size: 0.78rem;
            color: #92400e;
            font-weight: 700;
            margin-top: 3px;
        }

        [data-theme="dark"] .ulasan-score-num {
            color: #fcd34d;
        }

        [data-theme="dark"] .ulasan-score-label {
            color: #fde68a;
        }

        .ulasan-reviews-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
            gap: 1.25rem;
        }

        .ulasan-card-item {
            background: var(--bg-surface, #f8fafc);
            border: 1px solid var(--border-color, #e2e8f0);
            border-radius: 14px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .ulasan-buyer-name {
            color: var(--text-heading, #1e293b);
            font-size: 0.92rem;
            display: block;
            font-weight: 700;
        }

        .ulasan-meta-date {
            font-size: 0.75rem;
            color: var(--text-secondary, #64748b);
        }

        .ulasan-tag-badge {
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
            font-size: 0.72rem;
            padding: 2px 8px;
            border-radius: 999px;
            font-weight: 700;
        }

        [data-theme="dark"] .ulasan-tag-badge {
            color: #6ee7b7;
        }

        .ulasan-comment-text {
            margin: 0;
            color: var(--text-primary, #334155);
            font-size: 0.88rem;
            line-height: 1.5;
            font-style: italic;
        }

        .ulasan-reply-box {
            margin-top: 0.85rem;
            padding: 0.6rem 0.85rem;
            border-top: 1px dashed var(--border-color, #cbd5e1);
            font-size: 0.8rem;
            color: #047857;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 8px;
        }

        [data-theme="dark"] .ulasan-reply-box {
            color: #6ee7b7;
        }

        .ulasan-empty-state {
            text-align: center;
            padding: 2.5rem 1rem;
            background: var(--bg-surface, #f8fafc);
            border-radius: 14px;
            border: 1px dashed var(--border-color, #cbd5e1);
        }

        .ulasan-empty-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-heading, #334155);
            margin-top: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .ulasan-empty-desc {
            color: var(--text-secondary, #64748b);
            font-size: 0.88rem;
            margin: 0;
        }

        .btn-sapi-terjual {
            width: 100%;
            height: 52px;
            background: var(--bg-muted, #f1f5f9);
            color: var(--text-secondary, #64748b);
            border: 2px dashed var(--border-color, #cbd5e1);
            border-radius: 12px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.95rem;
            font-weight: 800;
            cursor: not-allowed;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .ulasan-section-box {
                margin-top: 2rem;
                padding: 1.25rem 1rem;
                border-radius: 14px;
            }

            .ulasan-section-header {
                flex-direction: column;
                gap: 1rem;
                margin-bottom: 1.25rem;
                padding-bottom: 1.25rem;
            }

            .ulasan-reviews-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .peternak-card {
                padding: 1rem;
                gap: 1rem;
            }

            .peternak-avatar {
                width: 54px;
                height: 54px;
            }
        }
    </style>
</head>
<body>

    {{-- ═══ Header / Navbar ═══ --}}
    <header class="site-header">
        <div class="header-container">
            <!-- LOGO Box matching wireframe -->
            <a href="{{ route('katalog.index') }}" class="logo-box" title="Kembali ke Beranda / Katalog">
                @if(file_exists(public_path('images/sipeter_logo.png')))
                    <img src="{{ asset('images/sipeter_logo.png') }}" class="sipeter-brand-logo" alt="SIPETER Logo">
                @else
                    LOGO
                @endif
            </a>

            <!-- Register / Login or User Session -->
            <div class="header-auth" style="display: flex; align-items: center; gap: 12px;">
                @include('partials.theme_toggle', ['id' => 'katalogShowThemeToggle'])
                @auth
                    @if(auth()->user()->role === 'pembeli')
                        @php
                            $keranjangCount = \App\Models\Keranjang::where('user_id', auth()->id())->count();
                        @endphp
                        <a href="{{ route('pembeli.keranjang.index') }}" class="cart-badge-btn" title="Keranjang Belanja">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                            @if($keranjangCount > 0)
                                <span class="cart-badge-count">{{ $keranjangCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('pembeli.dashboard') }}" class="user-pill">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                    @else
                        @php
                            $dashboardRoute = match(auth()->user()->role) {
                                'peternak' => route('peternak.dashboard'),
                                'mantri_hewan' => route('mantri_hewan.dashboard'),
                                'pengurus_kampung' => route('pengurus_kampung.dashboard'),
                                default => '/'
                            };
                        @endphp
                        <a href="{{ $dashboardRoute }}" class="user-pill">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" style="display: inline; margin: 0;">
                        @csrf
                        <button type="submit" class="btn-logout-header">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="auth-link">Register</a>
                    <a href="{{ route('login') }}" class="auth-link">Login</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- ═══ Main Page Content ═══ --}}
    <main class="page-main">
        <!-- Back Navigation -->
        <div class="back-nav">
            <a href="{{ route('katalog.index') }}" class="back-nav-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Kembali ke Katalog
            </a>
        </div>

        <!-- Title matching wireframe: Detail ternak -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
            <h1 class="page-title" style="margin-bottom: 0;">Detail ternak</h1>
            @if($sapi->is_terjual)
                <span style="background: #fee2e2; color: #dc2626; border: 1.5px solid #fca5a5; padding: 0.4rem 1.1rem; border-radius: 999px; font-weight: 800; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.05em; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="bi bi-bag-check-fill"></i> Status: Terjual / Dipesan
                </span>
            @else
                <span style="background: #ecfdf5; color: #059669; border: 1.5px solid #a7f3d0; padding: 0.4rem 1.1rem; border-radius: 999px; font-weight: 800; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.05em; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="bi bi-check-circle-fill"></i> Status: Tersedia
                </span>
            @endif
        </div>

        <!-- Flash messages -->
        @if(session('success'))
            <div class="alert-box alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-box alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="detail-grid-layout">
            
            {{-- ══════════════════════════════════════════════════════
               KOLOM KIRI: Media (Foto Ternak & Video Ternak)
            ══════════════════════════════════════════════════════ --}}
            <div class="media-column">

                {{-- 1. FOTO TERNAK CAROUSEL --}}
                <div class="media-card">
                    <div class="media-slider-box" id="photoSliderBox">
                        @php
                            $fotoList = is_array($sapi->foto) ? $sapi->foto : ($sapi->foto ? [$sapi->foto] : []);
                            $totalFotos = count($fotoList);
                        @endphp

                        @if($totalFotos > 0)
                            @foreach($fotoList as $index => $foto)
                                <div class="slide-item photo-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto Ternak {{ $sapi->jenis }} - {{ $index + 1 }}">
                                </div>
                            @endforeach
                        @else
                            <div class="slide-item photo-slide active">
                                <div class="media-placeholder-label">
                                    <i class="bi bi-image" style="font-size: 3.5rem; color: #94a3b8;"></i>
                                    <span>Foto ternak</span>
                                </div>
                            </div>
                        @endif

                        {{-- Sold Overlay Badge if ordered/sold --}}
                        @if($sapi->is_terjual)
                            <div style="position: absolute; top: 1rem; left: 1rem; z-index: 10; background: rgba(220, 38, 38, 0.95); color: white; padding: 0.45rem 1rem; border-radius: 8px; font-weight: 800; font-size: 0.85rem; letter-spacing: 0.05em; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35); text-transform: uppercase;">
                                <i class="bi bi-bag-check-fill"></i> Terjual / Dipesan
                            </div>
                        @endif

                        <!-- Health Verification Status Overlay Badge -->
                        @if ($sapi->status_kesehatan === 'sehat')
                            <div class="health-badge-overlay health-badge-sehat">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>Tersertifikasi Sehat</span>
                            </div>
                        @elseif ($sapi->status_kesehatan === 'tidak_sehat')
                            <div class="health-badge-overlay health-badge-tidak">
                                <span><i class="bi bi-x-circle-fill"></i> Tidak Lolos Uji</span>
                            </div>
                        @else
                            <div class="health-badge-overlay health-badge-menunggu">
                                <span><i class="bi bi-hourglass-split"></i> Menunggu Verifikasi</span>
                            </div>
                        @endif

                        <!-- Carousel Navigation Arrows -->
                        <button type="button" class="slider-arrow-btn slider-arrow-prev" onclick="movePhotoSlide(-1)" aria-label="Foto Sebelumnya" style="{{ $totalFotos <= 1 ? 'opacity: 0.45; cursor: default;' : '' }}">&lt;</button>
                        <button type="button" class="slider-arrow-btn slider-arrow-next" onclick="movePhotoSlide(1)" aria-label="Foto Berikutnya" style="{{ $totalFotos <= 1 ? 'opacity: 0.45; cursor: default;' : '' }}">&gt;</button>
                    </div>

                    <!-- Pagination Indicators below photo matching wireframe -->
                    <div class="pagination-indicators" id="photoIndicators">
                        @if($totalFotos > 1)
                            @for($i = 0; $i < $totalFotos; $i++)
                                <div class="indicator-dot photo-dot {{ $i === 0 ? 'active' : '' }}" onclick="goToPhotoSlide({{ $i }})"></div>
                            @endfor
                        @else
                            <div class="indicator-dot photo-dot active"></div>
                            <div class="indicator-dot photo-dot"></div>
                            <div class="indicator-dot photo-dot"></div>
                        @endif
                    </div>
                </div>

                {{-- 2. VIDEO TERNAK CAROUSEL --}}
                <div class="media-card">
                    <div class="media-slider-box" id="videoSliderBox">
                        @php
                            $videoList = is_array($sapi->video) ? $sapi->video : ($sapi->video ? [$sapi->video] : []);
                            $totalVideos = count($videoList);
                        @endphp

                        @if($totalVideos > 0)
                            @foreach($videoList as $index => $video)
                                <div class="slide-item video-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                                    <video controls preload="metadata">
                                        <source src="{{ asset('storage/' . $video) }}" type="video/mp4">
                                        Browser Anda tidak mendukung pemutar video.
                                    </video>
                                </div>
                            @endforeach
                        @else
                            <div class="slide-item video-slide active">
                                <div class="media-placeholder-label">
                                    <span style="font-size: 3.5rem;">🎥</span>
                                    <span>Video Ternak</span>
                                </div>
                            </div>
                        @endif

                        <!-- Carousel Navigation Arrows for Video -->
                        <button type="button" class="slider-arrow-btn slider-arrow-prev" onclick="moveVideoSlide(-1)" aria-label="Video Sebelumnya" style="{{ $totalVideos <= 1 ? 'opacity: 0.45; cursor: default;' : '' }}">&lt;</button>
                        <button type="button" class="slider-arrow-btn slider-arrow-next" onclick="moveVideoSlide(1)" aria-label="Video Berikutnya" style="{{ $totalVideos <= 1 ? 'opacity: 0.45; cursor: default;' : '' }}">&gt;</button>
                    </div>

                    <!-- Pagination Indicators below video matching wireframe -->
                    <div class="pagination-indicators" id="videoIndicators">
                        @if($totalVideos > 1)
                            @for($i = 0; $i < $totalVideos; $i++)
                                <div class="indicator-dot video-dot {{ $i === 0 ? 'active' : '' }}" onclick="goToVideoSlide({{ $i }})"></div>
                            @endfor
                        @else
                            <div class="indicator-dot video-dot active"></div>
                            <div class="indicator-dot video-dot"></div>
                            <div class="indicator-dot video-dot"></div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- ══════════════════════════════════════════════════════
               KOLOM KANAN: Spesifikasi, Peternak, Lokasi, Aksi
            ══════════════════════════════════════════════════════ --}}
            <div class="info-column">

                {{-- ═══ BANNER PERINGATAN JIKA SUDAH TERJUAL / DIPESAN ═══ --}}
                @if($sapi->is_terjual)
                    <div class="sold-alert-card" style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border: 2px solid #f87171; border-radius: 16px; padding: 1.25rem 1.4rem; margin-bottom: 1.25rem; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.08);">
                        <div style="display: flex; align-items: flex-start; gap: 14px;">
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: #dc2626; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);">
                                <i class="bi bi-bag-check-fill"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                                    <span style="background: #dc2626; color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em;">
                                        TERJUAL / SUDAH DIPESAN
                                    </span>
                                    <span style="font-size: 0.8rem; color: #991b1b; font-weight: 600;">(1 Katalog = 1 Kali Pembelian)</span>
                                </div>
                                <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1.05rem; font-weight: 800; color: #991b1b; margin: 0 0 4px 0;">
                                    Ternak Sapi Ini Telah Dipesan
                                </h4>
                                <p style="font-size: 0.86rem; color: #7f1d1d; margin: 0; line-height: 1.45;">
                                    Katalog ini sudah dipesan atau terjual kepada pembeli dan tidak lagi dapat ditambahkan ke keranjang atau dibeli ulang. Anda dapat melihat arsip detail historis di bawah ini atau menelusuri katalog sapi lain yang masih tersedia.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($sapi->is_preorder)
                    {{-- ═══ BANNER INFORMASI KHUSUS PRE-ORDER ═══ --}}
                    <div class="preorder-info-banner" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1.5px solid #fde68a; border-radius: 16px; padding: 1.25rem 1.4rem; margin-bottom: 0.5rem; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.08);">
                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; margin-bottom: 0.75rem;">
                            <span style="display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 5px 14px; border-radius: 30px; font-size: 0.82rem; font-weight: 800; letter-spacing: 0.03em; text-transform: uppercase; box-shadow: 0 2px 6px rgba(217, 119, 6, 0.3);">
                                <i class="bi bi-clock-history"></i> Sistem Pre-Order (PO)
                            </span>
                            @if($sapi->preorder_bulan)
                                <span style="font-size: 0.85rem; font-weight: 700; color: #92400e; background: #fff; padding: 4px 10px; border-radius: 8px; border: 1px solid #fde68a;">
                                    <i class="bi bi-calendar-check-fill" style="color: #f59e0b;"></i> Siap: {{ $sapi->preorder_label }} {{ $sapi->preorder_tahun }}
                                </span>
                            @endif
                        </div>
                        
                        <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 800; color: #78350f; margin: 0 0 0.45rem 0;">
                            Ternak Sapi Pre-Order dengan Pemeliharaan Terjamin
                        </h4>
                        
                        <p style="font-size: 0.9rem; color: #92400e; line-height: 1.55; margin: 0 0 0.9rem 0;">
                            Sapi ini dipesan lebih awal dan dirawat secara intensif di kandang peternak hingga tanggal penjemputan atau pengantaran yang Anda tentukan pada rincian pembelian.
                        </p>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 0.75rem; background: rgba(255, 255, 255, 0.85); padding: 0.85rem 1rem; border-radius: 12px; border: 1px dashed #fcd34d;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                                    🌾
                                </div>
                                <div style="font-size: 0.84rem; color: #78350f; line-height: 1.4;">
                                    <strong style="color: #92400e;">Biaya Perawatan:</strong><br>
                                    <span style="color: #b45309; font-weight: 800; font-size: 0.92rem;">{{ $sapi->biaya_perawatan_harian_formatted }} / hari</span><br>
                                    <span style="font-size: 0.76rem; color: #a16207;">(Pakan hijau, nutrisi, & kesehatan)</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                                    🗓️
                                </div>
                                <div style="font-size: 0.84rem; color: #78350f; line-height: 1.4;">
                                    <strong style="color: #92400e;">Jadwal Fleksibel:</strong><br>
                                    <span style="color: #1e293b; font-weight: 700;">Ditentukan Pembeli</span><br>
                                    <span style="font-size: 0.76rem; color: #a16207;">(Input tanggal di pembayaran)</span>
                                </div>
                            </div>
                        </div>


                    </div>
                @endif

                {{-- 1. DAFTAR SPESIFIKASI INFORMASI TERNAK --}}
                <div class="specs-list">
                    <div class="spec-item">
                        <span class="spec-label">Jenis</span>
                        <span class="spec-value">{{ $sapi->jenis }}</span>
                    </div>

                    @if($sapi->is_preorder)
                    <div class="spec-item">
                        <span class="spec-label">Biaya Perawatan</span>
                        <span class="spec-value" style="color: #b45309; font-weight: 700;">
                            {{ $sapi->biaya_perawatan_harian_formatted }} / hari
                        </span>
                    </div>
                    @endif

                    <div class="spec-item">
                        <span class="spec-label">Umur</span>
                        <span class="spec-value">{{ $sapi->umur_formatted }}</span>
                    </div>

                    <div class="spec-item">
                        <span class="spec-label">Bobot</span>
                        <span class="spec-value">{{ number_format($sapi->bobot, 0) }} kg</span>
                    </div>

                    <div class="spec-item">
                        <span class="spec-label">Harga</span>
                        <span class="spec-value harga-highlight">{{ $sapi->harga_formatted }}</span>
                    </div>

                    <div class="spec-item">
                        <span class="spec-label">Tipe Penjualan</span>
                        <span class="spec-value">
                            @if($sapi->is_preorder)
                                <span class="spec-badge-sale badge-preorder">Pre-Order</span>
                                @if($sapi->preorder_bulan)
                                    <span style="font-size: 0.9rem; color: #64748b; margin-left: 0.35rem;">({{ $sapi->preorder_label }} {{ $sapi->preorder_tahun }})</span>
                                @endif
                            @else
                                <span class="spec-badge-sale badge-order">Order (Siap Kirim)</span>
                            @endif
                        </span>
                    </div>

                    <div class="spec-item">
                        <span class="spec-label">Status Ketersediaan</span>
                        <span class="spec-value">
                            @if($sapi->is_terjual)
                                <span style="display: inline-flex; align-items: center; gap: 5px; background: #fee2e2; color: #dc2626; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.85rem;">
                                    <i class="bi bi-x-circle-fill"></i> Terjual / Sudah Dipesan
                                </span>
                            @else
                                <span style="display: inline-flex; align-items: center; gap: 5px; background: #dcfce7; color: #16a34a; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.85rem;">
                                    <i class="bi bi-check-circle-fill"></i> Tersedia (Siap Transaksi)
                                </span>
                            @endif
                        </span>
                    </div>

                    <div class="spec-item">
                        <span class="spec-label">Riwayat Budidaya</span>
                        <div class="spec-value riwayat-box">
                            @if ($sapi->status_kesehatan === 'sehat')
                                <span class="riwayat-status-chip sehat">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Layak Budidaya (Tersertifikasi Sehat)
                                </span>
                            @elseif ($sapi->status_kesehatan === 'tidak_sehat')
                                <span class="riwayat-status-chip tidak-sehat">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    Tidak Lolos Verifikasi Kesehatan
                                </span>
                            @else
                                <span class="riwayat-status-chip menunggu">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    Menunggu Pemeriksaan Mantri Hewan
                                </span>
                            @endif

                            @if($sapi->catatan_kesehatan)
                                <div class="riwayat-catatan">
                                    <strong>Catatan Pemeriksaan:</strong> {{ $sapi->catatan_kesehatan }}
                                </div>
                            @endif

                            @if($sapi->verifier)
                                <div class="riwayat-verifier">
                                    🩺 Dokter/Mantri Hewan: <strong>{{ $sapi->verifier->name }}</strong>
                                    @if($sapi->verified_at)
                                        ({{ $sapi->verified_at->format('d M Y') }})
                                    @endif
                                </div>
                            @endif

                            {{-- Dokumen Pemeriksaan PDF oleh Dokter Hewan --}}
                            @if($sapi->dokumen_pemeriksaan)
                                <div style="margin-top: 0.6rem;">
                                    <a href="{{ asset('storage/' . $sapi->dokumen_pemeriksaan) }}" target="_blank" rel="noopener noreferrer" class="btn-dokumen-pdf">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                        <span>Lihat Dokumen Pemeriksaan Dokter Hewan (PDF)</span>
                                    </a>
                                </div>
                            @else
                                <div class="dokumen-pdf-notice">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                    <span>Dokumen pemeriksaan akan diunggah oleh Dokter Hewan dalam bentuk PDF</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="spec-item">
                        <span class="spec-label">Tanggal di tambahkan</span>
                        <span class="spec-value">{{ $sapi->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                {{-- 2. KARTU NAMA PETERNAK (Matching Wireframe) --}}
                <div class="peternak-card">
                    <div class="peternak-avatar">
                        @if($sapi->peternak && !empty($sapi->peternak->avatar))
                            <img src="{{ asset('storage/' . $sapi->peternak->avatar) }}" alt="{{ $sapi->peternak->name }}">
                        @else
                            <i class="bi bi-person-fill"></i>
                        @endif
                    </div>
                    <div class="peternak-info-block" style="flex: 1;">
                        <span class="peternak-label-title">Nama Peternak</span>
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 2px;">
                            <span class="peternak-name-value">{{ $sapi->peternak->name ?? 'Peternak Kampung Suka Maju' }}</span>
                            @if(($peternakTotalUlasan ?? 0) > 0)
                                <a href="#ulasan-peternak" style="text-decoration: none; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.4); color: var(--amber-dark, #b45309); padding: 2px 8px; border-radius: 999px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i> {{ $peternakAvgRating }} ({{ $peternakTotalUlasan }} Ulasan)
                                </a>
                            @else
                                <span style="background: var(--bg-muted, #f1f5f9); color: var(--text-secondary, #64748b); border: 1px solid var(--border-color, #cbd5e1); padding: 2px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: 600;">
                                    Peternak Baru
                                </span>
                            @endif
                        </div>
                        @if($sapi->peternak && $sapi->peternak->no_telepon)
                            <span class="peternak-meta-phone">
                                <i class="bi bi-telephone-fill"></i>
                                {{ $sapi->peternak->no_telepon }}
                            </span>
                        @endif
                    </div>
                    @if($sapi->peternak)
                        <div>
                            @auth
                                <button type="button" onclick="openChatWith({{ $sapi->peternak->id }}, '{{ addslashes($sapi->peternak->name) }}', 'Peternak', null, {{ $sapi->id }}, 'Sapi {{ addslashes($sapi->jenis) }}', '{{ $totalFotos > 0 ? asset('storage/'.$fotoList[0]) : asset('images/default_sapi.jpg') }}')" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; padding: 0.6rem 1.1rem; border-radius: 10px; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);">
                                    <i class="bi bi-chat-dots-fill"></i> Chat
                                </button>
                            @else
                                <a href="{{ route('login') }}" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; padding: 0.6rem 1.1rem; border-radius: 10px; font-weight: 700; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="bi bi-chat-dots-fill"></i> Chat
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>

                {{-- 3. KARTU LOKASI TERNAK (Peta di atas, Alamat tertulis di bawahnya) --}}
                @php
                    $mapLat = $sapi->latitude ?? ($sapi->peternak->latitude ?? -6.9175);
                    $mapLng = $sapi->longitude ?? ($sapi->peternak->longitude ?? 107.6191);
                    $alamatPeternak = $sapi->lokasi ?? ($sapi->peternak->alamat ?? 'Dusun Suka Maju, RT 02 / RW 04, Desa Suka Maju, Kec. Peternakan');
                @endphp
                <div class="lokasi-card">
                    <h3 class="lokasi-card-title">Lokasi Ternak</h3>

                    <!-- Peta Menunjukkan Lokasi Peternak -->
                    <div class="map-wrapper" id="map"></div>

                    <!-- Alamat Tertulis di Bawah Petanya -->
                    <div class="lokasi-address-text">
                        <div style="font-weight: 700; color: var(--text-heading, #111827); margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.4rem;">
                            <i class="bi bi-geo-alt-fill" style="color: #ef4444;"></i>
                            <span>Alamat Peternak:</span>
                        </div>
                        <div style="color: var(--text-primary, #374151); font-size: 0.95rem; line-height: 1.5;">
                            {{ $alamatPeternak }}
                        </div>
                    </div>

                    <a href="https://www.google.com/maps/search/?api=1&query={{ $mapLat }},{{ $mapLng }}" target="_blank" rel="noopener noreferrer" class="btn-maps-nav">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                        Buka Petunjuk Arah di Google Maps
                    </a>
                </div>

                {{-- 4. TOMBOL AKSI: MASUKAN KERANJANG & BELI (Matching Wireframe) --}}
                @if($sapi->is_terjual)
                    <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.85rem;">
                        <button type="button" class="btn-sapi-terjual" disabled>
                            <i class="bi bi-lock-fill" style="color: #ef4444; font-size: 1.15rem;"></i>
                            Sapi Ini Sudah Terjual (Tidak Dapat Dipesan)
                        </button>

                        <a href="{{ route('katalog.index') }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 46px; background: #00A740; color: #ffffff; text-decoration: none; border-radius: 10px; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 0.92rem; box-shadow: 0 2px 8px rgba(0, 167, 64, 0.25); transition: background-color 0.2s;">
                            <i class="bi bi-arrow-left"></i> Lihat Katalog Sapi Tersedia Lainnya
                        </a>
                    </div>
                @else
                    <div class="actions-row">
                        <!-- Form Masukan Keranjang -->
                        @if(!auth()->check())
                            <a href="{{ route('login') }}" class="btn-action btn-keranjang" onclick="alert('Silakan login terlebih dahulu untuk menambahkan ternak ke keranjang belanja.');">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                Masukan Keranjang
                            </a>
                            <a href="{{ route('pembayaran.show', $sapi->id) }}" class="btn-action btn-beli">
                                Beli
                            </a>
                        @elseif(auth()->user()->role === 'pembeli')
                            <form action="{{ route('pembeli.keranjang.store') }}" method="POST" style="margin: 0; display: contents;">
                                @csrf
                                <input type="hidden" name="sapi_id" value="{{ $sapi->id }}">
                                <button type="submit" class="btn-action btn-keranjang">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                    Masukan Keranjang
                                </button>
                            </form>

                            <a href="{{ route('pembayaran.show', $sapi->id) }}" class="btn-action btn-beli">
                                Beli
                            </a>
                        @else
                            <button type="button" class="btn-action btn-keranjang" onclick="showRoleWarning('keranjang')" title="Hanya akun pembeli yang dapat membeli" style="cursor: pointer;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                Masukan Keranjang
                            </button>
                            <button type="button" class="btn-action btn-beli" onclick="showRoleWarning('beli')" title="Hanya akun pembeli yang dapat membeli" style="cursor: pointer;">
                                Beli
                            </button>
                        @endif
                    </div>
                @endif

            </div>

        </div>

        {{-- ═══ SECTION ULASAN & REPUTASI PETERNAK ═══ --}}
        <section id="ulasan-peternak" class="ulasan-section-box">
            <div class="ulasan-section-header">
                <div>
                    <h2 style="font-family: 'Montserrat', sans-serif; font-size: clamp(1.2rem, 3vw, 1.45rem); font-weight: 800; color: var(--text-heading, #111827); margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-star-fill" style="color: #f59e0b;"></i> Ulasan & Reputasi Peternak
                    </h2>
                    <p style="color: var(--text-secondary, #64748b); font-size: 0.9rem; margin-top: 4px; margin-bottom: 0;">
                        Testimoni kepuasan pembeli sapi dari <strong>{{ $sapi->peternak->name ?? 'Peternak Suka Maju' }}</strong>
                    </p>
                </div>

                {{-- Rating Summary Pill --}}
                <div class="ulasan-score-pill">
                    <div class="ulasan-score-num">
                        {{ $peternakAvgRating ?? 0 }}
                    </div>
                    <div>
                        <div style="color: #f59e0b; font-size: 1rem; line-height: 1;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= round($peternakAvgRating ?? 0) ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <div class="ulasan-score-label">
                            {{ $peternakTotalUlasan ?? 0 }} Ulasan Terverifikasi
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($peternakUlasans) && $peternakUlasans->count() > 0)
                <div class="ulasan-reviews-grid">
                    @foreach($peternakUlasans as $review)
                        <div class="ulasan-card-item">
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; margin-bottom: 0.75rem;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #10b981, #059669); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;">
                                            {{ strtoupper(substr($review->pembeli->name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong class="ulasan-buyer-name">
                                                {{ $review->pembeli->name ?? 'Pembeli' }}
                                            </strong>
                                            <span class="ulasan-meta-date">
                                                Membeli {{ $review->sapi->jenis ?? 'Ternak Sapi' }} &bull; {{ $review->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div style="color: #f59e0b; font-size: 0.88rem; white-space: nowrap;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                </div>

                                @if(!empty($review->kategori) && is_array($review->kategori))
                                    <div style="display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 0.65rem;">
                                        @foreach($review->kategori as $cat)
                                            <span class="ulasan-tag-badge">
                                                <i class="bi bi-check2"></i> {{ $cat }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <p class="ulasan-comment-text">
                                    "{{ $review->komentar }}"
                                </p>

                                @if($review->foto)
                                    <div style="margin-top: 8px;">
                                        <img src="{{ asset('storage/' . $review->foto) }}" alt="Foto Ulasan" style="max-height: 70px; border-radius: 6px; border: 1px solid var(--border-color, #cbd5e1); object-fit: cover;">
                                    </div>
                                @endif
                            </div>

                            @if($review->balasan_peternak)
                                <div class="ulasan-reply-box">
                                    <strong><i class="bi bi-reply-fill"></i> Balasan Peternak:</strong>
                                    <div style="margin-top: 2px; font-style: italic;">"{{ $review->balasan_peternak }}"</div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="ulasan-empty-state">
                    <i class="bi bi-chat-heart" style="font-size: 2.5rem; color: var(--text-muted, #94a3b8);"></i>
                    <h3 class="ulasan-empty-title">Belum Ada Ulasan untuk Peternak Ini</h3>
                    <p class="ulasan-empty-desc">Jadilah pembeli pertama yang memberikan ulasan setelah pesanan Anda selesai!</p>
                </div>
            @endif
        </section>
    </main>

    {{-- ═══ Footer ═══ --}}
    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} Sistem Penjualan Ternak Sapi Kampung Suka Maju. All rights reserved.</p>
    </footer>

    <!-- Leaflet JS for Maps -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lat = {{ $mapLat }};
            const lng = {{ $mapLng }};
            
            const map = L.map('map', {
                scrollWheelZoom: false
            }).setView([lat, lng], 14);

            L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Google Maps Satelit'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup('<b>Lokasi Peternak: {{ addslashes($sapi->peternak->name ?? "Peternak") }}</b><br>{{ addslashes($alamatPeternak) }}')
                .openPopup();
        });
    </script>

    <!-- Carousel Logic for Foto and Video -->
    <script>
        // ─── FOTO SLIDER LOGIC ───
        let currentPhotoIndex = 0;
        const photoSlides = document.querySelectorAll('.photo-slide');
        const photoDots = document.querySelectorAll('.photo-dot');

        function showPhotoSlide(index) {
            if (photoSlides.length <= 1) return;
            photoSlides[currentPhotoIndex].classList.remove('active');
            if (photoDots[currentPhotoIndex]) {
                photoDots[currentPhotoIndex].classList.remove('active');
            }

            currentPhotoIndex = (index + photoSlides.length) % photoSlides.length;

            photoSlides[currentPhotoIndex].classList.add('active');
            if (photoDots[currentPhotoIndex]) {
                photoDots[currentPhotoIndex].classList.add('active');
            }
        }

        function movePhotoSlide(step) {
            showPhotoSlide(currentPhotoIndex + step);
        }

        function goToPhotoSlide(index) {
            showPhotoSlide(index);
        }

        // ─── VIDEO SLIDER LOGIC ───
        let currentVideoIndex = 0;
        const videoSlides = document.querySelectorAll('.video-slide');
        const videoDots = document.querySelectorAll('.video-dot');

        function showVideoSlide(index) {
            if (videoSlides.length <= 1) return;

            // Pause any running video on previous slide
            const prevVideo = videoSlides[currentVideoIndex].querySelector('video');
            if (prevVideo) {
                prevVideo.pause();
            }

            videoSlides[currentVideoIndex].classList.remove('active');
            if (videoDots[currentVideoIndex]) {
                videoDots[currentVideoIndex].classList.remove('active');
            }

            currentVideoIndex = (index + videoSlides.length) % videoSlides.length;

            videoSlides[currentVideoIndex].classList.add('active');
            if (videoDots[currentVideoIndex]) {
                videoDots[currentVideoIndex].classList.add('active');
            }
        }

        function moveVideoSlide(step) {
            showVideoSlide(currentVideoIndex + step);
        }

        function goToVideoSlide(index) {
            showVideoSlide(index);
        }

        // ─── DIRECT BUY ACTION ───
        function handleDirectBuy() {
            if (confirm('Lanjutkan pemesanan langsung untuk ternak {{ $sapi->jenis }} seharga {{ $sapi->harga_formatted }}?')) {
                // If user confirms direct buy, submit to cart and redirect to cart/checkout
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('pembeli.keranjang.store') }}";

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = "{{ csrf_token() }}";
                form.appendChild(csrfToken);

                const sapiInput = document.createElement('input');
                sapiInput.type = 'hidden';
                sapiInput.name = 'sapi_id';
                sapiInput.value = "{{ $sapi->id }}";
                form.appendChild(sapiInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // ─── ROLE WARNING MODAL FOR NON-BUYER USERS ───
        function showRoleWarning(actionName) {
            const modal = document.getElementById('roleWarningModal');
            if (modal) {
                modal.style.display = 'flex';
            } else {
                alert('Akun Anda saat ini login sebagai {{ auth()->check() ? ucfirst(auth()->user()->role) : "Non-Pembeli" }}. Fitur ' + actionName + ' ternak hanya dapat dilakukan menggunakan akun Pembeli. Silakan ganti ke akun Pembeli untuk memesan.');
            }
        }

        function closeRoleWarning() {
            const modal = document.getElementById('roleWarningModal');
            if (modal) modal.style.display = 'none';
        }
    </script>

    {{-- Modal Role Warning --}}
    @auth
    <div id="roleWarningModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closeRoleWarning()">
        <div style="background: white; border-radius: 16px; max-width: 460px; width: 100%; padding: 1.75rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); text-align: center;" onclick="event.stopPropagation()">
            <div style="width: 56px; height: 56px; background: #fef2f2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1rem;">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;">
                Fitur Khusus Akun Pembeli
            </h3>
            <p style="color: #64748b; font-size: 0.92rem; line-height: 1.6; margin-bottom: 1.5rem;">
                Saat ini Anda sedang login sebagai akun <strong>{{ ucfirst(auth()->user()->role) }}</strong> ({{ auth()->user()->name }}). Transaksi pembelian sapi dan penambahan ke keranjang belanja hanya dapat dilakukan melalui akun dengan role <strong>Pembeli</strong>.
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" onclick="closeRoleWarning()" style="padding: 0.6rem 1.25rem; border-radius: 10px; border: 1px solid #cbd5e1; background: white; color: #475569; font-weight: 600; cursor: pointer;">
                    Tutup
                </button>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="padding: 0.6rem 1.25rem; border-radius: 10px; border: none; background: #00A740; color: white; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="bi bi-box-arrow-right"></i> Ganti ke Akun Pembeli
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endauth

    @include('partials.chat_box')
</body>
</html>
