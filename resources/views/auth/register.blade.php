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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
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
            align-items: flex-start;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 2rem 0;
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
            max-width: 960px;
            padding: 1.5rem;
        }

        /* Header Bar */
        .register-header-bar {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .header-logo-box {
            width: 100px;
            height: 56px;
            border: 2px solid rgba(148, 163, 184, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.5);
            overflow: hidden;
            flex-shrink: 0;
        }

        .header-logo-box img {
            max-width: 80px;
            max-height: 44px;
            object-fit: contain;
        }

        .header-title {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #f1f5f9;
        }

        /* Role Tabs */
        .role-tabs {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .role-tab {
            padding: 0.6rem 1.75rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            border: 2px solid rgba(148, 163, 184, 0.15);
            background: rgba(30, 41, 59, 0.5);
            color: #94a3b8;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .role-tab:hover {
            border-color: rgba(148, 163, 184, 0.3);
            color: #cbd5e1;
        }

        .role-tab.active {
            background: linear-gradient(135deg, #10b981, #059669);
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
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

        /* Form */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.85rem 1rem;
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

        textarea.form-input {
            resize: none;
            min-height: 100px;
        }

        /* Select */
        .form-select {
            width: 100%;
            padding: 0.85rem 1rem;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(148, 163, 184, 0.12);
            border-radius: 12px;
            color: #f1f5f9;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.25s ease;
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

        .form-select option {
            background: #1e293b;
            color: #f1f5f9;
            padding: 0.5rem;
        }

        /* Grid layouts */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1rem;
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

        /* File Upload */
        .file-upload-area {
            position: relative;
            border: 2px dashed rgba(148, 163, 184, 0.2);
            border-radius: 12px;
            padding: 1.5rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(15, 23, 42, 0.4);
            min-height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .file-upload-area:hover {
            border-color: rgba(59, 130, 246, 0.4);
            background: rgba(15, 23, 42, 0.6);
        }

        .file-upload-area.has-file {
            border-color: rgba(16, 185, 129, 0.4);
            background: rgba(16, 185, 129, 0.05);
        }

        .file-upload-area input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-icon {
            font-size: 2rem;
            line-height: 1;
        }

        .file-upload-text {
            font-size: 0.8rem;
            color: #94a3b8;
            font-weight: 500;
        }

        .file-upload-name {
            font-size: 0.75rem;
            color: #10b981;
            font-weight: 600;
            margin-top: 0.25rem;
            word-break: break-all;
        }

        .file-upload-preview {
            max-width: 100%;
            max-height: 140px;
            border-radius: 8px;
            object-fit: contain;
            margin-top: 0.35rem;
            border: 1px solid rgba(16, 185, 129, 0.4);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            display: none;
            z-index: 2;
            position: relative;
            pointer-events: none;
        }

        .file-upload-label {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.5rem;
            text-align: center;
            font-weight: 500;
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
            padding: 0.95rem;
            background: linear-gradient(135deg, #10b981, #059669);
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
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
        }

        .btn-submit:hover::before {
            opacity: 1;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Peternak-only sections */
        .peternak-section {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .peternak-section.visible {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Section divider */
        .section-divider {
            border: none;
            border-top: 1px solid rgba(148, 163, 184, 0.08);
            margin: 1.5rem 0;
        }

        /* Map */
        #map {
            height: 100%;
            min-height: 180px;
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.15);
            z-index: 1;
        }

        .form-hint {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 0.35rem;
            display: block;
        }

        .btn-gps {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #10b981;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 0.5rem;
            outline: none;
            font-family: 'Inter', sans-serif;
        }

        .btn-gps:hover {
            background: #10b981;
            color: white;
        }

        /* Footer */
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

        .page-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: #475569;
        }

        @media (max-width: 640px) {
            .register-card {
                padding: 2rem 1.25rem;
            }

            .form-row,
            .form-row-3 {
                grid-template-columns: 1fr;
            }

            .role-tabs {
                justify-content: center;
            }

            .register-header-bar {
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
            }

            .header-title {
                font-size: 1.35rem;
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
        {{-- Header Bar: Logo + Title --}}
        <div class="register-header-bar">
            <div class="header-logo-box">
                <img src="{{ asset('images/sipeter_logo.png') }}" alt="SIPETER Logo">
            </div>
            <h1 class="header-title">Registrasi</h1>
        </div>

        {{-- Role Tabs --}}
        <div class="role-tabs">
            <button type="button" class="role-tab" id="tab-peternak" data-role="peternak" onclick="switchRole('peternak')">
                🐄 Peternak
            </button>
            <button type="button" class="role-tab" id="tab-pembeli" data-role="pembeli" onclick="switchRole('pembeli')">
                🛒 Pembeli
            </button>
        </div>

        {{-- Registration Card --}}
        <div class="register-card">
            {{-- Error Messages --}}
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

            <form method="POST" action="{{ route('register.process') }}" id="register-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="role" id="role-input" value="{{ old('role', 'peternak') }}">

                {{-- Row 1: Nama Pengguna + Nomer Induk --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="name">Nama Pengguna</label>
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
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nik">Nomer Induk (NIK)</label>
                        <input
                            type="text"
                            id="nik"
                            name="nik"
                            class="form-input"
                            placeholder="Masukkan 16 digit NIK"
                            value="{{ old('nik') }}"
                            maxlength="20"
                            required
                        >
                    </div>
                </div>

                {{-- Row 2: No Telephone + Email --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="no_telepon">No Telephone</label>
                        <input
                            type="tel"
                            id="no_telepon"
                            name="no_telepon"
                            class="form-input"
                            placeholder="Contoh: 08123456789"
                            value="{{ old('no_telepon') }}"
                            maxlength="20"
                            required
                        >
                    </div>
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
                        >
                    </div>
                </div>

                <hr class="section-divider">

                {{-- Alamat & Map side by side (For Peternak & Pembeli) --}}
                <div class="form-row" style="margin-bottom: 1.25rem; align-items: stretch;">
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label" for="alamat">Alamat</label>
                        <textarea
                            id="alamat"
                            name="alamat"
                            class="form-input"
                            placeholder="Contoh: Kampung Suka Maju, Kecamatan Abung Selatan, Kabupaten Lampung Utara, Lampung"
                            style="flex: 1; min-height: 180px;"
                        >{{ old('alamat') }}</textarea>
                        <span class="form-hint">💡 Urutan: Kampung/Desa, Kecamatan, Kabupaten, Provinsi — peta otomatis mencari lokasi.</span>
                    </div>
                    <div style="display: flex; flex-direction: column;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                            <label class="form-label" style="margin-bottom: 0;">Detail Lokasi Map</label>
                            <button type="button" class="btn-gps" onclick="getCurrentLocation()" style="margin-bottom: 0;">
                                🛰️ GPS Saya
                            </button>
                        </div>
                        <div id="map" style="flex: 1; min-height: 180px;"></div>
                        <span class="form-hint" id="map-status">Geser marker atau klik peta untuk menentukan titik tepat.</span>
                        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                    </div>
                </div>

                {{-- Nomor Rekening & Jenis Bank (Peternak Only) --}}
                <div class="form-row" id="rekening-bank-section" style="margin-bottom: 1.25rem;">
                    <div>
                        <label class="form-label" for="nomor_rekening">Nomor Rekening</label>
                        <input
                            type="text"
                            id="nomor_rekening"
                            name="nomor_rekening"
                            class="form-input"
                            placeholder="Masukkan nomor rekening"
                            value="{{ old('nomor_rekening') }}"
                        >
                    </div>
                    <div>
                        <label class="form-label" for="jenis_bank">Jenis Bank</label>
                        <select id="jenis_bank" name="jenis_bank" class="form-select">
                            <option value="" disabled {{ old('jenis_bank') ? '' : 'selected' }}>— Pilih Bank —</option>
                            <option value="BRI" {{ old('jenis_bank') === 'BRI' ? 'selected' : '' }}>BRI</option>
                            <option value="BNI" {{ old('jenis_bank') === 'BNI' ? 'selected' : '' }}>BNI</option>
                            <option value="BCA" {{ old('jenis_bank') === 'BCA' ? 'selected' : '' }}>BCA</option>
                            <option value="Mandiri" {{ old('jenis_bank') === 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                            <option value="BSI" {{ old('jenis_bank') === 'BSI' ? 'selected' : '' }}>BSI</option>
                            <option value="BTN" {{ old('jenis_bank') === 'BTN' ? 'selected' : '' }}>BTN</option>
                            <option value="CIMB Niaga" {{ old('jenis_bank') === 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                            <option value="Danamon" {{ old('jenis_bank') === 'Danamon' ? 'selected' : '' }}>Danamon</option>
                            <option value="Bank Jago" {{ old('jenis_bank') === 'Bank Jago' ? 'selected' : '' }}>Bank Jago</option>
                            <option value="Lainnya" {{ old('jenis_bank') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>

                {{-- Foto KTP & Foto Selfie (For Peternak & Pembeli) --}}
                <div class="form-row" style="margin-bottom: 1.25rem;">
                    <div>
                        <label class="form-label">Foto KTP</label>
                        <div class="file-upload-area" id="ktp-upload-area">
                            <input type="file" name="foto_ktp" id="foto_ktp" accept="image/jpeg,image/png,image/jpg" onchange="handleFileSelect(this, 'ktp-upload-area', 'ktp-file-name', 'ktp-preview')">
                            <div class="file-upload-icon">📄</div>
                            <div class="file-upload-text">Klik untuk pilih file</div>
                            <img id="ktp-preview" class="file-upload-preview" alt="Preview Foto KTP">
                            <div class="file-upload-name" id="ktp-file-name"></div>
                        </div>
                        <div class="file-upload-label">Foto KTP</div>
                    </div>
                    <div>
                        <label class="form-label">Foto Selfie dengan KTP</label>
                        <div class="file-upload-area" id="selfie-upload-area">
                            <input type="file" name="foto_selfie_ktp" id="foto_selfie_ktp" accept="image/jpeg,image/png,image/jpg" onchange="handleFileSelect(this, 'selfie-upload-area', 'selfie-file-name', 'selfie-preview')">
                            <div class="file-upload-icon">🤳</div>
                            <div class="file-upload-text">Klik untuk pilih file</div>
                            <img id="selfie-preview" class="file-upload-preview" alt="Preview Foto Selfie dengan KTP">
                            <div class="file-upload-name" id="selfie-file-name"></div>
                        </div>
                        <div class="file-upload-label">Foto Selfie dengan KTP</div>
                    </div>
                </div>

                <hr class="section-divider">

                {{-- Row: Password + Verifikasi Password --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-password-wrapper">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input"
                                placeholder="Minimal 6 karakter"
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword('password', this)" aria-label="Toggle password visibility">
                                <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Verifikasi Password</label>
                        <div class="input-password-wrapper">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-input"
                                placeholder="Ulangi password"
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)" aria-label="Toggle password visibility">
                                <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="btn-register">
                    Daftar Sekarang
                </button>
            </form>

            {{-- Login Link --}}
            <div class="register-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </div>
        </div>

        <div class="page-footer">
            &copy; {{ date('Y') }} Sistem Penjualan Sapi. All rights reserved.
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // ══════ Role Tabs ══════
        const roleInput = document.getElementById('role-input');
        const rekeningBankSection = document.getElementById('rekening-bank-section');
        const tabPeternak = document.getElementById('tab-peternak');
        const tabPembeli = document.getElementById('tab-pembeli');

        function switchRole(role) {
            roleInput.value = role;

            // Update tab visuals
            tabPeternak.classList.toggle('active', role === 'peternak');
            tabPembeli.classList.toggle('active', role === 'pembeli');

            // Show/hide bank account fields (Peternak only)
            if (role === 'peternak') {
                if (rekeningBankSection) rekeningBankSection.style.display = 'grid';
            } else {
                if (rekeningBankSection) rekeningBankSection.style.display = 'none';
            }

            initMap();
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const initialRole = roleInput.value || 'peternak';
            switchRole(initialRole);
        });

        // ══════ Password Toggle ══════
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

        // ══════ File Upload Handler with Preview ══════
        function handleFileSelect(input, areaId, nameId, previewId) {
            const area = document.getElementById(areaId);
            const nameEl = document.getElementById(nameId);
            const previewEl = document.getElementById(previewId);
            const iconEl = area ? area.querySelector('.file-upload-icon') : null;
            const textEl = area ? area.querySelector('.file-upload-text') : null;

            if (input.files && input.files[0]) {
                const file = input.files[0];
                area.classList.add('has-file');
                if (nameEl) nameEl.textContent = file.name;

                if (previewEl && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewEl.src = e.target.result;
                        previewEl.style.display = 'block';
                        if (iconEl) iconEl.style.display = 'none';
                        if (textEl) textEl.textContent = 'Klik untuk ganti foto';
                    };
                    reader.readAsDataURL(file);
                }
            } else {
                area.classList.remove('has-file');
                if (nameEl) nameEl.textContent = '';
                if (previewEl) {
                    previewEl.src = '';
                    previewEl.style.display = 'none';
                }
                if (iconEl) iconEl.style.display = 'block';
                if (textEl) textEl.textContent = 'Klik untuk pilih file';
            }
        }

        // ══════ Map (Leaflet) ══════
        let map, marker;
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const alamatInput = document.getElementById('alamat');
        let geocodeTimer = null;

        function initMap() {
            if (map) {
                setTimeout(() => { map.invalidateSize(); }, 200);
                return;
            }

            let defaultLat = -6.2088;
            let defaultLng = 106.8456;

            if (latInput.value && lngInput.value) {
                defaultLat = parseFloat(latInput.value);
                defaultLng = parseFloat(lngInput.value);
            }

            map = L.map('map').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Google Maps Satelit'
            }).addTo(map);

            marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            marker.on('dragend', function(e) {
                const position = marker.getLatLng();
                latInput.value = position.lat.toFixed(8);
                lngInput.value = position.lng.toFixed(8);
            });

            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                marker.setLatLng([lat, lng]);
                latInput.value = lat.toFixed(8);
                lngInput.value = lng.toFixed(8);
            });

            if (!latInput.value || !lngInput.value) {
                latInput.value = defaultLat.toFixed(8);
                lngInput.value = defaultLng.toFixed(8);
            }

            // Attach geocoding listener to alamat input
            if (alamatInput) {
                alamatInput.addEventListener('input', function() {
                    clearTimeout(geocodeTimer);
                    const query = this.value.trim();
                    if (query.length < 5) return; // Minimum 5 chars to search

                    geocodeTimer = setTimeout(() => {
                        geocodeAddress(query);
                    }, 800); // Wait 800ms after user stops typing
                });
            }
        }

        // ══════ Geocode Address (Nominatim) ══════
        function geocodeAddress(query) {
            if (!map || !marker) return;

            const mapStatus = document.getElementById('map-status');
            if (mapStatus) {
                mapStatus.textContent = '🔍 Mencari lokasi...';
                mapStatus.style.color = '#f59e0b';
            }

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&countrycodes=id`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);

                        marker.setLatLng([lat, lng]);
                        map.setView([lat, lng], 16);

                        latInput.value = lat.toFixed(8);
                        lngInput.value = lng.toFixed(8);

                        if (mapStatus) {
                            mapStatus.textContent = '✅ Lokasi ditemukan — geser marker untuk titik tepat';
                            mapStatus.style.color = '#10b981';
                        }
                    } else {
                        if (mapStatus) {
                            mapStatus.textContent = '⚠️ Lokasi tidak ditemukan, coba lebih spesifik';
                            mapStatus.style.color = '#f59e0b';
                        }
                    }
                })
                .catch(() => {
                    if (mapStatus) {
                        mapStatus.textContent = '❌ Gagal mencari lokasi';
                        mapStatus.style.color = '#ef4444';
                    }
                });
        }

        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 16);

                    latInput.value = lat.toFixed(8);
                    lngInput.value = lng.toFixed(8);

                    const mapStatus = document.getElementById('map-status');
                    if (mapStatus) {
                        mapStatus.textContent = '✅ Lokasi GPS ditemukan — geser marker untuk titik tepat';
                        mapStatus.style.color = '#10b981';
                    }
                }, function(error) {
                    alert('Gagal mengambil lokasi GPS Anda. Pastikan izin lokasi diaktifkan di browser.');
                });
            } else {
                alert('Browser Anda tidak mendukung layanan lokasi GPS.');
            }
        }
    </script>
</body>
</html>
