<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Khusus peternak: wajib sudah diverifikasi oleh aparat kampung
        if (auth()->user()->role === 'peternak' && auth()->user()->status_verifikasi !== 'terverifikasi') {
            $isMenunggu = auth()->user()->status_verifikasi === 'menunggu_verifikasi';
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => $isMenunggu
                    ? 'Akun Peternak Anda sedang menunggu proses verifikasi oleh Aparat Kampung Suka Maju. Pihak kampung akan menghubungi Anda dan mengirimkan notifikasi aktivasi via WhatsApp.'
                    : 'Pendaftaran akun Peternak Anda belum disetujui oleh Aparat Kampung. Silakan hubungi aparat kampung.',
            ]);
        }

        return $next($request);
    }
}
