<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Sapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with('sapi')->where('user_id', Auth::id())->get();
        return view('frontend.keranjang', compact('keranjangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sapi_id' => 'required|exists:sapis,id',
        ]);

        $sapi = Sapi::findOrFail($request->sapi_id);

        // Cek apakah sapi sudah ada di keranjang user ini
        $exists = Keranjang::where('user_id', auth()->id())
            ->where('sapi_id', $sapi->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Sapi ini sudah ada di keranjang Anda.');
        }

        Keranjang::create([
            'user_id' => auth()->id(),
            'sapi_id' => $sapi->id,
        ]);

        return redirect()->route('pembeli.keranjang.index')->with('success', 'Sapi berhasil ditambahkan ke keranjang.');
    }

    public function destroy($id)
    {
        $keranjang = Keranjang::where('user_id', auth()->id())->findOrFail($id);
        $keranjang->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
