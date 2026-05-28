@extends('layouts.peternak', ['title' => 'Akun Saya — Sistem Penjualan Sapi'])

@section('page-styles')
<style>
    .profile-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .profile-banner {
        height: 100px;
        background: linear-gradient(135deg, #10b981, #059669, #047857);
        position: relative;
    }

    .profile-body {
        padding: 0 2rem 2rem;
        position: relative;
    }

    .profile-avatar-wrapper {
        margin-top: -40px;
        margin-bottom: 1rem;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 18px;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        font-weight: 800;
        color: white;
        border: 4px solid #0f172a;
    }

    .profile-name {
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-bottom: 0.15rem;
    }

    .profile-role {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.75rem;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6ee7b7;
        margin-top: 0.5rem;
    }

    .info-section {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .info-section h3 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        letter-spacing: -0.02em;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.85rem 0;
        border-bottom: 1px solid rgba(148, 163, 184, 0.06);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.85rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .info-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #f1f5f9;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.08);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 12px;
        padding: 0.85rem 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
        color: #6ee7b7;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

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

    .form-input {
        width: 100%;
        padding: 0.8rem 1rem;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(148, 163, 184, 0.1);
        border-radius: 10px;
        color: #f1f5f9;
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s ease;
        outline: none;
    }

    .form-input:focus {
        border-color: rgba(16, 185, 129, 0.4);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.08);
    }

    .form-input:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-save {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.3);
    }

    .form-error-list {
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 12px;
        padding: 0.85rem 1rem;
        margin-bottom: 1.25rem;
        list-style: none;
    }

    .form-error-list li {
        font-size: 0.85rem;
        color: #fca5a5;
        line-height: 1.6;
    }
</style>
@endsection

@section('page-content')
<div class="page-header">
    <h1>Akun Saya</h1>
    <p>Kelola informasi profil dan keamanan akun Anda.</p>
</div>

@if (session('success'))
    <div class="alert-success">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="profile-card">
    <div class="profile-banner"></div>
    <div class="profile-body">
        <div class="profile-avatar-wrapper">
            <div class="profile-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
        </div>
        <div class="profile-name">{{ auth()->user()->name }}</div>
        <div style="color: #94a3b8; font-size: 0.9rem;">{{ auth()->user()->email }}</div>
        <div class="profile-role">🐄 Peternak</div>
    </div>
</div>

<div class="info-section">
    <h3>👤 Informasi Akun</h3>
    <div class="info-row">
        <span class="info-label">Nama</span>
        <span class="info-value">{{ auth()->user()->name }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Email</span>
        <span class="info-value">{{ auth()->user()->email }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Role</span>
        <span class="info-value">Peternak</span>
    </div>
    <div class="info-row">
        <span class="info-label">Bergabung Sejak</span>
        <span class="info-value">{{ auth()->user()->created_at->format('d M Y') }}</span>
    </div>
</div>

<div class="info-section">
    <h3>✏️ Ubah Profil</h3>

    @if ($errors->any())
        <ul class="form-error-list">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('peternak.akun.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="name">Nama</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', auth()->user()->name) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-input" value="{{ auth()->user()->email }}" disabled>
            <small style="color: #64748b; font-size: 0.75rem; margin-top: 0.25rem; display: block;">Email tidak dapat diubah.</small>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password Baru <span style="color: #64748b; text-transform: none; letter-spacing: normal;">(kosongkan jika tidak ingin mengubah)</span></label>
            <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan password baru">
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password baru">
        </div>

        <button type="submit" class="btn-save" id="btn-save-profile">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
