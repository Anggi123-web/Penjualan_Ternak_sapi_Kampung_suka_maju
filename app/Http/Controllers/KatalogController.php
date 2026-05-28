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
        $query = Sapi::with('peternak')
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

        $sapis = $query->get();

        // Daftar jenis unik untuk dropdown filter
        $jenisList = Sapi::distinct()->pluck('jenis');

        // Statistik
        $totalSapi = Sapi::count();
        $totalTersertifikasi = Sapi::where('status_kesehatan', 'sehat')->count();

        return view('frontend.katalog', compact('sapis', 'jenisList', 'totalSapi', 'totalTersertifikasi'));
    }

    /**
     * Detail sapi publik — Informasi lengkap + riwayat kelayakan budidaya
     */
    public function show($id)
    {
        $sapi = Sapi::with(['peternak', 'verifier'])->findOrFail($id);

        return view('katalog.show', compact('sapi'));
    }
}
