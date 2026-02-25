<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Reservasi;
use App\Models\LogKunjungan;
use Illuminate\Support\Facades\Hash;

class GatekeeperController extends Controller
{
    public function loginForm()
    {
        if (\Illuminate\Support\Facades\Auth::guard('admin')->check() && in_array(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role, ['gatekeeper', 'admin'])) {
            return redirect('/gatekeeper/scan');
        }
        return view('gatekeeper.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (\Illuminate\Support\Facades\Auth::guard('admin')->attempt($credentials)) {
            $role = \Illuminate\Support\Facades\Auth::guard('admin')->user()->role;
            if (in_array($role, ['gatekeeper', 'admin'])) {
                $request->session()->regenerate();
                return redirect('/gatekeeper/scan');
            }
            // Logout jika rolenya tidak diperbolehkan (sebagai pengaman tambahan meski ini jarang terjadi)
            \Illuminate\Support\Facades\Auth::guard('admin')->logout();
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function scan()
    {
        return view('gatekeeper.scan');
    }

    public function validate_ticket(Request $request)
    {
        $kode = $request->input('kode');

        if (!$kode) {
            return response()->json(['success' => false, 'message' => 'Kode tiket tidak ditemukan.']);
        }

        // Decode QR content
        $decoded = json_decode($kode, true);
        $kodeTiket = $decoded['kode'] ?? $kode;

        $reservasi = Reservasi::where('kode_tiket', $kodeTiket)->with('sesi')->first();

        if (!$reservasi) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan dalam sistem.',
            ]);
        }

        if ($reservasi->status === \App\Enums\ReservasiStatus::TELAH_BERKUNJUNG) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket ini sudah digunakan sebelumnya.',
                'data' => [
                    'nama' => $reservasi->nama,
                    'kode_tiket' => $reservasi->kode_tiket,
                    'status' => $reservasi->status,
                ],
            ]);
        }

        // Validasi hash jika ada
        if (isset($decoded['hash'])) {
            $expectedHash = hash('sha256', $decoded['kode'] . $decoded['id'] . config('app.key'));
            if ($expectedHash !== $decoded['hash']) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid atau telah dimanipulasi.',
                ]);
            }
        }

        // Update status
        $reservasi->update(['status' => \App\Enums\ReservasiStatus::TELAH_BERKUNJUNG->value]);

        // Catat log
        LogKunjungan::create([
            'reservasi_id' => $reservasi->id,
            'scanned_by' => \Illuminate\Support\Facades\Auth::guard('admin')->id(),
            'scanned_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tiket VALID! Pengunjung diizinkan masuk.',
            'data' => [
                'nama' => $reservasi->nama,
                'kode_tiket' => $reservasi->kode_tiket,
                'jumlah_anggota' => $reservasi->jumlah_anggota,
                'tanggal_kunjungan' => $reservasi->tanggal_kunjungan->format('d M Y'),
                'sesi' => $reservasi->sesi->nama_sesi ?? '-',
                'status' => \App\Enums\ReservasiStatus::TELAH_BERKUNJUNG->value,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/gatekeeper/login');
    }
}
