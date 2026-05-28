<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Katalog Penjualan Sapi - Temukan sapi berkualitas dari peternak terpercaya dengan sertifikasi kesehatan resmi.">
    <title>Sistem Penjualan Ternak Sapi — SIPETER</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Alex+Brush&family=Satisfy&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --green-brand: #00A740;
            --green-hover: #008f38;
            --black-text: #000000;
            --medium-gray: #555555;
            --light-bg: #f8fafc;
            --font-montserrat: 'Montserrat', sans-serif;
            --font-inter: 'Inter', sans-serif;
            --font-sloop: 'Alex Brush', 'Satisfy', cursive;
        }

        body {
            font-family: var(--font-inter);
            background-color: var(--light-bg);
            color: var(--black-text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .font-bold-custom {
            font-family: var(--font-montserrat);
            font-weight: 700;
        }

        /* ═══ Navbar ═══ */
        .navbar-premium {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 110px; /* Scaled down from 140px */
            z-index: 100;
            background: rgba(255, 255, 255, 0.7); /* Opacity 70 */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }

        .navbar-inner-p {
            width: 100%;
            max-width: 1920px;
            margin: 0 auto;
            padding: 0 144px 0 123px; /* Exact Figma margins maintained */
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            height: 110px;
        }

        .navbar-brand-p {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .navbar-logo-img {
            height: 70px; /* Scaled down from 90px */
            width: auto;
            object-fit: contain;
        }

        .navbar-links-p {
            display: flex;
            gap: 60px; /* Scaled down from 100px for better fit */
            align-items: center;
        }

        .nav-link-p {
            font-family: var(--font-montserrat);
            font-size: 18px; /* Scaled down from 24px */
            font-weight: 700;
            color: #000000;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .nav-link-p.active, .nav-link-p:hover {
            color: var(--green-brand);
        }

        .navbar-actions-p {
            display: flex;
            align-items: center;
            gap: 20px; /* Scaled down from 26px */
        }

        /* Search input */
        .nav-search-wrapper-p {
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 4px solid var(--green-brand); /* Scaled border thickness */
            border-radius: 8px;
            width: 320px; /* Scaled down from 384px */
            height: 42px; /* Scaled down from 48px */
            overflow: hidden;
        }

        .nav-search-btn-p {
            background: var(--green-brand);
            border: none;
            width: 48px; /* Scaled down from 56px */
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #ffffff;
            transition: background-color 0.2s ease;
        }

        .nav-search-btn-p:hover {
            background: var(--green-hover);
        }

        .nav-search-input-p {
            border: none;
            outline: none;
            padding: 0 10px;
            width: 100%;
            font-size: 15px; /* Scaled down from 18px */
            font-family: var(--font-montserrat);
            font-weight: 700;
            color: #000000;
        }

        /* Login button */
        .btn-login-p {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 120px; /* Scaled down from 160px */
            height: 42px; /* Scaled down from 48px */
            background: var(--green-brand);
            color: #ffffff;
            font-family: var(--font-montserrat);
            font-size: 18px; /* Scaled down from 24px */
            font-weight: 700;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.2s ease;
        }

        .btn-login-p:hover {
            background: var(--green-hover);
        }

        .btn-logout-p {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 15px;
            width: 120px;
            height: 42px;
            border: 2px solid rgba(239, 68, 68, 0.3);
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            font-family: var(--font-montserrat);
            font-size: 16px;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-logout-p:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #ef4444;
        }

        /* Hamburger button */
        .hamburger-menu-btn {
            display: none;
            background: none;
            border: none;
            color: #000000;
            font-size: 32px;
            cursor: pointer;
        }

        .user-menu-dropdown:hover .dropdown-content {
            display: block !important;
        }

        /* ═══ Hero Carousel Section ═══ */
        .hero-carousel-section {
            padding-top: 140px; /* Space for fixed navbar */
            padding-bottom: 40px;
            background-color: var(--light-bg);
            width: 100%;
        }

        .carousel-wrapper {
            max-width: 1920px;
            margin: 0 auto;
            padding: 0 144px 0 123px; /* Align with navbar */
        }

        .carousel-container {
            position: relative;
            width: 100%;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-slide {
            min-width: 100%;
        }

        .carousel-slide img {
            width: 100%;
            aspect-ratio: 1638 / 500;
            display: block;
            border-radius: 30px;
            object-fit: cover;
            object-position: center;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.8);
            color: var(--green-brand);
            border: none;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 24px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .carousel-btn:hover {
            background: var(--green-brand);
            color: white;
        }

        .carousel-btn.prev {
            left: 20px;
        }

        .carousel-btn.next {
            right: 20px;
        }

        .carousel-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
            z-index: 10;
        }

        .carousel-dots .dot {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .carousel-dots .dot.active {
            background: var(--green-brand);
            width: 30px;
            border-radius: 10px;
        }

        /* ═══ Stats Section ═══ */
        .stats-section {
            background: #ffffff;
            padding: 3rem 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-around;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .stat-card {
            text-align: center;
            padding: 1.5rem 3rem;
            border-radius: 12px;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-number {
            font-family: var(--font-montserrat);
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--black-text);
            line-height: 1.1;
        }

        .stat-number.green {
            color: var(--green-brand);
        }

        .stat-label {
            font-family: var(--font-montserrat);
            font-size: 1rem;
            font-weight: 700;
            color: var(--medium-gray);
            margin-top: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* ═══ Catalog Section ═══ */
        .catalog-section {
            max-width: 1440px;
            margin: 0 auto;
            padding: 6rem 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-tag {
            font-family: var(--font-montserrat);
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--green-brand);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
            display: block;
        }

        .section-title {
            font-family: var(--font-montserrat);
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--black-text);
            letter-spacing: -0.02em;
        }

        /* Filters */
        .filter-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 30px -10px rgba(0, 167, 64, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.03);
            margin-bottom: 3rem;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            align-items: flex-end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-label {
            font-family: var(--font-montserrat);
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--medium-gray);
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .filter-input {
            width: 100%;
            height: 46px;
            padding: 0 1rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            font-family: var(--font-inter);
            font-size: 0.95rem;
            color: var(--black-text);
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--green-brand);
            box-shadow: 0 0 0 3px rgba(0, 167, 64, 0.1);
        }

        .filter-buttons-wrapper {
            display: flex;
            gap: 1rem;
        }

        .btn-search-apply {
            flex: 1;
            height: 46px;
            background: var(--green-brand);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-family: var(--font-montserrat);
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-search-apply:hover {
            background: var(--green-hover);
        }

        .btn-search-reset {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 46px;
            padding: 0 1.5rem;
            background: #ffffff;
            color: var(--medium-gray);
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            font-family: var(--font-montserrat);
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-search-reset:hover {
            background: #f1f5f9;
            color: var(--black-text);
        }

        .results-count {
            font-family: var(--font-inter);
            font-size: 1rem;
            color: var(--medium-gray);
            margin-bottom: 1.5rem;
        }

        .results-count strong {
            color: var(--black-text);
        }

        /* Cattle Grid */
        .sapi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        .sapi-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sapi-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: rgba(0, 167, 64, 0.25);
        }

        .sapi-card-img-wrapper {
            position: relative;
            width: 100%;
            height: 220px;
            overflow: hidden;
            background: #f1f5f9;
        }

        .sapi-card-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .sapi-card:hover .sapi-card-img-wrapper img {
            transform: scale(1.06);
        }

        .sapi-card-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4.5rem;
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            opacity: 0.7;
        }

        /* Checkmark Certified Badge */
        .badge-certified {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--green-brand);
            color: #ffffff;
            padding: 0.4rem 0.85rem;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-family: var(--font-montserrat);
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            box-shadow: 0 4px 10px rgba(0, 167, 64, 0.3);
            z-index: 5;
        }

        .badge-certified-icon {
            width: 16px;
            height: 16px;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .badge-certified-icon svg {
            width: 11px;
            height: 11px;
            stroke: var(--green-brand);
            stroke-width: 3.5;
        }

        .sapi-card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .sapi-card-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
            gap: 1rem;
        }

        .sapi-card-jenis {
            font-family: var(--font-montserrat);
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--black-text);
        }

        .sapi-card-harga {
            font-family: var(--font-montserrat);
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--green-brand);
            white-space: nowrap;
        }

        .sapi-card-specs {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.25rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding-bottom: 0.75rem;
        }

        .sapi-spec-item {
            font-size: 0.85rem;
            color: var(--medium-gray);
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .sapi-spec-item strong {
            color: var(--black-text);
        }

        .sapi-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            font-size: 0.8rem;
            color: var(--medium-gray);
        }

        .sapi-peternak {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-weight: 600;
            color: var(--black-text);
        }

        /* Empty State */
        .empty-catalog {
            grid-column: 1 / -1;
            text-align: center;
            padding: 5rem 2rem;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 30px -10px rgba(0, 167, 64, 0.05);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.6;
        }

        .empty-title {
            font-size: 1.35rem;
            margin-bottom: 0.5rem;
            color: var(--black-text);
        }

        .empty-desc {
            font-size: 0.95rem;
            color: var(--medium-gray);
            max-width: 400px;
            margin: 0 auto;
        }

        /* ═══ About Us Section ═══ */
        .about-section {
            background: #ffffff;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 6rem 2rem;
        }

        .about-container {
            max-width: 1440px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-content {
            display: flex;
            flex-direction: column;
        }

        .about-title {
            font-family: var(--font-montserrat);
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--black-text);
            line-height: 1.15;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .about-text {
            font-size: 1.05rem;
            line-height: 1.75;
            color: var(--medium-gray);
            margin-bottom: 2rem;
        }

        .about-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .about-feature-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 1.25rem;
            background: #f1f5f9;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .about-feature-item:hover {
            border-color: rgba(0, 167, 64, 0.2);
            transform: translateY(-2px);
        }

        .about-feature-icon {
            font-size: 1.5rem;
        }

        .about-feature-title {
            font-family: var(--font-montserrat);
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--black-text);
        }

        .about-feature-desc {
            font-size: 0.8rem;
            color: var(--medium-gray);
            line-height: 1.4;
        }

        .about-image-wrapper {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            height: 480px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
        }

        .about-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ═══ Footer ═══ */
        .footer {
            background: #ffffff;
            padding: 5rem 2rem 2.5rem;
        }

        .footer-inner {
            max-width: 1440px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            gap: 3rem;
            flex-wrap: wrap;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding-bottom: 4rem;
            margin-bottom: 2.5rem;
        }

        .footer-brand {
            max-width: 320px;
        }

        .footer-logo-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .footer-desc {
            font-size: 0.9rem;
            line-height: 1.6;
            color: var(--medium-gray);
        }

        .footer-links-group {
            display: flex;
            gap: 4rem;
        }

        .footer-column {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .footer-heading {
            font-family: var(--font-montserrat);
            font-size: 0.95rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--black-text);
        }

        .footer-link {
            font-size: 0.9rem;
            color: var(--medium-gray);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-link:hover {
            color: var(--green-brand);
        }

        .footer-copy {
            text-align: center;
            font-size: 0.85rem;
            color: var(--medium-gray);
        }

        /* ═══ Mobile Drawer Menu ═══ */
        .mobile-menu-drawer {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 360px;
            height: 100%;
            background: #ffffff;
            z-index: 150;
            box-shadow: -10px 0 30px rgba(0,0,0,0.1);
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-menu-drawer.open {
            right: 0;
        }

        .mobile-menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 140;
            display: none;
            backdrop-filter: blur(4px);
        }

        .mobile-menu-overlay.open {
            display: block;
        }

        .drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding-bottom: 1.5rem;
        }

        .drawer-close {
            background: none;
            border: none;
            font-size: 1.75rem;
            cursor: pointer;
            color: var(--black-text);
        }

        .drawer-nav {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .drawer-link {
            font-family: var(--font-montserrat);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--black-text);
            text-decoration: none;
        }

        .drawer-link:hover, .drawer-link.active {
            color: var(--green-brand);
        }

        /* ═══ Responsive Media Queries (Scaling gaps and widths) ═══ */
        @media (max-width: 1780px) {
            .navbar-inner-p {
                padding: 0 60px 0 60px;
            }
            .navbar-links-p {
                gap: 40px;
            }
            .nav-link-p {
                font-size: 16px;
            }
            .nav-search-wrapper-p {
                width: 260px;
            }
            .btn-login-p, .btn-logout-p {
                width: 110px;
                font-size: 16px;
            }
            .carousel-wrapper { padding: 0 60px; }
        }

        @media (max-width: 1399px) {
            .navbar-inner-p {
                padding: 0 40px 0 40px;
            }
            .navbar-links-p {
                gap: 24px;
            }
            .nav-link-p {
                font-size: 14px;
            }
            .nav-search-wrapper-p {
                width: 220px;
                height: 38px;
                border-width: 3px;
            }
            .nav-search-btn-p {
                width: 40px;
            }
            .nav-search-input-p {
                font-size: 13px;
            }
            .btn-login-p, .btn-logout-p {
                width: 95px;
                height: 38px;
                font-size: 14px;
            }
            .carousel-wrapper { padding: 0 40px; }
        }

        @media (max-width: 1199px) {
            .navbar-premium {
                height: 110px;
            }

            .navbar-inner-p {
                padding: 0 30px 0 30px;
                height: 110px;
            }

            .navbar-logo-img {
                height: 70px;
            }

            .navbar-links-p, .navbar-actions-p {
                display: none;
            }

            .hamburger-menu-btn {
                display: block;
                position: absolute;
                right: 30px;
                top: 34px;
            }
            
            .carousel-wrapper { padding: 0 20px; }
            .carousel-container { border-radius: 20px; }
            .carousel-slide img { border-radius: 20px; }
        }

        @media (max-width: 576px) {
            .navbar-inner-p {
                padding: 0 15px 0 15px;
            }

            .navbar-logo-img {
                height: 60px;
            }

            .hero-carousel-section { padding-top: 100px; }
            .carousel-btn { width: 36px; height: 36px; font-size: 18px; }
        }
    </style>
</head>
<body id="home">

    {{-- Overlay & Drawer Menu untuk Mobile --}}
    <div class="mobile-menu-overlay" id="mobileOverlay"></div>
    <div class="mobile-menu-drawer" id="mobileDrawer">
        <div class="drawer-header">
            <div class="navbar-brand">
                <img src="{{ asset('images/sipeter_logo.png') }}" class="navbar-brand-logo" alt="Logo" style="height: 55px; width: auto; object-fit: contain;">
            </div>
            <button class="drawer-close" id="drawerClose">&times;</button>
        </div>
        
        <!-- Search inside Mobile Drawer -->
        <form action="{{ route('katalog.index') }}" method="GET">
            <div class="navbar-search-wrapper" style="width: 100%; margin-top: 1rem; display: flex; align-items: center; border: 3px solid var(--green-brand); border-radius: 8px; overflow: hidden; height: 42px;">
                <button type="submit" class="navbar-search-btn" style="background: var(--green-brand); border: none; width: 44px; height: 100%; display: flex; align-items: center; justify-content: center; color: white;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
                <input type="text" name="search" class="navbar-search-input" placeholder="Cari jenis sapi..." value="{{ request('search') }}" style="border: none; outline: none; padding: 0 10px; flex: 1; font-size: 14px;">
            </div>
        </form>

        <div class="drawer-nav" style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
            <a href="{{ route('beranda') }}" class="drawer-link {{ request()->routeIs('beranda') ? 'active' : '' }}" id="m-link-home">Branda</a>
            <a href="{{ route('katalog.index') }}" class="drawer-link {{ request()->routeIs('katalog.*') ? 'active' : '' }}" id="m-link-catalog">Catalog</a>
            <a href="{{ route('about') }}" class="drawer-link {{ request()->routeIs('about') ? 'active' : '' }}" id="m-link-about">About us</a>
        </div>
        
        <div style="margin-top: auto; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 1.5rem;">
            @auth
                @php
                    $dashboardRoute = match(auth()->user()->role) {
                        'peternak' => route('peternak.dashboard'),
                        'pembeli' => route('pembeli.dashboard'),
                        'mantri_hewan' => route('mantri_hewan.dashboard'),
                        'pengurus_kampung' => route('pengurus_kampung.dashboard'),
                    };
                @endphp
                <a href="{{ $dashboardRoute }}" class="btn-login-premium" style="width: 100%; margin-bottom: 0.75rem; text-align: center; display: inline-flex; align-items: center; justify-content: center; height: 42px; background: var(--green-brand); color: white; border-radius: 8px; font-family: var(--font-montserrat); font-weight: 700; text-decoration: none;">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display: block; width: 100%;">
                    @csrf
                    <button type="submit" class="btn-search-reset" style="width: 100%; height: 42px; border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; background: transparent; border-radius: 8px; cursor: pointer;">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login-premium" style="width: 100%; text-align: center; display: inline-flex; align-items: center; justify-content: center; height: 42px; background: var(--green-brand); color: white; border-radius: 8px; font-family: var(--font-montserrat); font-weight: 700; text-decoration: none;">Login</a>
            @endauth
        </div>
    </div>

    {{-- ═══ Navbar ═══ --}}
    <nav class="navbar-premium">
        <div class="navbar-inner-p">
            <!-- Logo image with built-in branding text -->
            <a href="{{ route('katalog.index') }}" class="navbar-brand-p">
                <img src="{{ asset('images/sipeter_logo.png') }}" class="navbar-logo-img" alt="Logo">
            </a>

            <!-- Spaced Navigation Links -->
            <div class="navbar-links-p">
                <a href="{{ route('beranda') }}" class="nav-link-p {{ request()->routeIs('beranda') ? 'active' : '' }}" id="link-home">Branda</a>
                <a href="{{ route('katalog.index') }}" class="nav-link-p {{ request()->routeIs('katalog.*') ? 'active' : '' }}" id="link-catalog">Catalog</a>
                <a href="{{ route('about') }}" class="nav-link-p {{ request()->routeIs('about') ? 'active' : '' }}" id="link-about">About us</a>
            </div>

            <!-- Actions block -->
            <div class="navbar-actions-p">
                <form action="{{ route('katalog.index') }}" method="GET" class="nav-search-form">
                    @if(request('jenis')) <input type="hidden" name="jenis" value="{{ request('jenis') }}"> @endif
                    @if(request('harga_min')) <input type="hidden" name="harga_min" value="{{ request('harga_min') }}"> @endif
                    @if(request('harga_max')) <input type="hidden" name="harga_max" value="{{ request('harga_max') }}"> @endif
                    @if(request('sertifikasi')) <input type="hidden" name="sertifikasi" value="{{ request('sertifikasi') }}"> @endif

                    <div class="nav-search-wrapper-p">
                        <button type="submit" class="nav-search-btn-p">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        <input type="text" name="search" class="nav-search-input-p" placeholder="" value="{{ request('search') }}">
                    </div>
                </form>

                @auth
                    @if(auth()->user()->role === 'pembeli')
                        @php
                            $keranjangCount = \App\Models\Keranjang::where('user_id', auth()->id())->count();
                        @endphp
                        <a href="{{ route('pembeli.keranjang.index') }}" style="display: flex; align-items: center; justify-content: center; width: 42px; height: 42px; background: rgba(0, 167, 64, 0.1); border-radius: 8px; position: relative; text-decoration: none; color: var(--green-brand); transition: background-color 0.2s ease;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                            @if($keranjangCount > 0)
                                <span style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; font-size: 10px; font-weight: bold; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">{{ $keranjangCount }}</span>
                            @endif
                        </a>
                        <div class="user-menu-dropdown" style="position: relative; display: inline-block;">
                            <a href="{{ route('pembeli.dashboard') }}" class="btn-login-p" style="width: auto; padding: 0 15px; border: none; cursor: pointer; text-decoration: none; display: flex; align-items: center;">👤 Akun Saya</a>
                            <div class="dropdown-content" style="display: none; position: absolute; right: 0; padding-top: 8px; min-width: 160px; z-index: 10;">
                                <div style="background-color: #ffffff; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; border: 1px solid rgba(0,0,0,0.05);">
                                    <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                                        @csrf
                                        <button type="submit" style="width: 100%; text-align: left; padding: 12px 16px; border: none; background: transparent; cursor: pointer; color: #ef4444; font-weight: bold; font-family: var(--font-inter); transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#fee2e2'" onmouseout="this.style.backgroundColor='transparent'">Keluar</button>
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
                        <a href="{{ $dashboardRoute }}" class="btn-login-p">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                            @csrf
                            <button type="submit" class="btn-logout-p">Keluar</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-login-p">Login</a>
                @endauth
            </div>
            
            <button class="hamburger-menu-btn" id="hamburgerBtn">&#9776;</button>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>

    {{-- ═══ Footer ═══ --}}
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="footer-logo-row">
                    <img src="{{ asset('images/sipeter_logo.png') }}" alt="Logo" style="height: 80px; width: auto; object-fit: contain;">
                </div>
                <p class="footer-desc">
                    Mewujudkan ekosistem peternakan sapi digital Indonesia yang lebih sehat, transparan, dan terpercaya bagi peternak dan pembeli.
                </p>
            </div>

            <div class="footer-links-group">
                <div class="footer-column">
                    <h4 class="footer-heading">Navigasi</h4>
                    <a href="{{ route('beranda') }}" class="footer-link">Branda</a>
                    <a href="{{ route('katalog.index') }}" class="footer-link">Catalog</a>
                    <a href="{{ route('about') }}" class="footer-link">About Us</a>
                </div>
                <div class="footer-column">
                    <h4 class="footer-heading">Akses Sistem</h4>
                    <a href="{{ route('login') }}" class="footer-link">Masuk</a>
                    <a href="{{ route('register') }}" class="footer-link">Daftar Akun Baru</a>
                </div>
            </div>
        </div>

        <div class="footer-copy">
            <p>&copy; {{ date('Y') }} SIPETER — Sistem Penjualan Ternak Sapi. All rights reserved.</p>
        </div>
    </footer>

    {{-- JavaScript untuk Interaksi Smooth-scroll, Active states & Mobile Drawer --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const drawerClose = document.getElementById('drawerClose');
            const mobileDrawer = document.getElementById('mobileDrawer');
            const mobileOverlay = document.getElementById('mobileOverlay');
            
            // Toggle Mobile Drawer
            const toggleDrawer = () => {
                mobileDrawer.classList.toggle('open');
                mobileOverlay.classList.toggle('open');
            };

            hamburgerBtn.addEventListener('click', toggleDrawer);
            drawerClose.addEventListener('click', toggleDrawer);
            mobileOverlay.addEventListener('click', toggleDrawer);

            // Removed scroll active state logic since this is now multi-page

            // Carousel Logic
            const track = document.getElementById('carouselTrack');
            const dots = document.querySelectorAll('.carousel-dots .dot');
            let slideIndex = 0;
            const slideCount = dots.length;
            let slideInterval;

            function updateCarousel() {
                if(track) track.style.transform = `translateX(-${slideIndex * 100}%)`;
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === slideIndex);
                });
            }

            window.moveSlide = function(step) {
                slideIndex += step;
                if (slideIndex >= slideCount) slideIndex = 0;
                if (slideIndex < 0) slideIndex = slideCount - 1;
                updateCarousel();
                resetInterval();
            };

            window.currentSlide = function(index) {
                slideIndex = index;
                updateCarousel();
                resetInterval();
            };

            function startInterval() {
                slideInterval = setInterval(() => {
                    window.moveSlide(1);
                }, 5000); // 5 seconds autoplay
            }

            function resetInterval() {
                clearInterval(slideInterval);
                startInterval();
            }

            if(track) {
                startInterval();
            }

            // Close Mobile Drawer on link click
            document.querySelectorAll('.drawer-link').forEach(link => {
                link.addEventListener('click', () => {
                    mobileDrawer.classList.remove('open');
                    mobileOverlay.classList.remove('open');
                });
            });
        });
    </script>
</body>
</html>
