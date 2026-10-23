<?php

namespace App\Http\Controllers\PengurusKampung;

use App\Http\Controllers\Controller;
use App\Models\Sapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KatalogController extends Controller
{
    /**
     * Tampilkan semua katalog penjualan untuk aparat kampung
     */
    public function index(Request $request)
    {
        $query = Sapi::with('peternak')->orderBy('created_at', 'desc');

        // Pencarian jenis, peternak, atau lokasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhereHas('peternak', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter status aktif/nonaktif
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where('is_active', true);
            } elseif ($request->status === 'nonaktif') {
                $query->where('is_active', false);
            }
        }

        // Filter status kesehatan
        if ($request->filled('kesehatan')) {
            $query->where('status_kesehatan', $request->kesehatan);
        }

        $sapis = $query->paginate(12)->withQueryString();

        // Statistik ringkasan
        $totalSapi = Sapi::count();
        $totalAktif = Sapi::where('is_active', true)->count();
        $totalNonaktif = Sapi::where('is_active', false)->count();
        $totalSampah = Sapi::onlyTrashed()->count();

        return view('pengurus_kampung.katalog.index', compact(
            'sapis',
            'totalSapi',
            'totalAktif',
            'totalNonaktif',
            'totalSampah'
        ));
    }

    /**
     * Toggle status aktif / nonaktif katalog sapi
     */
    public function toggleStatus($id)
    {
        $sapi = Sapi::findOrFail($id);
        $sapi->is_active = !$sapi->is_active;
        $sapi->save();

        $statusText = $sapi->is_active ? 'diaktifkan kembali' : 'dinonaktifkan sementara';
        return back()->with('success', "Katalog sapi {$sapi->jenis} (ID #{$sapi->id}) berhasil {$statusText}.");
    }

    /**
     * Soft delete: Pindahkan katalog ke Sampah
     */
    public function softDelete($id)
    {
        $sapi = Sapi::findOrFail($id);
        $jenis = $sapi->jenis;
        $sapiId = $sapi->id;
        $sapi->delete();

        return back()->with('success', "Katalog sapi {$jenis} (ID #{$sapiId}) berhasil dipindahkan ke Sampah.");
    }

    /**
     * Halaman Sampah: Menampilkan katalog yang telah dihapus sementara
     */
    public function sampah(Request $request)
    {
        $query = Sapi::onlyTrashed()->with('peternak')->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhereHas('peternak', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $sapis = $query->paginate(12)->withQueryString();
        $totalSampah = Sapi::onlyTrashed()->count();

        return view('pengurus_kampung.katalog.sampah', compact('sapis', 'totalSampah'));
    }

    /**
     * Pulihkan katalog dari Sampah
     */
    public function restore($id)
    {
        $sapi = Sapi::onlyTrashed()->findOrFail($id);
        $sapi->restore();

        return back()->with('success', "Katalog sapi {$sapi->jenis} (ID #{$sapi->id}) berhasil dipulihkan dari Sampah.");
    }

    /**
     * Hapus permanen katalog dari database & bersihkan berkas di storage
     */
    public function forceDelete($id)
    {
        $sapi = Sapi::onlyTrashed()->findOrFail($id);
        $jenis = $sapi->jenis;
        $sapiId = $sapi->id;

        // Hapus foto dari storage
        if ($sapi->foto) {
            $fotos = is_array($sapi->foto) ? $sapi->foto : [$sapi->foto];
            foreach ($fotos as $f) {
                Storage::disk('public')->delete($f);
            }
        }

        // Hapus video dari storage
        if ($sapi->video) {
            $videos = is_array($sapi->video) ? $sapi->video : [$sapi->video];
            foreach ($videos as $v) {
                Storage::disk('public')->delete($v);
            }
        }

        // Hapus dokumen jika ada
        if ($sapi->dokumen_pemeriksaan) {
            Storage::disk('public')->delete($sapi->dokumen_pemeriksaan);
        }

        $sapi->forceDelete();

        return back()->with('success', "Katalog sapi {$jenis} (ID #{$sapiId}) telah dihapus secara permanen dari sistem.");
    }
}
