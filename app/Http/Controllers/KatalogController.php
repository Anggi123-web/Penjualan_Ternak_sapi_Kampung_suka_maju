<?php

namespace App\Http\Controllers;

use App\Models\Sapi;
use App\Models\Iklan;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Halaman utama — Katalog publik semua sapi
     * Sapi yang tersertifikasi ditandai dengan badge hijau
     */
    public function index(Request $request)
    {
        $query = Sapi::tersedia()
            ->with('peternak')
            ->orderByRaw("CASE WHEN status_kesehatan = 'sehat' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan keyword (search bar di navbar)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('jenis', 'like', '%' . $search . '%')
                  ->orWhere('catatan_kesehatan', 'like', '%' . $search . '%')
                  ->orWhereHas('peternak', function($pq) use ($search) {
                      $pq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter berdasarkan jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', 'like', '%' . $request->jenis . '%');
        }

        // Filter berdasarkan range harga
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }

        // Filter berdasarkan status sertifikasi
        if ($request->filled('sertifikasi') && $request->sertifikasi === 'tersertifikasi') {
            $query->where('status_kesehatan', 'sehat');
        }

        // Filter berdasarkan tipe penjualan (order / pre_order)
        if ($request->filled('tipe_penjualan')) {
            $query->where('tipe_penjualan', $request->tipe_penjualan);
        }

        $sapis = $query->get();

        // Daftar jenis unik untuk dropdown filter
        $jenisList = Sapi::tersedia()->distinct()->pluck('jenis');

        // Ambil data iklan banner yang aktif dan belum expired
        $iklans = Iklan::where('jenis', 'banner')
            ->where('status', 'aktif')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->get();

        if ($iklans->isEmpty()) {
            $iklans = Iklan::where('jenis', 'banner')->latest()->get();
        }

        // Statistik
        $totalSapi = Sapi::tersedia()->count();
        $totalTersertifikasi = Sapi::tersedia()->where('status_kesehatan', 'sehat')->count();

        return view('frontend.katalog', compact('sapis', 'jenisList', 'totalSapi', 'totalTersertifikasi', 'iklans'));
    }

    /**
     * Detail sapi publik — Informasi lengkap + riwayat kelayakan budidaya
     */
    public function show($id)
    {
        $query = Sapi::with(['peternak', 'verifier', 'transaksiAktif']);
        
        // Aparat kampung, peternak pemilik, atau publik bisa melihat detail (bahkan jika nonaktif/terjual)
        if (!auth()->check() || (auth()->user()->role !== 'pengurus_kampung' && auth()->id() !== Sapi::withTrashed()->find($id)?->user_id)) {
            $query->where(function ($q) {
                $q->where('is_active', true)
                  ->orWhereHas('transaksis', function ($tq) {
                      $tq->where('status', '!=', 'dibatalkan');
                  });
            });
        }

        $sapi = $query->findOrFail($id);

        $peternak = $sapi->peternak;
        $peternakUlasans = collect();
        $peternakAvgRating = 0;
        $peternakTotalUlasan = 0;
        $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        if ($peternak) {
            $peternakUlasans = \App\Models\Ulasan::with(['pembeli', 'sapi'])
                ->where('peternak_id', $peternak->id)
                ->latest()
                ->take(8)
                ->get();
            $peternakTotalUlasan = \App\Models\Ulasan::where('peternak_id', $peternak->id)->count();
            $peternakAvgRating = $peternakTotalUlasan > 0 
                ? round(\App\Models\Ulasan::where('peternak_id', $peternak->id)->avg('rating'), 1) 
                : 0;

            foreach ([5, 4, 3, 2, 1] as $star) {
                $ratingCounts[$star] = \App\Models\Ulasan::where('peternak_id', $peternak->id)->where('rating', $star)->count();
            }
        }

        $isTerjual = $sapi->is_terjual;

        return view('katalog.show', compact('sapi', 'peternak', 'peternakUlasans', 'peternakAvgRating', 'peternakTotalUlasan', 'ratingCounts', 'isTerjual'));
    }
}
