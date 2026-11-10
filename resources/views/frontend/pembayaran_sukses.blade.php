@extends('layouts.frontend')

@section('title', 'Pesanan Berhasil — ' . $transaksi->kode_transaksi)

@section('content')
<div class="sukses-page" style="padding-top: 140px; padding-bottom: 80px; min-height: calc(100vh - 110px); background: var(--bg-body, #fafafa);">
    <div style="max-width: 640px; margin: 0 auto; padding: 0 20px;">

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.35); color: var(--green-brand, #065f46); padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-weight: 600; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        <div style="background: var(--bg-card, #ffffff); border-radius: 18px; border: 1px solid var(--border-color, rgba(0,0,0,0.06)); box-shadow: var(--card-shadow, 0 10px 30px rgba(0,0,0,0.04)); padding: 2.5rem; text-align: center;">
            
            <div style="width: 72px; height: 72px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.25rem; margin: 0 auto 1.5rem; box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);">
                <i class="bi bi-check-lg"></i>
            </div>

            <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.65rem; font-weight: 800; color: var(--text-heading, #111827); margin-bottom: 0.5rem;">
                Pesanan Berhasil Dibuat!
            </h2>
            <p style="color: var(--text-secondary, #64748b); font-size: 0.95rem; margin-bottom: 2rem;">
                Nomor Transaksi: <strong style="color: var(--text-heading, #1e293b); font-family: monospace; font-size: 1.05rem;">{{ $transaksi->kode_transaksi }}</strong>
            </p>

            {{-- Nota Rincian --}}
            <div style="background: var(--bg-surface, #f8fafc); border: 1px solid var(--border-color, #e2e8f0); border-radius: 14px; padding: 1.5rem; text-align: left; margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Jenis Sapi:</span>
                    <strong style="color: var(--text-heading, #1e293b);">{{ $transaksi->sapi->jenis }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Tipe Penjualan:</span>
                    <strong style="color: var(--text-heading, #1e293b);">{{ $transaksi->tipe_penjualan === 'pre_order' ? 'Pre-Order' : 'Order Siap Kirim' }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Metode Pembayaran:</span>
                    <strong style="color: var(--text-heading, #1e293b); text-transform: uppercase;">{{ $transaksi->metode_pembayaran }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Pengantaran:</span>
                    <strong style="color: var(--text-heading, #1e293b);">
                        {{ $transaksi->is_pengantaran ? 'Ya (' . ($transaksi->jarak_km ? $transaksi->jarak_km . ' km — ' : '') . 'Rp ' . number_format($transaksi->ongkir, 0, ',', '.') . ')' : 'Tidak (Ambil Sendiri)' }}
                    </strong>
                </div>

                @if($transaksi->tanggal_pengambilan)
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Jadwal {{ $transaksi->is_pengantaran ? 'Pengantaran' : 'Pengambilan' }}:</span>
                    <strong style="color: var(--text-heading, #1e293b);">
                        {{ \Carbon\Carbon::parse($transaksi->tanggal_pengambilan)->translatedFormat('d F Y') }} ({{ $transaksi->durasi_perawatan_hari }} Hari)
                    </strong>
                </div>
                @endif

                @if($transaksi->biaya_perawatan > 0)
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Biaya Perawatan ({{ $transaksi->durasi_perawatan_hari }} Hari):</span>
                    <strong style="color: #b45309;">Rp {{ number_format($transaksi->biaya_perawatan, 0, ',', '.') }}</strong>
                </div>
                @endif

                @if($transaksi->is_pengantaran && $transaksi->detail_lokasi)
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Alamat Pengantaran:</span>
                    <span style="color: var(--text-primary, #1e293b); text-align: right; max-width: 250px; font-size: 0.9rem;">{{ $transaksi->detail_lokasi }}</span>
                </div>
                @else
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.95rem;">Lokasi Pengambilan:</span>
                    <span style="color: var(--text-primary, #1e293b); text-align: right; max-width: 250px; font-size: 0.9rem;">
                        {{ $transaksi->sapi->lokasi ?? ($transaksi->sapi->peternak->alamat ?? 'Kampung Suka Maju') }}
                    </span>
                </div>
                @php
                    $latSapi = $transaksi->sapi->latitude ?? ($transaksi->sapi->peternak->latitude ?? null);
                    $lngSapi = $transaksi->sapi->longitude ?? ($transaksi->sapi->peternak->longitude ?? null);
                @endphp
                @if($latSapi && $lngSapi)
                <div style="text-align: right; margin-top: -0.35rem; margin-bottom: 0.75rem;">
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $latSapi }},{{ $lngSapi }}" target="_blank" rel="noopener noreferrer" style="font-size: 0.8rem; font-weight: 700; color: var(--green-brand, #00A740); text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="bi bi-signpost-2-fill"></i> Buka Rute ke Kandang di Google Maps
                    </a>
                </div>
                @endif
                @endif

                <div style="border-top: 2px dashed var(--border-color, #cbd5e1); padding-top: 0.75rem; margin-top: 0.75rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="color: var(--text-heading, #1e293b); font-weight: 700;">Total Biaya Keseluruhan:</span>
                        <strong style="color: var(--text-heading, #1e293b);">{{ $transaksi->total_harga_formatted }}</strong>
                    </div>
                    @if($transaksi->is_preorder)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; background: rgba(16, 185, 129, 0.12); padding: 4px 8px; border-radius: 6px;">
                        <span style="color: #047857; font-weight: 700;">Pembayaran 1 (DP):</span>
                        <strong style="color: #047857; font-size: 1.05rem;">{{ $transaksi->dp_formatted }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; background: rgba(245, 158, 11, 0.12); padding: 4px 8px; border-radius: 6px;">
                        <span style="color: #b45309; font-weight: 700;">Pembayaran 2 (Pelunasan saat Ambil/Kirim):</span>
                        <strong style="color: #b45309;">{{ $transaksi->sisa_pembayaran_formatted }}</strong>
                    </div>
                    @else
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="color: var(--green-brand, #10b981); font-weight: 700;">Dibayarkan:</span>
                        <strong style="color: var(--green-brand, #10b981); font-size: 1.1rem;">{{ $transaksi->dibayarkan_formatted }}</strong>
                    </div>
                    @if($transaksi->sisa_pembayaran > 0)
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #e11d48; font-weight: 700;">Sisa Pembayaran:</span>
                        <strong style="color: #e11d48;">{{ $transaksi->sisa_pembayaran_formatted }}</strong>
                    </div>
                    @endif
                    @endif
                </div>

                <div style="border-top: 1px solid var(--border-color, #e2e8f0); padding-top: 0.75rem; margin-top: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--text-secondary, #64748b); font-size: 0.85rem;">Status Pesanan:</span>
                    <span style="padding: 0.35rem 0.75rem; border-radius: 999px; font-size: 0.85rem; font-weight: 700; background: rgba(16, 185, 129, 0.15); color: #047857;">
                        {{ match($transaksi->status) {
                            'menunggu_pembayaran' => 'Menunggu Pembayaran',
                            'menunggu_verifikasi' => 'Menunggu Verifikasi Peternak',
                            'diproses' => 'Sedang Diproses',
                            'selesai' => 'Selesai',
                            default => ucfirst($transaksi->status)
                        } }}
                    </span>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('katalog.index') }}" style="padding: 0.75rem 1.75rem; background: var(--green-brand, #10b981); color: white; border-radius: 10px; font-family: 'Montserrat', sans-serif; font-weight: 700; text-decoration: none; font-size: 0.95rem; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                    Kembali ke Katalog
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
