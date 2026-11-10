@extends('layouts.frontend')

@section('title', 'Detail Pembayaran — ' . $sapi->jenis)

@section('content')
<!-- Leaflet CSS for Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<div class="pembayaran-page" style="padding-top: 130px; padding-bottom: 80px; min-height: calc(100vh - 110px); background: #fafafa;">
    <div style="max-width: 1120px; margin: 0 auto; padding: 0 20px;">
        
        @if(session('error'))
            <div style="background: #fee2e2; border: 1px solid #f87171; color: #b91c1c; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 2rem; font-weight: 500;">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #fee2e2; border: 1px solid #f87171; color: #b91c1c; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 2rem;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Role Warning Banner if logged in as non-buyer --}}
        @auth
            @if(auth()->user()->role !== 'pembeli')
                <div style="background: rgba(239, 68, 68, 0.08); border: 1.5px solid #ef4444; border-radius: 14px; padding: 1.15rem 1.4rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="bi bi-shield-exclamation" style="font-size: 1.8rem; color: #dc2626;"></i>
                        <div>
                            <strong style="color: #991b1b; font-size: 1rem;">Perhatian: Anda Sedang Login sebagai {{ ucfirst(auth()->user()->role) }} ({{ auth()->user()->name }})</strong>
                            <p style="margin: 3px 0 0; color: #b91c1c; font-size: 0.88rem;">
                                Fitur pemesanan dan pembelian sapi khusus diperuntukkan bagi akun dengan role <strong>Pembeli</strong>.
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #dc2626; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="bi bi-box-arrow-right"></i> Ganti ke Akun Pembeli
                        </button>
                    </form>
                </div>
            @endif
        @else
            <div style="background: rgba(59, 130, 246, 0.08); border: 1.5px solid #3b82f6; border-radius: 14px; padding: 1.15rem 1.4rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="bi bi-info-circle-fill" style="font-size: 1.8rem; color: #2563eb;"></i>
                    <div>
                        <strong style="color: #1e40af; font-size: 1rem;">Anda Belum Masuk (Login)</strong>
                        <p style="margin: 3px 0 0; color: #1d4ed8; font-size: 0.88rem;">
                            Untuk menyelesaikan pemesanan ternak, silakan masuk menggunakan akun Pembeli Anda.
                        </p>
                    </div>
                </div>
                <a href="{{ route('login') }}" style="background: #2563eb; color: white; text-decoration: none; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="bi bi-box-arrow-in-right"></i> Login Sekarang
                </a>
            </div>
        @endauth

        <form action="{{ route('pembayaran.store', $sapi->id) }}" method="POST" id="formPembayaran">
            @csrf
            <input type="hidden" name="pengantaran" id="inputPengantaran" value="ya">
            <input type="hidden" name="metode_pembayaran" id="inputMetodePembayaran" value="transfer">
            <input type="hidden" name="latitude" id="inputLatitude" value="">
            <input type="hidden" name="longitude" id="inputLongitude" value="">
            <input type="hidden" name="jarak_km" id="inputJarakKm" value="0">
            <input type="hidden" name="durasi_perawatan_hari" id="inputDurasiPerawatanHari" value="{{ $sapi->is_preorder ? 7 : 0 }}">
            <input type="hidden" name="biaya_perawatan" id="inputBiayaPerawatan" value="{{ $sapi->is_preorder ? (7 * $tarifPerawatanPerHari) : 0 }}">

            <div class="pembayaran-grid">
                
                {{-- ═══ KOLOM KIRI (Detail Ternak, Catatan, Metode Pembayaran) ═══ --}}
                <div class="col-left">
                    <h2 class="section-heading">Detail ternak</h2>
                    
                    {{-- Foto Ternak --}}
                    <div class="foto-ternak-box">
                        @if($sapi->first_foto)
                            <img src="{{ asset('storage/' . $sapi->first_foto) }}" alt="Foto {{ $sapi->jenis }}" class="foto-ternak-img">
                        @else
                            <div class="foto-ternak-placeholder">
                                <span style="font-size: 3rem; color: #a5d6a7;"><i class="bi bi-image"></i></span>
                                <span style="font-size: 1.1rem; font-weight: 700; color: #475569; margin-top: 0.5rem;">Foto ternak</span>
                            </div>
                        @endif
                    </div>

                    {{-- Catatan --}}
                    <div class="catatan-wrapper">
                        <label for="catatanInput" class="catatan-label">Catatan:</label>
                        <textarea name="catatan" id="catatanInput" rows="3" class="catatan-box" placeholder="Tambahkan instruksi atau catatan untuk peternak...">{{ old('catatan') }}</textarea>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="metode-pembayaran-wrapper">
                        <label class="metode-label">Metode Pembayaran</label>
                        
                        <div class="toggle-group-payment">
                            <button type="button" class="btn-toggle-pay" id="btnPayCash" onclick="setMetodePembayaran('cash')">
                                Cash
                            </button>
                            <button type="button" class="btn-toggle-pay active" id="btnPayTransfer" onclick="setMetodePembayaran('transfer')">
                                Transfer
                            </button>
                        </div>

                        {{-- Info Rekening (Hanya muncul jika Transfer, Tersembunyi jika Cash) --}}
                        <div id="infoRekeningBox" class="info-rekening-box">
                            <div class="bank-title">{{ $bankNama }}</div>
                            <div class="bank-number">{{ $bankRekening }}</div>
                            <p class="bank-note">Upload bukti pembayaran di halaman berikutnya</p>
                        </div>

                        {{-- Pesan Khusus Cash (Hanya muncul jika Cash) --}}
                        <div id="infoCashBox" class="info-cash-box" style="display: none;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; color: #15803d; font-weight: 700; font-size: 1rem;">
                                <i class="bi bi-cash-stack"></i> Pembayaran Tunai (Cash)
                            </div>
                            <p style="color: #64748b; font-size: 0.88rem; margin-top: 0.35rem; line-height: 1.4;">
                                Pembayaran dilakukan secara tunai langsung di lokasi peternakan saat serah terima ternak.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ═══ KOLOM KANAN (Spesifikasi Ternak, Pengantaran, Peta, Total, Aksi) ═══ --}}
                <div class="col-right">
                    
                    {{-- Detail Spesifikasi List --}}
                    <div class="spec-list">
                        
                        <div class="spec-row">
                            <span class="spec-title">Jenis</span>
                            <span class="spec-value">{{ $sapi->jenis }}</span>
                        </div>

                        <div class="spec-row">
                            <span class="spec-title">Umur</span>
                            <span class="spec-value">{{ $sapi->umur_formatted }}</span>
                        </div>

                        <div class="spec-row">
                            <span class="spec-title">Bobot</span>
                            <span class="spec-value">{{ number_format($sapi->bobot, 0, ',', '.') }} kg</span>
                        </div>

                        <div class="spec-row">
                            <span class="spec-title">Tipe Penjualan</span>
                            <span class="spec-value">{{ $sapi->tipe_penjualan_label }}</span>
                        </div>

                        {{-- Preorder Details (hanya jika pre_order) --}}
                        @if($sapi->is_preorder)
                        <div class="spec-row">
                            <span class="spec-title">Detail Preorder</span>
                            <span class="spec-value" style="color: #64748b; font-size: 0.95rem; max-width: 260px; text-align: right;">
                                Pre-order dengan DP mulai dari Rp. {{ number_format($dp, 0, ',', '.') }}
                            </span>
                        </div>
                        @endif

                        <div class="spec-row">
                            <span class="spec-title">Harga</span>
                            <span class="spec-value">Rp.{{ number_format($sapi->harga, 0, ',', '.') }}</span>
                        </div>

                        @if($sapi->is_preorder)
                        <div class="spec-row">
                            <span class="spec-title">DP</span>
                            <span class="spec-value">Rp.{{ number_format($dp, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        {{-- Pengantaran Toggle --}}
                        <div class="spec-row align-center">
                            <span class="spec-title">Pengantaran</span>
                            <div class="toggle-group-delivery">
                                <button type="button" class="btn-toggle-deliv" id="btnDelivTidak" onclick="setPengantaran('tidak')">
                                    Tidak
                                </button>
                                <button type="button" class="btn-toggle-deliv active" id="btnDelivYa" onclick="setPengantaran('ya')">
                                    Ya
                                </button>
                            </div>
                        </div>

                        {{-- ═══ INPUT TANGGAL PENGAMBILAN / PENGANTARAN (KHUSUS PRE-ORDER) ═══ --}}
                        @if($sapi->is_preorder)
                        <div class="spec-row" id="containerTanggalPreorder" style="flex-direction: column; align-items: stretch; gap: 0.6rem; background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 12px; padding: 1rem 1.1rem; margin-top: 0.5rem; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.08);">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span class="spec-title" style="color: #92400e; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                                    <i class="bi bi-calendar-event-fill" style="color: #f59e0b;"></i>
                                    <span id="labelTanggalAmbil">Tanggal Rencana Pengantaran Sapi</span>
                                </span>
                                <span style="font-size: 0.75rem; font-weight: 800; background: #fef3c7; color: #b45309; padding: 3px 9px; border-radius: 6px; border: 1px solid #fcd34d; text-transform: uppercase;">
                                    Pre-Order
                                </span>
                            </div>

                            <div>
                                <input type="date" 
                                       name="tanggal_pengambilan" 
                                       id="inputTanggalPengambilan" 
                                       class="lokasi-input-box" 
                                       value="{{ old('tanggal_pengambilan', $defaultTanggalAmbil) }}" 
                                       min="{{ $minTanggalAmbil }}" 
                                       style="width: 100%; padding: 0.65rem 0.9rem; font-size: 0.95rem; font-weight: 600; color: #1e293b; background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 8px; outline: none; transition: border-color 0.2s;"
                                       onchange="onTanggalAmbilChange(this.value)"
                                       required>
                                <div id="errorTanggalMsg" style="display: none; color: #dc2626; font-size: 0.82rem; font-weight: 700; margin-top: 4px;">
                                    <i class="bi bi-exclamation-circle-fill"></i> Tanggal penjemputan/pengantaran sapi wajib dipilih minimal besok.
                                </div>
                            </div>

                            <div style="font-size: 0.82rem; color: #78350f; line-height: 1.5; background: rgba(255, 255, 255, 0.75); padding: 0.55rem 0.8rem; border-radius: 8px; border: 1px dashed #fde68a;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span><i class="bi bi-clock"></i> Tanggal Pesan:</span>
                                    <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 3px;">
                                    <span><i class="bi bi-hourglass-split"></i> Durasi Pemeliharaan:</span>
                                    <strong id="badgeDurasiHariText">— Hari</strong>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- ═══ 1. INPUT LOKASI PENGANTARAN (HANYA MUNCUL SAAT PENGANTARAN = YA) ═══ --}}
                        <div class="delivery-field" id="containerInputPengantaran" style="display: flex; flex-direction: column; gap: 0.6rem; margin-top: 0.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span class="spec-title">Detail Lokasi Pengantaran</span>
                                <button type="button" class="btn-gps-action" onclick="getCurrentLocation()">
                                    <i class="bi bi-crosshair"></i> GPS Saya
                                </button>
                            </div>

                            {{-- Textarea Alamat (Mendukung Ketik Alamat + Geocoding Otomatis seperti Registrasi) --}}
                            <div>
                                <textarea name="detail_lokasi" id="inputDetailLokasi" class="lokasi-input-box" rows="2" placeholder="Contoh: Kampung Suka Maju, Kecamatan Abung Selatan, Lampung Utara... (peta otomatis mencari)">{{ old('detail_lokasi', auth()->check() ? auth()->user()->alamat : '') }}</textarea>
                                <div id="errorLokasiMsg" style="display: none; color: #dc2626; font-size: 0.82rem; font-weight: 700; margin-top: 4px;">
                                    <i class="bi bi-exclamation-circle-fill"></i> Detail alamat pengantaran wajib diisi atau ditentukan pada peta.
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.25rem;">
                                    <span class="form-hint-text" id="map-status">
                                        <i class="bi bi-lightbulb-fill" style="color: #eab308;"></i> Geser marker merah atau klik peta satelit untuk menentukan titik tepat.
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- ═══ 2. INFO AMBIL MANDIRI DI KANDANG (HANYA MUNCUL SAAT PENGANTARAN = TIDAK) ═══ --}}
                        <div id="containerInfoAmbilSendiri" style="display: none; margin-top: 0.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span class="spec-title" style="display: flex; align-items: center; gap: 6px;">
                                    <i class="bi bi-geo-alt-fill" style="color: #10b981;"></i> Lokasi Pengambilan Sapi
                                </span>
                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $sapiLat }},{{ $sapiLng }}" target="_blank" rel="noopener noreferrer" style="font-size: 0.78rem; font-weight: 700; color: #00A740; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; background: rgba(0, 167, 64, 0.08); border-radius: 6px; border: 1px solid rgba(0, 167, 64, 0.2); transition: all 0.2s;">
                                    <i class="bi bi-signpost-2-fill"></i> Buka Google Maps
                                </a>
                            </div>

                            <div style="background: var(--bg-surface, #f8fafc); border: 1.5px solid var(--border-color, #cbd5e1); border-radius: 12px; padding: 0.85rem 1.1rem; font-size: 0.88rem; color: var(--text-primary, #334155); box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                                    <strong style="color: var(--text-heading, #0f172a); font-size: 0.95rem; display: flex; align-items: center; gap: 6px;">
                                        <i class="bi bi-shop" style="color: #10b981;"></i> Kandang Peternak: {{ $sapi->peternak->name ?? 'Peternak' }}
                                    </strong>
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $sapiLat }},{{ $sapiLng }}" target="_blank" rel="noopener noreferrer" style="background: #00A740; color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(0, 167, 64, 0.25); transition: all 0.2s;" title="Klik untuk membuka titik rute lokasi sapi di Google Maps">
                                        <i class="bi bi-geo-alt-fill"></i> Ambil di Lokasi (Peta)
                                    </a>
                                </div>
                                <div style="color: var(--text-secondary, #475569); line-height: 1.5; font-size: 0.88rem;">
                                    {{ $sapiLokasi }}
                                </div>
                                <div style="margin-top: 4px;">
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $sapiLat }},{{ $sapiLng }}" target="_blank" rel="noopener noreferrer" style="color: var(--green-brand, #00A740); font-weight: 700; font-size: 0.82rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="bi bi-signpost-2-fill"></i> Lihat Rute Petunjuk Arah Google Maps &rarr;
                                    </a>
                                </div>
                                <div style="font-size: 0.8rem; color: var(--text-secondary, #64748b); margin-top: 6px; border-top: 1px dashed var(--border-color, #e2e8f0); padding-top: 6px; display: flex; align-items: center; gap: 5px;">
                                    <i class="bi bi-info-circle-fill" style="color: #3b82f6;"></i>
                                    <span>Peta di bawah menunjukkan titik koordinat lokasi sapi untuk penjemputan ternak secara mandiri.</span>
                                </div>
                            </div>
                        </div>

                        {{-- ═══ 3. PETA LOKASI (SELALU MUNCUL: BAIK PENGANTARAN YA MAUPUN TIDAK) ═══ --}}
                        <div id="containerPetaLokasi" style="display: flex; flex-direction: column; gap: 0.5rem; margin-top: 0.5rem;">
                            {{-- Peta Satelit Google Maps --}}
                            <div style="position: relative; width: 100%; border-radius: 12px; overflow: hidden; border: 1px solid #cbd5e1; box-shadow: 0 3px 10px rgba(0,0,0,0.08);">
                                <div id="mapPengantaran" style="width: 100%; height: 280px; z-index: 1;"></div>
                                
                                {{-- Overlay Bar Bawah 1: Menampilkan Jarak Tempuh Rute Jalan (Saat Pengantaran = Ya) --}}
                                <div id="overlayRutePengantaran" style="position: absolute; bottom: 8px; left: 8px; right: 8px; z-index: 1000; background: rgba(255,255,255,0.95); backdrop-filter: blur(6px); padding: 0.5rem 0.9rem; border-radius: 8px; font-size: 0.82rem; color: #1e293b; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(0,0,0,0.08); box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                    <span><i class="bi bi-signpost-split-fill" style="color: #10b981;"></i> Rute Jalan Terdekat</span>
                                    <span style="font-weight: 800; color: #0f172a; font-family: 'Montserrat', sans-serif;" id="badgeJarak">
                                        Mencari rute terdekat...
                                    </span>
                                </div>

                                {{-- Overlay Bar Bawah 2: Menampilkan Keterangan Lokasi Sapi/Kandang (Saat Pengantaran = Tidak) --}}
                                <div id="overlayLokasiKandang" style="display: none; position: absolute; bottom: 8px; left: 8px; right: 8px; z-index: 1000; background: rgba(255,255,255,0.95); backdrop-filter: blur(6px); padding: 0.5rem 0.9rem; border-radius: 8px; font-size: 0.82rem; color: #1e293b; justify-content: space-between; align-items: center; border: 1px solid rgba(0,0,0,0.08); box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                    <span style="display: flex; align-items: center; gap: 6px;">
                                        <i class="bi bi-shop" style="color: #10b981; font-size: 1rem;"></i>
                                        <strong style="color: #0f172a;">Lokasi Kandang Peternak</strong>
                                    </span>
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $sapiLat }},{{ $sapiLng }}" target="_blank" rel="noopener noreferrer" style="font-weight: 700; color: #166534; background: #dcfce7; padding: 3px 10px; border-radius: 6px; font-size: 0.75rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" title="Buka rute navigasi Google Maps">
                                        <i class="bi bi-geo-alt-fill"></i> Ambil di Lokasi (Maps &rarr;)
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Harga Pengantaran Dinamis Berdasarkan Jarak Tempuh Rute Jalan --}}
                        <div class="spec-row delivery-field" id="rowHargaPengantaran" style="align-items: flex-start; margin-top: 0.5rem;">
                            <div>
                                <span class="spec-title">Harga Pengataran</span>
                                <div id="rincianOngkir" style="font-size: 0.8rem; color: #64748b; margin-top: 0.2rem;">
                                    Tarif dasar (0–5 km): Rp100.000
                                </div>
                            </div>
                            <span class="spec-value" id="labelHargaPengataran" style="font-size: 1.15rem; font-weight: 800; color: #1e293b;">
                                Rp.100.000
                            </span>
                        </div>

                        {{-- Baris Biaya Perawatan Ternak (Hanya jika Pre-Order) --}}
                        @if($sapi->is_preorder)
                        <div class="spec-row" id="rowBiayaPerawatan" style="align-items: flex-start; margin-top: 0.5rem; background: #fffbeb; padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid #fde68a;">
                            <div>
                                <span class="spec-title" style="display: flex; align-items: center; gap: 6px; color: #92400e;">
                                    <i class="bi bi-shield-fill-check" style="color: #f59e0b;"></i> Biaya Perawatan Ternak
                                </span>
                                <div id="rincianBiayaPerawatan" style="font-size: 0.8rem; color: #78350f; margin-top: 0.2rem;">
                                    Pakan & pemeliharaan selama masa tunggu
                                </div>
                            </div>
                            <span class="spec-value" id="labelBiayaPerawatan" style="font-size: 1.15rem; font-weight: 800; color: #b45309;">
                                Rp.{{ number_format(7 * $tarifPerawatanPerHari, 0, ',', '.') }}
                            </span>
                        </div>
                        @endif

                    </div>

                    {{-- ═══ TOTAL SUMMARY BOX (Grey container matching wireframe) ═══ --}}
                    <div class="total-summary-card">
                        <div class="summary-row">
                            <span class="summary-label">Total Biaya</span>
                            <span class="summary-val" id="textTotal">Rp.20.100.000</span>
                        </div>
                        @if($sapi->is_preorder)
                        <div class="summary-row" style="color: #047857; font-weight: 700;">
                            <span class="summary-label" style="color: #047857;">Pembayaran 1 (DP Sekarang)</span>
                            <span class="summary-val" id="textDibayarkan" style="color: #047857;">Rp.5.000.000</span>
                        </div>
                        <div class="summary-row" style="color: #b45309;">
                            <span class="summary-label" style="color: #b45309;">Pembayaran 2 (Pelunasan saat Ambil/Kirim)</span>
                            <span class="summary-val" id="textSisaPembayaran" style="color: #b45309;">Rp.15.100.000</span>
                        </div>
                        @else
                        <div class="summary-row">
                            <span class="summary-label">Dibayarkan</span>
                            <span class="summary-val" id="textDibayarkan">Rp.20.100.000</span>
                        </div>
                        <div class="summary-row" style="display: none;">
                            <span class="summary-label">Sisa Pembayaran</span>
                            <span class="summary-val" id="textSisaPembayaran">Rp.0</span>
                        </div>
                        @endif
                    </div>

                    {{-- ═══ ACTION BUTTONS (Batal & Beli) ═══ --}}
                    <div class="action-buttons-wrapper">
                        <button type="button" class="btn-pembayaran btn-batal" onclick="handleBatal()">
                            <i class="bi bi-arrow-left"></i> Batal
                        </button>
                        <button type="button" class="btn-pembayaran btn-beli" id="btnSubmitBeli" onclick="handleBeliSubmit()">
                            <i class="bi bi-bag-check-fill"></i> Beli
                        </button>
                    </div>

                </div>

            </div>
        </form>

        {{-- Modal Konfirmasi Pemesanan --}}
        <div id="modalKonfirmasiBeli" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closeModalKonfirmasi()">
            <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, transparent); border-radius: 18px; max-width: 500px; width: 100%; padding: 1.75rem; box-shadow: var(--card-shadow, 0 25px 50px -12px rgba(0, 0, 0, 0.25));" onclick="event.stopPropagation()">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.25rem; border-bottom: 1px solid var(--border-color, #f1f5f9); padding-bottom: 1rem;">
                    <div style="width: 44px; height: 44px; background: rgba(0, 167, 64, 0.12); color: var(--green-brand, #00A740); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>
                    <div>
                        <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1.15rem; font-weight: 800; color: var(--text-heading, #0f172a); margin: 0;">
                            Konfirmasi Pemesanan Sapi
                        </h3>
                        <span style="font-size: 0.8rem; color: var(--text-secondary, #64748b);">Periksa rincian pesanan Anda sebelum lanjut</span>
                    </div>
                </div>

                <div style="background: var(--bg-surface, #f8fafc); border-radius: 12px; padding: 1rem; border: 1px solid var(--border-color, #e2e8f0); margin-bottom: 1.25rem; font-size: 0.88rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                        <span style="color: var(--text-secondary, #64748b);">Ternak:</span>
                        <strong style="color: var(--text-heading, #0f172a);">Sapi {{ $sapi->jenis }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                        <span style="color: var(--text-secondary, #64748b);">Harga Ternak:</span>
                        <span style="color: var(--text-heading, #0f172a); font-weight: 600;">Rp.{{ number_format($sapi->harga, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                        <span style="color: var(--text-secondary, #64748b);">Metode Pengantaran:</span>
                        <span id="modalPengantaranText" style="color: var(--text-heading, #0f172a); font-weight: 700;">Diantar</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;" id="modalRowLokasiAmbil">
                        <span style="color: var(--text-secondary, #64748b);">Lokasi Pengambilan:</span>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $sapiLat }},{{ $sapiLng }}" target="_blank" rel="noopener noreferrer" style="color: var(--green-brand, #00A740); font-weight: 700; text-align: right; max-width: 250px; font-size: 0.82rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" title="Buka rute Google Maps">
                            <span>{{ Str::limit($sapiLokasi, 32) }}</span>
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;" id="modalRowOngkir">
                        <span style="color: var(--text-secondary, #64748b);">Ongkos Kirim:</span>
                        <span id="modalOngkirText" style="color: var(--text-heading, #0f172a); font-weight: 600;">Rp.100.000</span>
                    </div>
                    @if($sapi->is_preorder)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;" id="modalRowTanggalPreorder">
                        <span style="color: var(--text-secondary, #64748b);">Rencana Penjemputan/Kirim:</span>
                        <strong id="modalTanggalText" style="color: var(--text-heading, #0f172a);"></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;" id="modalRowBiayaPerawatan">
                        <span style="color: var(--text-secondary, #64748b);">Biaya Perawatan:</span>
                        <span id="modalBiayaPerawatanText" style="color: #b45309; font-weight: 700;"></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px; background: rgba(16, 185, 129, 0.12); padding: 5px 8px; border-radius: 8px;">
                        <span style="color: #047857; font-weight: 700;">Pembayaran 1 (DP Sekarang):</span>
                        <strong id="modalDpText" style="color: #047857;"></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px; background: rgba(245, 158, 11, 0.12); padding: 5px 8px; border-radius: 8px;">
                        <span style="color: #b45309; font-weight: 700;">Pembayaran 2 (Pelunasan):</span>
                        <strong id="modalSisaText" style="color: #b45309;"></strong>
                    </div>
                    @endif
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: var(--text-secondary, #64748b);">Metode Pembayaran:</span>
                        <span id="modalMetodeBayarText" style="color: var(--text-heading, #0f172a); font-weight: 700;">Transfer Bank</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding-top: 8px; border-top: 1px dashed var(--border-color, #cbd5e1); font-size: 1rem;">
                        <strong style="color: var(--text-heading, #0f172a);">Total Biaya Keseluruhan:</strong>
                        <strong id="modalTotalText" style="color: var(--green-brand, #00A740); font-family: 'Montserrat', sans-serif;"></strong>
                    </div>
                </div>

                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" onclick="closeModalKonfirmasi()" style="padding: 0.65rem 1.25rem; border-radius: 10px; border: 1px solid var(--border-color, #cbd5e1); background: var(--bg-card, white); color: var(--text-secondary, #475569); font-weight: 600; cursor: pointer;">
                        Periksa Kembali
                    </button>
                    <button type="button" id="btnModalExecuteSubmit" onclick="executeSubmitForm()" style="padding: 0.65rem 1.4rem; border-radius: 10px; border: none; background: var(--green-brand, #00A740); color: white; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(0, 167, 64, 0.3);">
                        <i class="bi bi-check-circle-fill"></i> Ya, Buat Pesanan
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal Role Notice untuk Non-Pembeli di Pembayaran --}}
        <div id="modalRoleNotice" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;" onclick="closeModalRoleNotice()">
            <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, transparent); border-radius: 16px; max-width: 460px; width: 100%; padding: 1.75rem; box-shadow: var(--card-shadow, 0 25px 50px -12px rgba(0, 0, 0, 0.25)); text-align: center;" onclick="event.stopPropagation()">
                <div style="width: 56px; height: 56px; background: rgba(239, 68, 68, 0.12); color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1rem;">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1.2rem; font-weight: 800; color: var(--text-heading, #0f172a); margin-bottom: 0.5rem;" id="modalRoleTitle">
                    Pemberitahuan Akun
                </h3>
                <p style="color: var(--text-secondary, #64748b); font-size: 0.92rem; line-height: 1.6; margin-bottom: 1.5rem;" id="modalRoleMessage">
                    Fitur transaksi pembelian sapi hanya dapat dilakukan melalui akun dengan role <strong>Pembeli</strong>.
                </p>
                <div style="display: flex; gap: 10px; justify-content: center;" id="modalRoleActionBtns">
                    <button type="button" onclick="closeModalRoleNotice()" style="padding: 0.6rem 1.25rem; border-radius: 10px; border: 1px solid var(--border-color, #cbd5e1); background: var(--bg-card, white); color: var(--text-secondary, #475569); font-weight: 600; cursor: pointer;">
                        Tutup
                    </button>
                    @auth
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="padding: 0.6rem 1.25rem; border-radius: 10px; border: none; background: #00A740; color: white; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="bi bi-box-arrow-right"></i> Ganti Akun Pembeli
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" style="padding: 0.6rem 1.25rem; border-radius: 10px; border: none; background: #00A740; color: white; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="bi bi-box-arrow-in-right"></i> Login Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* ═══ Styling Persis Wireframe Minimalis & Modern ═══ */
    .pembayaran-grid {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 60px;
        align-items: flex-start;
    }

    .section-heading {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.25rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 1.25rem;
    }

    /* Foto Ternak */
    .foto-ternak-box {
        width: 100%;
        height: 280px;
        background: #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }

    .foto-ternak-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .foto-ternak-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    /* Catatan */
    .catatan-wrapper {
        margin-top: 1.5rem;
    }

    .catatan-label {
        display: block;
        font-family: 'Montserrat', sans-serif;
        font-size: 1.05rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .catatan-box {
        width: 100%;
        background: #e2e8f0;
        border: none;
        border-radius: 12px;
        padding: 0.85rem 1rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        color: #111827;
        resize: vertical;
        box-sizing: border-box;
        outline: none;
        transition: all 0.2s;
    }

    .catatan-box:focus {
        background: #f1f5f9;
        box-shadow: 0 0 0 2px #94a3b8;
    }

    /* Metode Pembayaran */
    .metode-pembayaran-wrapper {
        margin-top: 1.5rem;
    }

    .metode-label {
        display: block;
        font-family: 'Montserrat', sans-serif;
        font-size: 1.05rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 0.65rem;
    }

    .toggle-group-payment {
        display: inline-flex;
        background: #f1f5f9;
        border-radius: 8px;
        padding: 3px;
        gap: 4px;
    }

    .btn-toggle-pay {
        padding: 0.45rem 1.25rem;
        border-radius: 6px;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
        border: none;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-toggle-pay.active {
        background: #cbd5e1;
        color: #0f172a;
        font-weight: 700;
    }

    .info-rekening-box {
        margin-top: 1rem;
    }

    .bank-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.2rem;
    }

    .bank-number {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: 0.5px;
        margin-bottom: 0.35rem;
    }

    .bank-note {
        font-family: 'Inter', sans-serif;
        font-size: 0.88rem;
        color: #64748b;
        line-height: 1.4;
    }

    .info-cash-box {
        margin-top: 1rem;
        padding: 0.85rem 1rem;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
    }

    /* Kolom Kanan */
    .col-right {
        display: flex;
        flex-direction: column;
    }

    .spec-list {
        display: flex;
        flex-direction: column;
        gap: 1.1rem;
        margin-bottom: 2rem;
    }

    .spec-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
    }

    .spec-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        white-space: nowrap;
    }

    .spec-value {
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        color: #64748b;
        font-weight: 500;
        text-align: right;
    }

    /* Toggle Pengantaran */
    .toggle-group-delivery {
        display: inline-flex;
        background: #f1f5f9;
        border-radius: 6px;
        padding: 2px;
        gap: 2px;
    }

    .btn-toggle-deliv {
        padding: 0.35rem 1.1rem;
        border-radius: 5px;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        border: none;
        background: #d1d5db;
        color: #1f2937;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-toggle-deliv.active {
        background: #000000 !important;
        color: #ffffff !important;
    }

    .btn-gps-action {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        outline: none;
        font-family: 'Inter', sans-serif;
    }

    .btn-gps-action:hover {
        background: #10b981;
        color: white;
    }

    .lokasi-input-box {
        width: 100%;
        background: #e2e8f0;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        color: #111827;
        resize: vertical;
        box-sizing: border-box;
        outline: none;
        transition: all 0.2s;
    }

    .lokasi-input-box:focus {
        background: #f1f5f9;
        box-shadow: 0 0 0 2px #94a3b8;
    }

    .form-hint-text {
        font-size: 0.78rem;
        color: #64748b;
        margin-top: 0.25rem;
        display: block;
        transition: color 0.2s;
    }

    /* Summary Card (Grey Card) */
    .total-summary-card {
        background: #e2e8f0;
        border-radius: 14px;
        padding: 1.4rem 1.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 2rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .summary-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e293b;
    }

    .summary-val {
        font-family: 'Inter', sans-serif;
        font-size: 1.05rem;
        font-weight: 600;
        color: #475569;
    }

    /* Action Buttons */
    .action-buttons-wrapper {
        display: flex;
        justify-content: flex-end;
        gap: 1.25rem;
    }

    .btn-pembayaran {
        min-width: 130px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-family: 'Montserrat', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
    }

    .btn-batal {
        background: #d1d5db;
        color: #111827;
    }

    .btn-batal:hover {
        background: #9ca3af;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-beli {
        background: #d1d5db;
        color: #111827;
    }

    .btn-beli:hover {
        background: #10b981;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Responsive */
    @media (max-width: 900px) {
        .pembayaran-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .action-buttons-wrapper {
            justify-content: stretch;
        }

        .btn-pembayaran {
            flex: 1;
        }
    }
</style>

<!-- Leaflet JS for Map -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    // ─── DATA DASAR DARI SERVER ───
    const HARGA_SAPI = {{ $sapi->harga }};
    const IS_PREORDER = {{ $sapi->is_preorder ? 'true' : 'false' }};
    const DP_SAPI = {{ $dp }};
    const SAPI_LAT = {{ $sapiLat }};
    const SAPI_LNG = {{ $sapiLng }};
    const SAPI_LOKASI = "{{ addslashes($sapiLokasi) }}";
    const IS_LOGGED_IN = {{ auth()->check() ? 'true' : 'false' }};
    const USER_ROLE = "{{ auth()->check() ? auth()->user()->role : '' }}";
    const TARIF_PERAWATAN_PER_HARI = {{ $tarifPerawatanPerHari ?? 25000 }};
    const TANGGAL_PESAN_STR = '{{ date('Y-m-d') }}';
    const DEFAULT_TANGGAL_AMBIL = '{{ $defaultTanggalAmbil ?? date('Y-m-d', strtotime('+7 days')) }}';

    let state = {
        pengantaran: 'ya', // 'ya' | 'tidak'
        metodePembayaran: 'transfer', // 'transfer' | 'cash'
        destLat: SAPI_LAT + 0.045, // Titik awal pengantaran
        destLng: SAPI_LNG + 0.045,
        jarakKm: 0,
        durasiMenit: 0,
        biayaOngkir: 100000,
        tanggalPengambilan: DEFAULT_TANGGAL_AMBIL,
        durasiHariPerawatan: 7,
        biayaPerawatan: 7 * TARIF_PERAWATAN_PER_HARI
    };

    let map = null;
    let sapiMarker = null;
    let destMarker = null;
    let roadRouteLayer = null;
    let geocodeTimer = null;

    // Format Rupiah helper
    function formatRupiah(angka) {
        return 'Rp.' + Math.round(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Inisialisasi Peta (Menggunakan Google Maps Satelit sama persis seperti di registrasi)
    function initMap() {
        if (map !== null) return;

        const mapContainer = document.getElementById('mapPengantaran');
        if (!mapContainer) return;

        map = L.map('mapPengantaran', {
            scrollWheelZoom: true
        }).setView([SAPI_LAT, SAPI_LNG], 13);

        // Google Maps Satelit / Hybrid Layer persis seperti pada halaman registrasi
        L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps Satelit'
        }).addTo(map);

        // Marker Lokasi Sapi (Asal)
        const iconSapi = L.divIcon({
            className: 'sapi-custom-marker',
            html: '<div style="background: #10b981; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.4); border: 2.5px solid white;"><i class="bi bi-shop"></i></div>',
            iconSize: [36, 36],
            iconAnchor: [18, 18]
        });

        // Marker Lokasi Pengantaran (Tujuan - Draggable persis seperti registrasi)
        const iconDest = L.divIcon({
            className: 'dest-custom-marker',
            html: '<div style="background: #ef4444; color: white; width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 4px 12px rgba(239,68,68,0.45); border: 2.5px solid white; cursor: grab;"><i class="bi bi-geo-alt-fill"></i></div>',
            iconSize: [38, 38],
            iconAnchor: [19, 36]
        });

        const popupSapiHtml = `
            <div style="min-width: 190px; font-family: 'Inter', sans-serif;">
                <strong style="color: #0f172a; font-size: 13px; display: flex; align-items: center; gap: 4px;">
                    <i class="bi bi-shop" style="color: #10b981;"></i> Lokasi Kandang Sapi
                </strong>
                <p style="margin: 4px 0 6px; font-size: 12px; color: #475569; line-height: 1.4;">
                    ${SAPI_LOKASI}
                </p>
                <div style="margin-top: 4px;">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${SAPI_LAT},${SAPI_LNG}" target="_blank" rel="noopener noreferrer" style="background: #00A740; color: white; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="bi bi-box-arrow-up-right"></i> Ambil di Lokasi (Buka Maps)
                    </a>
                </div>
            </div>
        `;

        sapiMarker = L.marker([SAPI_LAT, SAPI_LNG], { icon: iconSapi }).addTo(map)
            .bindPopup(popupSapiHtml);

        destMarker = L.marker([state.destLat, state.destLng], {
            icon: iconDest,
            draggable: true
        });

        destMarker.bindPopup('<b>Titik Pengantaran Anda</b><br>Geser untuk mengubah lokasi pengantaran.');

        // Event saat marker digeser (dragend)
        destMarker.on('dragend', function(e) {
            if (state.pengantaran === 'ya') {
                const pos = e.target.getLatLng();
                handleLokasiTujuanBerubah(pos.lat, pos.lng, true);
            }
        });

        // Event saat peta diklik
        map.on('click', function(e) {
            if (state.pengantaran === 'ya') {
                if (!map.hasLayer(destMarker)) {
                    destMarker.addTo(map);
                }
                destMarker.setLatLng(e.latlng);
                handleLokasiTujuanBerubah(e.latlng.lat, e.latlng.lng, true);
            }
        });

        // Attach Geocoding Address listener seperti di register.blade.php
        const alamatInput = document.getElementById('inputDetailLokasi');
        if (alamatInput) {
            alamatInput.addEventListener('input', function() {
                clearTimeout(geocodeTimer);
                const query = this.value.trim();
                if (query.length < 5) return;

                const mapStatus = document.getElementById('map-status');
                if (mapStatus) {
                    mapStatus.innerHTML = '<i class="bi bi-search"></i> Mencari lokasi dari alamat...';
                    mapStatus.style.color = '#f59e0b';
                }

                geocodeTimer = setTimeout(() => {
                    geocodeAddress(query);
                }, 800);
            });
        }

        // Tampilkan elemen sesuai state pengantaran saat inisialisasi
        if (state.pengantaran === 'ya') {
            destMarker.addTo(map);
            handleLokasiTujuanBerubah(state.destLat, state.destLng, false);
        } else {
            map.setView([SAPI_LAT, SAPI_LNG], 15);
            sapiMarker.openPopup();
        }
    }

    // Geocode Alamat ke Koordinat (Sama persis seperti sistem di registrasi)
    function geocodeAddress(query) {
        if (!map || !destMarker) return;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&countrycodes=id`)
            .then(response => response.json())
            .then(data => {
                const mapStatus = document.getElementById('map-status');
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lng = parseFloat(data[0].lon);

                    destMarker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 15);

                    if (mapStatus) {
                        mapStatus.innerHTML = '<i class="bi bi-check-circle-fill"></i> Lokasi ditemukan &bull; menghitung rute jalan...';
                        mapStatus.style.color = '#10b981';
                    }

                    handleLokasiTujuanBerubah(lat, lng, false);
                } else {
                    if (mapStatus) {
                        mapStatus.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> Lokasi tidak ditemukan, coba alamat lebih spesifik';
                        mapStatus.style.color = '#f59e0b';
                    }
                }
            })
            .catch(() => {
                const mapStatus = document.getElementById('map-status');
                if (mapStatus) {
                    mapStatus.innerHTML = '<i class="bi bi-x-circle-fill"></i> Gagal mencari lokasi alamat';
                    mapStatus.style.color = '#ef4444';
                }
            });
    }

    // Handle Lokasi Pengantaran Berubah
    function handleLokasiTujuanBerubah(lat, lng, doReverseGeocode = true) {
        state.destLat = lat;
        state.destLng = lng;

        document.getElementById('inputLatitude').value = lat.toFixed(8);
        document.getElementById('inputLongitude').value = lng.toFixed(8);

        // Hitung rute jarak tempuh jalan via OSRM Driving Engine
        calculateRoadRoute(SAPI_LAT, SAPI_LNG, lat, lng);

        // Reverse geocoding otomatis jika marker dipindah manual
        if (doReverseGeocode) {
            reverseGeocode(lat, lng);
        }
    }

    // ─── PERHITUNGAN JARAK TEMPUH MELALUI JALAN RAYA (Mencari Rute Terdekat) ───
    function calculateRoadRoute(sapiLat, sapiLng, destLat, destLng) {
        if (state.pengantaran !== 'ya') return;

        const badgeJarak = document.getElementById('badgeJarak');
        if (badgeJarak) {
            badgeJarak.innerHTML = '<i class="bi bi-car-front-fill"></i> <em>Mencari rute jalan terdekat...</em>';
        }

        // OSRM Driving Service dengan opsi alternatives=true untuk mencari rute jalan terpendek
        const url = `https://router.project-osrm.org/route/v1/driving/${sapiLng},${sapiLat};${destLng},${destLat}?overview=full&geometries=geojson&alternatives=true`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (state.pengantaran !== 'ya') return;

                if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
                    // Cari rute dengan jarak paling minimal (jarak terdekat) di antara semua alternatif
                    let shortestRoute = data.routes[0];
                    for (let i = 1; i < data.routes.length; i++) {
                        if (data.routes[i].distance < shortestRoute.distance) {
                            shortestRoute = data.routes[i];
                        }
                    }

                    const jarakJalanMeters = shortestRoute.distance;
                    const jarakJalanKm = jarakJalanMeters / 1000.0;
                    const durasiMenit = Math.round(shortestRoute.duration / 60.0);

                    // Gambar garis rute jalan raya terdekat di atas peta satelit
                    if (roadRouteLayer && map) {
                        map.removeLayer(roadRouteLayer);
                    }

                    roadRouteLayer = L.geoJSON(shortestRoute.geometry, {
                        style: {
                            color: '#10b981',
                            weight: 5,
                            opacity: 0.95,
                            lineCap: 'round',
                            lineJoin: 'round'
                        }
                    }).addTo(map);

                    // Fit bounds agar rute penuh tampak di layar
                    if (map && destMarker && sapiMarker) {
                        const bounds = L.latLngBounds([[sapiLat, sapiLng], [destLat, destLng]]);
                        map.fitBounds(bounds.pad(0.25));
                    }

                    // Terapkan perhitungan tarif pengantaran untuk rute terdekat
                    applyDeliveryFare(jarakJalanKm, durasiMenit);
                } else {
                    fallbackHaversineWithRoadFactor(sapiLat, sapiLng, destLat, destLng);
                }
            })
            .catch(() => {
                if (state.pengantaran !== 'ya') return;
                fallbackHaversineWithRoadFactor(sapiLat, sapiLng, destLat, destLng);
            });
    }

    // Fallback jika API rute sedang offline: gunakan jarak lurus × faktor kelokan jalan (1.35x)
    function fallbackHaversineWithRoadFactor(lat1, lon1, lat2, lon2) {
        if (state.pengantaran !== 'ya') return;

        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const straightDistance = R * c;

        // Faktor rute jalan darat rata-rata
        const estimatedRoadKm = straightDistance * 1.35;

        if (roadRouteLayer && map) {
            map.removeLayer(roadRouteLayer);
        }
        roadRouteLayer = L.polyline([[lat1, lon1], [lat2, lon2]], {
            color: '#10b981',
            weight: 4,
            dashArray: '8, 8',
            opacity: 0.85
        }).addTo(map);

        applyDeliveryFare(estimatedRoadKm, Math.round(estimatedRoadKm * 2.5));
    }

    // ─── SKEMA TARIF DASAR + TARIF PER KILOMETER JALAN RAYA ───
    // Tarif dasar (0–5 km): Rp100.000
    // Tarif per km berikutnya (> 5 km): Rp12.000/km
    // Contoh simulasi:
    // - Jarak 3 km: Rp100.000
    // - Jarak 10 km: Rp100.000 + (5 km × Rp12.000) = Rp160.000
    // - Jarak 20 km: Rp100.000 + (15 km × Rp12.000) = Rp280.000
    function applyDeliveryFare(jarakKm, durasiMenit) {
        state.jarakKm = jarakKm;
        state.durasiMenit = durasiMenit;
        document.getElementById('inputJarakKm').value = jarakKm.toFixed(2);

        let ongkir = 0;
        let rincian = '';

        if (jarakKm <= 5.0) {
            ongkir = 100000;
            rincian = 'Tarif dasar (0–5 km rute terdekat): Rp100.000';
        } else {
            const jarakTambahan = jarakKm - 5.0;
            const biayaTambahan = Math.round(jarakTambahan * 12000);
            ongkir = 100000 + biayaTambahan;
            rincian = `Tarif dasar Rp100.000 + (${jarakTambahan.toFixed(1)} km rute terdekat × Rp12.000)`;
        }

        state.biayaOngkir = ongkir;

        // Update UI
        const badge = document.getElementById('badgeJarak');
        if (badge) {
            badge.innerHTML = `<i class="bi bi-signpost-split-fill"></i> <strong>${jarakKm.toFixed(1)} km</strong> (~${durasiMenit} mnt)`;
        }

        document.getElementById('labelHargaPengataran').innerText = formatRupiah(ongkir);
        document.getElementById('rincianOngkir').innerText = rincian;

        const mapStatus = document.getElementById('map-status');
        if (mapStatus) {
            mapStatus.innerHTML = `<i class="bi bi-check-circle-fill"></i> Rute terdekat dipilih &bull; Jarak tempuh: <strong>${jarakKm.toFixed(1)} km</strong>`;
            mapStatus.style.color = '#10b981';
        }

        // Hitung ulang total pembayaran
        hitungDanRenderTotal();
    }

    // Reverse Geocoding (Nominatim)
    function reverseGeocode(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
            .then(res => res.json())
            .then(data => {
                if (data && data.display_name) {
                    const inputLokasi = document.getElementById('inputDetailLokasi');
                    if (!inputLokasi.value || inputLokasi.dataset.autofilled === "true") {
                        inputLokasi.value = data.display_name;
                        inputLokasi.dataset.autofilled = "true";
                    }
                }
            })
            .catch(() => {});
    }

    // GPS Saya (Sama persis dengan getCurrentLocation di registrasi)
    function getCurrentLocation() {
        if (!navigator.geolocation) {
            alert('Browser Anda tidak mendukung layanan lokasi GPS.');
            return;
        }

        const mapStatus = document.getElementById('map-status');
        if (mapStatus) {
            mapStatus.innerHTML = '<i class="bi bi-crosshair"></i> Mengambil lokasi GPS Anda...';
            mapStatus.style.color = '#3b82f6';
        }

        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            if (destMarker && map) {
                destMarker.setLatLng([lat, lng]);
                map.setView([lat, lng], 15);

                if (mapStatus) {
                    mapStatus.innerHTML = '<i class="bi bi-check-circle-fill"></i> Lokasi GPS ditemukan &bull; menghitung rute jalan...';
                    mapStatus.style.color = '#10b981';
                }

                handleLokasiTujuanBerubah(lat, lng, true);
            }
        }, function(err) {
            alert('Gagal mengambil lokasi GPS Anda. Pastikan izin lokasi diaktifkan di browser.');
        }, { enableHighAccuracy: true, timeout: 8000 });
    }

    // Toggle Pengantaran (Tidak / Ya)
    function setPengantaran(val) {
        state.pengantaran = val;
        document.getElementById('inputPengantaran').value = val;

        const btnYa = document.getElementById('btnDelivYa');
        const btnTidak = document.getElementById('btnDelivTidak');
        const containerInputPengantaran = document.getElementById('containerInputPengantaran');
        const containerInfoAmbilSendiri = document.getElementById('containerInfoAmbilSendiri');
        const rowHargaPengantaran = document.getElementById('rowHargaPengantaran');
        const overlayRutePengantaran = document.getElementById('overlayRutePengantaran');
        const overlayLokasiKandang = document.getElementById('overlayLokasiKandang');
        const inputDetailLokasi = document.getElementById('inputDetailLokasi');

        if (val === 'ya') {
            btnYa.classList.add('active');
            btnTidak.classList.remove('active');

            const lblTgl = document.getElementById('labelTanggalAmbil');
            if (lblTgl) lblTgl.innerText = 'Tanggal Rencana Pengantaran Sapi';
            
            // TAMPILKAN Form Input Lokasi Pengantaran & Harga Pengantaran
            if (containerInputPengantaran) containerInputPengantaran.style.display = 'flex';
            if (containerInfoAmbilSendiri) containerInfoAmbilSendiri.style.display = 'none';
            if (rowHargaPengantaran) rowHargaPengantaran.style.display = 'flex';
            if (overlayRutePengantaran) overlayRutePengantaran.style.display = 'flex';
            if (overlayLokasiKandang) overlayLokasiKandang.style.display = 'none';
            if (inputDetailLokasi) inputDetailLokasi.required = true;

            setTimeout(() => {
                initMap();
                if (map) {
                    map.invalidateSize();
                    // Pasang kembali marker tujuan jika belum ada di layer peta
                    if (destMarker && !map.hasLayer(destMarker)) {
                        destMarker.addTo(map);
                    }
                    // Hitung dan gambar rute jalan raya
                    handleLokasiTujuanBerubah(state.destLat, state.destLng, false);
                }
            }, 60);
        } else {
            btnTidak.classList.add('active');
            btnYa.classList.remove('active');

            const lblTgl = document.getElementById('labelTanggalAmbil');
            if (lblTgl) lblTgl.innerText = 'Tanggal Pengambilan Sapi di Kandang';

            // SEMBUNYIKAN Form Input Lokasi Pengantaran & Harga Pengantaran
            // TAMPILKAN Info Pengambilan Mandiri & PETA LOKASI TETAP MUNCUL
            if (containerInputPengantaran) containerInputPengantaran.style.display = 'none';
            if (containerInfoAmbilSendiri) containerInfoAmbilSendiri.style.display = 'block';
            if (rowHargaPengantaran) rowHargaPengantaran.style.display = 'none';
            if (overlayRutePengantaran) overlayRutePengantaran.style.display = 'none';
            if (overlayLokasiKandang) overlayLokasiKandang.style.display = 'flex';
            if (inputDetailLokasi) inputDetailLokasi.required = false;

            setTimeout(() => {
                initMap();
                if (map) {
                    map.invalidateSize();
                    // Hapus layer rute garis rute jalan
                    if (roadRouteLayer && map.hasLayer(roadRouteLayer)) {
                        map.removeLayer(roadRouteLayer);
                    }
                    // Sembunyikan marker tujuan pengantaran
                    if (destMarker && map.hasLayer(destMarker)) {
                        map.removeLayer(destMarker);
                    }
                    // Pastikan marker sapi ada di peta
                    if (sapiMarker && !map.hasLayer(sapiMarker)) {
                        sapiMarker.addTo(map);
                    }
                    // Fokuskan peta ke lokasi kandang sapi
                    map.setView([SAPI_LAT, SAPI_LNG], 15);
                    if (sapiMarker) {
                        sapiMarker.openPopup();
                    }
                }
            }, 60);
        }

        hitungDanRenderTotal();
    }

    // Toggle Metode Pembayaran (Cash / Transfer)
    function setMetodePembayaran(val) {
        state.metodePembayaran = val;
        document.getElementById('inputMetodePembayaran').value = val;

        const btnCash = document.getElementById('btnPayCash');
        const btnTransfer = document.getElementById('btnPayTransfer');
        const infoRekeningBox = document.getElementById('infoRekeningBox');
        const infoCashBox = document.getElementById('infoCashBox');

        if (val === 'transfer') {
            btnTransfer.classList.add('active');
            btnCash.classList.remove('active');

            infoRekeningBox.style.display = 'block';
            infoCashBox.style.display = 'none';
        } else {
            btnCash.classList.add('active');
            btnTransfer.classList.remove('active');

            infoRekeningBox.style.display = 'none';
            infoCashBox.style.display = 'block';
        }
    }

    // Event Handler Perubahan Tanggal Pengambilan / Pengantaran Pre-Order
    function onTanggalAmbilChange(val) {
        if (!val) return;
        state.tanggalPengambilan = val;

        const datePesan = new Date(TANGGAL_PESAN_STR + 'T00:00:00');
        const dateAmbil = new Date(val + 'T00:00:00');
        const diffTime = dateAmbil - datePesan;
        const diffDays = Math.max(1, Math.round(diffTime / (1000 * 60 * 60 * 24)));

        state.durasiHariPerawatan = diffDays;
        state.biayaPerawatan = diffDays * TARIF_PERAWATAN_PER_HARI;

        const badgeDurasi = document.getElementById('badgeDurasiHariText');
        if (badgeDurasi) {
            badgeDurasi.innerText = diffDays + ' Hari';
        }

        const rincianPerawatan = document.getElementById('rincianBiayaPerawatan');
        if (rincianPerawatan) {
            rincianPerawatan.innerText = 'Pakan & pemeliharaan selama ' + diffDays + ' hari';
        }

        const labelPerawatan = document.getElementById('labelBiayaPerawatan');
        if (labelPerawatan) {
            labelPerawatan.innerText = formatRupiah(state.biayaPerawatan);
        }

        // Simpan ke hidden input form
        const inputDurasi = document.getElementById('inputDurasiPerawatanHari');
        if (inputDurasi) inputDurasi.value = diffDays;
        const inputBiaya = document.getElementById('inputBiayaPerawatan');
        if (inputBiaya) inputBiaya.value = state.biayaPerawatan;

        hitungDanRenderTotal();
    }

    // Kalkulasi Total, Dibayarkan, dan Sisah Pembayaran
    function hitungDanRenderTotal() {
        const ongkir = (state.pengantaran === 'ya') ? state.biayaOngkir : 0;
        const biayaPerawatan = IS_PREORDER ? state.biayaPerawatan : 0;
        const total = HARGA_SAPI + ongkir + biayaPerawatan;

        let dibayarkan = 0;
        let sisah = 0;

        if (IS_PREORDER) {
            dibayarkan = DP_SAPI;
            sisah = total - dibayarkan;
        } else {
            dibayarkan = total;
            sisah = 0;
        }

        document.getElementById('textTotal').innerText = formatRupiah(total);
        document.getElementById('textDibayarkan').innerText = formatRupiah(dibayarkan);
        document.getElementById('textSisaPembayaran').innerText = formatRupiah(sisah);
    }

    // Handle Batal
    function handleBatal() {
        if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = "{{ route('katalog.show', $sapi->id) }}";
        }
    }

    // Handle Beli Submit
    function handleBeliSubmit() {
        if (!IS_LOGGED_IN) {
            document.getElementById('modalRoleTitle').innerText = 'Silakan Login Terlebih Dahulu';
            document.getElementById('modalRoleMessage').innerHTML = 'Untuk melakukan pemesanan ternak sapi, Anda harus masuk (login) menggunakan akun <strong>Pembeli</strong>.';
            document.getElementById('modalRoleNotice').style.display = 'flex';
            return;
        }

        if (USER_ROLE !== 'pembeli') {
            document.getElementById('modalRoleTitle').innerText = 'Akses Khusus Pembeli';
            document.getElementById('modalRoleMessage').innerHTML = 'Anda saat ini sedang login sebagai akun <strong>' + USER_ROLE.toUpperCase() + '</strong>. Pembelian sapi di sistem ini hanya dapat dilakukan melalui akun dengan role <strong>Pembeli</strong>.';
            document.getElementById('modalRoleNotice').style.display = 'flex';
            return;
        }

        if (IS_PREORDER) {
            const inputTgl = document.getElementById('inputTanggalPengambilan');
            const errTgl = document.getElementById('errorTanggalMsg');
            if (!inputTgl || !inputTgl.value) {
                if (errTgl) errTgl.style.display = 'block';
                if (inputTgl) {
                    inputTgl.style.borderColor = '#ef4444';
                    inputTgl.focus();
                    inputTgl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            } else {
                if (errTgl) errTgl.style.display = 'none';
                if (inputTgl) inputTgl.style.borderColor = '#cbd5e1';
            }
        }

        if (state.pengantaran === 'ya') {
            const inputLokasi = document.getElementById('inputDetailLokasi');
            const lokasi = inputLokasi ? inputLokasi.value.trim() : '';
            const errorMsg = document.getElementById('errorLokasiMsg');
            if (!lokasi) {
                if (errorMsg) errorMsg.style.display = 'block';
                if (inputLokasi) {
                    inputLokasi.style.borderColor = '#ef4444';
                    inputLokasi.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.2)';
                    inputLokasi.focus();
                    inputLokasi.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            } else {
                if (errorMsg) errorMsg.style.display = 'none';
                if (inputLokasi) {
                    inputLokasi.style.borderColor = '#cbd5e1';
                    inputLokasi.style.boxShadow = 'none';
                }
            }
        }

        openModalKonfirmasi();
    }

    function openModalKonfirmasi() {
        const modal = document.getElementById('modalKonfirmasiBeli');
        if (!modal) {
            executeSubmitForm();
            return;
        }

        const ongkir = (state.pengantaran === 'ya') ? state.biayaOngkir : 0;
        const biayaPerawatan = IS_PREORDER ? state.biayaPerawatan : 0;
        const total = HARGA_SAPI + ongkir + biayaPerawatan;

        const elPengantaran = document.getElementById('modalPengantaranText');
        const elOngkir = document.getElementById('modalOngkirText');
        const modalRowOngkir = document.getElementById('modalRowOngkir');
        const modalRowLokasiAmbil = document.getElementById('modalRowLokasiAmbil');
        const elMetode = document.getElementById('modalMetodeBayarText');
        const elTotal = document.getElementById('modalTotalText');
        const elTanggal = document.getElementById('modalTanggalText');
        const elBiayaPerawatan = document.getElementById('modalBiayaPerawatanText');

        if (elTanggal && IS_PREORDER) {
            elTanggal.innerText = `${state.tanggalPengambilan} (${state.durasiHariPerawatan} Hari)`;
        }
        if (elBiayaPerawatan && IS_PREORDER) {
            elBiayaPerawatan.innerText = formatRupiah(state.biayaPerawatan);
        }

        const elDp = document.getElementById('modalDpText');
        const elSisa = document.getElementById('modalSisaText');
        if (elDp && IS_PREORDER) {
            elDp.innerText = formatRupiah(DP_SAPI);
        }
        if (elSisa && IS_PREORDER) {
            elSisa.innerText = formatRupiah(Math.max(0, total - DP_SAPI));
        }

        if (elPengantaran) {
            elPengantaran.innerText = (state.pengantaran === 'ya') 
                ? `Diantar ke Lokasi (${(parseFloat(state.jarakKm) || 0).toFixed(1)} km)` 
                : 'Ambil Mandiri di Kandang Peternak';
        }

        if (state.pengantaran === 'ya') {
            if (modalRowOngkir) modalRowOngkir.style.display = 'flex';
            if (modalRowLokasiAmbil) modalRowLokasiAmbil.style.display = 'none';
            if (elOngkir) elOngkir.innerText = formatRupiah(ongkir);
        } else {
            if (modalRowOngkir) modalRowOngkir.style.display = 'none';
            if (modalRowLokasiAmbil) modalRowLokasiAmbil.style.display = 'flex';
        }

        if (elMetode) {
            elMetode.innerText = (state.metodePembayaran === 'transfer') 
                ? 'Transfer Bank' 
                : 'Tunai (Cash di Lokasi)';
        }
        if (elTotal) elTotal.innerText = formatRupiah(total);

        modal.style.display = 'flex';
    }

    function closeModalKonfirmasi() {
        const modal = document.getElementById('modalKonfirmasiBeli');
        if (modal) modal.style.display = 'none';
    }

    function closeModalRoleNotice() {
        const modal = document.getElementById('modalRoleNotice');
        if (modal) modal.style.display = 'none';
    }

    function executeSubmitForm() {
        const btnModal = document.getElementById('btnModalExecuteSubmit');
        const btnBeli = document.getElementById('btnSubmitBeli');

        if (btnModal) {
            btnModal.disabled = true;
            btnModal.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Memproses Pesanan...';
        }
        if (btnBeli) {
            btnBeli.disabled = true;
            btnBeli.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Memproses...';
        }

        document.getElementById('formPembayaran').submit();
    }

    // Inisialisasi saat DOM siap
    document.addEventListener('DOMContentLoaded', function() {
        setPengantaran('ya');
        setMetodePembayaran('transfer');

        const inputLokasi = document.getElementById('inputDetailLokasi');
        if (inputLokasi) {
            inputLokasi.addEventListener('input', function() {
                this.dataset.autofilled = "false";
                const errorMsg = document.getElementById('errorLokasiMsg');
                if (this.value.trim() && errorMsg) {
                    errorMsg.style.display = 'none';
                    this.style.borderColor = '#cbd5e1';
                    this.style.boxShadow = 'none';
                }
            });
        }
    });
</script>
@endsection
