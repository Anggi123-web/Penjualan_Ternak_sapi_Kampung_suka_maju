<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - Sistem Penjualan Sapi">
    <title>Login — Sistem Penjualan Sapi</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
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
            width: 140px;
            height: 80px;
            border: 2px solid rgba(148, 163, 184, 0.15);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.5);
            overflow: hidden;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .login-logo-box:hover {
            border-color: rgba(16, 185, 129, 0.3);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.08);
        }

        .login-logo-box img {
            max-width: 110px;
            max-height: 60px;
            object-fit: contain;
        }

        /* Title */
        .login-title {
            text-align: center;
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 2rem;
            color: #f1f5f9;
        }

        /* Error */
        .form-error {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
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
            color: #fca5a5;
        }

        .form-error-icon svg {
            width: 18px;
            height: 18px;
        }

        .form-error-text {
            font-size: 0.85rem;
            color: #fca5a5;
            line-height: 1.4;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 0.6rem;
        }

        .form-input {
            width: 100%;
            padding: 0.9rem 1rem;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(148, 163, 184, 0.12);
            border-radius: 12px;
            color: #f1f5f9;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.25s ease;
            outline: none;
        }

        .form-input::placeholder {
            color: #475569;
        }

        .form-input:focus {
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.08);
            background: rgba(15, 23, 42, 0.8);
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
            color: #475569;
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
            color: #93c5fd;
        }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 0.95rem;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 0.75rem;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.12));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
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
            border-top: 1px solid rgba(148, 163, 184, 0.08);
            font-size: 0.9rem;
            color: #94a3b8;
        }

        .register-link a {
            color: #60a5fa;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .register-link a:hover {
            color: #93c5fd;
            text-decoration: underline;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: #475569;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 2.5rem 1.5rem;
            }

            .login-title {
                font-size: 1.35rem;
            }

            .login-logo-box {
                width: 120px;
                height: 70px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-gradient">
        <div class="bg-orb"></div>
    </div>
    <div class="grid-pattern"></div>

    <div class="login-container">
        <div class="login-card">
            {{-- Logo --}}
            <div class="login-logo-wrapper">
                <div class="login-logo-box">
                    <img src="{{ asset('images/sipeter_logo.png') }}" alt="SIPETER Logo">
                </div>
            </div>

            {{-- Title --}}
            <h1 class="login-title">Login</h1>

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
