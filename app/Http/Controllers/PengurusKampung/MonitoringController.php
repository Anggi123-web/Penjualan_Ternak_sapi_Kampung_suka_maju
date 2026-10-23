<?php

namespace App\Http\Controllers\PengurusKampung;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    /**
     * Tampilkan halaman monitoring pesanan & surat keterangan untuk Aparat Kampung
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'semua');

        $counts = [
            'semua' => Transaksi::count(),
            'perlu_surat' => Transaksi::whereIn('status', ['diproses', 'dikirim'])
                ->whereNull('surat_released_at')
                ->count(),
            'surat_rilis' => Transaksi::whereNotNull('surat_released_at')->count(),
            'menunggu_verifikasi' => Transaksi::where('status', 'menunggu_verifikasi')->count(),
            'selesai' => Transaksi::where('status', 'selesai')->count(),
        ];

        $query = Transaksi::with(['sapi.peternak', 'pembeli', 'aparat'])
            ->orderBy('created_at', 'desc');

        if ($tab === 'perlu_surat') {
            $query->whereIn('status', ['diproses', 'dikirim'])->whereNull('surat_released_at');
        } elseif ($tab === 'surat_rilis') {
            $query->whereNotNull('surat_released_at');
        } elseif ($tab === 'menunggu_verifikasi') {
            $query->where('status', 'menunggu_verifikasi');
        } elseif ($tab === 'selesai') {
            $query->where('status', 'selesai');
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('pengurus_kampung.monitoring', compact('orders', 'tab', 'counts'));
    }

    /**
     * Upload & Rilis Surat Keterangan Pembelian Sapi oleh Aparat Kampung
     */
    public function uploadSurat(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'surat_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'catatan_aparat' => 'nullable|string|max:500',
        ], [
            'nomor_surat.required' => 'Nomor Surat Keterangan wajib diisi.',
            'surat_file.mimes' => 'Berkas surat harus berformat PDF, JPG, JPEG, PNG, atau WEBP.',
            'surat_file.max' => 'Ukuran berkas surat maksimal 5MB.',
        ]);

        $path = $transaksi->surat_keterangan;
        if ($request->hasFile('surat_file')) {
            // Hapus file lama jika ada
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('surat_file')->store('surat_keterangan', 'public');
        } else {
            // Jika aparat tidak mengunggah berkas scan fisik, sistem otomatis meng-generate Dokumen PDF Resmi
            $transaksi->loadMissing(['sapi.peternak', 'pembeli']);
            $transaksi->nomor_surat = $request->nomor_surat;
            $transaksi->surat_released_at = now();
            $transaksi->surat_aparat_id = Auth::id();

            $sapi = $transaksi->sapi;
            $peternak = $sapi ? $sapi->peternak : null;
            $pembeli = $transaksi->pembeli;
            $aparat = Auth::user();

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat_keterangan', compact('transaksi', 'sapi', 'peternak', 'pembeli', 'aparat'))
                ->setPaper('a4', 'portrait');

            $cleanKode = preg_replace('/[^A-Za-z0-9_\-]/', '_', $transaksi->kode_transaksi);
            $fileName = 'surat_keterangan/surat_' . $cleanKode . '.pdf';
            Storage::disk('public')->put($fileName, $pdf->output());
            $path = $fileName;
        }

        $aparatName = Auth::user()->name;
        $catatan = "Surat Keterangan Jalan Ternak No. {$request->nomor_surat} telah resmi dirilis oleh Aparat Kampung ({$aparatName}).";
        if ($request->filled('catatan_aparat')) {
            $catatan .= ' Catatan: ' . $request->catatan_aparat;
        }

        $transaksi->update([
            'surat_keterangan' => $path,
            'nomor_surat' => $request->nomor_surat,
            'surat_released_at' => now(),
            'surat_aparat_id' => Auth::id(),
            'status_updated_at' => now(),
            'catatan_status' => $catatan,
        ]);

        return back()->with('success', "Surat Keterangan Jalan Ternak No. {$request->nomor_surat} untuk transaksi {$transaksi->kode_transaksi} berhasil dirilis dalam bentuk dokumen resmi!");
    }

    /**
     * Update catatan monitoring resmi dari Aparat
     */
    public function updateMonitoring(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'status' => 'nullable|in:diproses,dikirim,selesai,dibatalkan',
            'catatan_status' => 'required|string|max:500',
        ], [
            'catatan_status.required' => 'Catatan update monitoring wajib diisi.',
        ]);

        $data = [
            'catatan_status' => '[Aparat Kampung] ' . $request->catatan_status,
            'status_updated_at' => now(),
        ];

        if ($request->filled('status')) {
            $data['status'] = $request->status;
        }

        $transaksi->update($data);

        return back()->with('success', "Monitoring pesanan {$transaksi->kode_transaksi} berhasil diperbarui.");
    }
}
