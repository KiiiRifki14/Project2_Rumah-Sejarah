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
        if (session()->has('admin_id') && session('admin_role') === 'admin') {
            return redirect('/admin');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->where('role', 'admin')->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session([
                'admin_id' => $admin->id,
                'admin_nama' => $admin->nama,
                'admin_role' => $admin->role,
            ]);
            return redirect('/admin');
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function index()
    {
        $data = [
            'totalTiketHariIni' => Reservasi::whereDate('tanggal_kunjungan', today())->count(),
            'totalPengunjungHariIni' => Reservasi::whereDate('tanggal_kunjungan', today())
                ->where('status', 'telah_berkunjung')->sum('jumlah_anggota'),
            'totalZona' => Zona::count(),
            'totalBenda' => BendaSejarah::count(),
            'totalReservasi' => Reservasi::count(),
            'recentReservasi' => Reservasi::with('sesi')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $data);
    }

    public function logout()
    {
        session()->flush();
        return redirect('/admin/login');
    }
}
