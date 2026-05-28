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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:peternak,pembeli,mantri_hewan,pengurus_kampung',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Pilih jenis akun.',
            'role.in' => 'Jenis akun tidak valid.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
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
