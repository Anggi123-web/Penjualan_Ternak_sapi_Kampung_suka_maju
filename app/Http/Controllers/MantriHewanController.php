<?php

namespace App\Http\Controllers;

use App\Models\Sapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MantriHewanController extends Controller
{
    /**
     * Dashboard Mantri Hewan — statistik real dari database
     */
    public function dashboard()
    {
        $menungguPemeriksaan = Sapi::where('status_kesehatan', 'belum_diperiksa')->count();

        $verifikasiSehatBulanIni = Sapi::where('status_kesehatan', 'sehat')
            ->whereMonth('verified_at', now()->month)
            ->whereYear('verified_at', now()->year)
            ->count();

        $tidakSehatBulanIni = Sapi::where('status_kesehatan', 'tidak_sehat')
            ->whereMonth('verified_at', now()->month)
            ->whereYear('verified_at', now()->year)
            ->count();

        $totalDiperiksa = Sapi::whereIn('status_kesehatan', ['sehat', 'tidak_sehat'])->count();

        // Ambil daftar sapi yang menunggu pemeriksaan (langsung ditampilkan di dashboard)
        $sapis = Sapi::where('status_kesehatan', 'belum_diperiksa')
            ->with('peternak')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('dashboard.mantri_hewan', compact(
            'menungguPemeriksaan',
            'verifikasiSehatBulanIni',
            'tidakSehatBulanIni',
            'totalDiperiksa',
            'sapis'
        ));
    }

    /**
     * Redirect pemeriksaan langsung ke dashboard mantri hewan
     */
    public function pemeriksaan()
    {
        return redirect()->route('mantri_hewan.dashboard');
    }

    /**
     * Detail sapi + form verifikasi
     */
    public function showPemeriksaan($id)
    {
        $sapi = Sapi::with('peternak')->findOrFail($id);

        return view('mantri_hewan.pemeriksaan_show', compact('sapi'));
    }

    /**
     * Proses verifikasi sapi (sehat / tidak_sehat)
     */
    public function verifikasi(Request $request, $id)
    {
        $sapi = Sapi::findOrFail($id);

        $request->validate([
            'status_kesehatan' => 'required|in:sehat,tidak_sehat',
            'catatan_kesehatan' => 'required|string|max:2000',
            'dokumen_pemeriksaan' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'status_kesehatan.required' => 'Pilih status kesehatan.',
            'status_kesehatan.in' => 'Status kesehatan tidak valid.',
            'catatan_kesehatan.required' => 'Catatan kesehatan wajib diisi.',
            'catatan_kesehatan.max' => 'Catatan kesehatan maksimal 2000 karakter.',
            'dokumen_pemeriksaan.mimes' => 'Dokumen pemeriksaan harus berformat PDF.',
            'dokumen_pemeriksaan.max' => 'Ukuran file dokumen PDF maksimal 10MB.',
        ]);

        if ($request->hasFile('dokumen_pemeriksaan')) {
            $path = $request->file('dokumen_pemeriksaan')->store('sapi/dokumen', 'public');
            $sapi->dokumen_pemeriksaan = $path;
        }

        $sapi->status_kesehatan = $request->status_kesehatan;
        $sapi->catatan_kesehatan = $request->catatan_kesehatan;
        $sapi->verified_by = Auth::id();
        $sapi->verified_at = now();
        $sapi->save();

        $statusText = $request->status_kesehatan === 'sehat' ? 'Sehat' : 'Tidak Sehat';

        return redirect()->route('mantri_hewan.dashboard')
            ->with('success', "Sapi {$sapi->jenis} berhasil diverifikasi sebagai \"{$statusText}\".");
    }

    /**
     * Riwayat sapi yang sudah diverifikasi
     */
    public function riwayat(Request $request)
    {
        $query = Sapi::whereIn('status_kesehatan', ['sehat', 'tidak_sehat'])
            ->with(['peternak', 'verifier'])
            ->orderBy('verified_at', 'desc');

        // Filter berdasarkan status
        if ($request->filled('status') && in_array($request->status, ['sehat', 'tidak_sehat'])) {
            $query->where('status_kesehatan', $request->status);
        }

        $sapis = $query->get();
        $filterStatus = $request->status;

        return view('mantri_hewan.riwayat', compact('sapis', 'filterStatus'));
    }
}
