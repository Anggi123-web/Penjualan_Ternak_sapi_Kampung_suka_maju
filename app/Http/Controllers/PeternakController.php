<?php

namespace App\Http\Controllers;

use App\Models\Sapi;
use App\Models\Transaksi;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PeternakController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        // 1. Data Inventaris Ternak Sapi
        $totalSapi = Sapi::where('user_id', $userId)->count();
        $sapiSehat = Sapi::where('user_id', $userId)->where('status_kesehatan', 'sehat')->count();
        $sapiBelumDiperiksa = Sapi::where('user_id', $userId)->where('status_kesehatan', 'belum_diperiksa')->count();
        $sapiTerjual = Sapi::where('user_id', $userId)->where('status_penjualan', 'terjual')->count();

        // 2. Data Laporan Penjualan & Pendapatan
        $sapiIds = Sapi::withTrashed()->where('user_id', $userId)->pluck('id');
        
        $transaksiSelesai = Transaksi::whereIn('sapi_id', $sapiIds)
            ->where('status', 'selesai');

        $totalPenjualan = $transaksiSelesai->count();
        $totalPendapatan = (int) $transaksiSelesai->sum('total_harga');
        $rataRataHarga = $totalPenjualan > 0 ? (int) round($totalPendapatan / $totalPenjualan) : 0;
        
        $pesananDiproses = Transaksi::whereIn('sapi_id', $sapiIds)
            ->whereIn('status', ['menunggu_verifikasi', 'diproses', 'dikirim'])
            ->count();

        // 3. Data Grafik Tren Penjualan Bulanan (6 bulan terakhir)
        $bulanLabels = [];
        $penjualanBulanan = [];
        $pendapatanBulanan = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            $label = $date->locale('id')->translatedFormat('M Y');

            $trxInMonth = Transaksi::whereIn('sapi_id', $sapiIds)
                ->where('status', 'selesai')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);

            $count = $trxInMonth->count();
            $sum = (int) $trxInMonth->sum('total_harga');

            $bulanLabels[] = $label;
            $penjualanBulanan[] = $count;
            $pendapatanBulanan[] = round($sum / 1000000, 2); // dalam juta rupiah untuk sumbu grafik
        }

        // 4. Data Distribusi Penjualan per Jenis Sapi
        $terjualGroup = Transaksi::whereIn('sapi_id', $sapiIds)
            ->where('status', 'selesai')
            ->with('sapi')
            ->get()
            ->groupBy(function ($item) {
                return $item->sapi ? $item->sapi->jenis : 'Lainnya';
            })
            ->map(fn($group) => $group->count());

        $populasiGroup = Sapi::where('user_id', $userId)
            ->get()
            ->groupBy('jenis')
            ->map(fn($group) => $group->count());

        $isJenisTerjual = $terjualGroup->isNotEmpty();
        $chartJenisSource = $isJenisTerjual ? $terjualGroup : $populasiGroup;
        $jenisLabels = $chartJenisSource->keys()->toArray();
        $jenisCounts = $chartJenisSource->values()->toArray();

        // 5. Pesanan Terbaru
        $pesananTerbaru = Transaksi::with(['sapi', 'pembeli'])
            ->whereIn('sapi_id', $sapiIds)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.peternak', compact(
            'totalSapi',
            'sapiSehat',
            'sapiBelumDiperiksa',
            'sapiTerjual',
            'totalPenjualan',
            'totalPendapatan',
            'rataRataHarga',
            'pesananDiproses',
            'bulanLabels',
            'penjualanBulanan',
            'pendapatanBulanan',
            'jenisLabels',
            'jenisCounts',
            'isJenisTerjual',
            'pesananTerbaru'
        ));
    }

    // ─── Penjualan / Data Sapi ───────────────────────

    public function penjualan()
    {
        $sapis = Sapi::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSampah = Sapi::onlyTrashed()
            ->where('user_id', Auth::id())
            ->count();

        return view('peternak.penjualan', compact('sapis', 'totalSampah'));
    }

    public function createSapi()
    {
        return view('peternak.sapi_create');
    }

    public function storeSapi(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'bobot' => 'required|numeric|min:1',
            'harga' => 'required|integer|min:1',
            'tipe_penjualan' => 'required|in:order,pre_order',
            'preorder_bulan' => 'required_if:tipe_penjualan,pre_order|nullable|integer|min:1|max:12',
            'preorder_tahun' => 'required_if:tipe_penjualan,pre_order|nullable|integer|min:2024|max:2035',
            'biaya_perawatan_harian' => 'nullable|integer|min:0',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|array',
            'foto.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
            'video' => 'nullable|array',
            'video.*' => 'mimes:mp4,mov,avi,webm|max:102400',
        ], [
            'jenis.required' => 'Jenis sapi wajib diisi.',
            'umur.required' => 'Umur wajib diisi.',
            'umur.min' => 'Umur minimal 1 bulan.',
            'bobot.required' => 'Bobot wajib diisi.',
            'bobot.min' => 'Bobot minimal 1 kg.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.min' => 'Harga minimal Rp 1.',
            'tipe_penjualan.required' => 'Tipe penjualan wajib dipilih.',
            'tipe_penjualan.in' => 'Tipe penjualan harus Order atau Pre-Order.',
            'preorder_bulan.required_if' => 'Bulan pre-order wajib diisi jika tipe Pre-Order.',
            'preorder_tahun.required_if' => 'Tahun pre-order wajib diisi jika tipe Pre-Order.',
            'biaya_perawatan_harian.integer' => 'Biaya perawatan harian harus berupa angka.',
            'latitude.required' => 'Lokasi pada peta wajib ditentukan.',
            'latitude.numeric' => 'Format koordinat latitude tidak valid.',
            'longitude.required' => 'Lokasi pada peta wajib ditentukan.',
            'longitude.numeric' => 'Format koordinat longitude tidak valid.',
            'foto.*.image' => 'File foto harus berupa gambar.',
            'foto.*.max' => 'Ukuran foto maksimal 10MB.',
            'video.*.mimes' => 'Format video harus mp4, mov, avi, atau webm.',
            'video.*.max' => 'Ukuran video maksimal 100MB.',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'umur' => $request->umur,
            'bobot' => $request->bobot,
            'harga' => $request->harga,
            'tipe_penjualan' => $request->tipe_penjualan,
            'preorder_bulan' => $request->tipe_penjualan === 'pre_order' ? $request->preorder_bulan : null,
            'preorder_tahun' => $request->tipe_penjualan === 'pre_order' ? $request->preorder_tahun : null,
            'biaya_perawatan_harian' => $request->tipe_penjualan === 'pre_order' ? (int) ($request->biaya_perawatan_harian ?: 25000) : 0,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'lokasi' => $request->lokasi ?: Auth::user()->alamat,
            'foto' => [],
            'video' => [],
        ];

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $data['foto'][] = $this->compressAndStoreImage($file, 'sapi/foto');
            }
        }

        if ($request->hasFile('video')) {
            foreach ($request->file('video') as $file) {
                $data['video'][] = $file->store('sapi/video', 'public');
            }
        }

        Sapi::create($data);

        return redirect()->route('peternak.penjualan')->with('success', 'Data sapi berhasil ditambahkan.');
    }

    public function showSapi($id)
    {
        $sapi = Sapi::where('user_id', Auth::id())->findOrFail($id);
        return view('peternak.sapi_show', compact('sapi'));
    }

    public function editSapi($id)
    {
        $sapi = Sapi::where('user_id', Auth::id())->findOrFail($id);
        return view('peternak.sapi_edit', compact('sapi'));
    }

    public function updateSapi(Request $request, $id)
    {
        $sapi = Sapi::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'jenis' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'bobot' => 'required|numeric|min:1',
            'harga' => 'required|integer|min:1',
            'tipe_penjualan' => 'required|in:order,pre_order',
            'preorder_bulan' => 'required_if:tipe_penjualan,pre_order|nullable|integer|min:1|max:12',
            'preorder_tahun' => 'required_if:tipe_penjualan,pre_order|nullable|integer|min:2024|max:2035',
            'biaya_perawatan_harian' => 'nullable|integer|min:0',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|array',
            'foto.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
            'video' => 'nullable|array',
            'video.*' => 'mimes:mp4,mov,avi,webm|max:102400',
        ], [
            'jenis.required' => 'Jenis sapi wajib diisi.',
            'umur.required' => 'Umur wajib diisi.',
            'umur.min' => 'Umur minimal 1 bulan.',
            'bobot.required' => 'Bobot wajib diisi.',
            'bobot.min' => 'Bobot minimal 1 kg.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.min' => 'Harga minimal Rp 1.',
            'tipe_penjualan.required' => 'Tipe penjualan wajib dipilih.',
            'tipe_penjualan.in' => 'Tipe penjualan harus Order atau Pre-Order.',
            'preorder_bulan.required_if' => 'Bulan pre-order wajib diisi jika tipe Pre-Order.',
            'preorder_tahun.required_if' => 'Tahun pre-order wajib diisi jika tipe Pre-Order.',
            'biaya_perawatan_harian.integer' => 'Biaya perawatan harian harus berupa angka.',
            'latitude.required' => 'Lokasi pada peta wajib ditentukan.',
            'latitude.numeric' => 'Format koordinat latitude tidak valid.',
            'longitude.required' => 'Lokasi pada peta wajib ditentukan.',
            'longitude.numeric' => 'Format koordinat longitude tidak valid.',
            'foto.*.image' => 'File foto harus berupa gambar.',
            'foto.*.max' => 'Ukuran foto maksimal 10MB.',
            'video.*.mimes' => 'Format video harus mp4, mov, avi, atau webm.',
            'video.*.max' => 'Ukuran video maksimal 100MB.',
        ]);

        $sapi->jenis = $request->jenis;
        $sapi->umur = $request->umur;
        $sapi->bobot = $request->bobot;
        $sapi->harga = $request->harga;
        $sapi->tipe_penjualan = $request->tipe_penjualan;
        $sapi->preorder_bulan = $request->tipe_penjualan === 'pre_order' ? $request->preorder_bulan : null;
        $sapi->preorder_tahun = $request->tipe_penjualan === 'pre_order' ? $request->preorder_tahun : null;
        $sapi->biaya_perawatan_harian = $request->tipe_penjualan === 'pre_order' ? (int) ($request->biaya_perawatan_harian ?: 25000) : 0;
        $sapi->latitude = $request->latitude;
        $sapi->longitude = $request->longitude;
        $sapi->lokasi = $request->lokasi ?: Auth::user()->alamat;

        // Handle deleted photos
        $existingFotos = is_array($sapi->foto) ? $sapi->foto : ($sapi->foto ? [$sapi->foto] : []);
        if ($request->has('deleted_fotos')) {
            foreach ($request->deleted_fotos as $delFoto) {
                Storage::disk('public')->delete($delFoto);
                $existingFotos = array_values(array_filter($existingFotos, fn($f) => $f !== $delFoto));
            }
        }

        // Handle deleted videos
        $existingVideos = is_array($sapi->video) ? $sapi->video : ($sapi->video ? [$sapi->video] : []);
        if ($request->has('deleted_videos')) {
            foreach ($request->deleted_videos as $delVideo) {
                Storage::disk('public')->delete($delVideo);
                $existingVideos = array_values(array_filter($existingVideos, fn($v) => $v !== $delVideo));
            }
        }

        // Add new photos
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $existingFotos[] = $this->compressAndStoreImage($file, 'sapi/foto');
            }
        }

        // Add new videos
        if ($request->hasFile('video')) {
            foreach ($request->file('video') as $file) {
                $existingVideos[] = $file->store('sapi/video', 'public');
            }
        }

        $sapi->foto = $existingFotos;
        $sapi->video = $existingVideos;

        $sapi->save();

        return redirect()->route('peternak.sapi.show', $sapi->id)->with('success', 'Data sapi berhasil diperbarui.');
    }

    public function deleteSapi($id)
    {
        $sapi = Sapi::where('user_id', Auth::id())->findOrFail($id);
        $jenis = $sapi->jenis;

        // Pindahkan ke Sampah (Soft Delete)
        $sapi->delete();

        return redirect()->route('peternak.penjualan')->with('success', "Data sapi {$jenis} berhasil dipindahkan ke Sampah.");
    }

    /**
     * Halaman Sampah untuk Peternak
     */
    public function sampah()
    {
        $sapis = Sapi::onlyTrashed()
            ->where('user_id', Auth::id())
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('peternak.sampah', compact('sapis'));
    }

    /**
     * Pulihkan data sapi dari Sampah
     */
    public function restoreSapi($id)
    {
        $sapi = Sapi::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        $jenis = $sapi->jenis;
        $sapi->restore();

        return back()->with('success', "Data sapi {$jenis} berhasil dipulihkan dari Sampah.");
    }

    /**
     * Hapus permanen data sapi beserta berkas foto/video dari storage
     */
    public function forceDeleteSapi($id)
    {
        $sapi = Sapi::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        $jenis = $sapi->jenis;

        // Hapus file foto
        if ($sapi->foto) {
            $fotos = is_array($sapi->foto) ? $sapi->foto : [$sapi->foto];
            foreach ($fotos as $f) {
                Storage::disk('public')->delete($f);
            }
        }
        // Hapus file video
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

        return back()->with('success', "Data sapi {$jenis} telah dihapus permanen.");
    }

    // ─── Laporan ─────────────────────────────────────

    public function laporan()
    {
        return redirect()->route('peternak.dashboard');
    }

    // ─── Akun ────────────────────────────────────────

    public function akun()
    {
        return view('peternak.akun');
    }

    public function updateAkun(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();
        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Compress image using PHP GD and save it to storage
     */
    private function compressAndStoreImage($file, $path): string
    {
        $tempPath = $file->getRealPath();
        
        // Get image info
        $info = getimagesize($tempPath);
        if (!$info) {
            return $file->store($path, 'public');
        }
        
        $mime = $info['mime'];
        
        // Create image resource based on mime type
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($tempPath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($tempPath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($tempPath);
                break;
            default:
                return $file->store($path, 'public');
        }
        
        if (!$image) {
            return $file->store($path, 'public');
        }
        
        $width = imagesx($image);
        $height = imagesy($image);
        
        // Resize image if it exceeds 1200px width/height
        $maxDim = 1200;
        if ($width > $maxDim || $height > $maxDim) {
            $ratio = $width / $height;
            if ($ratio > 1) {
                $newWidth = $maxDim;
                $newHeight = $maxDim / $ratio;
            } else {
                $newHeight = $maxDim;
                $newWidth = $maxDim * $ratio;
            }
            
            $newWidth = (int)round($newWidth);
            $newHeight = (int)round($newHeight);

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            
            if ($mime == 'image/png' || $mime == 'image/webp') {
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);
                $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
                imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
            }
            
            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resizedImage;
        }
        
        // Generate unique name
        $filename = uniqid() . '.jpg';
        $targetDir = storage_path('app/public/' . $path);
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        $targetPath = $targetDir . '/' . $filename;
        
        // Save as JPEG with 70% quality
        imagejpeg($image, $targetPath, 70);
        imagedestroy($image);
        
        return $path . '/' . $filename;
    }

    // ─── Kelola Pesanan Masuk Peternak ──────────────

    public function pesanan(Request $request)
    {
        $peternakId = Auth::id();

        // Ambil semua sapi milik peternak
        $sapiIds = Sapi::withTrashed()->where('user_id', $peternakId)->pluck('id');

        $counts = [
            'semua' => Transaksi::whereIn('sapi_id', $sapiIds)->count(),
            'menunggu_verifikasi' => Transaksi::whereIn('sapi_id', $sapiIds)->where('status', 'menunggu_verifikasi')->count(),
            'menunggu_pembayaran' => Transaksi::whereIn('sapi_id', $sapiIds)->where('status', 'menunggu_pembayaran')->count(),
            'diproses' => Transaksi::whereIn('sapi_id', $sapiIds)->where('status', 'diproses')->count(),
            'dikirim' => Transaksi::whereIn('sapi_id', $sapiIds)->where('status', 'dikirim')->count(),
            'selesai' => Transaksi::whereIn('sapi_id', $sapiIds)->where('status', 'selesai')->count(),
        ];

        $tab = $request->query('tab', 'semua');
        $query = Transaksi::with(['sapi', 'pembeli'])
            ->whereIn('sapi_id', $sapiIds)
            ->orderBy('created_at', 'desc');

        if ($tab === 'menunggu_verifikasi') {
            $query->where('status', 'menunggu_verifikasi');
        } elseif ($tab === 'menunggu_pembayaran') {
            $query->where('status', 'menunggu_pembayaran');
        } elseif ($tab === 'diproses') {
            $query->where('status', 'diproses');
        } elseif ($tab === 'dikirim') {
            $query->where('status', 'dikirim');
        } elseif ($tab === 'selesai') {
            $query->where('status', 'selesai');
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('peternak.pesanan', compact('orders', 'tab', 'counts'));
    }

    public function updateStatusPesanan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,dikirim,selesai,dibatalkan',
            'catatan_status' => 'nullable|string|max:500',
        ]);

        $peternakId = Auth::id();
        $sapiIds = Sapi::withTrashed()->where('user_id', $peternakId)->pluck('id');

        $transaksi = Transaksi::whereIn('sapi_id', $sapiIds)->findOrFail($id);

        $statusLama = $transaksi->status;
        $statusBaru = $request->status;

        $catatan = $request->catatan_status;
        if (empty($catatan)) {
            $catatan = match ($statusBaru) {
                'diproses' => 'Pembayaran telah dikonfirmasi oleh peternak. Hewan sapi sedang disiapkan.',
                'dikirim' => $transaksi->is_pengantaran 
                    ? 'Sapi telah diberangkatkan dan sedang dalam perjalanan pengantaran.' 
                    : 'Sapi telah siap di kandang dan dapat diambil oleh pembeli.',
                'selesai' => 'Pesanan telah selesai dan diserahkan.',
                'dibatalkan' => 'Pesanan dibatalkan oleh peternak.',
                default => null,
            };
        }

        $transaksi->update([
            'status' => $statusBaru,
            'status_updated_at' => now(),
            'catatan_status' => $catatan,
        ]);

        // Sinkronisasi ketersediaan sapi di katalog & beranda
        if ($statusBaru === 'dibatalkan') {
            $transaksi->sapi?->update(['status_penjualan' => 'tersedia']);
        } elseif (in_array($statusBaru, ['diproses', 'dikirim', 'selesai'])) {
            $transaksi->sapi?->update(['status_penjualan' => 'terjual']);
        }

        return back()->with('success', "Status pesanan {$transaksi->kode_transaksi} berhasil diperbarui menjadi: " . $transaksi->status_meta['label']);
    }

    /**
     * Peternak mengonfirmasi pelunasan sisa pembayaran Pre-Order (Tahap 2)
     */
    public function konfirmasiPelunasan(Request $request, $id)
    {
        $peternakId = Auth::id();
        $sapiIds = Sapi::withTrashed()->where('user_id', $peternakId)->pluck('id');

        $transaksi = Transaksi::whereIn('sapi_id', $sapiIds)->findOrFail($id);

        if (!$transaksi->is_preorder) {
            return back()->with('error', 'Transaksi ini bukan pesanan Pre-Order.');
        }

        $sisa = $transaksi->sisa_pembayaran;

        $transaksi->update([
            'fase_pembayaran' => 'lunas',
            'jumlah_pelunasan' => $sisa,
            'dibayarkan' => $transaksi->total_harga,
            'sisa_pembayaran' => 0,
            'catatan_status' => 'Pelunasan sisa pembayaran telah diverifikasi & diterima oleh peternak. Transaksi resmi lunas.',
            'status_updated_at' => now(),
        ]);

        return back()->with('success', "Pelunasan untuk pesanan {$transaksi->kode_transaksi} berhasil diverifikasi dan berstatus LUNAS!");
    }

    /**
     * Tampilkan halaman kelola ulasan pembeli untuk peternak
     */
    public function ulasan(Request $request)
    {
        $peternakId = Auth::id();

        // Ambil ulasan yang diterima peternak
        $query = Ulasan::with(['pembeli', 'transaksi', 'sapi'])
            ->where('peternak_id', $peternakId)
            ->latest();

        // Filter berdasarkan rating jika ada
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $ulasans = $query->paginate(10)->withQueryString();

        // Statistik rating
        $totalUlasan = Ulasan::where('peternak_id', $peternakId)->count();
        $avgRating = $totalUlasan > 0 ? round(Ulasan::where('peternak_id', $peternakId)->avg('rating'), 1) : 0;
        $ratingCounts = [
            5 => Ulasan::where('peternak_id', $peternakId)->where('rating', 5)->count(),
            4 => Ulasan::where('peternak_id', $peternakId)->where('rating', 4)->count(),
            3 => Ulasan::where('peternak_id', $peternakId)->where('rating', 3)->count(),
            2 => Ulasan::where('peternak_id', $peternakId)->where('rating', 2)->count(),
            1 => Ulasan::where('peternak_id', $peternakId)->where('rating', 1)->count(),
        ];

        return view('peternak.ulasan', compact('ulasans', 'totalUlasan', 'avgRating', 'ratingCounts'));
    }

    /**
     * Peternak membalas ulasan pembeli
     */
    public function balasUlasan(Request $request, $id)
    {
        $request->validate([
            'balasan_peternak' => 'required|string|min:3|max:1000',
        ], [
            'balasan_peternak.required' => 'Tanggapan/balasan ulasan wajib diisi.',
            'balasan_peternak.min' => 'Tanggapan minimal terdiri dari 3 karakter.',
        ]);

        $ulasan = Ulasan::where('peternak_id', Auth::id())->findOrFail($id);

        $ulasan->update([
            'balasan_peternak' => $request->balasan_peternak,
            'balasan_at' => now(),
        ]);

        return back()->with('success', 'Balasan ulasan Anda berhasil dikirimkan!');
    }
}

