<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Sapi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    /**
     * Tampilkan halaman Detail Pembayaran untuk ternak sapi tertentu
     */
    public function show($sapi_id)
    {
        $sapi = Sapi::with('peternak')->findOrFail($sapi_id);

        if ($sapi->is_terjual) {
            return redirect()->route('katalog.index')
                ->with('error', 'Mohon maaf, ternak sapi ini sudah dibeli/dipesan dan tidak lagi tersedia di katalog.');
        }

        // Hitung DP jika tipe penjualan pre-order (25% dari harga atau Rp 5.000.000)
        $dp = $sapi->is_preorder ? max(1000000, round($sapi->harga * 0.25)) : 0;

        // Informasi rekening peternak (dengan fallback sesuai wireframe)
        $bankNama = $sapi->peternak->jenis_bank ?? 'BRI';
        $bankRekening = $sapi->peternak->nomor_rekening ?? '12345678910';

        // Koordinat lokasi sapi / peternakan
        $sapiLat = (float) ($sapi->latitude ?? ($sapi->peternak->latitude ?? -6.9175));
        $sapiLng = (float) ($sapi->longitude ?? ($sapi->peternak->longitude ?? 107.6191));
        $sapiLokasi = $sapi->lokasi ?? ($sapi->peternak->alamat ?? 'Dusun Suka Maju, Desa Suka Maju');

        // Pengaturan default Pre-Order (Estimasi penjemputan 7 hari, tarif perawatan dari peternak)
        $defaultTanggalAmbil = date('Y-m-d', strtotime('+7 days'));
        $minTanggalAmbil = date('Y-m-d', strtotime('+1 day'));
        $tarifPerawatanPerHari = $sapi->biaya_perawatan_harian ?: 25000;

        return view('frontend.pembayaran', compact(
            'sapi',
            'dp',
            'bankNama',
            'bankRekening',
            'sapiLat',
            'sapiLng',
            'sapiLokasi',
            'defaultTanggalAmbil',
            'minTanggalAmbil',
            'tarifPerawatanPerHari'
        ));
    }

    /**
     * Simpan transaksi pesanan baru
     */
    public function store(Request $request, $sapi_id)
    {
        $sapi = Sapi::findOrFail($sapi_id);

        if ($sapi->is_terjual) {
            return redirect()->route('katalog.index')
                ->with('error', 'Mohon maaf, ternak sapi ini sudah dibeli/dipesan oleh pembeli lain.');
        }

        $rules = [
            'pengantaran' => 'required|in:ya,tidak',
            'detail_lokasi' => 'nullable|string|max:1000|required_if:pengantaran,ya',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'jarak_km' => 'nullable|numeric',
            'metode_pembayaran' => 'required|in:transfer,cash',
            'catatan' => 'nullable|string|max:1000',
        ];

        if ($sapi->is_preorder) {
            $rules['tanggal_pengambilan'] = 'required|date|after_or_equal:today';
        }

        $request->validate($rules, [
            'detail_lokasi.required_if' => 'Detail lokasi pengantaran wajib diisi jika memilih pengantaran.',
            'tanggal_pengambilan.required' => 'Tanggal pengambilan atau pengantaran wajib diisi untuk ternak pre-order.',
            'tanggal_pengambilan.after_or_equal' => 'Tanggal pengambilan atau pengantaran tidak boleh sebelum hari ini.',
        ]);

        $isPengantaran = $request->pengantaran === 'ya';
        $jarakKm = $isPengantaran ? floatval($request->jarak_km ?? 0) : 0;

        // Perhitungan Tarif Pengantaran:
        // Tarif dasar (0-5 km): Rp 100.000
        // Tarif per km berikutnya (> 5 km): Rp 12.000 / km
        if ($isPengantaran) {
            if ($jarakKm <= 5) {
                $ongkir = 100000;
            } else {
                $jarakTambahan = max(0, $jarakKm - 5);
                $ongkir = 100000 + (int) round($jarakTambahan * 12000);
            }
        } else {
            $ongkir = 0;
        }

        // Perhitungan Biaya Perawatan Harian Pre-Order (Disesuaikan dengan tarif inputan peternak)
        $tanggalPengambilan = null;
        $durasiPerawatanHari = 0;
        $biayaPerawatan = 0;

        if ($sapi->is_preorder && $request->filled('tanggal_pengambilan')) {
            $tanggalPesan = \Carbon\Carbon::today();
            $tanggalAmbil = \Carbon\Carbon::parse($request->tanggal_pengambilan)->startOfDay();
            $durasiPerawatanHari = max(1, $tanggalPesan->diffInDays($tanggalAmbil));
            $tarifHarian = $sapi->biaya_perawatan_harian ?: 25000;
            $biayaPerawatan = $durasiPerawatanHari * $tarifHarian;
            $tanggalPengambilan = $request->tanggal_pengambilan;
        }

        $totalHarga = $sapi->harga + $ongkir + $biayaPerawatan;

        if ($sapi->is_preorder) {
            $dp = max(1000000, round($sapi->harga * 0.25));
            $dibayarkan = $dp;
            $sisaPembayaran = $totalHarga - $dibayarkan;
            $fasePembayaran = 'dp';
        } else {
            $dp = null;
            $dibayarkan = $totalHarga;
            $sisaPembayaran = 0;
            $fasePembayaran = 'lunas';
        }

        $kodeTransaksi = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $transaksi = Transaksi::create([
            'kode_transaksi' => $kodeTransaksi,
            'user_id' => Auth::id(),
            'sapi_id' => $sapi->id,
            'tipe_penjualan' => $sapi->tipe_penjualan,
            'harga_sapi' => $sapi->harga,
            'dp' => $dp,
            'fase_pembayaran' => $fasePembayaran,
            'is_pengantaran' => $isPengantaran,
            'tanggal_pengambilan' => $tanggalPengambilan,
            'durasi_perawatan_hari' => $durasiPerawatanHari,
            'biaya_perawatan' => $biayaPerawatan,
            'detail_lokasi' => $isPengantaran ? $request->detail_lokasi : null,
            'latitude' => $isPengantaran ? $request->latitude : null,
            'longitude' => $isPengantaran ? $request->longitude : null,
            'jarak_km' => $isPengantaran ? $jarakKm : null,
            'ongkir' => $ongkir,
            'total_harga' => $totalHarga,
            'dibayarkan' => $dibayarkan,
            'sisa_pembayaran' => $sisaPembayaran,
            'jumlah_pelunasan' => 0,
            'metode_pembayaran' => $request->metode_pembayaran,
            'catatan' => $request->catatan,
            'status' => $request->metode_pembayaran === 'transfer' ? 'menunggu_pembayaran' : 'diproses',
        ]);

        // Tandai ternak sapi sebagai telah terjual / dipesan
        $sapi->update(['status_penjualan' => 'terjual']);

        // Hapus dari semua keranjang pembeli agar tidak ada yang memesan ulang
        Keranjang::where('sapi_id', $sapi->id)->delete();

        if ($request->metode_pembayaran === 'transfer') {
            return redirect()->route('pembayaran.upload', $transaksi->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan transfer dan unggah bukti pembayaran.');
        }

        return redirect()->route('pembayaran.sukses', $transaksi->id)
            ->with('success', 'Pesanan metode Cash berhasil dikonfirmasi! Peternak akan memproses transaksi ini.');
    }

    /**
     * Halaman upload bukti pembayaran transfer
     */
    public function showUpload($transaksi_id)
    {
        $transaksi = Transaksi::with(['sapi.peternak', 'pembeli'])->findOrFail($transaksi_id);

        $bankNama = $transaksi->sapi->peternak->jenis_bank ?? 'BRI';
        $bankRekening = $transaksi->sapi->peternak->nomor_rekening ?? '12345678910';

        return view('frontend.pembayaran_upload', compact('transaksi', 'bankNama', 'bankRekening'));
    }

    /**
     * Proses unggah bukti pembayaran
     */
    public function processUpload(Request $request, $transaksi_id)
    {
        $transaksi = Transaksi::findOrFail($transaksi_id);

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ], [
            'bukti_pembayaran.required' => 'Silakan pilih file foto bukti transfer pembayaran.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 4MB.',
        ]);

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $transaksi->update([
            'bukti_pembayaran' => $path,
            'status' => 'menunggu_verifikasi',
        ]);

        return redirect()->route('pembayaran.sukses', $transaksi->id)
            ->with('success', 'Bukti pembayaran berhasil diunggah! Peternak akan memverifikasi pesanan Anda.');
    }

    /**
     * Halaman pembayaran pelunasan untuk transaksi Pre-Order (Tahap 2)
     */
    public function showPelunasan($transaksi_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk mengakses pelunasan.');
        }

        $transaksi = Transaksi::with(['sapi.peternak', 'pembeli'])->findOrFail($transaksi_id);

        if ($transaksi->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk transaksi ini.');
        }

        if (!$transaksi->is_preorder) {
            return redirect()->route('pesanan.index')->with('info', 'Transaksi ini bukan tipe pre-order.');
        }

        if ($transaksi->sisa_pembayaran <= 0 || $transaksi->fase_pembayaran === 'lunas') {
            return redirect()->route('pesanan.index')->with('info', 'Pesanan ini sudah lunas sepenuhnya.');
        }

        $bankNama = $transaksi->sapi->peternak->jenis_bank ?? 'BRI';
        $bankRekening = $transaksi->sapi->peternak->nomor_rekening ?? '12345678910';

        return view('frontend.pembayaran_pelunasan', compact('transaksi', 'bankNama', 'bankRekening'));
    }

    /**
     * Proses unggah bukti pembayaran pelunasan Pre-Order
     */
    public function processPelunasan(Request $request, $transaksi_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $transaksi = Transaksi::findOrFail($transaksi_id);

        if ($transaksi->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses.');
        }

        $request->validate([
            'bukti_pelunasan' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ], [
            'bukti_pelunasan.required' => 'Silakan pilih file foto bukti transfer pelunasan.',
            'bukti_pelunasan.image' => 'File harus berupa gambar.',
            'bukti_pelunasan.max' => 'Ukuran file maksimal 4MB.',
        ]);

        $path = $request->file('bukti_pelunasan')->store('bukti_pelunasan', 'public');

        $transaksi->update([
            'bukti_pelunasan' => $path,
            'catatan_status' => 'Bukti pembayaran pelunasan telah diunggah oleh pembeli dan sedang diverifikasi oleh peternak.',
            'status_updated_at' => now(),
        ]);

        return redirect()->route('pesanan.index')
            ->with('success', "Bukti pelunasan untuk pesanan {$transaksi->kode_transaksi} berhasil diunggah! Peternak akan segera memverifikasi pelunasan Anda.");
    }

    /**
     * Halaman nota / ringkasan transaksi sukses
     */
    public function sukses($transaksi_id)
    {
        $transaksi = Transaksi::with(['sapi.peternak', 'pembeli'])->findOrFail($transaksi_id);

        return view('frontend.pembayaran_sukses', compact('transaksi'));
    }
}
