<?php

namespace Database\Seeders;

use App\Models\Sapi;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ─── 1. Akun untuk Masing-Masing Role ───────────────────────────
        $peternak = User::updateOrCreate(
            ['email' => 'peternak@gmail.com'],
            [
                'name' => 'Pak Budi Peternak',
                'password' => bcrypt('password123'),
                'role' => 'peternak',
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Kandang Sukamaju No. 12, RT 02/RW 01, Kampung Sukamaju, Merauke',
                'latitude' => -8.4991,
                'longitude' => 140.4011,
                'nomor_rekening' => '342501002345532',
                'jenis_bank' => 'BRI',
            ]
        );

        $pembeli = User::updateOrCreate(
            ['email' => 'pembeli@gmail.com'],
            [
                'name' => 'Pak Ahmad Pembeli',
                'password' => bcrypt('password123'),
                'role' => 'pembeli',
                'no_telepon' => '081987654321',
                'alamat' => 'Jl. Trans Papua No. 45, Rimba Jaya, Merauke',
                'latitude' => -8.5120,
                'longitude' => 140.4150,
            ]
        );

        $mantri = User::updateOrCreate(
            ['email' => 'mantri@gmail.com'],
            [
                'name' => 'Drh. Siti Mantri',
                'password' => bcrypt('password123'),
                'role' => 'mantri_hewan',
                'no_telepon' => '081345678901',
                'alamat' => 'Puskeswan Sukamaju, Merauke',
            ]
        );

        $pengurus = User::updateOrCreate(
            ['email' => 'pengurus@gmail.com'],
            [
                'name' => 'Pak Hasan Pengurus',
                'password' => bcrypt('password123'),
                'role' => 'pengurus_kampung',
                'no_telepon' => '081456789012',
                'alamat' => 'Kantor Balai Desa Kampung Sukamaju, Merauke',
            ]
        );

        // ─── 2. Katalog Sapi Order (Pesan Biasa / Ready) - 3 Ekor ───────
        $katalogOrder = [
            [
                'user_id' => $peternak->id,
                'jenis' => 'Sapi Limosin Super Jantan',
                'umur' => 32, // 2 tahun 8 bulan
                'bobot' => 680.00,
                'harga' => 27500000,
                'tipe_penjualan' => 'order',
                'status_penjualan' => 'tersedia',
                'foto' => ['sapi/foto/limosin_super.jpg'],
                'latitude' => -8.4991,
                'longitude' => 140.4011,
                'lokasi' => 'Kandang A1, Kampung Sukamaju',
                'catatan_kesehatan' => 'Sapi dalam kondisi sangat prima, nafsu makan tinggi, bebas PMK, telah divaksin lengkap oleh Mantri Hewan.',
                'status_kesehatan' => 'sehat',
                'is_active' => true,
                'verified_by' => $mantri->id,
                'verified_at' => Carbon::now()->subDays(2),
            ],
            [
                'user_id' => $peternak->id,
                'jenis' => 'Sapi Simental Bobot Jumbo',
                'umur' => 36, // 3 tahun
                'bobot' => 750.00,
                'harga' => 32000000,
                'tipe_penjualan' => 'order',
                'status_penjualan' => 'tersedia',
                'foto' => ['sapi/foto/simental_jumbo.jpg'],
                'latitude' => -8.4991,
                'longitude' => 140.4011,
                'lokasi' => 'Kandang A2, Kampung Sukamaju',
                'catatan_kesehatan' => 'Struktur tulang kokoh, bobot padat berotot, rutin konsentrat & vitamin berkala.',
                'status_kesehatan' => 'sehat',
                'is_active' => true,
                'verified_by' => $mantri->id,
                'verified_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => $peternak->id,
                'jenis' => 'Sapi Bali Murni Siap Kirim',
                'umur' => 26, // 2 tahun 2 bulan
                'bobot' => 430.00,
                'harga' => 18000000,
                'tipe_penjualan' => 'order',
                'status_penjualan' => 'tersedia',
                'foto' => ['sapi/foto/bali_asli.jpg'],
                'latitude' => -8.4991,
                'longitude' => 140.4011,
                'lokasi' => 'Kandang B1, Kampung Sukamaju',
                'catatan_kesehatan' => 'Daya tahan tubuh tinggi, pakan hijauan segar melimpah, kondisi fisik prima bebas parasit.',
                'status_kesehatan' => 'sehat',
                'is_active' => true,
                'verified_by' => $mantri->id,
                'verified_at' => Carbon::now()->subDays(1),
            ],
        ];

        foreach ($katalogOrder as $item) {
            Sapi::updateOrCreate(
                ['jenis' => $item['jenis'], 'user_id' => $item['user_id']],
                $item
            );
        }

        // ─── 3. Katalog Sapi Pre-Order - 3 Ekor ─────────────────────────
        $katalogPreorder = [
            [
                'user_id' => $peternak->id,
                'jenis' => 'Sapi Brahman Cross Super (Pre-Order)',
                'umur' => 28,
                'bobot' => 590.00,
                'harga' => 24500000,
                'tipe_penjualan' => 'pre_order',
                'preorder_bulan' => 6,
                'preorder_tahun' => 2026,
                'biaya_perawatan_harian' => 25000,
                'status_penjualan' => 'tersedia',
                'foto' => ['sapi/foto/brahman_unggul.jpg'],
                'latitude' => -8.4991,
                'longitude' => 140.4011,
                'lokasi' => 'Kandang C1, Kampung Sukamaju',
                'catatan_kesehatan' => 'Sangat ideal untuk Qurban bulan Juni 2026, kerangka besar dan punuk tegap.',
                'status_kesehatan' => 'sehat',
                'is_active' => true,
                'verified_by' => $mantri->id,
                'verified_at' => Carbon::now()->subDays(2),
            ],
            [
                'user_id' => $peternak->id,
                'jenis' => 'Sapi Pegon Istimewa Idul Adha (Pre-Order)',
                'umur' => 30,
                'bobot' => 620.00,
                'harga' => 26000000,
                'tipe_penjualan' => 'pre_order',
                'preorder_bulan' => 6,
                'preorder_tahun' => 2026,
                'biaya_perawatan_harian' => 30000,
                'status_penjualan' => 'tersedia',
                'foto' => ['sapi/foto/pegon_spesial.jpg'],
                'latitude' => -8.4991,
                'longitude' => 140.4011,
                'lokasi' => 'Kandang C2, Kampung Sukamaju',
                'catatan_kesehatan' => 'Persilangan unggul lokal dan simental, nafsu makan lahap, siap dirawat hingga jadwal hari raya.',
                'status_kesehatan' => 'sehat',
                'is_active' => true,
                'verified_by' => $mantri->id,
                'verified_at' => Carbon::now()->subDays(4),
            ],
            [
                'user_id' => $peternak->id,
                'jenis' => 'Sapi Ongole Berkah Penggemukan (Pre-Order)',
                'umur' => 24,
                'bobot' => 530.00,
                'harga' => 21500000,
                'tipe_penjualan' => 'pre_order',
                'preorder_bulan' => 7,
                'preorder_tahun' => 2026,
                'biaya_perawatan_harian' => 25000,
                'status_penjualan' => 'tersedia',
                'foto' => ['sapi/foto/ongole_berkah.jpg'],
                'latitude' => -8.4991,
                'longitude' => 140.4011,
                'lokasi' => 'Kandang C3, Kampung Sukamaju',
                'catatan_kesehatan' => 'Dada bidang proporsional, prospek kenaikan bobot mencapai 0.8 kg per hari dalam program perawatan.',
                'status_kesehatan' => 'sehat',
                'is_active' => true,
                'verified_by' => $mantri->id,
                'verified_at' => Carbon::now()->subDays(3),
            ],
        ];

        foreach ($katalogPreorder as $item) {
            Sapi::updateOrCreate(
                ['jenis' => $item['jenis'], 'user_id' => $item['user_id']],
                $item
            );
        }

        // ─── 4. Pembelian Oleh Pembeli (Agar Tampil di Monitoring) ──────
        // Transaksi 1: Order Langsung (Status: Dikirim, Pengantaran)
        $sapiOrderDibeli = Sapi::updateOrCreate(
            ['jenis' => 'Sapi Madura Super Dipesan', 'user_id' => $peternak->id],
            [
                'umur' => 28,
                'bobot' => 510.00,
                'harga' => 22000000,
                'tipe_penjualan' => 'order',
                'status_penjualan' => 'terjual',
                'foto' => ['sapi/foto/limosin_super.jpg'],
                'latitude' => -8.4991,
                'longitude' => 140.4011,
                'lokasi' => 'Kandang Utama, Kampung Sukamaju',
                'catatan_kesehatan' => 'Kesehatan layak potong dan lolos uji klinis.',
                'status_kesehatan' => 'sehat',
                'is_active' => true,
                'verified_by' => $mantri->id,
                'verified_at' => Carbon::now()->subDays(5),
            ]
        );

        Transaksi::updateOrCreate(
            ['kode_transaksi' => 'TRX-20261023-ORD01'],
            [
                'user_id' => $pembeli->id,
                'sapi_id' => $sapiOrderDibeli->id,
                'tipe_penjualan' => 'order',
                'harga_sapi' => 22000000,
                'dp' => null,
                'is_pengantaran' => true,
                'detail_lokasi' => 'Jl. Trans Papua No. 45, RT 01/RW 03, Rimba Jaya, Merauke',
                'latitude' => -8.5120,
                'longitude' => 140.4150,
                'jarak_km' => 8.5,
                'ongkir' => 142000,
                'total_harga' => 22142000,
                'dibayarkan' => 22142000,
                'sisa_pembayaran' => 0,
                'metode_pembayaran' => 'transfer',
                'catatan' => 'Mohon diantar pagi hari sebelum jam 10 pagi, terima kasih.',
                'bukti_pembayaran' => 'bukti_pembayaran/sample_bukti.png',
                'status' => 'dikirim',
                'status_updated_at' => Carbon::now()->subHours(2),
                'catatan_status' => 'Sapi telah dimuat ke armada pikap dan sedang dalam perjalanan pengantaran menuju lokasi Anda.',
                'surat_keterangan' => 'surat_keterangan/surat_jalan_desa.pdf',
                'nomor_surat' => 'SKT/SKM/2026/10/018',
                'surat_released_at' => Carbon::now()->subHours(4),
                'surat_aparat_id' => $pengurus->id,
            ]
        );

        // Transaksi 2: Pre-Order (Status: Diproses, DP Terbayar & Perawatan)
        $sapiPreorderDibeli = Sapi::updateOrCreate(
            ['jenis' => 'Sapi Simental Pre-Order Qurban Dipesan', 'user_id' => $peternak->id],
            [
                'umur' => 24,
                'bobot' => 540.00,
                'harga' => 28000000,
                'tipe_penjualan' => 'pre_order',
                'preorder_bulan' => 6,
                'preorder_tahun' => 2026,
                'biaya_perawatan_harian' => 25000,
                'status_penjualan' => 'terjual',
                'foto' => ['sapi/foto/simental_jumbo.jpg'],
                'latitude' => -8.4991,
                'longitude' => 140.4011,
                'lokasi' => 'Kandang Karantina Pre-Order, Kampung Sukamaju',
                'catatan_kesehatan' => 'Sehat prima, bobot tumbuh stabil dalam pantauan Mantri.',
                'status_kesehatan' => 'sehat',
                'is_active' => true,
                'verified_by' => $mantri->id,
                'verified_at' => Carbon::now()->subDays(6),
            ]
        );

        Transaksi::updateOrCreate(
            ['kode_transaksi' => 'TRX-20261023-PRE02'],
            [
                'user_id' => $pembeli->id,
                'sapi_id' => $sapiPreorderDibeli->id,
                'tipe_penjualan' => 'pre_order',
                'harga_sapi' => 28000000,
                'dp' => 7000000, // 25% dari 28.000.000
                'is_pengantaran' => false,
                'tanggal_pengambilan' => '2026-06-15',
                'durasi_perawatan_hari' => 235,
                'biaya_perawatan' => 5875000,
                'detail_lokasi' => null,
                'latitude' => null,
                'longitude' => null,
                'jarak_km' => null,
                'ongkir' => 0,
                'total_harga' => 33875000,
                'dibayarkan' => 7000000,
                'sisa_pembayaran' => 26875000,
                'metode_pembayaran' => 'transfer',
                'catatan' => 'Pre-order untuk ibadah Qurban Idul Adha 2026, pengambilan langsung di kandang.',
                'bukti_pembayaran' => 'bukti_pembayaran/sample_bukti.png',
                'status' => 'diproses',
                'status_updated_at' => Carbon::now()->subHours(6),
                'catatan_status' => 'Uang Muka (DP) Rp 7.000.000 telah diverifikasi. Sapi resmi masuk program perawatan intensif.',
            ]
        );
    }
}
