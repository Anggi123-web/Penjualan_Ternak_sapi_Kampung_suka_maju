<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IklanController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'pengurus_kampung') {
            // Pengurus Kampung sees all ads
            $iklans = Iklan::with('user')->latest()->get();
        } else {
            // Peternak sees only their ads
            $iklans = Iklan::where('user_id', auth()->id())->latest()->get();
        }
        
        return view('iklan.index', compact('iklans'));
    }

    public function create()
    {
        return view('iklan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $path = $request->file('gambar')->store('iklan/foto', 'public');

        Iklan::create([
            'user_id' => auth()->id(),
            'judul' => $request->judul,
            'gambar' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('iklan.index')->with('success', 'Iklan berhasil diunggah dan sedang menunggu konfirmasi dari Pengurus Kampung.');
    }

    public function approve(Request $request, Iklan $iklan)
    {
        if (auth()->user()->role !== 'pengurus_kampung') {
            abort(403);
        }

        $request->validate([
            'durasi_hari' => 'required|integer|min:1|max:365',
        ]);

        $iklan->update([
            'status' => 'aktif',
            'expires_at' => now()->addDays((int) $request->durasi_hari),
        ]);

        return back()->with('success', 'Iklan berhasil disetujui dan akan tayang selama ' . $request->durasi_hari . ' hari.');
    }

    public function toggle(Iklan $iklan)
    {
        // Ensure user owns the iklan
        if ($iklan->user_id !== auth()->id()) {
            abort(403);
        }

        $iklan->update([
            'is_active' => !$iklan->is_active,
        ]);

        return back()->with('success', 'Status iklan berhasil diubah.');
    }

    public function destroy(Iklan $iklan)
    {
        if ($iklan->user_id !== auth()->id()) {
            abort(403);
        }

        if ($iklan->gambar) {
            Storage::disk('public')->delete($iklan->gambar);
        }

        $iklan->delete();

        return redirect()->route('iklan.index')->with('success', 'Iklan berhasil dihapus.');
    }
}
