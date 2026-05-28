@extends('layouts.frontend')

@section('content')
<div class="catalog-section" style="padding-top: 120px; min-height: calc(100vh - 110px); max-width: 1200px; margin: 0 auto; padding-left: 20px; padding-right: 20px;">
    <div class="section-header" style="margin-bottom: 2rem; text-align: left;">
        <span class="section-tag">Profil Akun</span>
        <h2 class="section-title">Informasi Pembeli</h2>
        <p style="color: var(--medium-gray); margin-top: 0.5rem; font-size: 1.05rem;">Kelola informasi akun Anda dan pantau ketersediaan sapi.</p>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 2rem;">
        <!-- Profil Card -->
        <div style="flex: 1; min-width: 300px; background: #ffffff; border: 1px solid rgba(0,0,0,0.05); border-radius: 16px; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--green-brand), #059669); color: white; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; font-family: var(--font-montserrat);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div>
                    <h3 style="font-family: var(--font-montserrat); font-size: 1.5rem; font-weight: 700; color: var(--black-text); margin: 0 0 0.25rem 0;">{{ auth()->user()->name }}</h3>
                    <p style="color: var(--medium-gray); margin: 0;">{{ auth()->user()->email }}</p>
                    <span style="display: inline-block; margin-top: 0.5rem; padding: 0.25rem 0.75rem; background: rgba(16, 185, 129, 0.1); color: var(--green-brand); border-radius: 999px; font-size: 0.85rem; font-weight: 600;">Role: Pembeli</span>
                </div>
            </div>
            
            <div style="border-top: 1px solid rgba(0,0,0,0.05); padding-top: 1.5rem;">
                <h4 style="font-family: var(--font-montserrat); font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: var(--black-text);">Menu Akun</h4>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="{{ route('pembeli.keranjang.index') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #f8fafc; border-radius: 10px; text-decoration: none; color: var(--black-text); font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.05)'; this.style.color='var(--green-brand)';" onmouseout="this.style.background='#f8fafc'; this.style.color='var(--black-text)';">
                        <span style="display: flex; align-items: center; gap: 0.75rem;">🛒 Keranjang Belanja</span>
                        <span>➔</span>
                    </a>
                    <a href="{{ route('katalog.index') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #f8fafc; border-radius: 10px; text-decoration: none; color: var(--black-text); font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.05)'; this.style.color='var(--green-brand)';" onmouseout="this.style.background='#f8fafc'; this.style.color='var(--black-text)';">
                        <span style="display: flex; align-items: center; gap: 0.75rem;">🔍 Cari Sapi Baru</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Info / Ketersediaan Sapi -->
        <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Stat Card -->
            <div style="background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 16px; padding: 2rem; color: white; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                    <div>
                        <span style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600;">Sapi Tersedia</span>
                        <div style="font-family: var(--font-montserrat); font-size: 3rem; font-weight: 800; line-height: 1; margin-top: 0.5rem; color: #38bdf8;">
                            {{ $sapiTersedia }}
                        </div>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(56, 189, 248, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        🐮
                    </div>
                </div>
                <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.5; margin: 0;">
                    Ada <strong style="color: white;">{{ $sapiTersedia }} ekor sapi</strong> terverifikasi sehat yang saat ini tersedia di katalog untuk Anda beli.
                </p>
                <div style="margin-top: 1.5rem;">
                    <a href="{{ route('katalog.index') }}" class="btn-login-p" style="width: 100%; justify-content: center; background: #38bdf8; color: #0f172a; border: none;">
                        Lihat Katalog Sekarang
                    </a>
                </div>
            </div>

            <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 16px; padding: 1.5rem;">
                <div style="display: flex; gap: 1rem; align-items: flex-start;">
                    <div style="font-size: 1.5rem;">💡</div>
                    <div>
                        <h4 style="font-family: var(--font-montserrat); font-size: 1.05rem; font-weight: 700; color: var(--black-text); margin: 0 0 0.5rem 0;">Informasi Pembelian</h4>
                        <p style="color: var(--medium-gray); font-size: 0.9rem; margin: 0; line-height: 1.6;">
                            Semua sapi yang masuk ke katalog telah melalui proses verifikasi kesehatan yang ketat oleh Mantri Hewan untuk menjamin kualitas hewan ternak Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
