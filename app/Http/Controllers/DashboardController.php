<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function peternak()
    {
        return view('dashboard.peternak');
    }

    public function pembeli()
    {
        $sapiTersedia = \App\Models\Sapi::where('status_kesehatan', 'sehat')->count();
        return view('dashboard.pembeli', compact('sapiTersedia'));
    }

    public function mantriHewan()
    {
        return view('dashboard.mantri_hewan');
    }

    public function pengurusKampung()
    {
        return view('dashboard.pengurus_kampung');
    }
}
