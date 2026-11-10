<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Ternak Sapi Triwulan {{ $triwulan }} Tahun {{ $tahun }} — Kampung Suka Maju</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm 1.5cm 1.5cm;
            size: a4 portrait;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
            line-height: 1.35;
            font-size: 10.5pt;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        /* Toolbar Cetak Web */
        .print-toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #1e293b;
            color: #ffffff;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 9999;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .btn-toolbar {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
        }

        .btn-print-now {
            background: #10b981;
            color: #ffffff;
        }

        .btn-print-now:hover {
            background: #059669;
        }

        .btn-close-window {
            background: #475569;
            color: #ffffff;
        }

        .page-content-wrap {
            padding-top: 60px;
        }

        @media print {
            .print-toolbar {
                display: none !important;
            }
            .page-content-wrap {
                padding-top: 0 !important;
            }
            body {
                background: none;
            }
        }

        /* KOP SURAT RESMI */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3px;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 150px;
            text-align: left;
        }

        .kop-logo img {
            height: 68px;
            width: auto;
            object-fit: contain;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h4 {
            margin: 0;
            font-size: 12pt;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .kop-text h3 {
            margin: 2px 0;
            font-size: 13pt;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .kop-text h2 {
            margin: 2px 0;
            font-size: 16pt;
            font-weight: 900;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 2px 0 0 0;
            font-size: 8.5pt;
            font-style: italic;
            font-family: Arial, sans-serif;
            color: #222222;
        }

        .garis-kop-tebal {
            border-bottom: 2.5px solid #000000;
            margin-top: 5px;
            margin-bottom: 1.5px;
        }

        .garis-kop-tipis {
            border-bottom: 1px solid #000000;
            margin-bottom: 15px;
        }

        /* JUDUL LAPORAN */
        .judul-box {
            text-align: center;
            margin-bottom: 18px;
        }

        .judul-utama {
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .subjudul {
            font-size: 10pt;
            margin-top: 4px;
            font-weight: bold;
        }

        /* TABEL STATISTIK */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        .summary-table td {
            padding: 8px 12px;
            border: 1px solid #333333;
            font-size: 10pt;
        }

        .summary-table .label {
            font-weight: bold;
            background: #f3f4f6;
            width: 35%;
        }

        .summary-table .val {
            font-weight: bold;
            color: #000000;
        }

        /* TABEL DATA */
        .section-title {
            font-size: 10.5pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 16px;
            margin-bottom: 6px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            font-size: 9.5pt;
        }

        .data-table th, .data-table td {
            border: 1px solid #333333;
            padding: 5px 8px;
        }

        .data-table th {
            background: #e5e7eb;
            font-weight: bold;
            text-align: center;
            font-size: 9pt;
            text-transform: uppercase;
        }

        /* TANDA TANGAN */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            page-break-inside: avoid;
        }

        .ttd-table td {
            vertical-align: top;
            width: 50%;
        }

        .ttd-box {
            text-align: center;
            font-size: 10pt;
        }

        .ttd-space {
            height: 70px;
        }

        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Floating Print Toolbar (Hidden on Print) -->
    <div class="print-toolbar">
        <div>
            <strong>Laporan Penjualan Triwulan {{ $triwulan == 'all' ? 'Tahunan' : $triwulan }} Tahun {{ $tahun }}</strong>
            <span style="opacity: 0.7; margin-left: 10px; font-size: 12px;">Kampung Suka Maju, Distrik Malind</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="button" class="btn-toolbar btn-print-now" onclick="window.print()">
                &#128438; Cetak Halaman
            </button>
            <a href="{{ route('pengurus_kampung.laporan.pdf', request()->query()) }}" class="btn-toolbar" style="background: #ef4444; color: #fff;">
                &#128196; Download PDF
            </a>
            <button type="button" class="btn-toolbar btn-close-window" onclick="window.close()">
                Tutup
            </button>
        </div>
    </div>

    <div class="page-content-wrap">
        <!-- KOP SURAT PEMERINTAHAN KAMPUNG -->
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ asset('images/sipeter_logo.png') }}" alt="Logo" style="height: 68px; width: auto; object-fit: contain;">
                </td>
                <td class="kop-text">
                    <h4>Pemerintah Kabupaten Merauke</h4>
                    <h3>Distrik Malind</h3>
                    <h2>Pemerintahan Kampung Suka Maju</h2>
                    <p>Alamat: Jl. Poros Utama Kampung Suka Maju, Distrik Malind, Kab. Merauke, Papua Selatan &bull; Kode Pos: 99651</p>
                </td>
            </tr>
        </table>

        <div class="garis-kop-tebal"></div>
        <div class="garis-kop-tipis"></div>

        <!-- JUDUL LAPORAN -->
        <div class="judul-box">
            <h2 class="judul-utama">Laporan Penjualan Ternak Sapi Per Triwulan</h2>
            <div class="subjudul">
                Periode: 
                @if($triwulan === 'all')
                    Semua Triwulan (Tahun Anggaran {{ $tahun }})
                @else
                    Triwulan {{ match((string)$triwulan) { '1' => 'I (Januari - Maret)', '2' => 'II (April - Juni)', '3' => 'III (Juli - September)', '4' => 'IV (Oktober - Desember)', default => (string)$triwulan } }} Tahun {{ $tahun }}
                @endif
            </div>
            <div style="font-size: 8.5pt; color: #555555; margin-top: 2px;">
                Dokumen Resmi Administrasi Usaha Peternakan Wilayah Kampung Suka Maju
            </div>
        </div>

        <!-- RINGKASAN EKSEKUTIF -->
        <table class="summary-table">
            <tr>
                <td class="label">Total Nilai Penjualan (Omset)</td>
                <td class="val" style="font-size: 11pt;">Rp {{ number_format($totalOmset, 0, ',', '.') }}</td>
                <td class="label">Total Sapi Terjual</td>
                <td class="val">{{ $totalSapiTerjual }} Ekor</td>
            </tr>
            <tr>
                <td class="label">Jumlah Transaksi Selesai</td>
                <td class="val">{{ $transaksiSelesai }} Transaksi</td>
                <td class="label">Rata-Rata Penjualan per Ekor</td>
                <td class="val">Rp {{ number_format($avgHarga, 0, ',', '.') }}</td>
            </tr>
        </table>

        <!-- REKAPITULASI 4 TRIWULAN (TAHUN BERJALAN) -->
        <div class="section-title">I. Rekapitulasi Penjualan Antar-Triwulan (Tahun {{ $tahun }})</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Periode Triwulan</th>
                    <th>Rentang Bulan</th>
                    <th style="text-align: center; width: 90px;">Jumlah Sapi</th>
                    <th style="text-align: center; width: 90px;">Transaksi</th>
                    <th style="text-align: right; width: 140px;">Total Omset (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quarterComparison as $qKey => $qData)
                    <tr style="{{ ($triwulan == $qKey) ? 'background-color: #f3f4f6; font-weight: bold;' : '' }}">
                        <td style="text-align: center;">{{ $qKey }}</td>
                        <td>{{ $qData['label'] }}</td>
                        <td>
                            @if($qKey == 1) Januari s/d Maret
                            @elseif($qKey == 2) April s/d Juni
                            @elseif($qKey == 3) Juli s/d September
                            @else Oktober s/d Desember @endif
                        </td>
                        <td style="text-align: center;">{{ $qData['total_sapi'] }} Ekor</td>
                        <td style="text-align: center;">{{ $qData['total_transaksi'] }}</td>
                        <td style="text-align: right;">Rp {{ number_format($qData['total_omset'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- REKAPITULASI PENJUALAN PER PETERNAK -->
        <div class="section-title">II. Rekapitulasi Penjualan Berdasarkan Peternak</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Nama Peternak</th>
                    <th style="width: 120px;">NIK</th>
                    <th>Alamat / Lokasi Kandang</th>
                    <th style="text-align: center; width: 90px;">Sapi Terjual</th>
                    <th style="text-align: right; width: 140px;">Total Nilai (Rp)</th>
                    <th style="text-align: center; width: 70px;">Porsi (%)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peternakBreakdown as $idx => $pb)
                    @php
                        $pct = $totalOmset > 0 ? round(($pb['total_omset'] / $totalOmset) * 100, 1) : 0;
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $idx + 1 }}</td>
                        <td><strong>{{ $pb['name'] }}</strong></td>
                        <td style="text-align: center; font-family: monospace;">{{ $pb['nik'] }}</td>
                        <td>{{ Str::limit($pb['alamat'], 45) }}</td>
                        <td style="text-align: center;">{{ $pb['jumlah_sapi'] }} Ekor</td>
                        <td style="text-align: right;">Rp {{ number_format($pb['total_omset'], 0, ',', '.') }}</td>
                        <td style="text-align: center;">{{ $pct }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; font-style: italic; color: #666;">
                            Tidak ada transaksi penjualan peternak pada triwulan ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- RINCIAN SELURUH TRANSAKSI -->
        <div class="section-title">III. Rincian Seluruh Transaksi Penjualan Ternak</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th style="width: 105px;">No. Transaksi</th>
                    <th style="width: 75px;">Tanggal</th>
                    <th>Peternak (Penjual)</th>
                    <th>Pembeli</th>
                    <th>Jenis Sapi & Bobot</th>
                    <th>Metode</th>
                    <th style="width: 80px;">Status</th>
                    <th style="text-align: right; width: 110px;">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $idx => $trx)
                    <tr>
                        <td style="text-align: center;">{{ $idx + 1 }}</td>
                        <td style="font-family: monospace; font-size: 8.5pt;">{{ $trx->kode_transaksi }}</td>
                        <td style="text-align: center;">{{ $trx->created_at->format('d/m/Y') }}</td>
                        <td>{{ $trx->sapi?->peternak?->name ?? '-' }}</td>
                        <td>{{ $trx->pembeli?->name ?? 'Pembeli' }}</td>
                        <td>
                            {{ $trx->sapi?->jenis ?? 'Sapi' }}
                            @if($trx->sapi)
                                ({{ $trx->sapi->bobot }} kg)
                            @endif
                        </td>
                        <td>{{ ucfirst($trx->metode_pembayaran) }}</td>
                        <td style="text-align: center; text-transform: capitalize;">{{ str_replace('_', ' ', $trx->status) }}</td>
                        <td style="text-align: right; font-weight: bold;">{{ $trx->total_harga_formatted }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; font-style: italic; color: #666;">
                            Tidak ada transaksi tercatat untuk periode laporan ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- TANDA TANGAN PENGURUS KAMPUNG -->
        <table class="ttd-table">
            <tr>
                <td style="width: 55%;"></td>
                <td style="width: 45%;">
                    <div class="ttd-box">
                        <div>Suka Maju, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</div>
                        <div style="font-weight: bold; margin-top: 4px;">Pemerintahan Kampung Suka Maju</div>
                        <div style="margin-bottom: 8px;">Aparat / Pengurus Kampung,</div>
                        <div class="ttd-space"></div>
                        <div class="ttd-name">{{ auth()->check() ? auth()->user()->name : 'Pak Hasan Pengurus' }}</div>
                        <div style="font-size: 9pt; color: #444444;">NIP/Jabatan: Pengurus Administrasi Wilayah</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
