<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar Akun - Sistem Penjualan Sapi">
    <title>Daftar Akun — Sistem Penjualan Sapi</title>
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
            overflow-x: hidden;
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
            background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, transparent 70%);
            bottom: -120px;
            left: -80px;
            animation: float 18s ease-in-out infinite reverse;
        }

        .bg-orb {
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
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

        /* Container */
        .register-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            padding: 1.5rem;
        }

        /* Back Link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #f1f5f9;
        }

        .back-link svg {
            width: 16px;
            height: 16px;
        }

        /* Card */
        .register-card {
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

        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #3b82f6, #8b5cf6);
        }

        /* Header */
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(139,92,246,0.12));
            border: 1px solid rgba(148, 163, 184, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.25rem;
        }

        .register-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.35rem;
        }

        .register-header p {
            font-size: 0.9rem;
            color: #94a3b8;
            line-height: 1.5;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.15rem;
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

        /* Select */
        .form-select {
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
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
        }

        .form-select:focus {
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.08);
        }

        .form-select:focus ~ .input-icon {
            color: #93c5fd;
        }

        .form-select option {
            background: #1e293b;
            color: #f1f5f9;
            padding: 0.5rem;
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
            margin-bottom: 1.25rem;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            50% { transform: translateX(6px); }
            75% { transform: translateX(-4px); }
        }

        .form-error-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #fca5a5;
            line-height: 1.5;
        }

        .form-error-item + .form-error-item {
            margin-top: 0.35rem;
        }

        .form-error-item svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #10b981, #059669);
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
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
        }

        .btn-submit:hover::before {
            opacity: 1;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Footer */
        .register-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #94a3b8;
        }

        .register-footer a {
            color: #93c5fd;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .register-footer a:hover {
            color: #bfdbfe;
        }

        .page-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: #475569;
        }

        @media (max-width: 480px) {
            .register-card {
                padding: 2rem 1.5rem;
            }

            .register-header h1 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-gradient">
        <div class="bg-orb"></div>
    </div>
    <div class="grid-pattern"></div>

    <div class="register-container">
        <a href="{{ route('login') }}" class="back-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Login
        </a>

        <div class="register-card">
            <div class="register-header">
                <div class="register-icon">📝</div>
                <h1>Daftar Akun Baru</h1>
                <p>Buat akun untuk mengakses Sistem Penjualan Sapi</p>
            </div>

            @if ($errors->any())
                <div class="form-error">
                    @foreach ($errors->all() as $error)
                        <div class="form-error-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register.process') }}" id="register-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-input"
                            placeholder="Masukkan nama lengkap"
                            value="{{ old('name') }}"
                            required
                            autofocus
                        >
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                    </div>
                </div>

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
                        >
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="role">Jenis Akun</label>
                    <div class="input-wrapper">
                        <select id="role" name="role" class="form-select" required>
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>— Pilih jenis akun —</option>
                            <option value="peternak" {{ old('role') === 'peternak' ? 'selected' : '' }}>🐄 Peternak</option>
                            <option value="pembeli" {{ old('role') === 'pembeli' ? 'selected' : '' }}>🛒 Pembeli</option>
                            <option value="mantri_hewan" {{ old('role') === 'mantri_hewan' ? 'selected' : '' }}>🩺 Mantri Hewan</option>
                            <option value="pengurus_kampung" {{ old('role') === 'pengurus_kampung' ? 'selected' : '' }}>🏘️ Pengurus Kampung</option>
                        </select>
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
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
                            placeholder="Minimal 6 karakter"
                            required
                        >
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)" aria-label="Toggle password visibility">
                            <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Ulangi password"
                            required
                        >
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </span>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)" aria-label="Toggle password visibility">
                            <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="btn-register">
                    Daftar Sekarang
                </button>
            </form>

            <div class="register-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>

        <div class="page-footer">
            &copy; {{ date('Y') }} Sistem Penjualan Sapi. All rights reserved.
        </div>
    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');

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
