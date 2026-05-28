@extends('layouts.peternak', ['title' => 'Dashboard Peternak — Sistem Penjualan Sapi'])

@section('page-content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>! Berikut ringkasan data Anda.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Total Sapi</span>
            <div class="stat-card-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;">🐮</div>
        </div>
        <div class="stat-card-value">{{ $totalSapi }}</div>
        <div class="stat-card-change">Terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Terverifikasi Sehat</span>
            <div class="stat-card-icon" style="background: rgba(59,130,246,0.1); color: #93c5fd;">✅</div>
        </div>
        <div class="stat-card-value">{{ $sapiSehat }}</div>
        <div class="stat-card-change">Sapi sehat</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">Belum Diperiksa</span>
            <div class="stat-card-icon" style="background: rgba(245,158,11,0.1); color: #fcd34d;">⏳</div>
        </div>
        <div class="stat-card-value">{{ $sapiBelumDiperiksa }}</div>
        <div class="stat-card-change">Menunggu mantri</div>
    </div>
</div>

<div class="content-card">
    <h3>📋 Aktivitas Terbaru</h3>
    <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 0.5rem;">Belum ada aktivitas terbaru.</p>
</div>
@endsection
