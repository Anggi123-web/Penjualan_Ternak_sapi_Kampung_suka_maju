<?php

namespace App\Http\Controllers\PengurusKampung;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Tampilkan Laporan Penjualan Ternak Sapi Per Triwulan
     */
    public function index(Request $request)
    {
        $data = $this->getLaporanData($request);

        return view('pengurus_kampung.laporan.index', $data);
    }

    /**
     * Tampilan cetak ramah cetak (Print-friendly format A4)
     */
    public function cetak(Request $request)
    {
        $data = $this->getLaporanData($request, false);

        return view('pengurus_kampung.laporan.cetak', $data);
    }

    /**
     * Unduh berkas PDF resmi Laporan Penjualan Triwulan
     */
    public function downloadPdf(Request $request)
    {
        $data = $this->getLaporanData($request, false);

        $pdf = Pdf::loadView('pengurus_kampung.laporan.cetak', $data)
            ->setPaper('a4', 'portrait');

        $triwulanLabel = match ($data['triwulan']) {
            '1' => 'Triwulan_I',
            '2' => 'Triwulan_II',
            '3' => 'Triwulan_III',
            '4' => 'Triwulan_IV',
            default => 'Semua_Triwulan',
        };

        $filename = "Laporan_Penjualan_Sapi_{$triwulanLabel}_{$data['tahun']}.pdf";

        return $pdf->download($filename);
    }

    /**
     * Logika query data laporan berdasarkan tahun, triwulan, dan status
     */
    private function getLaporanData(Request $request, bool $paginate = true): array
    {
        $tahun = (int) $request->query('tahun', Carbon::now()->year);
        $triwulan = $request->query('triwulan', 'all'); // 'all', '1', '2', '3', '4'
        $status = $request->query('status', 'selesai'); // 'selesai', 'semua'
        $peternakId = $request->query('peternak_id', 'all');

        // Daftar tahun yang ada pada sistem untuk filter
        $dbYears = Transaksi::selectRaw('YEAR(created_at) as yr')
            ->distinct()
            ->orderBy('yr', 'desc')
            ->pluck('yr')
            ->toArray();
        $availableYears = array_unique(array_merge([Carbon::now()->year, Carbon::now()->year - 1], $dbYears));
        rsort($availableYears);

        // Daftar peternak untuk opsi filter
        $listPeternak = User::where('role', 'peternak')->orderBy('name', 'asc')->get();

        // Tentukan rentang bulan berdasarkan triwulan
        $monthRange = match ($triwulan) {
            '1' => [1, 2, 3],
            '2' => [4, 5, 6],
            '3' => [7, 8, 9],
            '4' => [10, 11, 12],
            default => range(1, 12),
        };

        // Query utama
        $baseQuery = Transaksi::with(['sapi.peternak', 'pembeli', 'aparat'])
            ->whereYear('created_at', $tahun)
            ->whereIn(\DB::raw('MONTH(created_at)'), $monthRange);

        if ($status === 'selesai') {
            $baseQuery->where('status', 'selesai');
        }

        if ($peternakId !== 'all') {
            $baseQuery->whereHas('sapi', function ($q) use ($peternakId) {
                $q->where('user_id', $peternakId);
            });
        }

        // Ringkasan KPI periode terpilih
        $clonedForStats = clone $baseQuery;
        $allSelectedTransactions = $clonedForStats->get();

        $totalOmset = $allSelectedTransactions->sum('total_harga');
        $totalSapiTerjual = $allSelectedTransactions->count();
        $transaksiSelesai = $allSelectedTransactions->where('status', 'selesai')->count();
        $avgHarga = $totalSapiTerjual > 0 ? round($totalOmset / $totalSapiTerjual) : 0;

        // Data komparasi 4 Triwulan untuk tahun terpilih
        $quarterComparison = [];
        $quarterDefinitions = [
            1 => ['label' => 'Triwulan I (Jan - Mar)', 'short' => 'Triwulan I', 'months' => [1, 2, 3]],
            2 => ['label' => 'Triwulan II (Apr - Jun)', 'short' => 'Triwulan II', 'months' => [4, 5, 6]],
            3 => ['label' => 'Triwulan III (Jul - Sep)', 'short' => 'Triwulan III', 'months' => [7, 8, 9]],
            4 => ['label' => 'Triwulan IV (Okt - Des)', 'short' => 'Triwulan IV', 'months' => [10, 11, 12]],
        ];

        foreach ($quarterDefinitions as $qNum => $qDef) {
            $qQuery = Transaksi::whereYear('created_at', $tahun)
                ->whereIn(\DB::raw('MONTH(created_at)'), $qDef['months']);

            if ($status === 'selesai') {
                $qQuery->where('status', 'selesai');
            }
            if ($peternakId !== 'all') {
                $qQuery->whereHas('sapi', function ($q) use ($peternakId) {
                    $q->where('user_id', $peternakId);
                });
            }

            $qItems = $qQuery->get();
            $quarterComparison[$qNum] = [
                'label' => $qDef['label'],
                'short' => $qDef['short'],
                'months' => $qDef['months'],
                'total_omset' => $qItems->sum('total_harga'),
                'total_sapi' => $qItems->count(),
                'total_transaksi' => $qItems->count(),
            ];
        }

        // Rekapitulasi penjualan per Peternak pada periode terpilih
        $peternakBreakdown = [];
        foreach ($allSelectedTransactions as $trx) {
            $p = $trx->sapi?->peternak;
            $pId = $p ? $p->id : 0;
            $pName = $p ? $p->name : 'Tidak Diketahui';
            $pNik = $p ? ($p->nik ?? '-') : '-';
            $pAlamat = $p ? ($p->alamat ?? '-') : '-';

            if (!isset($peternakBreakdown[$pId])) {
                $peternakBreakdown[$pId] = [
                    'id' => $pId,
                    'name' => $pName,
                    'nik' => $pNik,
                    'alamat' => $pAlamat,
                    'jumlah_sapi' => 0,
                    'total_omset' => 0,
                ];
            }
            $peternakBreakdown[$pId]['jumlah_sapi'] += 1;
            $peternakBreakdown[$pId]['total_omset'] += $trx->total_harga;
        }

        // Urutkan peternak berdasarkan omset tertinggi
        usort($peternakBreakdown, fn ($a, $b) => $b['total_omset'] <=> $a['total_omset']);

        // Data transaksi (paginasi jika untuk halaman web, get all jika untuk cetak/PDF)
        $orderQuery = clone $baseQuery;
        $orderQuery->orderBy('created_at', 'desc');

        if ($paginate) {
            $transaksis = $orderQuery->paginate(10)->withQueryString();
        } else {
            $transaksis = $orderQuery->get();
        }

        return compact(
            'tahun',
            'triwulan',
            'status',
            'peternakId',
            'availableYears',
            'listPeternak',
            'totalOmset',
            'totalSapiTerjual',
            'transaksiSelesai',
            'avgHarga',
            'quarterComparison',
            'peternakBreakdown',
            'transaksis'
        );
    }
}
