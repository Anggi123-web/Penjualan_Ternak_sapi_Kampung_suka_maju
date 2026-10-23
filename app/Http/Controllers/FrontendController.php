<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use App\Models\Sapi;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function beranda()
    {
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

        // Ambil data sapi baru (1 minggu terakhir) yang masih tersedia (belum dipesan)
        $sapis = Sapi::tersedia()
            ->with('peternak')
            ->where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->get();

        // Ambil data sapi Pre-Order yang masih tersedia (belum dipesan)
        $sapiPreorder = Sapi::tersedia()
            ->where('tipe_penjualan', 'pre_order')
            ->with('peternak')
            ->latest()
            ->take(8)
            ->get();

        // Ambil data sapi Pesan Biasa (Order langsung) yang masih tersedia (belum dipesan)
        $sapiBiasa = Sapi::tersedia()
            ->where('tipe_penjualan', 'order')
            ->with('peternak')
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.beranda', compact('iklans', 'sapis', 'sapiPreorder', 'sapiBiasa'));
    }

    public function showEdukasi($id)
    {
        $edukasi = Iklan::where('jenis', 'edukasi')->findOrFail($id);
        return view('frontend.edukasi_detail', compact('edukasi'));
    }

    public function about()
    {
        return view('frontend.about');
    }
}
