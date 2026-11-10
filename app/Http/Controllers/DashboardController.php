<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function peternak()
    {
        return view('dashboard.peternak');
    }

    public function pembeli()
    {
        $sapiTersedia = \App\Models\Sapi::where('status_kesehatan', 'sehat')->count();
        return view('dashboard.pembeli', compact('sapiTersedia'));
    }

    public function mantriHewan()
    {
        return view('dashboard.mantri_hewan');
    }

    public function pengurusKampung()
    {
        $now = \Carbon\Carbon::now();
        $currentQuarter = (int) ceil($now->month / 3);
        $quarterMonths = match ($currentQuarter) {
            1 => [1, 2, 3],
            2 => [4, 5, 6],
            3 => [7, 8, 9],
            4 => [10, 11, 12],
        };

        $totalPeternak = \App\Models\User::where('role', 'peternak')->count();
        $peternakAktif = \App\Models\User::where('role', 'peternak')->has('sapisAktif')->count();
        $totalSapi = \App\Models\Sapi::count();
        $pendingSurat = \App\Models\Transaksi::whereIn('status', ['diproses', 'dikirim'])
            ->whereNull('surat_released_at')
            ->count();
        $transaksiBulanIni = \App\Models\Transaksi::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();
        $omsetTriwulan = \App\Models\Transaksi::where('status', 'selesai')
            ->whereYear('created_at', $now->year)
            ->where(function($q) use ($quarterMonths) {
                foreach ($quarterMonths as $m) {
                    $q->orWhereMonth('created_at', $m);
                }
            })
            ->sum('total_harga');

        $recentPeternaks = \App\Models\User::where('role', 'peternak')
            ->withCount(['sapis', 'sapisAktif'])
            ->latest()
            ->take(5)
            ->get();

        $recentTransaksis = \App\Models\Transaksi::with(['sapi.peternak', 'pembeli'])
            ->latest()
            ->take(5)
            ->get();

        $pendingPeternakCount = \App\Models\User::where('role', 'peternak')
            ->where('status_verifikasi', 'menunggu_verifikasi')
            ->count();

        return view('dashboard.pengurus_kampung', compact(
            'totalPeternak',
            'peternakAktif',
            'pendingPeternakCount',
            'totalSapi',
            'pendingSurat',
            'transaksiBulanIni',
            'omsetTriwulan',
            'currentQuarter',
            'recentPeternaks',
            'recentTransaksis'
        ));
    }
}
