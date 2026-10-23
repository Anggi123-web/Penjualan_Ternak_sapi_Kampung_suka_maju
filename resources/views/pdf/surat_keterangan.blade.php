<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Jalan Ternak - {{ $transaksi->nomor_surat ?? $transaksi->kode_transaksi }}</title>
    <style>
        /* ═══ KONFIGURASI KERTAS CETAK (PDF / PRINT) ═══ */
        @page {
            size: a4 portrait;
            margin: 1.8cm 2.2cm 1.8cm 2.2cm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000000;
            line-height: 1.35;
            font-size: 11pt;
            margin: 0;
            padding: 0;
        }

        /* ═══ TAMPILAN PREVIEW LAYAR BROWSER (A4 SHEET) ═══ */
        @media screen {
            body {
                background-color: #525659;
                padding: 30px 15px;
                display: flex;
                justify-content: center;
                align-items: flex-start;
                min-height: 100vh;
            }

            .paper-container {
                background: #ffffff;
                width: 210mm;
                min-height: 297mm;
                padding: 1.8cm 2.2cm 1.8cm 2.2cm;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
                margin: 0 auto;
            }
        }

        @media print {
            body {
                background: #ffffff;
                margin: 0;
                padding: 0;
            }

            .paper-container {
                width: 100%;
                min-height: auto;
                padding: 0;
                margin: 0;
                box-shadow: none;
                background: transparent;
            }
        }

        /* ═══ KOP SURAT PEMERINTAH ═══ */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo-col {
            width: 75px;
            text-align: left;
        }

        .kop-logo-img {
            width: 70px;
            height: auto;
            display: block;
        }

        .kop-text-col {
            text-align: center;
        }

        .kop-text-1 {
            font-size: 13.5pt;
            font-weight: bold;
            line-height: 1.25;
            letter-spacing: 0.5px;
        }

        .kop-text-2 {
            font-size: 12.5pt;
            font-weight: bold;
            line-height: 1.25;
            margin-top: 1px;
            letter-spacing: 0.5px;
        }

        .kop-text-3 {
            font-size: 13.5pt;
            font-weight: bold;
            line-height: 1.25;
            margin-top: 1px;
            letter-spacing: 0.5px;
        }

        .kop-spacer-col {
            width: 75px;
        }

        .garis-kop {
            border-top: 2.5px solid #000000;
            border-bottom: 1px solid #000000;
            height: 2px;
            margin-top: 6px;
            margin-bottom: 16px;
        }

        /* ═══ JUDUL & NOMOR SURAT ═══ */
        .judul-box {
            text-align: center;
            margin-bottom: 18px;
        }

        .judul-surat {
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .nomor-surat {
            font-size: 11pt;
            margin-top: 3px;
            letter-spacing: 0.5px;
        }

        /* ═══ TEKS PENGANTAR ═══ */
        .intro-text {
            font-size: 11pt;
            margin: 0 0 10px 0;
            line-height: 1.4;
        }

        .section-separator-text {
            font-size: 11pt;
            margin: 12px 0 8px 0;
            line-height: 1.4;
        }

        /* ═══ TABEL DATA BERKOLOM ═══ */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
            font-size: 11pt;
        }

        .data-table td {
            padding: 2.5px 0;
            vertical-align: top;
        }

        .col-label {
            width: 155px;
            color: #000000;
        }

        .col-colon {
            width: 18px;
            text-align: left;
        }

        .col-value {
            text-align: left;
            color: #000000;
        }

        /* ═══ TEKS PENUTUP ═══ */
        .closing-text {
            font-size: 11pt;
            margin-top: 16px;
            line-height: 1.45;
        }

        /* ═══ TANDA TANGAN KEPALA KAMPUNG ═══ */
        .ttd-container {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
        }

        .ttd-box {
            float: right;
            width: 270px;
            text-align: center;
            position: relative;
        }

        .ttd-date {
            font-size: 11pt;
            margin-bottom: 2px;
        }

        .ttd-role {
            font-size: 11pt;
            margin-bottom: 0;
        }

        .ttd-space {
            height: 100px;
            position: relative;
            margin: 2px auto;
        }

        .img-signature {
            position: absolute;
            bottom: 4px;
            right: 10px;
            height: 75px;
            width: auto;
            z-index: 1;
        }

        .img-stamp {
            position: absolute;
            bottom: -15px;
            left: -15px;
            width: 5cm;
            height: 5cm;
            z-index: 2;
            opacity: 0.92;
        }

        .ttd-name {
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="paper-container">

        @php
            // Logo Merauke (Base64 untuk kompatibilitas penuh DomPDF)
            $logoPath = public_path('images/logo_merauke.png');
            $logoBase64 = '';
            if (file_exists($logoPath)) {
                $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
            }

            // Tanda Tangan Pak Ahmad Hamdan
            $sigPath = public_path('images/ttd_ahmad_hamdan.png');
            $sigBase64 = '';
            if (file_exists($sigPath)) {
                $sigBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($sigPath));
            }

            // Cap Stempel Resmi Kampung Sukamaju
            $stampPath = public_path('images/cap_desa_sukamaju.png');
            $stampBase64 = '';
            if (file_exists($stampPath)) {
                $stampBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($stampPath));
            }

            // Format Tanggal Indonesia
            $bulanIndo = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $tglObj = $transaksi->surat_released_at ?? now();
            $tglStr = $tglObj->format('j') . ' ' . ($bulanIndo[(int)$tglObj->format('n')] ?? $tglObj->format('F')) . ' ' . $tglObj->format('Y');

            // Format Nomor Surat Resmi
            $bulanRomawi = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
            $romawiBulan = $bulanRomawi[(int)$tglObj->format('n')] ?? 'XI';
            $tahunSurat = $tglObj->format('Y');

            $nomorSurat = $transaksi->nomor_surat;
            if (!$nomorSurat) {
                $nomorSurat = '140 / ' . str_pad($transaksi->id, 3, '0', STR_PAD_LEFT) . ' / SKMJ / ' . $romawiBulan . ' / ' . $tahunSurat;
            }
            $nomorSuratClean = preg_replace('/^(nomor|no)\s*[:.]?\s*/i', '', trim($nomorSurat));

            // Format Data Penjual (Peternak)
            $namaPeternak = strtoupper($peternak->name ?? 'SUWARNO HADI PRANOTO');
            $jkPeternak = strtoupper($peternak->jenis_kelamin ?? 'LAKI - LAKI');
            $ttlPeternak = strtoupper($peternak->tempat_tanggal_lahir ?? ($peternak->ttl ?? 'BANYUWANGI, 20 – 12 - 1982'));
            $agamaPeternak = strtoupper($peternak->agama ?? 'ISLAM');
            $pekerjaanPeternak = strtoupper($peternak->pekerjaan ?? 'PETANI');
            $alamatPeternak = strtoupper($peternak->alamat ?? 'KAMPUNG SUKAMAJU, RT 001/RW 001');

            // Format Data Sapi
            $rawJenis = strtoupper($sapi->jenis ?? 'LEMOSIN');
            $jenisSapi = str_starts_with($rawJenis, 'SAPI') ? $rawJenis : 'SAPI ' . $rawJenis;

            $umurSapi = '1 TAHUN';
            if ($sapi && $sapi->umur) {
                if ($sapi->umur >= 12) {
                    $thn = floor($sapi->umur / 12);
                    $bln = $sapi->umur % 12;
                    $umurSapi = $thn . ' TAHUN' . ($bln > 0 ? ' ' . $bln . ' BULAN' : '');
                } else {
                    $umurSapi = $sapi->umur . ' BULAN';
                }
            }

            $jkSapi = strtoupper($sapi->jenis_kelamin ?? 'LAKI - LAKI');
            $warnaSapi = strtoupper($sapi->warna ?? 'HITAM');
            $tinggiSapi = strtoupper($sapi->tinggi ?? '140 CM');
            $tandukSapi = strtoupper($sapi->tanduk ?? '-');
            $ekorSapi = strtoupper($sapi->ekor ?? 'PANJANG');
            $ciriLainSapi = strtoupper($sapi->catatan_kesehatan ? substr($sapi->catatan_kesehatan, 0, 30) : ($sapi->ciri_lain ?? '-'));

            // Format Data Pembeli
            $namaPembeli = strtoupper($pembeli->name ?? 'BAPAK ADHE');
            $jkPembeli = strtoupper($pembeli->jenis_kelamin ?? 'LAKI - LAKI');
            $umurPembeli = $pembeli && !empty($pembeli->umur) ? strtoupper($pembeli->umur) . ' TAHUN' : '40 TAHUN';
            $pekerjaanPembeli = strtoupper($pembeli->pekerjaan ?? 'WIRASWASTA');
            $alamatPembeli = strtoupper($transaksi->detail_lokasi ?? ($pembeli->alamat ?? 'KAMPUNG SEMANGGA 40, DISTRIK SEMANGGA'));
            $tujuanPembeli = strtoupper($transaksi->tujuan ?? 'DIPIARA');
        @endphp

        {{-- ═══ KOP SURAT ═══ --}}
        <table class="kop-table">
            <tr>
                <td class="kop-logo-col">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" class="kop-logo-img" alt="Logo Merauke">
                    @endif
                </td>
                <td class="kop-text-col">
                    <div class="kop-text-1">PEMERINTAH KABUPATEN MERAUKE</div>
                    <div class="kop-text-2">DISTRIK MALIND</div>
                    <div class="kop-text-3">KAMPUNG SUKAMAJU</div>
                </td>
                <td class="kop-spacer-col"></td>
            </tr>
        </table>

        <div class="garis-kop"></div>

        {{-- ═══ JUDUL DAN NOMOR SURAT ═══ --}}
        <div class="judul-box">
            <h1 class="judul-surat">SURAT KETERANGAN JALAN TERNAK</h1>
            <div class="nomor-surat">NOMOR : {{ $nomorSuratClean }}</div>
        </div>

        {{-- ═══ KALIMAT PEMBUKA ═══ --}}
        <div class="intro-text">
            Yang bertanda tangan di bawah ini Kepala Kampung Sukamaju menerangkan bahwa :
        </div>

        {{-- ═══ IDENTITAS PEMILIK / PETERNAK ═══ --}}
        <table class="data-table">
            <tr>
                <td class="col-label">Nama lengkap</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $namaPeternak }}</td>
            </tr>
            <tr>
                <td class="col-label">Jenis kelamin</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $jkPeternak }}</td>
            </tr>
            <tr>
                <td class="col-label">Tempat Tgl lahir</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $ttlPeternak }}</td>
            </tr>
            <tr>
                <td class="col-label">A g a m a</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $agamaPeternak }}</td>
            </tr>
            <tr>
                <td class="col-label">Pekerjaan</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $pekerjaanPeternak }}</td>
            </tr>
            <tr>
                <td class="col-label">Alamat tinggal</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $alamatPeternak }}</td>
            </tr>
        </table>

        {{-- ═══ PERNYATAAN KEPEMILIKAN TERNAK ═══ --}}
        <div class="section-separator-text">
            Tersebut diatas mempunyai 1 Ekor Sapi dengan ciri-ciri Sbb :
        </div>

        {{-- ═══ CIRI-CIRI TERNAK SAPI ═══ --}}
        <table class="data-table">
            <tr>
                <td class="col-label">Jenis</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $jenisSapi }}</td>
            </tr>
            <tr>
                <td class="col-label">Umur</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $umurSapi }}</td>
            </tr>
            <tr>
                <td class="col-label">Jenis kelamin</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $jkSapi }}</td>
            </tr>
            <tr>
                <td class="col-label">Warna</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $warnaSapi }}</td>
            </tr>
            <tr>
                <td class="col-label">Tinggi</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $tinggiSapi }}</td>
            </tr>
            <tr>
                <td class="col-label">Tanduk</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $tandukSapi }}</td>
            </tr>
            <tr>
                <td class="col-label">Ekor</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $ekorSapi }}</td>
            </tr>
            <tr>
                <td class="col-label">Ciri –ciri lain</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $ciriLainSapi }}</td>
            </tr>
        </table>

        {{-- ═══ PERNYATAAN PENJUALAN KEPADA PEMBELI ═══ --}}
        <div class="section-separator-text">
            Ternak tersebut telah dijual kepada :
        </div>

        {{-- ═══ IDENTITAS PEMBELI ═══ --}}
        <table class="data-table">
            <tr>
                <td class="col-label">Nama</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $namaPembeli }}</td>
            </tr>
            <tr>
                <td class="col-label">Jenis kelamin</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $jkPembeli }}</td>
            </tr>
            <tr>
                <td class="col-label">U m u r</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $umurPembeli }}</td>
            </tr>
            <tr>
                <td class="col-label">Pekerjaan</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $pekerjaanPembeli }}</td>
            </tr>
            <tr>
                <td class="col-label">Alamat</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $alamatPembeli }}</td>
            </tr>
            <tr>
                <td class="col-label">Tujuan</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $tujuanPembeli }}</td>
            </tr>
        </table>

        {{-- ═══ KALIMAT PENUTUP ═══ --}}
        <div class="closing-text">
            Demikian surat keterangan Jalan Ternak ini kami buat dengan sebenarnya, agar dapat 
            dipergunakan sebagaimana mestinya.
        </div>

        {{-- ═══ TANDA TANGAN KEPALA KAMPUNG ═══ --}}
        <div class="ttd-container">
            <div class="ttd-box">
                <div class="ttd-date">Sukamaju, {{ $tglStr }}</div>
                <div class="ttd-role">Kepala Kampung Sukamaju</div>

                <div class="ttd-space">
                    {{-- 1. Tanda tangan terlebih dahulu (di bawah) --}}
                    @if($sigBase64)
                        <img src="{{ $sigBase64 }}" class="img-signature" alt="Tanda Tangan Kepala Kampung">
                    @endif

                    {{-- 2. Cap stempel resmi di atas tanda tangan --}}
                    @if($stampBase64)
                        <img src="{{ $stampBase64 }}" class="img-stamp" alt="Cap Stempel Kampung Sukamaju">
                    @endif
                </div>

                <div class="ttd-name">AHMAD HAMDAN</div>
            </div>
            <div style="clear: both;"></div>
        </div>

    </div>

</body>
</html>
