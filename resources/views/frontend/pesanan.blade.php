@extends('layouts.frontend')

@section('title', 'Monitoring Pemesanan Sapi — SIPETER Suka Maju')

@section('content')
<style>
    :root {
        --tracker-done: #10b981;
        --tracker-active: #3b82f6;
        --tracker-pending: #cbd5e1;
        --green-brand: #00A740;
    }

    .pesanan-page-container {
        padding-top: 105px;
        padding-bottom: 60px;
        max-width: 1200px;
        margin: 0 auto;
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }

    /* ═══ Header Ringkas & Modern ═══ */
    .pesanan-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 16px;
        padding: 1.75rem 2rem;
        color: white;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
    }

    .pesanan-header::after {
        content: '';
        position: absolute;
        right: -30px;
        top: -30px;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(0, 167, 64, 0.22) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .pesanan-header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .pesanan-header-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(0, 167, 64, 0.2);
        color: #4ade80;
        border: 1px solid rgba(74, 222, 128, 0.3);
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        font-family: var(--font-montserrat);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .pesanan-header-title {
        font-family: var(--font-montserrat);
        font-size: clamp(1.35rem, 3vw, 1.85rem);
        font-weight: 800;
        margin: 0 0 0.35rem 0;
        color: #ffffff;
        letter-spacing: -0.01em;
    }

    .pesanan-header-desc {
        color: #94a3b8;
        font-size: 0.9rem;
        max-width: 680px;
        margin: 0;
        line-height: 1.5;
    }

    /* Stats bar: Compact horizontal layout */
    .pesanan-stats-bar {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 0.75rem;
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .stat-mini-pill {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 10px;
        padding: 0.55rem 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.55rem;
        transition: transform 0.15s ease;
    }

    .stat-mini-pill:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .stat-mini-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .stat-mini-content span {
        display: block;
        font-size: 0.68rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        font-weight: 600;
        white-space: nowrap;
    }

    .stat-mini-content strong {
        font-size: 1.1rem;
        color: white;
        font-family: var(--font-montserrat);
        font-weight: 800;
        line-height: 1;
    }

    /* ═══ Filter Tabs ═══ */
    .pesanan-tabs-wrapper {
        position: relative;
        margin-bottom: 1.25rem;
    }

    .pesanan-tabs {
        display: flex;
        gap: 0.4rem;
        overflow-x: auto;
        padding-bottom: 4px;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }

    .pesanan-tabs::-webkit-scrollbar {
        display: none;
    }

    .pesanan-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.5rem 1rem;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        color: #475569;
        font-size: 0.85rem;
        font-weight: 600;
        font-family: var(--font-montserrat);
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .pesanan-tab-btn:hover {
        border-color: var(--green-brand);
        color: var(--green-brand);
        background: rgba(0, 167, 64, 0.04);
    }

    .pesanan-tab-btn.active {
        background: var(--green-brand);
        color: white;
        border-color: var(--green-brand);
        box-shadow: 0 4px 10px rgba(0, 167, 64, 0.22);
    }

    .pesanan-tab-count {
        background: rgba(0, 0, 0, 0.06);
        padding: 1px 6px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .pesanan-tab-btn.active .pesanan-tab-count {
        background: rgba(255, 255, 255, 0.25);
        color: white;
    }

    /* ═══ Kartu Pesanan Ringkas ═══ */
    .order-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        transition: box-shadow 0.2s ease;
    }

    .order-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .order-card.has-new-update {
        border-color: #3b82f6;
        box-shadow: 0 0 0 1px #3b82f6;
    }

    /* Card Top Bar */
    .order-card-header {
        background: #f8fafc;
        border-bottom: 1px solid #eef2f6;
        padding: 0.75rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .order-header-left {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        flex-wrap: wrap;
    }

    .order-code {
        font-family: var(--font-montserrat);
        font-weight: 800;
        font-size: 0.92rem;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .order-date {
        color: #64748b;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .order-badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        font-family: var(--font-montserrat);
    }

    .badge-new-update {
        background: #ef4444;
        color: white;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        animation: pulseOrderBadge 2s infinite;
    }

    @keyframes pulseOrderBadge {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.85; transform: scale(0.97); }
    }

    /* ═══ Stepper Tracker (Responsif) ═══ */
    .tracker-box {
        padding: 1rem 1.25rem 0.85rem;
        background: var(--bg-card, #ffffff);
        border-bottom: 1px solid var(--border-color, #f1f5f9);
    }

    /* Stepper Desktop & Tablet (> 768px) */
    .tracker-desktop {
        display: block;
    }

    .tracker-steps {
        display: flex;
        position: relative;
        justify-content: space-between;
        max-width: 960px;
        margin: 0 auto;
        padding: 0 10px;
    }

    .tracker-steps::before {
        content: '';
        position: absolute;
        top: 16px;
        left: 30px;
        right: 30px;
        height: 3px;
        background: var(--border-color, #e2e8f0);
        z-index: 1;
    }

    .tracker-progress-bar {
        position: absolute;
        top: 16px;
        left: 30px;
        height: 3px;
        background: linear-gradient(90deg, #10b981, #059669);
        z-index: 2;
        transition: width 0.4s ease;
    }

    .tracker-step {
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        text-align: center;
    }

    .tracker-node {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--bg-card, white);
        border: 2.5px solid var(--border-color, #cbd5e1);
        color: var(--text-muted, #94a3b8);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        transition: all 0.25s ease;
    }

    .tracker-step.done .tracker-node {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }

    .tracker-step.current .tracker-node {
        background: var(--bg-card, #ffffff);
        border-color: #3b82f6;
        color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
    }

    .tracker-step-label {
        font-size: 0.75rem;
        font-weight: 700;
        margin-top: 6px;
        color: var(--text-secondary, #64748b);
        font-family: var(--font-montserrat);
    }

    .tracker-step.done .tracker-step-label { color: var(--text-heading, #0f172a); }
    .tracker-step.current .tracker-step-label { color: #2563eb; }

    .tracker-step-desc {
        font-size: 0.68rem;
        color: #94a3b8;
        margin-top: 1px;
    }

    /* Stepper Mobile (<= 768px) - Menghemat 90px+ Vertikal */
    .tracker-mobile {
        display: none;
    }

    .tracker-mobile-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.78rem;
        margin-bottom: 6px;
    }

    .tracker-mobile-segments {
        display: flex;
        gap: 4px;
        height: 6px;
        width: 100%;
    }

    .tracker-segment {
        flex: 1;
        background: #e2e8f0;
        border-radius: 999px;
        transition: background 0.3s ease;
    }

    .tracker-segment.done { background: #10b981; }
    .tracker-segment.current { background: #3b82f6; }

    /* ═══ Surat Keterangan Strip (Ringkas) ═══ */
    .surat-strip {
        margin: 0.75rem 1.25rem 0;
        background: #ecfdf5;
        border: 1px solid rgba(16, 185, 129, 0.25);
        border-radius: 10px;
        padding: 0.65rem 0.95rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.65rem;
    }

    .surat-strip-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .surat-strip-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .surat-strip-title {
        font-size: 0.84rem;
        color: #065f46;
        font-weight: 700;
        line-height: 1.2;
    }

    .surat-strip-sub {
        font-size: 0.75rem;
        color: #047857;
        margin-top: 1px;
    }

    /* ═══ Body Grid Ringkas ═══ */
    .order-card-body {
        padding: 1rem 1.25rem;
        display: grid;
        grid-template-columns: 1.1fr 1.2fr 0.9fr;
        gap: 1.25rem;
        align-items: start;
    }

    /* Col 1: Sapi Info */
    .cattle-info-box {
        display: flex;
        gap: 0.85rem;
    }

    .cattle-thumb-link {
        flex-shrink: 0;
        width: 90px;
        height: 85px;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #f1f5f9;
        display: block;
    }

    .cattle-thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.25s ease;
    }

    .cattle-thumb-link:hover .cattle-thumb-img {
        transform: scale(1.06);
    }

    .cattle-meta-title {
        font-family: var(--font-montserrat);
        font-size: 1rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 0.3rem 0;
        line-height: 1.2;
    }

    .cattle-spec-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-bottom: 0.45rem;
    }

    .spec-pill {
        background: #f1f5f9;
        color: #475569;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    .cattle-price {
        font-family: var(--font-montserrat);
        font-size: 1rem;
        font-weight: 800;
        color: var(--green-brand);
    }

    /* Col 2: Pengiriman & Catatan */
    .delivery-box {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 10px;
        padding: 0.75rem 0.85rem;
        font-size: 0.8rem;
    }

    .delivery-row {
        display: flex;
        align-items: flex-start;
        gap: 6px;
        margin-bottom: 0.4rem;
        color: #334155;
    }

    .delivery-row:last-child {
        margin-bottom: 0;
    }

    .delivery-row i {
        color: #64748b;
        font-size: 0.9rem;
        margin-top: 1px;
        flex-shrink: 0;
    }

    .status-note-highlight {
        background: #eff6ff;
        border-left: 3px solid #3b82f6;
        padding: 0.5rem 0.75rem;
        border-radius: 0 6px 6px 0;
        margin-top: 0.5rem;
        font-size: 0.78rem;
        color: #1e3a8a;
        line-height: 1.35;
    }

    /* Col 3: Peternak & Tagihan */
    .payment-summary-box {
        background: var(--bg-surface, #ffffff);
        border: 1px solid var(--border-color, #edf2f7);
        border-radius: 10px;
        padding: 0.75rem 0.85rem;
    }

    .seller-compact {
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-color, #f1f5f9);
        margin-bottom: 0.5rem;
    }

    .seller-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .cost-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.78rem;
        margin-bottom: 0.25rem;
        color: var(--text-secondary, #64748b);
    }

    .cost-row.total {
        margin-top: 0.4rem;
        padding-top: 0.4rem;
        border-top: 1px dashed var(--border-color, #e2e8f0);
        color: var(--text-heading, #0f172a);
        font-weight: 800;
        font-size: 0.9rem;
    }

    /* ═══ Box Ulasan Ringkas ═══ */
    .review-display-box {
        margin: 0 1.25rem 0.75rem;
        background: rgba(245, 158, 11, 0.08);
        border: 1px solid rgba(245, 158, 11, 0.3);
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }

    /* ═══ Card Footer Actions ═══ */
    .order-card-footer {
        background: var(--bg-muted, #f8fafc);
        border-top: 1px solid var(--border-color, #eef2f6);
        padding: 0.65rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .footer-actions-left {
        display: flex;
        gap: 0.45rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .footer-actions-right {
        display: flex;
        gap: 0.45rem;
        align-items: center;
    }

    /* Button styles */
    .btn-action-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 0.5rem 1rem;
        background: var(--green-brand);
        color: white;
        border-radius: 8px;
        font-family: var(--font-montserrat);
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
        box-shadow: 0 2px 6px rgba(0, 167, 64, 0.2);
    }

    .btn-action-primary:hover {
        background: #008f37;
        color: white;
        transform: translateY(-1px);
    }

    .btn-action-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 0.45rem 0.85rem;
        background: white;
        color: #334155;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-family: var(--font-montserrat);
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-action-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    .btn-whatsapp-compact {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 0.45rem 0.85rem;
        background: #25d366;
        color: white;
        border-radius: 8px;
        font-family: var(--font-montserrat);
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.15s ease;
    }

    .btn-whatsapp-compact:hover {
        background: #1eb854;
        color: white;
    }

    /* ═══ Modals Responsif untuk Semua Device ═══ */
    .modal-proof {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(3px);
        z-index: 1050;
        align-items: center;
        justify-content: center;
        padding: 12px;
    }

    .modal-proof.open {
        display: flex;
    }

    .modal-proof-content {
        background: white;
        border-radius: 14px;
        max-width: 540px;
        width: 100%;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        animation: modalSlideUp 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes modalSlideUp {
        from { opacity: 0; transform: translateY(12px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .modal-header-clean {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #eef2f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafafa;
        flex-shrink: 0;
    }

    .modal-body-scroll {
        padding: 1.25rem;
        overflow-y: auto;
        flex: 1;
        -webkit-overflow-scrolling: touch;
    }

    .modal-footer-clean {
        padding: 0.75rem 1.25rem;
        border-top: 1px solid #eef2f6;
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        background: #fafafa;
        flex-shrink: 0;
    }

    /* Tag checklist */
    .tag-pill-check {
        cursor: pointer;
        display: inline-block;
        margin: 0;
    }

    .tag-pill-check input { display: none; }

    .tag-pill-check span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 10px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .tag-pill-check input:checked + span {
        background: #ecfdf5;
        color: #065f46;
        border-color: #10b981;
        box-shadow: 0 1px 4px rgba(16, 185, 129, 0.25);
    }

    .star-btn {
        transition: transform 0.15s ease, color 0.15s ease;
    }
    .star-btn:hover { transform: scale(1.15); }

    /* ═══ RESPONSIVE MEDIA QUERIES ═══ */

    /* Tablet & iPad (<= 991px) */
    @media (max-width: 991px) {
        .pesanan-page-container {
            padding-top: 95px;
            padding-bottom: 50px;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .pesanan-stats-bar {
            grid-template-columns: repeat(3, 1fr);
            gap: 0.65rem;
        }

        .order-card-body {
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .cattle-info-box {
            grid-column: span 2;
        }
    }

    /* Mobile Devices (<= 640px) */
    @media (max-width: 640px) {
        .pesanan-page-container {
            padding-top: 80px;
            padding-bottom: 95px;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .pesanan-header {
            padding: 1.15rem 1rem;
            border-radius: 14px;
            margin-bottom: 0.85rem;
        }

        .pesanan-header-desc {
            display: none; /* Menghemat ruang vertikal di HP */
        }

        .pesanan-stats-bar {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin-top: 0.85rem;
            padding-top: 0.85rem;
        }

        .stat-mini-pill {
            padding: 0.45rem 0.6rem;
        }

        .stat-mini-icon {
            width: 26px;
            height: 26px;
            font-size: 0.85rem;
        }

        .stat-mini-content strong {
            font-size: 0.95rem;
        }

        /* Tampilkan tracker mobile, sembunyikan tracker desktop */
        .tracker-desktop { display: none; }
        .tracker-mobile { display: block; }

        .order-card {
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .order-card-body {
            grid-template-columns: 1fr;
            gap: 0.75rem;
            padding: 0.85rem;
        }

        .cattle-info-box {
            grid-column: span 1;
        }

        .cattle-thumb-link {
            width: 76px;
            height: 74px;
        }

        .cattle-meta-title {
            font-size: 0.92rem;
        }

        .order-card-footer {
            padding: 0.75rem 0.85rem;
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }

        .footer-actions-left {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }

        .footer-actions-left .btn-action-primary {
            width: 100%;
            min-height: 42px;
            font-size: 0.84rem;
        }

        .footer-actions-left .btn-action-outline {
            width: 100%;
            min-height: 38px;
        }

        .footer-actions-right {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(75px, 1fr));
            gap: 0.4rem;
        }

        .footer-actions-right a, .footer-actions-right button {
            width: 100%;
            min-height: 38px;
            justify-content: center;
        }

        .surat-strip {
            margin: 0.5rem 0.85rem 0;
            padding: 0.6rem 0.75rem;
            flex-direction: column;
            align-items: stretch;
            gap: 0.6rem;
        }

        .surat-strip > div:last-child {
            display: flex;
            gap: 6px;
            width: 100%;
        }

        .surat-strip > div:last-child a,
        .surat-strip > div:last-child button {
            flex: 1;
            min-height: 38px;
            justify-content: center;
            text-align: center;
        }

        .review-display-box {
            margin: 0 0.85rem 0.5rem;
            padding: 0.65rem 0.85rem;
        }

        /* Modals on Mobile */
        .modal-proof {
            padding: 8px;
        }

        .modal-proof-content {
            border-radius: 12px;
            max-height: 94vh;
        }

        #reviewKomentar {
            font-size: 16px; /* Cegah auto-zoom di iOS */
        }
    }

    /* Extra Small (<= 420px) */
    @media (max-width: 420px) {
        .order-card-header {
            padding: 0.6rem 0.75rem;
        }

        .order-code {
            font-size: 0.82rem;
        }

        .order-badge-status {
            font-size: 0.7rem;
            padding: 2px 7px;
        }
    }
</style>

<div class="pesanan-page-container">
    {{-- Notifikasi Flash --}}
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.12); border-left: 4px solid #10b981; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; color: #065f46; font-size: 0.88rem;">
            <i class="bi bi-check-circle-fill" style="font-size: 1.1rem; color: #059669;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('info'))
        <div style="background: rgba(59, 130, 246, 0.12); border-left: 4px solid #3b82f6; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; color: #1e40af; font-size: 0.88rem;">
            <i class="bi bi-info-circle-fill" style="font-size: 1.1rem; color: #2563eb;"></i>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    {{-- Top Header Banner (Ringkas & Mewah) --}}
    <div class="pesanan-header">
        <div class="pesanan-header-top">
            <span class="pesanan-header-badge">
                <i class="bi bi-shield-check"></i> Monitoring Real-Time
            </span>
            <span style="font-size: 0.8rem; color: #94a3b8;">
                <i class="bi bi-person-check-fill" style="color: #34d399;"></i> {{ Auth::user()->name }}
            </span>
        </div>
        <h1 class="pesanan-header-title">Monitoring Pemesanan Sapi</h1>
        <p class="pesanan-header-desc">
            Pantau status pesanan ternak Anda secara transparan: verifikasi pembayaran, administrasi surat aparat kampung, pengiriman armada, hingga penerimaan ternak.
        </p>

        {{-- Stat Summary Pills Ringkas --}}
        <div class="pesanan-stats-bar">
            <div class="stat-mini-pill">
                <div class="stat-mini-icon" style="background: rgba(255,255,255,0.1); color: white;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-mini-content">
                    <span>Semua</span>
                    <strong>{{ $counts['semua'] }}</strong>
                </div>
            </div>
            <div class="stat-mini-pill">
                <div class="stat-mini-icon" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24;">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-mini-content">
                    <span>Menunggu</span>
                    <strong>{{ $counts['menunggu'] }}</strong>
                </div>
            </div>
            <div class="stat-mini-pill">
                <div class="stat-mini-icon" style="background: rgba(59, 130, 246, 0.2); color: #60a5fa;">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div class="stat-mini-content">
                    <span>Diproses</span>
                    <strong>{{ $counts['diproses'] }}</strong>
                </div>
            </div>
            <div class="stat-mini-pill">
                <div class="stat-mini-icon" style="background: rgba(168, 85, 247, 0.2); color: #c084fc;">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="stat-mini-content">
                    <span>Dikirim</span>
                    <strong>{{ $counts['dikirim'] }}</strong>
                </div>
            </div>
            <div class="stat-mini-pill">
                <div class="stat-mini-icon" style="background: rgba(16, 185, 129, 0.2); color: #34d399;">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div class="stat-mini-content">
                    <span>Selesai</span>
                    <strong>{{ $counts['selesai'] }}</strong>
                </div>
            </div>
            <div class="stat-mini-pill">
                <div class="stat-mini-icon" style="background: rgba(239, 68, 68, 0.2); color: #f87171;">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stat-mini-content">
                    <span>Batal</span>
                    <strong>{{ $counts['dibatalkan'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs (Scrollable & Clean) --}}
    <div class="pesanan-tabs-wrapper">
        <div class="pesanan-tabs">
            <a href="{{ route('pesanan.index', ['tab' => 'semua']) }}" class="pesanan-tab-btn {{ $tab === 'semua' ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> Semua
                <span class="pesanan-tab-count">{{ $counts['semua'] }}</span>
            </a>
            <a href="{{ route('pesanan.index', ['tab' => 'menunggu']) }}" class="pesanan-tab-btn {{ $tab === 'menunggu' ? 'active' : '' }}">
                <i class="bi bi-hourglass-split"></i> Menunggu Bayar
                <span class="pesanan-tab-count">{{ $counts['menunggu'] }}</span>
            </a>
            <a href="{{ route('pesanan.index', ['tab' => 'diproses']) }}" class="pesanan-tab-btn {{ $tab === 'diproses' ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i> Diproses Peternak
                <span class="pesanan-tab-count">{{ $counts['diproses'] }}</span>
            </a>
            <a href="{{ route('pesanan.index', ['tab' => 'dikirim']) }}" class="pesanan-tab-btn {{ $tab === 'dikirim' ? 'active' : '' }}">
                <i class="bi bi-truck"></i> Sedang Dikirim
                <span class="pesanan-tab-count">{{ $counts['dikirim'] }}</span>
            </a>
            <a href="{{ route('pesanan.index', ['tab' => 'selesai']) }}" class="pesanan-tab-btn {{ $tab === 'selesai' ? 'active' : '' }}">
                <i class="bi bi-patch-check-fill"></i> Selesai
                <span class="pesanan-tab-count">{{ $counts['selesai'] }}</span>
            </a>
            <a href="{{ route('pesanan.index', ['tab' => 'dibatalkan']) }}" class="pesanan-tab-btn {{ $tab === 'dibatalkan' ? 'active' : '' }}">
                <i class="bi bi-x-octagon"></i> Dibatalkan
                <span class="pesanan-tab-count">{{ $counts['dibatalkan'] }}</span>
            </a>
        </div>
    </div>

    {{-- Daftar Pesanan --}}
    @forelse($orders as $order)
        @php
            $sapi = $order->sapi;
            $peternak = $sapi ? $sapi->peternak : null;
            $fotoUrl = ($sapi && !empty($sapi->foto)) ? asset('storage/' . $sapi->foto[0]) : asset('images/default_sapi.jpg');
            $isNew = in_array($order->id, $unreadOrderIds ?? []);

            $step = match($order->status) {
                'menunggu_pembayaran' => 1,
                'menunggu_verifikasi' => 2,
                'diproses' => 3,
                'dikirim' => 4,
                'selesai' => 5,
                'dibatalkan' => 0,
                default => 1,
            };

            $progressPercent = match($step) {
                1 => 15,
                2 => 35,
                3 => 60,
                4 => 85,
                5 => 100,
                default => 0,
            };

            $meta = match($order->status) {
                'menunggu_pembayaran' => ['label' => 'Menunggu Pembayaran', 'icon' => 'bi-wallet2', 'color' => '#d97706', 'bg' => '#fef3c7', 'border' => '#fde68a'],
                'menunggu_verifikasi' => ['label' => 'Menunggu Verifikasi', 'icon' => 'bi-clock-history', 'color' => '#2563eb', 'bg' => '#eff6ff', 'border' => '#bfdbfe'],
                'diproses' => ['label' => 'Pesanan Diproses', 'icon' => 'bi-gear-wide-connected', 'color' => '#7c3aed', 'bg' => '#f5f3ff', 'border' => '#ddd6fe'],
                'dikirim' => ['label' => ($order->is_pengantaran ? 'Sedang Dikirim' : 'Siap Diambil'), 'icon' => ($order->is_pengantaran ? 'bi-truck' : 'bi-geo-alt-fill'), 'color' => '#0284c7', 'bg' => '#f0f9ff', 'border' => '#bae6fd'],
                'selesai' => ['label' => 'Pesanan Selesai', 'icon' => 'bi-check-circle-fill', 'color' => '#059669', 'bg' => '#ecfdf5', 'border' => '#a7f3d0'],
                'dibatalkan' => ['label' => 'Pesanan Dibatalkan', 'icon' => 'bi-x-circle-fill', 'color' => '#dc2626', 'bg' => '#fef2f2', 'border' => '#fecaca'],
                default => ['label' => ucfirst($order->status), 'icon' => 'bi-question-circle', 'color' => '#64748b', 'bg' => '#f8fafc', 'border' => '#e2e8f0'],
            };

            $hasSurat = !empty($order->nomor_surat) && !empty($order->surat_released_at);
        @endphp

        <div class="order-card {{ $isNew ? 'has-new-update' : '' }}" id="order-card-{{ $order->id }}">
            {{-- Top Bar Kartu --}}
            <div class="order-card-header">
                <div class="order-header-left">
                    <span class="order-code">
                        <i class="bi bi-receipt" style="color: var(--green-brand);"></i> {{ $order->kode_transaksi }}
                    </span>
                    <span class="order-date">
                        <i class="bi bi-calendar3"></i> {{ $order->created_at->format('d M Y, H:i') }}
                    </span>
                    @if($order->tipe_penjualan === 'pre_order')
                        <span style="background: rgba(245, 158, 11, 0.12); color: #d97706; padding: 2px 7px; border-radius: 6px; font-size: 0.72rem; font-weight: 700;">
                            Pre-Order
                        </span>
                    @else
                        <span style="background: rgba(16, 185, 129, 0.1); color: var(--green-brand); padding: 2px 7px; border-radius: 6px; font-size: 0.72rem; font-weight: 700;">
                            Ready Order
                        </span>
                    @endif

                    @if($isNew)
                        <span class="badge-new-update">
                            <i class="bi bi-bell-fill"></i> Baru
                        </span>
                    @endif
                </div>

                <div>
                    <span class="order-badge-status" style="background: {{ $meta['bg'] }}; color: {{ $meta['color'] }}; border: 1px solid {{ $meta['border'] }};">
                        <i class="bi {{ $meta['icon'] }}"></i> {{ $meta['label'] }}
                    </span>
                </div>
            </div>

            {{-- Visual Tracker (Responsif Desktop & Mobile) --}}
            <div class="tracker-box">
                @if($order->status === 'dibatalkan')
                    <div style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px; padding: 0.6rem 0.85rem; color: #dc2626; display: flex; align-items: center; gap: 8px; font-size: 0.82rem;">
                        <i class="bi bi-x-circle-fill" style="font-size: 1.1rem; flex-shrink: 0;"></i>
                        <div>
                            <strong>Pesanan dibatalkan:</strong> {{ $order->catatan_status ?: 'Hubungi peternak untuk informasi lebih lanjut.' }}
                        </div>
                    </div>
                @else
                    {{-- 1. Stepper Desktop (> 768px) --}}
                    <div class="tracker-desktop">
                        <div class="tracker-steps">
                            <div class="tracker-progress-bar" style="width: calc({{ $progressPercent }}% - 60px);"></div>

                            {{-- Step 1: Pesanan Dibuat --}}
                            <div class="tracker-step done">
                                <div class="tracker-node"><i class="bi bi-bag-check-fill"></i></div>
                                <span class="tracker-step-label">Dibuat</span>
                                <span class="tracker-step-desc">{{ $order->created_at->format('d/m H:i') }}</span>
                            </div>

                            {{-- Step 2: Pembayaran --}}
                            @php
                                $step2State = ($order->status === 'menunggu_pembayaran' || $order->status === 'menunggu_verifikasi') ? 'current' : ($step > 2 ? 'done' : 'pending');
                            @endphp
                            <div class="tracker-step {{ $step2State }}">
                                <div class="tracker-node">
                                    <i class="bi {{ $step2State === 'done' ? 'bi-check-lg' : 'bi-credit-card-2-front-fill' }}"></i>
                                </div>
                                <span class="tracker-step-label">Verifikasi Bayar</span>
                                <span class="tracker-step-desc">{{ $step2State === 'done' ? 'Lunas' : ($order->status === 'menunggu_pembayaran' ? 'Transfer' : 'Dicek') }}</span>
                            </div>

                            {{-- Step 3: Surat Rilis --}}
                            @php
                                $step3State = $hasSurat ? 'done' : ($order->status !== 'menunggu_pembayaran' && $order->status !== 'menunggu_verifikasi' ? 'current' : 'pending');
                            @endphp
                            <div class="tracker-step {{ $step3State }}">
                                <div class="tracker-node">
                                    <i class="bi {{ $hasSurat ? 'bi-file-earmark-check-fill' : 'bi-file-earmark-text' }}"></i>
                                </div>
                                <span class="tracker-step-label">Surat Rilis</span>
                                <span class="tracker-step-desc">{{ $hasSurat ? 'Resmi Aparat' : 'Proses Aparat' }}</span>
                            </div>

                            {{-- Step 4: Pengiriman --}}
                            @php
                                $step4State = ($order->status === 'dikirim') ? 'current' : ($step > 4 ? 'done' : 'pending');
                            @endphp
                            <div class="tracker-step {{ $step4State }}">
                                <div class="tracker-node">
                                    <i class="bi {{ $step4State === 'done' ? 'bi-check-lg' : ($order->is_pengantaran ? 'bi-truck' : 'bi-geo-alt-fill') }}"></i>
                                </div>
                                <span class="tracker-step-label">{{ $order->is_pengantaran ? 'Pengiriman' : 'Siap Ambil' }}</span>
                                <span class="tracker-step-desc">{{ $step4State === 'current' ? 'Dalam Proses' : ($step4State === 'done' ? 'Tiba' : 'Menunggu') }}</span>
                            </div>

                            {{-- Step 5: Selesai --}}
                            <div class="tracker-step {{ $order->status === 'selesai' ? 'done' : 'pending' }}">
                                <div class="tracker-node"><i class="bi bi-check-circle-fill"></i></div>
                                <span class="tracker-step-label">Selesai</span>
                                <span class="tracker-step-desc">{{ $order->status === 'selesai' ? 'Ternak Diterima' : 'Akhir' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Compact Tracker Mobile (<= 768px) --}}
                    <div class="tracker-mobile">
                        <div class="tracker-mobile-header">
                            <span style="font-weight: 700; color: #334155;">
                                <i class="bi bi-diagram-3-fill" style="color: var(--green-brand);"></i> Tahap {{ $step }}/5:
                                <span style="color: {{ $meta['color'] }};">{{ $meta['label'] }}</span>
                            </span>
                            <span style="color: #64748b; font-size: 0.74rem;">{{ $progressPercent }}%</span>
                        </div>
                        <div class="tracker-mobile-segments">
                            @for($s = 1; $s <= 5; $s++)
                                <div class="tracker-segment {{ $s < $step ? 'done' : ($s == $step ? 'current' : '') }}"></div>
                            @endfor
                        </div>
                    </div>
                @endif
            </div>

            {{-- Surat Keterangan Pembelian Sapi Strip (Ringkas & Langsung Akses) --}}
            @if($hasSurat)
                <div class="surat-strip">
                    <div class="surat-strip-left">
                        <div class="surat-strip-icon">
                            <i class="bi bi-file-earmark-check-fill"></i>
                        </div>
                        <div>
                            <div class="surat-strip-title">
                                Surat Keterangan Resmi Dirilis
                                <span style="background: #10b981; color: white; font-size: 0.68rem; font-weight: 700; padding: 1px 6px; border-radius: 999px; margin-left: 4px;">Sah Aparat</span>
                            </div>
                            <div class="surat-strip-sub">
                                No: <strong>{{ $order->nomor_surat }}</strong> &bull; {{ $order->surat_released_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                        <a href="{{ route('pesanan.surat_pdf', $order->id) }}" target="_blank" class="btn-action-primary" style="background: #059669; font-size: 0.76rem; padding: 0.4rem 0.85rem;">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Buka Dokumen PDF
                        </a>
                        <button type="button" class="btn-action-outline" onclick="openSuratModal('{{ route('pesanan.surat_pdf', $order->id) }}', '{{ $order->nomor_surat }}')" style="font-size: 0.76rem; padding: 0.4rem 0.75rem;">
                            <i class="bi bi-eye"></i> Pratinjau
                        </button>
                    </div>
                </div>
            @elseif($order->status !== 'menunggu_pembayaran' && $order->status !== 'menunggu_verifikasi' && $order->status !== 'dibatalkan')
                <div style="margin: 0.5rem 1.25rem 0; background: rgba(245, 158, 11, 0.08); border: 1px dashed rgba(245, 158, 11, 0.3); border-radius: 8px; padding: 0.55rem 0.85rem; font-size: 0.78rem; color: #92400e; display: flex; align-items: center; gap: 6px;">
                    <i class="bi bi-hourglass-split" style="font-size: 1rem; color: #d97706; flex-shrink: 0;"></i>
                    <span><strong>Surat Keterangan Pembelian Sapi:</strong> Sedang diproses dan ditandatangani oleh Aparat Kampung Suka Maju.</span>
                </div>
            @endif

            {{-- Kartu Utama Grid --}}
            <div class="order-card-body">
                {{-- 1. Sapi Info --}}
                <div class="cattle-info-box">
                    <a href="{{ $sapi ? route('katalog.show', $sapi->id) : '#' }}" class="cattle-thumb-link">
                        <img src="{{ $fotoUrl }}" alt="{{ $sapi->jenis ?? 'Sapi' }}" class="cattle-thumb-img">
                    </a>
                    <div>
                        <h3 class="cattle-meta-title">
                            <a href="{{ $sapi ? route('katalog.show', $sapi->id) : '#' }}" style="color: inherit; text-decoration: none;">
                                Sapi {{ $sapi->jenis ?? 'Ternak' }}
                            </a>
                        </h3>
                        <div class="cattle-spec-pills">
                            <span class="spec-pill"><i class="bi bi-speedometer2"></i> {{ $sapi->bobot ?? '-' }} kg</span>
                            <span class="spec-pill"><i class="bi bi-calendar-heart"></i> {{ $sapi->umur ?? '-' }} Bln</span>
                            @if($sapi && $sapi->status_kesehatan === 'sehat')
                                <span class="spec-pill" style="background: rgba(16, 185, 129, 0.12); color: #059669;">
                                    <i class="bi bi-patch-check-fill"></i> Sehat Mantri
                                </span>
                            @endif
                        </div>
                        <div class="cattle-price">
                            Rp {{ number_format($order->harga_sapi, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                {{-- 2. Lokasi & Catatan Terkini --}}
                <div class="delivery-box">
                    <div class="delivery-row">
                        <i class="bi {{ $order->is_pengantaran ? 'bi-truck' : 'bi-geo-alt-fill' }}"></i>
                        <div>
                            <strong>{{ $order->is_pengantaran ? 'Diantar ke Alamat' : 'Ambil di Kandang' }}</strong>
                            @if($order->tanggal_pengambilan)
                                <div style="color: #b45309; font-size: 0.75rem; font-weight: 700; margin-top: 2px;">
                                    <i class="bi bi-calendar-event"></i> Jadwal: {{ \Carbon\Carbon::parse($order->tanggal_pengambilan)->translatedFormat('d M Y') }} ({{ $order->durasi_perawatan_hari }} Hari PO)
                                </div>
                            @endif
                            <div style="color: #64748b; font-size: 0.76rem; margin-top: 1px;">
                                @if($order->is_pengantaran && $order->detail_lokasi)
                                    {{ Str::limit($order->detail_lokasi, 55) }} ({{ $order->jarak_km }} km)
                                @else
                                    Kandang: {{ Str::limit($sapi->lokasi ?? ($peternak->alamat ?? 'Kampung Suka Maju'), 45) }}
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($order->catatan_status)
                        <div class="status-note-highlight">
                            <i class="bi bi-chat-left-quote-fill" style="margin-right: 4px; color: #3b82f6;"></i>
                            {{ $order->catatan_status }}
                        </div>
                    @endif
                </div>

                {{-- 3. Peternak & Total Tagihan --}}
                <div class="payment-summary-box">
                    @if($peternak)
                        <div class="seller-compact">
                            <div class="seller-avatar">
                                {{ strtoupper(substr($peternak->name, 0, 2)) }}
                            </div>
                            <div style="line-height: 1.2;">
                                <strong style="font-size: 0.82rem; color: #0f172a;">{{ $peternak->name }}</strong>
                                <span style="font-size: 0.72rem; color: #64748b; display: block;">Peternak Suka Maju</span>
                            </div>
                        </div>
                    @endif

                    <div>
                        <div class="cost-row">
                            <span>Metode:</span>
                            <span style="font-weight: 600; color: #334155;">{{ ucfirst($order->metode_pembayaran) }}</span>
                        </div>
                        @if($order->is_pengantaran)
                            <div class="cost-row">
                                <span>Ongkir:</span>
                                <span>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        @if($order->biaya_perawatan > 0)
                            <div class="cost-row" style="color: #b45309;">
                                <span>Perawatan ({{ $order->durasi_perawatan_hari }} hr):</span>
                                <span>Rp {{ number_format($order->biaya_perawatan, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="cost-row total">
                            <span>Total Biaya:</span>
                            <span style="color: var(--green-brand);">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                        @if($order->is_preorder)
                            <div class="cost-row" style="color: #047857; font-size: 0.74rem;">
                                <span>DP (Tahap 1):</span>
                                <span style="font-weight: 700;">Rp {{ number_format($order->dp, 0, ',', '.') }}</span>
                            </div>
                            <div class="cost-row" style="color: #b45309; font-size: 0.74rem;">
                                <span>Pelunasan (Tahap 2):</span>
                                <span style="font-weight: 700;">Rp {{ number_format($order->sisa_pembayaran, 0, ',', '.') }}</span>
                            </div>
                            <div class="cost-row" style="margin-top: 4px; padding-top: 4px; border-top: 1px dashed rgba(0,0,0,0.08);">
                                <span>Status Bayar:</span>
                                @if($order->is_lunas)
                                    <span style="background: rgba(16, 185, 129, 0.15); color: #047857; padding: 2px 7px; border-radius: 6px; font-size: 0.7rem; font-weight: 700;">
                                        <i class="bi bi-check-circle-fill"></i> LUNAS 100%
                                    </span>
                                @elseif($order->is_menunggu_verifikasi_pelunasan)
                                    <span style="background: rgba(245, 158, 11, 0.15); color: #b45309; padding: 2px 7px; border-radius: 6px; font-size: 0.7rem; font-weight: 700;">
                                        <i class="bi bi-hourglass-split"></i> Verifikasi Pelunasan
                                    </span>
                                @elseif($order->status === 'menunggu_pembayaran' || $order->status === 'menunggu_verifikasi')
                                    <span style="background: rgba(239, 68, 68, 0.1); color: #dc2626; padding: 2px 7px; border-radius: 6px; font-size: 0.7rem; font-weight: 700;">
                                        Menunggu DP
                                    </span>
                                @else
                                    <span style="background: rgba(245, 158, 11, 0.15); color: #b45309; padding: 2px 7px; border-radius: 6px; font-size: 0.7rem; font-weight: 700;">
                                        DP Lunas &bull; Belum Dilunasi
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Banner Status Pembayaran Pre-Order (DP & Pelunasan) --}}
            @if($order->is_preorder)
                @if($order->can_pelunasan)
                    <div style="margin: 0.75rem 1.25rem 0; background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1.5px solid #fde68a; border-radius: 12px; padding: 0.9rem 1.15rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: #f59e0b; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div>
                                <div style="font-weight: 800; font-size: 0.88rem; color: #92400e;">
                                    Saatnya Melakukan Pembayaran Pelunasan (Tahap 2)
                                </div>
                                <div style="font-size: 0.78rem; color: #78350f;">
                                    Sapi Anda siap {{ $order->is_pengantaran ? 'dikirim' : 'diambil' }} (Jadwal: {{ \Carbon\Carbon::parse($order->tanggal_pengambilan)->translatedFormat('d M Y') }}). Sisa tagihan: <strong style="color: #b45309; font-size: 0.85rem;">Rp {{ number_format($order->sisa_pembayaran, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('pembayaran.pelunasan', $order->id) }}" class="btn-action-primary" style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); font-size: 0.82rem; padding: 0.5rem 1.1rem; text-decoration: none;">
                            <i class="bi bi-credit-card-fill"></i> Lunasi Sekarang
                        </a>
                    </div>
                @elseif($order->is_menunggu_verifikasi_pelunasan)
                    <div style="margin: 0.75rem 1.25rem 0; background: rgba(59, 130, 246, 0.08); border: 1.5px dashed rgba(59, 130, 246, 0.35); border-radius: 12px; padding: 0.8rem 1.1rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #3b82f6; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; flex-shrink: 0;">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; font-size: 0.85rem; color: #1e3a8a;">
                                    Bukti Pelunasan Sedang Diverifikasi Peternak
                                </div>
                                <div style="font-size: 0.76rem; color: #3b82f6;">
                                    Anda telah mengunggah bukti transfer pelunasan. Peternak akan memverifikasi sebelum penyerahan sapi.
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-action-outline" onclick="openProofModal('{{ asset('storage/' . $order->bukti_pelunasan) }}')" style="font-size: 0.76rem; padding: 0.4rem 0.85rem; border-color: #3b82f6; color: #2563eb;">
                            <i class="bi bi-image"></i> Cek Bukti Pelunasan
                        </button>
                    </div>
                @elseif($order->is_lunas && $order->is_preorder)
                    <div style="margin: 0.75rem 1.25rem 0; background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 12px; padding: 0.65rem 1.1rem; display: flex; align-items: center; gap: 10px;">
                        <i class="bi bi-patch-check-fill" style="color: #10b981; font-size: 1.25rem;"></i>
                        <span style="font-size: 0.8rem; color: #065f46; font-weight: 600;">
                            <strong>Pembayaran Pre-Order Lunas 100%:</strong> Uang Muka (DP) & Pelunasan telah selesai diverifikasi oleh peternak.
                        </span>
                    </div>
                @endif
            @endif

            {{-- Box Ulasan Pembeli untuk Peternak (Jika sudah diulas) --}}
            @if($order->ulasan)
                <div class="review-display-box">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.5rem;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="font-weight: 700; color: #92400e; font-size: 0.82rem;">Ulasan Anda:</span>
                                <div style="color: #f59e0b; font-size: 0.88rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $order->ulasan->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                    <strong style="color: #78350f; font-size: 0.8rem; margin-left: 3px;">{{ $order->ulasan->rating }}.0</strong>
                                </div>
                            </div>
                            <p style="margin: 4px 0 0; font-size: 0.82rem; color: #451a03; line-height: 1.4;">
                                "{{ $order->ulasan->komentar }}"
                            </p>
                            @if(!empty($order->ulasan->kategori) && is_array($order->ulasan->kategori))
                                <div style="display: flex; gap: 4px; flex-wrap: wrap; margin-top: 5px;">
                                    @foreach($order->ulasan->kategori as $kat)
                                        <span style="background: rgba(245, 158, 11, 0.15); color: #92400e; font-size: 0.7rem; padding: 1px 7px; border-radius: 999px; font-weight: 600;">
                                            <i class="bi bi-patch-check"></i> {{ $kat }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn-action-outline" style="font-size: 0.74rem; padding: 0.3rem 0.65rem; border-color: #f59e0b; color: #b45309;" onclick="openReviewModal({{ $order->id }}, '{{ $order->kode_transaksi }}', '{{ addslashes($peternak->name ?? 'Peternak') }}', 'Sapi {{ addslashes($sapi->jenis ?? 'Ternak') }}', false, {{ $order->ulasan->rating }}, '{{ addslashes($order->ulasan->komentar) }}', {{ json_encode($order->ulasan->kategori ?? []) }})">
                            <i class="bi bi-pencil-square"></i> Ubah
                        </button>
                    </div>
                    @if($order->ulasan->balasan_peternak)
                        <div style="margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px dashed #fde68a; font-size: 0.78rem; color: #047857;">
                            <strong><i class="bi bi-reply-fill"></i> Balasan Peternak:</strong> "{{ $order->ulasan->balasan_peternak }}"
                        </div>
                    @endif
                </div>
            @endif

            {{-- Footer Aksi (Hierarki Jelas & Responsif) --}}
            <div class="order-card-footer">
                <div class="footer-actions-left">
                    {{-- Aksi Utama 1: Konfirmasi Selesai & Beri Ulasan --}}
                    @if($order->status === 'dikirim')
                        <button type="button" class="btn-action-primary" style="background: linear-gradient(135deg, #10b981, #059669);" onclick="openReviewModal({{ $order->id }}, '{{ $order->kode_transaksi }}', '{{ addslashes($peternak->name ?? 'Peternak') }}', 'Sapi {{ addslashes($sapi->jenis ?? 'Ternak') }}', true)">
                            <i class="bi bi-check-circle-fill"></i> Konfirmasi Selesai & Beri Ulasan
                        </button>
                    @endif

                    {{-- Aksi Utama 2: Beri Ulasan Peternak --}}
                    @if($order->status === 'selesai' && !$order->ulasan)
                        <button type="button" class="btn-action-primary" style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 3px 10px rgba(245, 158, 11, 0.25);" onclick="openReviewModal({{ $order->id }}, '{{ $order->kode_transaksi }}', '{{ addslashes($peternak->name ?? 'Peternak') }}', 'Sapi {{ addslashes($sapi->jenis ?? 'Ternak') }}', false)">
                            <i class="bi bi-star-fill"></i> Beri Ulasan Peternak
                        </button>
                    @endif

                    {{-- Aksi Utama 3: Unggah Bukti Bayar DP jika belum bayar --}}
                    @if($order->status === 'menunggu_pembayaran')
                        <a href="{{ route('pembayaran.upload', $order->id) }}" class="btn-action-primary" style="background: #f59e0b;">
                            <i class="bi bi-upload"></i> {{ $order->is_preorder ? 'Unggah Bukti Transfer DP' : 'Unggah Bukti Pembayaran' }}
                        </a>
                    @endif

                    {{-- Aksi Utama 4: Pelunasan Pre-Order --}}
                    @if($order->can_pelunasan)
                        <a href="{{ route('pembayaran.pelunasan', $order->id) }}" class="btn-action-primary" style="background: linear-gradient(135deg, #f59e0b, #d97706); font-size: 0.8rem;">
                            <i class="bi bi-cash-coin"></i> Lunasi Sisa Tagihan
                        </a>
                    @endif

                    {{-- Chat Penjual --}}
                    @if($peternak)
                        <button type="button" class="btn-action-outline" onclick="openChatWith({{ $peternak->id }}, '{{ addslashes($peternak->name) }}', 'Peternak', {{ $order->id }}, {{ $order->sapi_id ?? 'null' }}, 'Sapi {{ addslashes($sapi->jenis ?? 'Ternak') }} ({{ $order->kode_transaksi }})', '{{ $fotoUrl }}')">
                            <i class="bi bi-chat-dots-fill" style="color: #10b981;"></i> Chat Penjual
                        </button>
                    @endif
                </div>

                <div class="footer-actions-right">
                    @if($order->bukti_pembayaran)
                        <button type="button" class="btn-action-outline" onclick="openProofModal('{{ asset('storage/' . $order->bukti_pembayaran) }}')" title="Lihat Bukti Transfer DP">
                            <i class="bi bi-image"></i> {{ $order->is_preorder ? 'Bukti DP' : 'Bukti Bayar' }}
                        </button>
                    @endif

                    @if($order->bukti_pelunasan)
                        <button type="button" class="btn-action-outline" onclick="openProofModal('{{ asset('storage/' . $order->bukti_pelunasan) }}')" title="Lihat Bukti Transfer Pelunasan" style="border-color: #f59e0b; color: #b45309;">
                            <i class="bi bi-receipt-cutoff"></i> Bukti Pelunasan
                        </button>
                    @endif

                    <a href="{{ route('pembayaran.sukses', $order->id) }}" class="btn-action-outline" title="Kwitansi Resmi">
                        <i class="bi bi-receipt"></i> Kwitansi
                    </a>

                    @if($peternak && $peternak->no_telepon)
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $peternak->no_telepon);
                            if (str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                        @endphp
                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Halo Pak ' . $peternak->name . ', saya ingin bertanya mengenai pesanan sapi dengan nomor: ' . $order->kode_transaksi) }}" target="_blank" class="btn-whatsapp-compact" title="WhatsApp Peternak">
                            <i class="bi bi-whatsapp"></i> WA
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        {{-- Empty State Ringkas --}}
        <div class="empty-orders-box">
            <div class="empty-orders-icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <h3 style="font-family: var(--font-montserrat); font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem 0;">
                Tidak Ada Pesanan Ditemukan
            </h3>
            <p style="color: #64748b; font-size: 0.92rem; max-width: 440px; margin: 0 auto 1.5rem; line-height: 1.5;">
                @if($tab === 'semua')
                    Anda belum pernah melakukan pemesanan sapi. Silakan jelajahi katalog kami untuk menemukan ternak sapi berkualitas.
                @else
                    Tidak ada pesanan sapi pada kategori status ini saat ini.
                @endif
            </p>
            <a href="{{ route('katalog.index') }}" class="btn-action-primary" style="padding: 0.65rem 1.4rem; font-size: 0.9rem;">
                <i class="bi bi-search"></i> Jelajahi Katalog Sapi
            </a>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($orders->hasPages())
        <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
            {{ $orders->links() }}
        </div>
    @endif
</div>

{{-- ═══ MODAL BUKTI PEMBAYARAN ═══ --}}
<div class="modal-proof" id="proofModal" onclick="closeProofModal(event)">
    <div class="modal-proof-content" onclick="event.stopPropagation()">
        <div class="modal-header-clean">
            <h4 style="margin: 0; font-family: var(--font-montserrat); font-size: 1rem; font-weight: 700; color: #0f172a;">
                <i class="bi bi-image" style="color: var(--green-brand);"></i> Bukti Transfer Pembayaran
            </h4>
            <button type="button" onclick="closeProofModal()" style="background: none; border: none; font-size: 1.4rem; cursor: pointer; color: #64748b; line-height: 1;">&times;</button>
        </div>
        <div class="modal-body-scroll" style="text-align: center; background: #f8fafc;">
            <img id="proofModalImage" src="" alt="Bukti Transfer" style="max-width: 100%; max-height: 60vh; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); object-fit: contain;">
        </div>
        <div class="modal-footer-clean">
            <button type="button" class="btn-action-outline" onclick="closeProofModal()">Tutup</button>
        </div>
    </div>
</div>

{{-- ═══ MODAL SURAT KETERANGAN PDF ═══ --}}
<div class="modal-proof" id="suratModal" onclick="closeSuratModal(event)">
    <div class="modal-proof-content" style="max-width: 620px;" onclick="event.stopPropagation()">
        <div class="modal-header-clean">
            <div>
                <h4 style="margin: 0; font-family: var(--font-montserrat); font-size: 1rem; font-weight: 700; color: #0f172a;">
                    <i class="bi bi-file-earmark-check-fill" style="color: #10b981;"></i> Dokumen Surat Keterangan Resmi
                </h4>
                <span id="modalSuratNomor" style="font-size: 0.75rem; color: #64748b;"></span>
            </div>
            <button type="button" onclick="closeSuratModal()" style="background: none; border: none; font-size: 1.4rem; cursor: pointer; color: #64748b; line-height: 1;">&times;</button>
        </div>
        <div class="modal-body-scroll" style="padding: 0.5rem; text-align: center; background: #f8fafc;" id="suratModalBody">
            <img id="suratModalImage" src="" alt="Surat Keterangan" style="max-width: 100%; height: auto; border-radius: 8px; display: none;">
            <iframe id="suratModalPdf" src="" style="width: 100%; height: clamp(300px, 58vh, 500px); border: none; border-radius: 8px; display: none;"></iframe>
        </div>
        <div class="modal-footer-clean" style="justify-content: space-between;">
            <a id="suratDownloadBtn" href="" target="_blank" download class="btn-action-primary" style="background: #059669; font-size: 0.78rem; padding: 0.45rem 0.9rem;">
                <i class="bi bi-download"></i> Unduh Berkas
            </a>
            <button type="button" class="btn-action-outline" onclick="closeSuratModal()">Tutup</button>
        </div>
    </div>
</div>

{{-- ═══ MODAL KONFIRMASI SELESAI & ULASAN PETERNAK ═══ --}}
<div class="modal-proof" id="reviewModal" onclick="closeReviewModal(event)">
    <div class="modal-proof-content" style="max-width: 520px; text-align: left;" onclick="event.stopPropagation()">
        <form id="reviewForm" method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="modal-header-clean">
                <div>
                    <h4 id="reviewModalTitle" style="margin: 0; font-family: var(--font-montserrat); font-size: 1.05rem; font-weight: 700; color: #0f172a;">
                        <i class="bi bi-star-fill" style="color: #f59e0b;"></i> Beri Ulasan Peternak
                    </h4>
                    <span id="reviewModalSubtitle" style="font-size: 0.76rem; color: #64748b;"></span>
                </div>
                <button type="button" onclick="closeReviewModal()" style="background: none; border: none; font-size: 1.4rem; cursor: pointer; color: #64748b; line-height: 1;">&times;</button>
            </div>
            
            <div class="modal-body-scroll">
                <div id="reviewAlertDikirim" style="margin-bottom: 1rem; background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 0.65rem 0.85rem; font-size: 0.8rem; color: #065f46; display: none;">
                    <i class="bi bi-shield-check" style="font-size: 1rem; margin-right: 4px; color: #059669;"></i>
                    Sapi pesanan Anda akan dinyatakan <strong>Selesai</strong> dan diterima dalam kondisi baik.
                </div>

                {{-- Rating Selector Bintang --}}
                <div style="margin-bottom: 1rem; text-align: center; background: #f8fafc; padding: 0.85rem; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <label style="display: block; font-weight: 700; color: #1e293b; font-size: 0.88rem; margin-bottom: 0.35rem;">
                        Rating Kepuasan Pelayanan Peternak <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="hidden" name="rating" id="reviewRatingInput" value="5" required>
                    <div id="starContainer" style="display: inline-flex; gap: 6px; font-size: clamp(1.8rem, 5vw, 2.2rem); cursor: pointer; color: #cbd5e1;">
                        <i class="bi bi-star-fill star-btn" data-val="1"></i>
                        <i class="bi bi-star-fill star-btn" data-val="2"></i>
                        <i class="bi bi-star-fill star-btn" data-val="3"></i>
                        <i class="bi bi-star-fill star-btn" data-val="4"></i>
                        <i class="bi bi-star-fill star-btn" data-val="5"></i>
                    </div>
                    <div id="ratingLabel" style="font-weight: 700; color: #d97706; font-size: 0.85rem; margin-top: 4px;">
                        ⭐⭐⭐⭐⭐ Sangat Puas & Direkomendasikan!
                    </div>
                </div>

                {{-- Quick Checklist Tags --}}
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; color: #334155; font-size: 0.82rem; margin-bottom: 0.4rem;">
                        Aspek Positif (Pilih yang sesuai):
                    </label>
                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                        <label class="tag-pill-check">
                            <input type="checkbox" name="kategori[]" value="Sapi Sehat & Sesuai Foto">
                            <span><i class="bi bi-heart-pulse"></i> Sapi Sehat & Sesuai</span>
                        </label>
                        <label class="tag-pill-check">
                            <input type="checkbox" name="kategori[]" value="Pengiriman Cepat & Aman">
                            <span><i class="bi bi-truck"></i> Pengiriman Cepat</span>
                        </label>
                        <label class="tag-pill-check">
                            <input type="checkbox" name="kategori[]" value="Peternak Ramah & Responsif">
                            <span><i class="bi bi-chat-heart"></i> Peternak Ramah</span>
                        </label>
                        <label class="tag-pill-check">
                            <input type="checkbox" name="kategori[]" value="Dokumen Resmi Lengkap">
                            <span><i class="bi bi-file-earmark-check"></i> Dokumen Lengkap</span>
                        </label>
                        <label class="tag-pill-check">
                            <input type="checkbox" name="kategori[]" value="Harga Jujur & Bersaing">
                            <span><i class="bi bi-tag"></i> Harga Jujur</span>
                        </label>
                    </div>
                </div>

                {{-- Comment textarea --}}
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; color: #334155; font-size: 0.82rem; margin-bottom: 0.35rem;">
                        Tuliskan Ulasan Pengalaman Anda <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea name="komentar" id="reviewKomentar" rows="3" required placeholder="Ceritakan bagaimana kondisi ternak sapi saat tiba, keramahan peternak, dan proses transaksinya..." style="width: 100%; padding: 0.65rem 0.75rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; font-family: inherit; resize: vertical; outline: none;"></textarea>
                </div>

                {{-- Optional Photo Upload --}}
                <div style="margin-bottom: 0.25rem;">
                    <label style="display: block; font-weight: 600; color: #334155; font-size: 0.8rem; margin-bottom: 0.3rem;">
                        Foto Bukti Sapi Diterima (Opsional)
                    </label>
                    <input type="file" name="foto" accept="image/*" style="width: 100%; padding: 0.45rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.8rem; background: #f8fafc;">
                    <span style="font-size: 0.72rem; color: #64748b; margin-top: 2px; display: block;">Format JPG, PNG, WEBP. Maks 3MB.</span>
                </div>
            </div>

            <div class="modal-footer-clean">
                <button type="button" class="btn-action-outline" onclick="closeReviewModal()">Batal</button>
                <button type="submit" id="reviewSubmitBtn" class="btn-action-primary" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="bi bi-send-fill"></i> Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Proof Modal
    function openProofModal(src) {
        document.getElementById('proofModalImage').src = src;
        document.getElementById('proofModal').classList.add('open');
    }

    function closeProofModal(e) {
        if (!e || e.target.id === 'proofModal') {
            document.getElementById('proofModal').classList.remove('open');
        }
    }

    // Surat Modal
    function openSuratModal(src, nomor) {
        document.getElementById('modalSuratNomor').innerText = 'Nomor: ' + nomor;
        document.getElementById('suratDownloadBtn').href = src.includes('download=1') ? src : (src + (src.includes('?') ? '&' : '?') + 'download=1');
        
        var isPdf = src.toLowerCase().endsWith('.pdf') || src.includes('surat-pdf');
        if (isPdf) {
            document.getElementById('suratModalImage').style.display = 'none';
            document.getElementById('suratModalPdf').src = src;
            document.getElementById('suratModalPdf').style.display = 'block';
        } else {
            document.getElementById('suratModalPdf').style.display = 'none';
            document.getElementById('suratModalImage').src = src;
            document.getElementById('suratModalImage').style.display = 'block';
        }
        
        document.getElementById('suratModal').classList.add('open');
    }

    function closeSuratModal(e) {
        if (!e || e.target.id === 'suratModal') {
            document.getElementById('suratModal').classList.remove('open');
        }
    }

    // Review Modal
    function openReviewModal(orderId, kodeTrx, peternakName, cattleDesc, isCompleteAction, existingRating = 5, existingKomentar = '', existingTags = []) {
        var form = document.getElementById('reviewForm');
        var title = document.getElementById('reviewModalTitle');
        var subtitle = document.getElementById('reviewModalSubtitle');
        var alertDikirim = document.getElementById('reviewAlertDikirim');
        var submitBtn = document.getElementById('reviewSubmitBtn');

        subtitle.innerText = kodeTrx + ' • ' + cattleDesc + ' • Peternak: ' + peternakName;

        if (isCompleteAction) {
            form.action = '/pemesanan/' + orderId + '/selesai';
            title.innerHTML = '<i class="bi bi-check-circle-fill" style="color: #10b981;"></i> Konfirmasi Selesai & Beri Ulasan';
            alertDikirim.style.display = 'block';
            submitBtn.innerHTML = '<i class="bi bi-check2-circle"></i> Selesaikan Pesanan & Kirim Ulasan';
        } else {
            form.action = '/pemesanan/' + orderId + '/ulasan';
            title.innerHTML = '<i class="bi bi-star-fill" style="color: #f59e0b;"></i> ' + (existingRating ? 'Ubah Ulasan Peternak' : 'Beri Ulasan Peternak');
            alertDikirim.style.display = 'none';
            submitBtn.innerHTML = '<i class="bi bi-send-fill"></i> Simpan Ulasan';
        }

        // Set star rating
        setStarRating(existingRating || 5);
        document.getElementById('reviewKomentar').value = existingKomentar || '';

        // Set tags
        var checkboxes = form.querySelectorAll('input[name="kategori[]"]');
        checkboxes.forEach(function(cb) {
            cb.checked = existingTags && existingTags.includes(cb.value);
        });

        document.getElementById('reviewModal').classList.add('open');
    }

    function closeReviewModal(e) {
        if (!e || e.target.id === 'reviewModal') {
            document.getElementById('reviewModal').classList.remove('open');
        }
    }

    function setStarRating(val) {
        document.getElementById('reviewRatingInput').value = val;
        var stars = document.querySelectorAll('#starContainer .star-btn');
        stars.forEach(function(star) {
            var sVal = parseInt(star.getAttribute('data-val'));
            if (sVal <= val) {
                star.style.color = '#f59e0b';
            } else {
                star.style.color = '#cbd5e1';
            }
        });

        var labels = {
            1: '⭐ Sangat Kurang',
            2: '⭐⭐ Kurang Memuaskan',
            3: '⭐⭐⭐ Cukup Baik',
            4: '⭐⭐⭐⭐ Puas!',
            5: '⭐⭐⭐⭐⭐ Sangat Puas & Direkomendasikan!'
        };
        document.getElementById('ratingLabel').innerText = labels[val] || '';
    }

    // Interactive Star Click & Hover
    document.addEventListener('DOMContentLoaded', function() {
        var stars = document.querySelectorAll('#starContainer .star-btn');
        stars.forEach(function(star) {
            star.addEventListener('click', function() {
                var val = parseInt(this.getAttribute('data-val'));
                setStarRating(val);
            });
            star.addEventListener('mouseenter', function() {
                var val = parseInt(this.getAttribute('data-val'));
                stars.forEach(function(s) {
                    var sVal = parseInt(s.getAttribute('data-val'));
                    s.style.color = sVal <= val ? '#f59e0b' : '#cbd5e1';
                });
            });
        });

        var container = document.getElementById('starContainer');
        if (container) {
            container.addEventListener('mouseleave', function() {
                var currentVal = parseInt(document.getElementById('reviewRatingInput').value) || 5;
                setStarRating(currentVal);
            });
        }
    });
</script>
@endsection
