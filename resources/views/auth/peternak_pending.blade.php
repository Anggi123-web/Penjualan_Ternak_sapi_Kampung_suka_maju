<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pendaftaran Akun Peternak Menunggu Verifikasi — Sistem Penjualan Ternak Sapi Kampung Suka Maju">
    <title>Pendaftaran Menunggu Verifikasi — SIPETER Suka Maju</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Unified SIPETER Design System & Dark/Light Mode Theme -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <script src="{{ asset('js/theme-manager.js') }}"></script>

    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-page, #0f172a);
            color: var(--text-primary, #f1f5f9);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 2rem 1rem;
            transition: var(--theme-transition);
        }

        .bg-gradient {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .bg-gradient::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
            top: -200px;
            right: -100px;
        }

        .bg-gradient::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
            bottom: -150px;
            left: -100px;
        }

        .grid-pattern {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 1;
            pointer-events: none;
        }

        .pending-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 640px;
            background: var(--bg-card, #ffffff);
            border: 1.5px solid var(--border-color, #e2e8f0);
            border-radius: 24px;
            padding: 2.75rem 2.25rem;
            box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.1), 0 0 0 1px rgba(15, 23, 42, 0.05);
            text-align: center;
            backdrop-filter: blur(20px);
            animation: cardEntry 0.5s ease forwards;
        }

        @keyframes cardEntry {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .status-badge-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(245, 158, 11, 0.12);
            color: #f59e0b;
            border: 2px dashed #f59e0b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 1.5rem auto;
            animation: pulseWarning 2.5s infinite;
        }

        @keyframes pulseWarning {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.3); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 12px rgba(245, 158, 11, 0); }
        }

        .pending-title {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--text-heading, #0f172a);
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .pending-subtitle {
            font-size: 0.95rem;
            color: var(--text-secondary, #475569);
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .timeline-steps {
            text-align: left;
            background: var(--bg-surface, #f8fafc);
            border: 1.5px solid var(--border-color, #e2e8f0);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .timeline-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.25rem;
            position: relative;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 17px;
            top: 36px;
            bottom: -14px;
            width: 2px;
            background: var(--border-color, #cbd5e1);
        }

        .step-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            font-weight: 800;
        }

        .step-icon.done {
            background: #10b981;
            color: white;
        }

        .step-icon.active {
            background: #f59e0b;
            color: white;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.2);
        }

        .step-icon.upcoming {
            background: var(--bg-muted, #e2e8f0);
            color: var(--text-muted, #94a3b8);
        }

        .step-content h5 {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-heading, #0f172a);
            margin-bottom: 0.2rem;
        }

        .step-content p {
            font-size: 0.82rem;
            color: var(--text-secondary, #64748b);
            line-height: 1.45;
            margin: 0;
        }

        .info-box-wa {
            background: rgba(16, 185, 129, 0.08);
            border: 1.5px solid rgba(16, 185, 129, 0.25);
            border-radius: 14px;
            padding: 1.2rem;
            display: flex;
            align-items: flex-start;
            gap: 0.9rem;
            text-align: left;
            margin-bottom: 2rem;
        }

        .info-box-wa i {
            font-size: 1.8rem;
            color: #10b981;
            flex-shrink: 0;
            line-height: 1;
        }

        .info-box-wa h6 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-heading, #0f172a);
            margin-bottom: 0.25rem;
        }

        .info-box-wa p {
            font-size: 0.82rem;
            color: var(--text-secondary, #475569);
            line-height: 1.45;
            margin: 0;
        }

        .btn-group-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        @media (min-width: 520px) {
            .btn-group-actions {
                flex-direction: row;
            }
            .btn-group-actions > * {
                flex: 1;
            }
        }

        .btn-primary-sipeter {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.9rem 1.5rem;
            background: linear-gradient(135deg, var(--green-brand, #00A740), var(--green-hover, #008f38));
            color: white !important;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.92rem;
            text-decoration: none;
            transition: all 0.25s ease;
            border: none;
            box-shadow: 0 4px 14px var(--green-glow, rgba(0, 167, 64, 0.25));
        }

        .btn-primary-sipeter:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--green-glow, rgba(0, 167, 64, 0.4));
        }

        .btn-secondary-sipeter {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.9rem 1.5rem;
            background: var(--bg-surface, #f8fafc);
            color: var(--text-primary, #0f172a) !important;
            border: 1.5px solid var(--border-color, #cbd5e1);
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.92rem;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-secondary-sipeter:hover {
            background: var(--bg-muted, #f1f5f9);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div style="position: fixed; top: 20px; left: 24px; z-index: 100;">
        <a href="{{ route('beranda') }}" class="sipeter-back-btn" title="Kembali ke Beranda">
            <i class="bi bi-arrow-left"></i> Beranda
        </a>
    </div>

    <div style="position: fixed; top: 20px; right: 24px; z-index: 100;">
        @include('partials.theme_toggle', ['id' => 'pendingThemeToggle'])
    </div>

    <div class="bg-gradient"></div>
    <div class="grid-pattern"></div>

    <div class="pending-card">
        <!-- Logo -->
        <div style="margin-bottom: 1.5rem;">
            <a href="{{ route('beranda') }}">
                <img src="{{ asset('images/sipeter_logo.png') }}" class="sipeter-brand-logo" alt="Logo" style="height: 58px; width: auto; object-fit: contain;">
            </a>
        </div>

        <!-- Status Icon -->
        <div class="status-badge-icon">
            <i class="bi bi-hourglass-split"></i>
        </div>

        <h1 class="pending-title">Pendaftaran Berhasil Diajukan!</h1>
        <p class="pending-subtitle">
            Terima kasih, <strong>{{ $user ? $user->name : 'Bapak/Ibu Peternak' }}</strong>. Akun Anda telah tercatat di sistem dan saat ini <strong>sedang dalam proses verifikasi oleh Aparat Kampung Suka Maju</strong>.
        </p>

        <!-- Timeline Tahapan -->
        <div class="timeline-steps">
            <div class="timeline-item">
                <div class="step-icon done">
                    <i class="bi bi-check-lg"></i>
                </div>
                <div class="step-content">
                    <h5>1. Pengisian Formulir & Unggah KTP</h5>
                    <p>Data identitas, alamat kandang, dan foto KTP telah berhasil disimpan di server kampung.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="step-icon active">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="step-content">
                    <h5>2. Verifikasi oleh Aparat Kampung (Sedang Berlangsung)</h5>
                    <p>Aparat Pemerintahan Kampung Suka Maju memeriksa keaslian KTP dan validitas lokasi peternak.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="step-icon upcoming">
                    <i class="bi bi-whatsapp"></i>
                </div>
                <div class="step-content">
                    <h5>3. Pengiriman Notifikasi & Akun via WhatsApp</h5>
                    <p>Setelah disetujui, aparat kampung akan mengirimkan konfirmasi aktivasi resmi langsung ke WhatsApp Anda.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="step-icon upcoming">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <div class="step-content">
                    <h5>4. Login & Siap Jual Sapi</h5>
                    <p>Anda dapat login ke dashboard Peternak untuk mendaftarkan dan menjual ternak sapi Anda.</p>
                </div>
            </div>
        </div>

        <!-- WhatsApp Info Box -->
        <div class="info-box-wa">
            <i class="bi bi-whatsapp"></i>
            <div>
                <h6>Notifikasi Aktivasi Dikirim Lewat WhatsApp</h6>
                <p>
                    Pastikan nomor WhatsApp Anda <strong>{{ $user ? $user->no_telepon : 'yang Anda daftarkan' }}</strong> tetap aktif. Anda akan menerima pesan resmi dari pihak Kampung Suka Maju saat akun telah disetujui.
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="btn-group-actions">
            <a href="{{ route('login') }}" class="btn-primary-sipeter">
                <i class="bi bi-box-arrow-in-right"></i> Cek Status / Login
            </a>
            <a href="{{ route('beranda') }}" class="btn-secondary-sipeter">
                <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
