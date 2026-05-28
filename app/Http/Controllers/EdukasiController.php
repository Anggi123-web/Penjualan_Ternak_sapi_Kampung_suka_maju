<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EdukasiController extends Controller
{
    public function index()
    {
        $edukasis = Iklan::where('jenis', 'edukasi')->latest()->get();
        return view('pengurus_kampung.edukasi.index', compact('edukasis'));
    }

    public function create()
    {
        return view('pengurus_kampung.edukasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
            'deskripsi' => 'nullable|string',
        ]);

        $path = $request->file('gambar')->store('iklan/edukasi', 'public');

        $kontenEdukasi = [];
        if ($request->has('blocks') && is_array($request->blocks)) {
            foreach ($request->blocks as $index => $block) {
                if ($block['type'] === 'poin' && !empty($block['content'])) {
                    $kontenEdukasi[] = [
                        'type' => 'poin',
                        'content' => $block['content']
                    ];
                } elseif ($block['type'] === 'gambar' && $request->hasFile("blocks.{$index}.file")) {
                    $imgPath = $request->file("blocks.{$index}.file")->store('iklan/edukasi/konten', 'public');
                    $kontenEdukasi[] = [
                        'type' => 'gambar',
                        'content' => $imgPath
                    ];
                }
            }
        }

        Iklan::create([
            'user_id' => auth()->id(),
            'judul' => $request->judul,
            'gambar' => $path,
            'deskripsi' => $request->deskripsi,
            'konten_edukasi' => $kontenEdukasi,
            'jenis' => 'edukasi',
            'status' => 'aktif', // Edukasi langsung aktif
        ]);

        return redirect()->route('pengurus_kampung.edukasi.index')->with('success', 'Pamflet edukasi berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $edukasi = Iklan::findOrFail($id);

        // Hanya pastikan ini tipe edukasi
        if ($edukasi->jenis !== 'edukasi') {
            abort(403);
        }

        // Hapus gambar utama
        if ($edukasi->gambar) {
            Storage::disk('public')->delete($edukasi->gambar);
        }

        // Hapus gambar-gambar di konten edukasi
        if (is_array($edukasi->konten_edukasi)) {
            foreach ($edukasi->konten_edukasi as $block) {
                if (isset($block['type']) && $block['type'] === 'gambar' && !empty($block['content'])) {
                    Storage::disk('public')->delete($block['content']);
                }
            }
        }

        $edukasi->delete();

        return redirect()->route('pengurus_kampung.edukasi.index')->with('success', 'Pamflet edukasi berhasil dihapus.');
    }
}
