<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Reservasi;
use App\Models\Zona;
use App\Models\BendaSejarah;
use App\Models\LogKunjungan;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function loginForm()
    {
        if (\Illuminate\Support\Facades\Auth::guard('admin')->check() && \Illuminate\Support\Facades\Auth::guard('admin')->user()->role === 'admin') {
            return redirect('/admin');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials['role'] = 'admin';

        if (\Illuminate\Support\Facades\Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin');
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function index()
    {
        $data = [
            'totalTiketHariIni' => Reservasi::whereDate('tanggal_kunjungan', today())->count(),
            'totalPengunjungHariIni' => Reservasi::whereDate('tanggal_kunjungan', today())
                ->where('status', \App\Enums\ReservasiStatus::TELAH_BERKUNJUNG->value)->sum('jumlah_anggota'),
            'totalZona' => Zona::count(),
            'totalBenda' => BendaSejarah::count(),
            'totalReservasi' => Reservasi::count(),
            'recentReservasi' => Reservasi::with('sesi')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $data);
    }

    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
