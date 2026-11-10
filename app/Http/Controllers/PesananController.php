<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    /**
     * Tampilkan halaman monitoring pemesanan bagi pembeli
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk memantau status pemesanan sapi Anda.');
        }

        $userId = Auth::id();

        // Hitung total ringkasan pesanan
        $counts = [
            'semua' => Transaksi::where('user_id', $userId)->count(),
            'menunggu' => Transaksi::where('user_id', $userId)->whereIn('status', ['menunggu_pembayaran', 'menunggu_verifikasi'])->count(),
            'diproses' => Transaksi::where('user_id', $userId)->where('status', 'diproses')->count(),
            'dikirim' => Transaksi::where('user_id', $userId)->where('status', 'dikirim')->count(),
            'selesai' => Transaksi::where('user_id', $userId)->where('status', 'selesai')->count(),
            'dibatalkan' => Transaksi::where('user_id', $userId)->where('status', 'dibatalkan')->count(),
        ];

        // Filter tab
        $tab = $request->query('tab', 'semua');
        $query = Transaksi::with(['sapi.peternak', 'aparat', 'ulasan'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc');

        if ($tab === 'menunggu') {
            $query->whereIn('status', ['menunggu_pembayaran', 'menunggu_verifikasi']);
        } elseif ($tab === 'diproses') {
            $query->where('status', 'diproses');
        } elseif ($tab === 'dikirim') {
            $query->where('status', 'dikirim');
        } elseif ($tab === 'selesai') {
            $query->where('status', 'selesai');
        } elseif ($tab === 'dibatalkan') {
            $query->where('status', 'dibatalkan');
        }

        $orders = $query->paginate(10)->withQueryString();

        // Ambil ID pesanan yang berstatus update baru sebelum ditandai terbaca
        $unreadOrderIds = Transaksi::where('user_id', $userId)
            ->where(function ($q) {
                $q->whereNull('pembeli_read_at')
                  ->orWhereColumn('status_updated_at', '>', 'pembeli_read_at');
            })
            ->pluck('id')
            ->toArray();

        // Tandai semua pesanan pembeli sebagai telah dibaca
        if (!empty($unreadOrderIds)) {
            Transaksi::where('user_id', $userId)
                ->whereIn('id', $unreadOrderIds)
                ->update(['pembeli_read_at' => now()]);
        }

        return view('frontend.pesanan', compact('orders', 'tab', 'counts', 'unreadOrderIds'));
    }

    /**
     * Pembeli mengonfirmasi bahwa hewan ternak telah diterima dengan baik & memberikan ulasan peternak
     */
    public function konfirmasiSelesai(Request $request, $id)
    {
        $transaksi = Transaksi::with('sapi')->where('user_id', Auth::id())->findOrFail($id);

        if ($transaksi->status !== 'dikirim') {
            return back()->with('error', 'Pesanan hanya dapat diselesaikan jika sudah berstatus dikirim atau siap diambil.');
        }

        // Validasi ulasan jika pembeli menyertakan rating
        if ($request->filled('rating') || $request->has('komentar')) {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'komentar' => 'required|string|min:4|max:1000',
                'kategori' => 'nullable|array',
                'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            ], [
                'rating.required' => 'Silakan tentukan rating bintang 1 - 5 untuk peternak.',
                'komentar.required' => 'Silakan tulis ulasan atau komentar Anda mengenai pelayanan peternak.',
                'komentar.min' => 'Ulasan minimal terdiri dari 4 karakter.',
            ]);
        }

        $transaksi->update([
            'status' => 'selesai',
            'status_updated_at' => now(),
            'pembeli_read_at' => now(),
            'catatan_status' => 'Ternak sapi telah sampai di lokasi dan dikonfirmasi selesai oleh pembeli.',
        ]);

        // Simpan ulasan jika diisi
        if ($request->filled('rating')) {
            $peternakId = $transaksi->sapi ? $transaksi->sapi->user_id : null;
            if ($peternakId) {
                $fotoPath = null;
                if ($request->hasFile('foto')) {
                    $fotoPath = $request->file('foto')->store('ulasan', 'public');
                }

                Ulasan::updateOrCreate(
                    ['transaksi_id' => $transaksi->id],
                    [
                        'pembeli_id' => Auth::id(),
                        'peternak_id' => $peternakId,
                        'sapi_id' => $transaksi->sapi_id,
                        'rating' => $request->rating,
                        'komentar' => $request->komentar,
                        'kategori' => $request->input('kategori', []),
                        'foto' => $fotoPath,
                    ]
                );

                return back()->with('success', "Pesanan {$transaksi->kode_transaksi} berhasil diselesaikan dan ulasan Anda untuk peternak telah dikirim!");
            }
        }

        return back()->with('success', "Pesanan {$transaksi->kode_transaksi} berhasil diselesaikan. Terima kasih atas kepercayaan Anda!");
    }

    /**
     * Pembeli memberikan atau memperbarui ulasan untuk pesanan yang telah selesai
     */
    public function simpanUlasan(Request $request, $id)
    {
        $transaksi = Transaksi::with('sapi')->where('user_id', Auth::id())->findOrFail($id);

        if ($transaksi->status !== 'selesai') {
            return back()->with('error', 'Ulasan hanya dapat diberikan setelah pesanan berstatus selesai.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:4|max:1000',
            'kategori' => 'nullable|array',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'rating.required' => 'Silakan tentukan rating bintang 1 - 5 untuk peternak.',
            'komentar.required' => 'Silakan tulis ulasan atau komentar Anda mengenai pelayanan peternak.',
            'komentar.min' => 'Ulasan minimal terdiri dari 4 karakter.',
        ]);

        $peternakId = $transaksi->sapi ? $transaksi->sapi->user_id : null;
        if (!$peternakId) {
            return back()->with('error', 'Data peternak untuk transaksi ini tidak ditemukan.');
        }

        $existing = Ulasan::where('transaksi_id', $transaksi->id)->first();
        $fotoPath = $existing ? $existing->foto : null;

        if ($request->hasFile('foto')) {
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('ulasan', 'public');
        }

        Ulasan::updateOrCreate(
            ['transaksi_id' => $transaksi->id],
            [
                'pembeli_id' => Auth::id(),
                'peternak_id' => $peternakId,
                'sapi_id' => $transaksi->sapi_id,
                'rating' => $request->rating,
                'komentar' => $request->komentar,
                'kategori' => $request->input('kategori', []),
                'foto' => $fotoPath,
            ]
        );

        return back()->with('success', 'Ulasan Anda untuk peternak berhasil disimpan!');
    }

    /**
     * Tampilkan atau unduh Dokumen PDF Resmi Surat Keterangan Pembelian Sapi
     */
    public function downloadSuratPdf($id)
    {
        if (!Auth::check()) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        $transaksi = Transaksi::with(['sapi.peternak', 'pembeli', 'aparat'])->findOrFail($id);
        $user = Auth::user();

        // Hak akses: pembeli, peternak pemilik ternak sapi, aparat kampung, atau admin
        $isBuyer = $transaksi->user_id === $user->id;
        $isSeller = $transaksi->sapi && $transaksi->sapi->user_id === $user->id;
        $isAparat = in_array($user->role, ['pengurus_kampung', 'admin']);

        if (!$isBuyer && !$isSeller && !$isAparat) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat dokumen Surat Keterangan pada transaksi ini.');
        }

        if (!$transaksi->surat_released_at && !$transaksi->nomor_surat) {
            return back()->with('error', 'Surat Keterangan Jalan Ternak belum dirilis oleh pihak Aparat Kampung.');
        }

        $sapi = $transaksi->sapi;
        $peternak = $sapi ? $sapi->peternak : null;
        $pembeli = $transaksi->pembeli;
        $aparat = $transaksi->aparat;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat_keterangan', compact('transaksi', 'sapi', 'peternak', 'pembeli', 'aparat'))
            ->setPaper('a4', 'portrait');

        $cleanNomor = preg_replace('/[^A-Za-z0-9_\-]/', '_', $transaksi->nomor_surat ?: $transaksi->kode_transaksi);
        $filename = 'Surat_Keterangan_Jual_Beli_Sapi_' . $cleanNomor . '.pdf';

        if (request()->query('download')) {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }
}

