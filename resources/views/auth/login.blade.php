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
            padding: 2.5rem;
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

        /* Header */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(59,130,246,0.12));
            border: 1px solid rgba(148, 163, 184, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.25rem;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.35rem;
        }

        .login-header p {
            font-size: 0.9rem;
            color: #94a3b8;
            line-height: 1.5;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            pointer-events: none;
            transition: color 0.2s ease;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .input-icon svg {
            width: 18px;
            height: 18px;
        }

        .form-input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.85rem;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 12px;
            color: #f1f5f9;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input::placeholder {
            color: #475569;
        }

        .form-input:focus {
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.08);
        }

        .form-input:focus ~ .input-icon {
            color: #93c5fd;
        }

        /* Password Toggle */
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

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 0.5rem;
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

        /* Roles Info */
        .roles-info {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(148, 163, 184, 0.08);
        }

        .roles-info-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            text-align: center;
            margin-bottom: 1rem;
        }

        .roles-badges {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid;
        }

        .badge-peternak {
            background: rgba(16, 185, 129, 0.08);
            border-color: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
        }

        .badge-pembeli {
            background: rgba(59, 130, 246, 0.08);
            border-color: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
        }

        .badge-mantri {
            background: rgba(245, 158, 11, 0.08);
            border-color: rgba(245, 158, 11, 0.15);
            color: #fcd34d;
        }

        .badge-pengurus {
            background: rgba(139, 92, 246, 0.08);
            border-color: rgba(139, 92, 246, 0.15);
            color: #c4b5fd;
        }

        /* Register Button */
        .btn-register {
            display: block;
            width: 100%;
            padding: 0.85rem;
            background: transparent;
            color: #94a3b8;
            border: 1px solid rgba(148, 163, 184, 0.15);
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            color: #f1f5f9;
            border-color: rgba(148, 163, 184, 0.3);
            background: rgba(148, 163, 184, 0.05);
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
                padding: 2rem 1.5rem;
            }

            .login-header h1 {
                font-size: 1.3rem;
            }

            .roles-badges {
                gap: 0.35rem;
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
            <div class="login-header">
                <div class="login-icon">🐄</div>
                <h1>Sistem Penjualan Sapi</h1>
                <p>Masuk dengan akun Anda untuk mengakses dashboard</p>
            </div>

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

            <form method="POST" action="{{ route('login.process') }}" id="login-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-wrapper">
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
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Masukkan password"
                            required
                        >
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
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

            <div class="roles-info">
                <a href="{{ route('register') }}" class="btn-register" id="btn-register">
                    Daftar Akun Baru
                </a>
                <div class="roles-info-title" style="margin-top: 1.25rem;">Mendukung 4 jenis akun</div>
                <div class="roles-badges">
                    <span class="role-badge badge-peternak">🐄 Peternak</span>
                    <span class="role-badge badge-pembeli">🛒 Pembeli</span>
                    <span class="role-badge badge-mantri">🩺 Mantri Hewan</span>
                    <span class="role-badge badge-pengurus">🏘️ Pengurus</span>
                </div>
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
