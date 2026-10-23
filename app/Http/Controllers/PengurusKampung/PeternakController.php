<?php

namespace App\Http\Controllers\PengurusKampung;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sapi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PeternakController extends Controller
{
    /**
     * Tampilkan direktori seluruh peternak di wilayah Kampung Suka Maju
     */
    public function index(Request $request)
    {
        $search = $request->query('q');
        $filterStatus = $request->query('status', 'semua');

        $query = User::where('role', 'peternak')
            ->withCount([
                'sapis as total_sapi',
                'sapisAktif as sapi_aktif_count'
            ])
            ->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_telepon', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($filterStatus === 'ada_sapi') {
            $query->has('sapisAktif');
        } elseif ($filterStatus === 'belum_ada_sapi') {
            $query->doesntHave('sapisAktif');
        }

        $peternaks = $query->paginate(10)->withQueryString();

        // Ambil ID semua sapi dari peternak-peternak untuk hitung omset masing-masing di halaman ini
        foreach ($peternaks as $peternak) {
            $sapiIds = Sapi::withTrashed()->where('user_id', $peternak->id)->pluck('id');
            $peternak->transaksi_selesai_count = Transaksi::whereIn('sapi_id', $sapiIds)->where('status', 'selesai')->count();
            $peternak->total_omset = Transaksi::whereIn('sapi_id', $sapiIds)->where('status', 'selesai')->sum('total_harga');
        }

        // Summary KPI wilayah
        $totalPeternak = User::where('role', 'peternak')->count();
        $peternakAktif = User::where('role', 'peternak')->has('sapisAktif')->count();
        $totalSapiWilayah = Sapi::count();
        $totalOmsetWilayah = Transaksi::where('status', 'selesai')->sum('total_harga');

        return view('pengurus_kampung.peternak.index', compact(
            'peternaks',
            'search',
            'filterStatus',
            'totalPeternak',
            'peternakAktif',
            'totalSapiWilayah',
            'totalOmsetWilayah'
        ));
    }

    /**
     * Tampilkan rincian profil peternak, dokumen identitas, katalog ternak & histori transaksi
     */
    public function show($id)
    {
        $peternak = User::where('role', 'peternak')
            ->withCount(['sapis', 'sapisAktif'])
            ->findOrFail($id);

        // Ambil seluruh sapi milik peternak ini (termasuk yang diarsipkan)
        $sapis = Sapi::withTrashed()
            ->where('user_id', $peternak->id)
            ->with(['verifier'])
            ->latest()
            ->get();

        $sapiIds = $sapis->pluck('id');

        // Ambil riwayat transaksi yang melibatkan sapi milik peternak ini
        $transaksis = Transaksi::whereIn('sapi_id', $sapiIds)
            ->with(['pembeli', 'sapi', 'aparat'])
            ->latest()
            ->get();

        // Statistik individual peternak
        $stats = [
            'total_sapi' => $sapis->whereNull('deleted_at')->count(),
            'sapi_sehat' => $sapis->whereNull('deleted_at')->where('status_kesehatan', 'sehat')->count(),
            'sapi_perlu_periksa' => $sapis->whereNull('deleted_at')->where('status_kesehatan', 'belum_diperiksa')->count(),
            'transaksi_sukses' => $transaksis->where('status', 'selesai')->count(),
            'total_omset' => $transaksis->where('status', 'selesai')->sum('total_harga'),
            'avg_rating' => $peternak->average_rating,
            'total_ulasan' => $peternak->total_ulasan,
        ];

        return view('pengurus_kampung.peternak.show', compact(
            'peternak',
            'sapis',
            'transaksis',
            'stats'
        ));
    }
}
