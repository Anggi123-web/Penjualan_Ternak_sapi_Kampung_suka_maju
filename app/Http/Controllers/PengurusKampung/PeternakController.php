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
        $filterVerifikasi = $request->query('status_verifikasi', 'semua');

        // Tab counts for verification status
        $countMenunggu = User::where('role', 'peternak')->where('status_verifikasi', 'menunggu_verifikasi')->count();
        $countTerverifikasi = User::where('role', 'peternak')->where('status_verifikasi', 'terverifikasi')->count();
        $countDitolak = User::where('role', 'peternak')->where('status_verifikasi', 'ditolak')->count();
        $countSemua = User::where('role', 'peternak')->count();

        // Default to 'menunggu_verifikasi' if there are pending applicants and user hasn't selected another tab
        if (!$request->has('status_verifikasi') && $countMenunggu > 0) {
            $filterVerifikasi = 'menunggu_verifikasi';
        }

        $query = User::where('role', 'peternak')
            ->with(['diverifikasiOleh'])
            ->withCount([
                'sapis as total_sapi',
                'sapisAktif as sapi_aktif_count'
            ]);

        // Prioritize pending verifications at the top
        $query->orderByRaw("CASE WHEN status_verifikasi = 'menunggu_verifikasi' THEN 0 WHEN status_verifikasi = 'terverifikasi' THEN 1 ELSE 2 END")
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

        if ($filterVerifikasi === 'menunggu_verifikasi') {
            $query->where('status_verifikasi', 'menunggu_verifikasi');
        } elseif ($filterVerifikasi === 'terverifikasi') {
            $query->where('status_verifikasi', 'terverifikasi');
        } elseif ($filterVerifikasi === 'ditolak') {
            $query->where('status_verifikasi', 'ditolak');
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
        $peternakAktif = User::where('role', 'peternak')->where('status_verifikasi', 'terverifikasi')->has('sapisAktif')->count();
        $totalSapiWilayah = Sapi::count();
        $totalOmsetWilayah = Transaksi::where('status', 'selesai')->sum('total_harga');

        return view('pengurus_kampung.peternak.index', compact(
            'peternaks',
            'search',
            'filterStatus',
            'filterVerifikasi',
            'countMenunggu',
            'countTerverifikasi',
            'countDitolak',
            'countSemua',
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
            ->with(['diverifikasiOleh'])
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

    /**
     * Setujui pendaftaran peternak dan generate link WhatsApp untuk kirim notifikasi aktivasi
     */
    public function verifikasi(Request $request, $id)
    {
        $peternak = User::where('role', 'peternak')->findOrFail($id);

        $peternak->update([
            'status_verifikasi' => 'terverifikasi',
            'diverifikasi_oleh' => auth()->id(),
            'tanggal_verifikasi' => now(),
            'alasan_penolakan' => null,
            'wa_notifikasi_terkirim_at' => now(),
        ]);

        $waUrl = $peternak->generateWhatsAppAktivasiUrl();

        return redirect()->route('pengurus_kampung.peternak.index', ['status_verifikasi' => 'terverifikasi'])
            ->with('success', 'Akun Peternak ' . $peternak->name . ' BERHASIL DIVERIFIKASI!')
            ->with('wa_url', $waUrl)
            ->with('verified_peternak', $peternak->name)
            ->with('verified_phone', $peternak->no_telepon);
    }

    /**
     * Tolak pendaftaran peternak dengan alasan
     */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:500',
        ], [
            'alasan_penolakan.required' => 'Wajib memberikan alasan atau catatan penolakan pendaftaran.',
        ]);

        $peternak = User::where('role', 'peternak')->findOrFail($id);

        $peternak->update([
            'status_verifikasi' => 'ditolak',
            'diverifikasi_oleh' => auth()->id(),
            'tanggal_verifikasi' => now(),
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        $waUrl = $peternak->generateWhatsAppPenolakanUrl($request->alasan_penolakan);

        return redirect()->route('pengurus_kampung.peternak.index', ['status_verifikasi' => 'ditolak'])
            ->with('warning', 'Pengajuan akun Peternak ' . $peternak->name . ' telah ditolak.')
            ->with('wa_url', $waUrl)
            ->with('rejected_peternak', $peternak->name);
    }

    /**
     * Kirim ulang notifikasi akun WhatsApp secara langsung
     */
    public function kirimWa(Request $request, $id)
    {
        $peternak = User::where('role', 'peternak')->findOrFail($id);

        if ($peternak->status_verifikasi === 'ditolak') {
            $waUrl = $peternak->generateWhatsAppPenolakanUrl();
        } else {
            $waUrl = $peternak->generateWhatsAppAktivasiUrl();
        }

        $peternak->update(['wa_notifikasi_terkirim_at' => now()]);

        return redirect()->away($waUrl);
    }
}
