<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan form login tunggal
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect($this->getDashboardUrl(Auth::user()->role));
        }

        return view('auth.login');
    }

    /**
     * Proses login — role ditentukan otomatis dari data user
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;
            return redirect()->intended($this->getDashboardUrl($role));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Tampilkan form registrasi
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect($this->getDashboardUrl(Auth::user()->role));
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi
     */
    public function register(Request $request)
    {
        // Base validation rules for all roles (peternak & pembeli)
        $rules = [
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:peternak,pembeli',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'foto_selfie_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $messages = [
            'name.required' => 'Nama pengguna wajib diisi.',
            'nik.required' => 'Nomer Induk (NIK) wajib diisi.',
            'no_telepon.required' => 'No telephone wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Pilih jenis akun.',
            'role.in' => 'Jenis akun tidak valid. Pilih Peternak atau Pembeli.',
            'alamat.required' => 'Alamat wajib diisi.',
            'latitude.required' => 'Titik lokasi koordinat wajib ditentukan di peta.',
            'longitude.required' => 'Titik lokasi koordinat wajib ditentukan di peta.',
            'foto_ktp.required' => 'Foto KTP wajib diunggah.',
            'foto_ktp.image' => 'Foto KTP harus berupa gambar.',
            'foto_ktp.max' => 'Foto KTP maksimal 2MB.',
            'foto_selfie_ktp.required' => 'Foto selfie dengan KTP wajib diunggah.',
            'foto_selfie_ktp.image' => 'Foto selfie KTP harus berupa gambar.',
            'foto_selfie_ktp.max' => 'Foto selfie KTP maksimal 2MB.',
        ];

        // Additional rules ONLY for Peternak
        if ($request->role === 'peternak') {
            $rules['nomor_rekening'] = 'required|string|max:30';
            $rules['jenis_bank'] = 'required|string|max:50';

            $messages['nomor_rekening.required'] = 'Nomor rekening wajib diisi untuk akun peternak.';
            $messages['jenis_bank.required'] = 'Jenis bank wajib dipilih.';
        }

        $request->validate($rules, $messages);

        // Handle file uploads for both peternak and pembeli
        $fotoKtpPath = null;
        $fotoSelfiePath = null;

        if ($request->hasFile('foto_ktp')) {
            $fotoKtpPath = $request->file('foto_ktp')->store('ktp', 'public');
        }
        if ($request->hasFile('foto_selfie_ktp')) {
            $fotoSelfiePath = $request->file('foto_selfie_ktp')->store('selfie-ktp', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'nomor_rekening' => $request->role === 'peternak' ? $request->nomor_rekening : null,
            'jenis_bank' => $request->role === 'peternak' ? $request->jenis_bank : null,
            'foto_ktp' => $fotoKtpPath,
            'foto_selfie_ktp' => $fotoSelfiePath,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect($this->getDashboardUrl($user->role));
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('katalog.index');
    }

    /**
     * Get dashboard URL berdasarkan role
     */
    private function getDashboardUrl(string $role): string
    {
        return match ($role) {
            'peternak' => '/peternak/dashboard',
            'pembeli' => '/',
            'mantri_hewan' => '/mantri-hewan/dashboard',
            'pengurus_kampung' => '/pengurus-kampung/dashboard',
            default => '/',
        };
    }
}
