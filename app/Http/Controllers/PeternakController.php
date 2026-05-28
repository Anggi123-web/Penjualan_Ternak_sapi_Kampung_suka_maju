<?php

namespace App\Http\Controllers;

use App\Models\Sapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PeternakController extends Controller
{
    public function dashboard()
    {
        $totalSapi = Sapi::where('user_id', Auth::id())->count();
        $sapiSehat = Sapi::where('user_id', Auth::id())->where('status_kesehatan', 'sehat')->count();
        $sapiBelumDiperiksa = Sapi::where('user_id', Auth::id())->where('status_kesehatan', 'belum_diperiksa')->count();

        return view('dashboard.peternak', compact('totalSapi', 'sapiSehat', 'sapiBelumDiperiksa'));
    }

    // ─── Penjualan / Data Sapi ───────────────────────

    public function penjualan()
    {
        $sapis = Sapi::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('peternak.penjualan', compact('sapis'));
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
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'video' => 'nullable|mimes:mp4,mov,avi,webm|max:51200',
        ], [
            'jenis.required' => 'Jenis sapi wajib diisi.',
            'umur.required' => 'Umur wajib diisi.',
            'umur.min' => 'Umur minimal 1 bulan.',
            'bobot.required' => 'Bobot wajib diisi.',
            'bobot.min' => 'Bobot minimal 1 kg.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.min' => 'Harga minimal Rp 1.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 5MB.',
            'video.mimes' => 'Format video harus mp4, mov, avi, atau webm.',
            'video.max' => 'Ukuran video maksimal 50MB.',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'umur' => $request->umur,
            'bobot' => $request->bobot,
            'harga' => $request->harga,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('sapi/foto', 'public');
        }

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('sapi/video', 'public');
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
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'video' => 'nullable|mimes:mp4,mov,avi,webm|max:51200',
        ], [
            'jenis.required' => 'Jenis sapi wajib diisi.',
            'umur.required' => 'Umur wajib diisi.',
            'umur.min' => 'Umur minimal 1 bulan.',
            'bobot.required' => 'Bobot wajib diisi.',
            'bobot.min' => 'Bobot minimal 1 kg.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.min' => 'Harga minimal Rp 1.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 5MB.',
            'video.mimes' => 'Format video harus mp4, mov, avi, atau webm.',
            'video.max' => 'Ukuran video maksimal 50MB.',
        ]);

        $sapi->jenis = $request->jenis;
        $sapi->umur = $request->umur;
        $sapi->bobot = $request->bobot;
        $sapi->harga = $request->harga;

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($sapi->foto) {
                Storage::disk('public')->delete($sapi->foto);
            }
            $sapi->foto = $request->file('foto')->store('sapi/foto', 'public');
        }

        if ($request->hasFile('video')) {
            // Hapus video lama
            if ($sapi->video) {
                Storage::disk('public')->delete($sapi->video);
            }
            $sapi->video = $request->file('video')->store('sapi/video', 'public');
        }

        $sapi->save();

        return redirect()->route('peternak.sapi.show', $sapi->id)->with('success', 'Data sapi berhasil diperbarui.');
    }

    public function deleteSapi($id)
    {
        $sapi = Sapi::where('user_id', Auth::id())->findOrFail($id);

        // Hapus file
        if ($sapi->foto) {
            Storage::disk('public')->delete($sapi->foto);
        }
        if ($sapi->video) {
            Storage::disk('public')->delete($sapi->video);
        }

        $sapi->delete();

        return redirect()->route('peternak.penjualan')->with('success', 'Data sapi berhasil dihapus.');
    }

    // ─── Laporan ─────────────────────────────────────

    public function laporan()
    {
        return view('peternak.laporan');
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
}
