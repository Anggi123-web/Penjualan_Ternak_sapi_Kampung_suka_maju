<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - Sistem Penjualan Sapi">
    <title>Login — Sistem Penjualan Sapi</title>
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
            overflow: hidden;
            transition: var(--theme-transition);
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
            width: 550px;
            height: 550px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
            top: -180px;
            right: -80px;
            animation: float 15s ease-in-out infinite;
        }

        .bg-gradient::after {
            content: '';
            position: absolute;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            bottom: -120px;
            left: -80px;
            animation: float 18s ease-in-out infinite reverse;
        }

        .bg-orb {
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, transparent 70%);
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

        .grid-pattern {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 1;
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 1.5rem;
        }

        /* Login Card */
        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(148, 163, 184, 0.08);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
            animation: cardEntry 0.5s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes cardEntry {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #3b82f6, #8b5cf6);
        }

        /* Logo Area */
        .login-logo-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 1.75rem;
        }

        .login-logo-box {
            width: auto;
            max-width: 280px;
            height: 72px;
            padding: 6px 16px;
            border: 1px solid rgba(148, 163, 184, 0.15);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-card, rgba(15, 23, 42, 0.5));
            overflow: hidden;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .login-logo-box:hover {
            border-color: rgba(16, 185, 129, 0.3);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.08);
        }

        .login-logo-box img {
            max-width: 100%;
            height: 56px;
            object-fit: contain;
            display: block;
        }

        /* Title */
        .login-title {
            text-align: center;
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 2rem;
            color: var(--text-heading, #0f172a);
        }

        /* Error */
        .form-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 0.85rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            50% { transform: translateX(6px); }
            75% { transform: translateX(-4px); }
        }

        .form-error-icon {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            color: #b91c1c;
        }

        .form-error-icon svg {
            width: 18px;
            height: 18px;
        }

        .form-error-text {
            font-size: 0.85rem;
            color: #b91c1c;
            font-weight: 600;
            line-height: 1.4;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-primary, #0f172a);
            margin-bottom: 0.6rem;
            letter-spacing: -0.01em;
        }

        .form-input {
            width: 100%;
            padding: 0.9rem 1.1rem;
            background: var(--input-bg, #ffffff);
            border: 1.5px solid var(--input-border, #cbd5e1);
            border-radius: 12px;
            color: var(--text-primary, #0f172a);
            font-size: 0.95rem;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            transition: all 0.25s ease;
            outline: none;
        }

        .form-input::placeholder {
            color: var(--text-muted, #64748b);
            opacity: 0.85;
        }

        .form-input:focus {
            border-color: var(--green-brand, #00A740);
            box-shadow: 0 0 0 3.5px var(--input-focus-ring, rgba(0, 167, 64, 0.2));
            background: var(--bg-surface, #ffffff);
            color: var(--text-primary, #0f172a);
        }

        /* Password wrapper */
        .input-password-wrapper {
            position: relative;
        }

        .input-password-wrapper .form-input {
            padding-right: 3rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted, #475569);
            cursor: pointer;
            padding: 0.25rem;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
        }

        .password-toggle svg {
            width: 18px;
            height: 18px;
        }

        .password-toggle:hover {
            color: var(--green-brand, #00A740);
        }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 0.95rem;
            background: linear-gradient(135deg, var(--green-brand, #00A740), var(--green-hover, #008f38));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 800;
            font-family: 'Montserrat', sans-serif;
            letter-spacing: 0.02em;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 0.75rem;
            box-shadow: 0 4px 14px var(--green-glow, rgba(0, 167, 64, 0.3));
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.15));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--green-glow, rgba(0, 167, 64, 0.45));
        }

        .btn-submit:hover::before {
            opacity: 1;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color, #e2e8f0);
            font-size: 0.92rem;
            font-weight: 500;
            color: var(--text-secondary, #334155);
        }

        .register-link a {
            color: var(--green-brand, #00A740);
            font-weight: 800;
            text-decoration: none;
            transition: color 0.2s ease;
            margin-left: 4px;
        }

        .register-link a:hover {
            color: var(--green-hover, #008f38);
            text-decoration: underline;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted, #64748b);
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 2.5rem 1.5rem;
            }

            .login-title {
                font-size: 1.45rem;
            }

            .login-logo-box {
                width: 120px;
                height: 70px;
            }
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
        @include('partials.theme_toggle', ['id' => 'loginThemeToggle'])
    </div>

    <div class="bg-gradient">
        <div class="bg-orb"></div>
    </div>
    <div class="grid-pattern"></div>

    <div class="login-container">
        <div class="login-card">
            {{-- Logo --}}
            <div class="login-logo-wrapper">
                <a href="{{ route('beranda') }}" class="login-logo-box" title="Kembali ke Beranda">
                    <img src="{{ asset('images/sipeter_logo.png') }}" class="sipeter-brand-logo" alt="SIPETER Logo">
                </a>
            </div>

            {{-- Title --}}
            <h1 class="login-title">Login</h1>

            {{-- Flash Alert Messages --}}
            @if (session('error'))
                <div class="form-error" style="margin-bottom: 1.25rem;">
                    <div class="form-error-icon">
                        <i class="bi bi-shield-x" style="font-size: 1.2rem;"></i>
                    </div>
                    <div class="form-error-text">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div style="display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.85rem 1rem; border-radius: 12px; font-size: 0.88rem; margin-bottom: 1.25rem; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.35); color: #d97706; font-weight: 600;">
                    <i class="bi bi-clock-history" style="font-size: 1.2rem; flex-shrink: 0; margin-top: 1px;"></i>
                    <div style="line-height: 1.45;">
                        {{ session('warning') }}
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div style="display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.85rem 1rem; border-radius: 12px; font-size: 0.88rem; margin-bottom: 1.25rem; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.35); color: #059669; font-weight: 600;">
                    <i class="bi bi-check-circle" style="font-size: 1.2rem; flex-shrink: 0; margin-top: 1px;"></i>
                    <div style="line-height: 1.45;">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="form-error">
                    <div class="form-error-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <div class="form-error-text">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.process') }}" id="login-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="nama@email.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Masukkan password"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword()" id="toggle-password" aria-label="Toggle password visibility">
                            <svg id="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg id="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="btn-login">
                    Masuk
                </button>
            </form>

            {{-- Register Link --}}
            <div class="register-link">
                Belum punya akun? <a href="{{ route('register') }}" id="btn-register">Register</a>
            </div>
        </div>

        <div class="login-footer">
            &copy; {{ date('Y') }} Sistem Penjualan Sapi. All rights reserved.
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                input.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        }
    </script>
</body>
</html>
