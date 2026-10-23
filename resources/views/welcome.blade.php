<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Penjualan Sapi - Platform digital untuk peternak, pembeli, mantri hewan, dan pengurus kampung">
    <title>Sistem Penjualan Sapi — Pilih Akun</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
            position: relative;
        }

        /* Animated Background */
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
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
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
            background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
            bottom: -150px;
            right: -100px;
            animation: float 18s ease-in-out infinite reverse;
        }

        .bg-orb {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: pulse-slow 12s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 0.5; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 0.8; transform: translate(-50%, -50%) scale(1.1); }
        }

        /* Grid Pattern */
        .grid-pattern {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 1;
        }

        /* Main Content */
        .container {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .header-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #6ee7b7;
            margin-bottom: 1.5rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .header-badge span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            animation: blink 2s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .header h1 {
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: -0.04em;
            line-height: 1.1;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #f1f5f9, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 1.15rem;
            color: #94a3b8;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .role-card {
            position: relative;
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(148, 163, 184, 0.08);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .role-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            padding: 1px;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        .role-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 20px 20px 0 0;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .role-card:hover {
            transform: translateY(-8px);
            border-color: rgba(148, 163, 184, 0.15);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        }

        .role-card:hover::after {
            opacity: 1;
        }

        .role-card:hover .card-icon {
            transform: scale(1.1);
        }

        .role-card:hover .card-arrow {
            opacity: 1;
            transform: translateX(0);
        }

        /* Card colors per role */
        .card-peternak::after { background: linear-gradient(90deg, #10b981, #34d399); }
        .card-peternak:hover { border-color: rgba(16, 185, 129, 0.3); }
        .card-peternak .card-icon { background: rgba(16, 185, 129, 0.1); color: #6ee7b7; }

        .card-pembeli::after { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .card-pembeli:hover { border-color: rgba(59, 130, 246, 0.3); }
        .card-pembeli .card-icon { background: rgba(59, 130, 246, 0.1); color: #93c5fd; }

        .card-mantri::after { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .card-mantri:hover { border-color: rgba(245, 158, 11, 0.3); }
        .card-mantri .card-icon { background: rgba(245, 158, 11, 0.1); color: #fcd34d; }

        .card-pengurus::after { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
        .card-pengurus:hover { border-color: rgba(139, 92, 246, 0.3); }
        .card-pengurus .card-icon { background: rgba(139, 92, 246, 0.1); color: #c4b5fd; }

        .card-icon {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .card-desc {
            font-size: 0.85rem;
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .card-arrow {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            opacity: 0;
            transform: translateX(-8px);
            transition: all 0.3s ease;
        }

        .card-peternak .card-arrow { color: #6ee7b7; }
        .card-pembeli .card-arrow { color: #93c5fd; }
        .card-mantri .card-arrow { color: #fcd34d; }
        .card-pengurus .card-arrow { color: #c4b5fd; }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(148, 163, 184, 0.08);
        }

        .footer p {
            font-size: 0.8rem;
            color: #64748b;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .header h1 {
                font-size: 2.25rem;
            }

            .header p {
                font-size: 1rem;
            }

            .cards-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .container {
                padding: 1.5rem 1rem;
            }
        }

        /* Entrance Animation */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.6s ease forwards;
        }

        .fade-up:nth-child(1) { animation-delay: 0.1s; }
        .fade-up:nth-child(2) { animation-delay: 0.2s; }
        .fade-up:nth-child(3) { animation-delay: 0.3s; }
        .fade-up:nth-child(4) { animation-delay: 0.4s; }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.6s ease forwards;
        }
    </style>
</head>
<body>
    <div class="bg-gradient">
        <div class="bg-orb"></div>
    </div>
    <div class="grid-pattern"></div>

    <div class="container">
        <div class="header">
            <div class="header-badge">
                <span></span>
                Sistem Penjualan Sapi
            </div>
            <h1>Selamat Datang</h1>
            <p>Pilih jenis akun Anda untuk masuk ke sistem. Setiap peran memiliki akses dan fitur yang berbeda sesuai kebutuhan.</p>
        </div>

        <div class="cards-grid">
            <a href="{{ url('/login/peternak') }}" class="role-card card-peternak fade-up" id="card-peternak">
                <div class="card-icon"><i class="bi bi-piggy-bank"></i></div>
                <div class="card-title">Peternak</div>
                <div class="card-desc">Kelola data sapi, pantau kesehatan ternak, dan kelola penjualan</div>
                <div class="card-arrow">
                    Masuk
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </div>
            </a>

            <a href="{{ url('/login/pembeli') }}" class="role-card card-pembeli fade-up" id="card-pembeli">
                <div class="card-icon"><i class="bi bi-cart3"></i></div>
                <div class="card-title">Pembeli</div>
                <div class="card-desc">Cari dan beli sapi, lihat katalog, dan kelola pembelian Anda</div>
                <div class="card-arrow">
                    Masuk
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </div>
            </a>

            <a href="{{ url('/login/mantri-hewan') }}" class="role-card card-mantri fade-up" id="card-mantri">
                <div class="card-icon"><i class="bi bi-heart-pulse"></i></div>
                <div class="card-title">Mantri Hewan</div>
                <div class="card-desc">Periksa kesehatan ternak, buat surat keterangan sehat, dan catat riwayat medis</div>
                <div class="card-arrow">
                    Masuk
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </div>
            </a>

            <a href="{{ url('/login/pengurus-kampung') }}" class="role-card card-pengurus fade-up" id="card-pengurus">
                <div class="card-icon"><i class="bi bi-houses"></i></div>
                <div class="card-title">Pengurus Kampung</div>
                <div class="card-desc">Verifikasi data peternak, kelola administrasi, dan buat laporan wilayah</div>
                <div class="card-arrow">
                    Masuk
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </div>
            </a>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Sistem Penjualan Sapi. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
