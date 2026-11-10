<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Jual Beli Sapi - {{ $transaksi->nomor_surat ?? $transaksi->kode_transaksi }}</title>
    <style>
        /* ═══ KONFIGURASI HALAMAN CETAK (A4 - TEPAT 1 LEMBAR) ═══ */
        @page {
            size: a4 portrait;
            margin: 1.2cm 1.8cm 1.2cm 1.8cm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, Georgia, serif;
            color: #000000;
            background: #ffffff;
            line-height: 1.32;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }

        .paper-container {
            width: 100%;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* ═══ KOP SURAT RESMI PEMERINTAH KAMPUNG ═══ */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo-col {
            width: 72px;
            text-align: left;
        }

        .kop-logo-img {
            width: 64px;
            height: auto;
            display: block;
        }

        .kop-text-col {
            text-align: center;
        }

        .kop-instansi {
            font-size: 13pt;
            font-weight: bold;
            line-height: 1.2;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .kop-distrik {
            font-size: 12.5pt;
            font-weight: bold;
            line-height: 1.2;
            margin-top: 1px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .kop-desa {
            font-size: 14pt;
            font-weight: bold;
            line-height: 1.2;
            margin-top: 1px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .kop-alamat {
            font-size: 8.5pt;
            font-style: italic;
            line-height: 1.25;
            margin-top: 3px;
            color: #222222;
        }

        .kop-spacer-col {
            width: 72px;
        }

        /* Garis Ganda Kop Surat Resmi */
        .garis-kop {
            border-top: 2.5px solid #000000;
            border-bottom: 0.75px solid #000000;
            height: 2px;
            margin-top: 5px;
            margin-bottom: 12px;
        }

        /* ═══ JUDUL & NOMOR SURAT ═══ */
        .judul-box {
            text-align: center;
            margin-bottom: 10px;
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
            font-size: 10pt;
            margin-top: 2px;
            letter-spacing: 0.5px;
        }

        /* ═══ TEKS PENGANTAR & SUB-JUDUL ═══ */
        .intro-text {
            font-size: 10pt;
            margin: 0 0 7px 0;
            text-align: justify;
            line-height: 1.35;
        }

        .section-lead {
            font-size: 9.5pt;
            font-weight: bold;
            margin: 6px 0 3px 0;
            text-decoration: underline;
        }

        .transition-text {
            font-size: 9.5pt;
            margin: 6px 0 3px 0;
            line-height: 1.35;
        }

        /* ═══ TABEL DATA UTAMA ═══ */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            margin-bottom: 2px;
        }

        .data-table td {
            padding: 2.2px 0;
            vertical-align: top;
        }

        .col-label {
            width: 140px;
            color: #000000;
        }

        .col-colon {
            width: 14px;
            text-align: center;
        }

        .col-value {
            text-align: left;
            color: #000000;
        }

        /* ═══ TABEL 2 KOLOM CIRI-CIRI SAPI (KOMPAK & RAPI) ═══ */
        .cattles-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            margin: 2px 0;
        }

        .cattles-table td {
            padding: 2.2px 0;
            vertical-align: top;
        }

        .cattles-col-lbl-1 {
            width: 105px;
        }

        .cattles-col-colon-1 {
            width: 12px;
            text-align: center;
        }

        .cattles-col-val-1 {
            width: 165px;
            padding-right: 8px;
        }

        .cattles-col-lbl-2 {
            width: 120px;
        }

        .cattles-col-colon-2 {
            width: 12px;
            text-align: center;
        }

        .cattles-col-val-2 {
            /* Remaining width */
        }

        /* ═══ TEKS PENUTUP ═══ */
        .closing-text {
            font-size: 9.5pt;
            margin-top: 8px;
            margin-bottom: 12px;
            text-align: justify;
            line-height: 1.35;
        }

        /* ═══ BAGIAN TANDA TANGAN ═══ */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
            margin-top: 6px;
        }

        .ttd-col-left {
            width: 48%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-col-center {
            width: 4%;
        }

        .ttd-col-right {
            width: 48%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-date {
            font-size: 9.5pt;
            margin-bottom: 2px;
        }

        .ttd-role {
            font-size: 9.5pt;
            font-weight: bold;
            margin-bottom: 0;
        }

        .ttd-space-penjual {
            height: 82px;
        }

        .ttd-space-kepala {
            height: 82px;
            position: relative;
            margin: 0 auto;
            width: 220px;
        }

        .img-signature {
            position: absolute;
            bottom: 8px;
            left: 55px;
            height: 56px;
            width: auto;
            z-index: 1;
        }

        .img-stamp {
            position: absolute;
            bottom: -2px;
            left: 8px;
            width: 76px;
            height: 76px;
            z-index: 2;
            opacity: 0.90;
        }

        .ttd-name {
            font-size: 10pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .ttd-subname {
            font-size: 8.5pt;
            margin-top: 1px;
            color: #333333;
        }
    </style>
</head>
<body>

    <div class="paper-container">

        @php
            // Logo Merauke (Base64 untuk kompatibilitas DomPDF)
            $logoPath = public_path('images/logo_merauke.png');
            $logoBase64 = '';
            if (file_exists($logoPath)) {
                $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
            }

            // Tanda Tangan Kepala Kampung Pak Ahmad Hamdan
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
            $romawiBulan = $bulanRomawi[(int)$tglObj->format('n')] ?? 'X';
            $tahunSurat = $tglObj->format('Y');

            $nomorSurat = $transaksi->nomor_surat;
            if (!$nomorSurat) {
                $nomorSurat = '524.3 / ' . str_pad($transaksi->id, 3, '0', STR_PAD_LEFT) . ' / SK-JB / SKMJ / ' . $romawiBulan . ' / ' . $tahunSurat;
            }
            $nomorSuratClean = preg_replace('/^(nomor|no)\s*[:.]?\s*/i', '', trim($nomorSurat));

            // Format Data Penjual (Peternak)
            $namaPeternak = strtoupper($peternak->name ?? 'SUWARNO HADI PRANOTO');
            $nikPeternak = $peternak->nik ?? ($peternak->ktp ?? '9101041508820002');
            $jkPeternak = strtoupper($peternak->jenis_kelamin ?? 'LAKI-LAKI');
            $ttlPeternak = strtoupper($peternak->tempat_tanggal_lahir ?? ($peternak->ttl ?? 'MERAUKE, 20 DESEMBER 1982'));
            $agamaPeternak = strtoupper($peternak->agama ?? 'ISLAM');
            $pekerjaanPeternak = strtoupper($peternak->pekerjaan ?? 'PETERNAK SAPI');
            $alamatPeternak = strtoupper($peternak->alamat ?? 'KAMPUNG SUKAMAJU, RT 002/RW 001, DISTRIK MALIND');

            // Format Data Sapi
            $rawJenis = strtoupper($sapi->jenis ?? 'LIMOUSIN');
            $cleanJenis = preg_replace('/^SAPI\s+/i', '', trim($rawJenis));
            $cleanJenis = preg_replace('/\s+DIPESAN$/i', '', trim($cleanJenis));
            $cleanJenis = preg_replace('/\s+TERJUAL$/i', '', trim($cleanJenis));
            $jenisSapi = 'SAPI ' . $cleanJenis;

            $umurSapi = '2 TAHUN';
            if ($sapi && $sapi->umur) {
                if ($sapi->umur >= 12) {
                    $thn = floor($sapi->umur / 12);
                    $bln = $sapi->umur % 12;
                    $umurSapi = $thn . ' TAHUN' . ($bln > 0 ? ' ' . $bln . ' BULAN' : '');
                } else {
                    $umurSapi = $sapi->umur . ' BULAN';
                }
            }

            $jkSapi = strtoupper($sapi->jenis_kelamin ?? 'JANTAN');
            $warnaSapi = strtoupper($sapi->warna ?? 'COKLAT KEMERAHAN');
            $tinggiSapi = strtoupper($sapi->tinggi ? $sapi->tinggi . (str_ends_with(strtolower($sapi->tinggi), 'cm') ? '' : ' CM') : '± 140 CM');
            $beratSapi = strtoupper($sapi->berat ? $sapi->berat . (str_ends_with(strtolower($sapi->berat), 'kg') ? '' : ' KG') : '± 380 KG');
            $tandukSapi = strtoupper($sapi->tanduk ?? 'ADA (NORMAL)');
            $ekorSapi = strtoupper($sapi->ekor ?? 'PANJANG (NORMAL)');
            $ciriLainSapi = strtoupper($sapi->catatan_kesehatan ? substr($sapi->catatan_kesehatan, 0, 50) : ($sapi->ciri_lain ?? 'SEHAT, BEBAS PENYAKIT PMK'));

            // Format Data Pembeli
            $namaPembeli = strtoupper($pembeli->name ?? 'BAPAK ADHE');
            $nikPembeli = $pembeli->nik ?? ($pembeli->ktp ?? '9101021204850001');
            $jkPembeli = strtoupper($pembeli->jenis_kelamin ?? 'LAKI-LAKI');
            $umurPembeli = $pembeli && !empty($pembeli->umur) ? strtoupper($pembeli->umur) . ' TAHUN' : '40 TAHUN';
            $pekerjaanPembeli = strtoupper($pembeli->pekerjaan ?? 'WIRASWASTA');
            $alamatPembeli = strtoupper($transaksi->detail_lokasi ?? ($pembeli->alamat ?? 'KAMPUNG SEMANGGA, DISTRIK SEMANGGA, MERAUKE'));
            $tujuanPembeli = strtoupper($transaksi->tujuan ?? 'DIPELIHARA / BETERNAK');
            $hargaRp = 'RP ' . number_format($transaksi->total_harga ?? 0, 0, ',', '.');
        @endphp

        {{-- ═══ KOP SURAT PEMERINTAH KAMPUNG ═══ --}}
        <table class="kop-table">
            <tr>
                <td class="kop-logo-col">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" class="kop-logo-img" alt="Logo Kabupaten Merauke">
                    @endif
                </td>
                <td class="kop-text-col">
                    <div class="kop-instansi">PEMERINTAH KABUPATEN MERAUKE</div>
                    <div class="kop-distrik">DISTRIK MALIND</div>
                    <div class="kop-desa">KAMPUNG SUKAMAJU</div>
                    <div class="kop-alamat">Alamat: Jl. Poros Kampung Sukamaju, Distrik Malind, Kab. Merauke, Papua Selatan 99656</div>
                </td>
                <td class="kop-spacer-col"></td>
            </tr>
        </table>

        <div class="garis-kop"></div>

        {{-- ═══ JUDUL DAN NOMOR SURAT ═══ --}}
        <div class="judul-box">
            <h1 class="judul-surat">SURAT KETERANGAN JUAL BELI TERNAK SAPI</h1>
            <div class="nomor-surat">Nomor : {{ $nomorSuratClean }}</div>
        </div>

        {{-- ═══ KALIMAT PEMBUKA ═══ --}}
        <div class="intro-text">
            Yang bertanda tangan di bawah ini, Kepala Kampung Sukamaju, Distrik Malind, Kabupaten Merauke, Provinsi Papua Selatan, dengan ini menerangkan bahwa:
        </div>

        {{-- ═══ I. IDENTITAS PENJUAL (PIHAK I) ═══ --}}
        <div class="section-lead">I. PIHAK PENJUAL (PEMILIK TERNAK)</div>
        <table class="data-table">
            <tr>
                <td class="col-label">Nama Lengkap</td>
                <td class="col-colon">:</td>
                <td class="col-value"><strong>{{ $namaPeternak }}</strong></td>
            </tr>
            <tr>
                <td class="col-label">NIK / No. KTP</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $nikPeternak }}</td>
            </tr>
            <tr>
                <td class="col-label">Jenis Kelamin / Agama</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $jkPeternak }} / {{ $agamaPeternak }}</td>
            </tr>
            <tr>
                <td class="col-label">Tempat, Tanggal Lahir</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $ttlPeternak }}</td>
            </tr>
            <tr>
                <td class="col-label">Pekerjaan</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $pekerjaanPeternak }}</td>
            </tr>
            <tr>
                <td class="col-label">Alamat Domisili</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $alamatPeternak }}</td>
            </tr>
        </table>

        {{-- ═══ II. KETERANGAN CIRI-CIRI TERNAK SAPI ═══ --}}
        <div class="transition-text">
            Adalah benar-benar pemilik sah dari <strong>1 (satu) ekor ternak sapi</strong> dengan identitas dan ciri-ciri fisik sebagai berikut:
        </div>
        <div class="section-lead">II. IDENTITAS & CIRI-CIRI TERNAK SAPI</div>
        <table class="cattles-table">
            <tr>
                <td class="cattles-col-lbl-1">1. Jenis / Bangsa</td>
                <td class="cattles-col-colon-1">:</td>
                <td class="cattles-col-val-1"><strong>{{ $jenisSapi }}</strong></td>

                <td class="cattles-col-lbl-2">5. Warna Bulu</td>
                <td class="cattles-col-colon-2">:</td>
                <td class="cattles-col-val-2">{{ $warnaSapi }}</td>
            </tr>
            <tr>
                <td class="cattles-col-lbl-1">2. Jenis Kelamin</td>
                <td class="cattles-col-colon-1">:</td>
                <td class="cattles-col-val-1">{{ $jkSapi }}</td>

                <td class="cattles-col-lbl-2">6. Kondisi Tanduk</td>
                <td class="cattles-col-colon-2">:</td>
                <td class="cattles-col-val-2">{{ $tandukSapi }}</td>
            </tr>
            <tr>
                <td class="cattles-col-lbl-1">3. Perkiraan Umur</td>
                <td class="cattles-col-colon-1">:</td>
                <td class="cattles-col-val-1">{{ $umurSapi }}</td>

                <td class="cattles-col-lbl-2">7. Kondisi Ekor</td>
                <td class="cattles-col-colon-2">:</td>
                <td class="cattles-col-val-2">{{ $ekorSapi }}</td>
            </tr>
            <tr>
                <td class="cattles-col-lbl-1">4. Tinggi / Bobot</td>
                <td class="cattles-col-colon-1">:</td>
                <td class="cattles-col-val-1">{{ $tinggiSapi }} / {{ $beratSapi }}</td>

                <td class="cattles-col-lbl-2">8. Kondisi Kesehatan</td>
                <td class="cattles-col-colon-2">:</td>
                <td class="cattles-col-val-2">{{ $ciriLainSapi }}</td>
            </tr>
        </table>

        {{-- ═══ III. IDENTITAS PEMBELI (PIHAK II) ═══ --}}
        <div class="transition-text">
            Ternak sapi tersebut di atas telah secara sah <strong>DIJUAL / DIPINDAHTANGANKAN</strong> hak kepemilikannya kepada:
        </div>
        <div class="section-lead">III. PIHAK PEMBELI</div>
        <table class="data-table">
            <tr>
                <td class="col-label">Nama Lengkap</td>
                <td class="col-colon">:</td>
                <td class="col-value"><strong>{{ $namaPembeli }}</strong></td>
            </tr>
            <tr>
                <td class="col-label">NIK / No. KTP</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $nikPembeli }}</td>
            </tr>
            <tr>
                <td class="col-label">Jenis Kelamin / Umur</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $jkPembeli }} / {{ $umurPembeli }}</td>
            </tr>
            <tr>
                <td class="col-label">Pekerjaan</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $pekerjaanPembeli }}</td>
            </tr>
            <tr>
                <td class="col-label">Alamat Tujuan Ternak</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $alamatPembeli }}</td>
            </tr>
            <tr>
                <td class="col-label">Tujuan Pembelian</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $tujuanPembeli }}</td>
            </tr>
            <tr>
                <td class="col-label">Nilai Transaksi Jual Beli</td>
                <td class="col-colon">:</td>
                <td class="col-value"><strong>{{ $hargaRp }}</strong> (Lunas &mdash; Kode Trx: {{ $transaksi->kode_transaksi }})</td>
            </tr>
        </table>

        {{-- ═══ KALIMAT PENUTUP ═══ --}}
        <div class="closing-text">
            Demikian Surat Keterangan Jual Beli Ternak Sapi ini kami buat dan terbitkan dengan sebenarnya agar dapat dipergunakan sebagai bukti sah kepemilikan dan kelengkapan administrasi lalu lintas pengangkutan ternak jalan sebagaimana mestinya.
        </div>

        {{-- ═══ BAGIAN TANDA TANGAN (KIRI: PENJUAL, KANAN: KEPALA KAMPUNG) ═══ --}}
        <table class="ttd-table">
            <tr>
                <td class="ttd-col-left">
                    <div class="ttd-date">&nbsp;</div>
                    <div class="ttd-role">Pihak Penjual / Pemilik Ternak,</div>
                    <div class="ttd-space-penjual"></div>
                    <div class="ttd-name">{{ $namaPeternak }}</div>
                    <div class="ttd-subname">Warga Peternak Kampung Sukamaju</div>
                </td>
                <td class="ttd-col-center"></td>
                <td class="ttd-col-right">
                    <div class="ttd-date">Sukamaju, {{ $tglStr }}</div>
                    <div class="ttd-role">Kepala Kampung Sukamaju,</div>
                    <div class="ttd-space-kepala">
                        {{-- Tanda tangan digital --}}
                        @if($sigBase64)
                            <img src="{{ $sigBase64 }}" class="img-signature" alt="Tanda Tangan Kepala Kampung">
                        @endif

                        {{-- Cap stempel resmi --}}
                        @if($stampBase64)
                            <img src="{{ $stampBase64 }}" class="img-stamp" alt="Cap Stempel Resmi">
                        @endif
                    </div>
                    <div class="ttd-name">AHMAD HAMDAN</div>
                    <div class="ttd-subname">Kepala Pemerintahan Kampung</div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
