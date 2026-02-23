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
        if (session()->has('admin_id') && in_array(session('admin_role'), ['gatekeeper', 'admin'])) {
            return redirect('/gatekeeper/scan');
        }
        return view('gatekeeper.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session([
                'admin_id' => $admin->id,
                'admin_nama' => $admin->nama,
                'admin_role' => $admin->role,
            ]);
            return redirect('/gatekeeper/scan');
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

        if ($reservasi->status === 'telah_berkunjung') {
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
            $expectedHash = hash('sha256', $decoded['kode'] . $decoded['id'] . env('APP_KEY'));
            if ($expectedHash !== $decoded['hash']) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid atau telah dimanipulasi.',
                ]);
            }
        }

        // Update status
        $reservasi->update(['status' => 'telah_berkunjung']);

        // Catat log
        LogKunjungan::create([
            'reservasi_id' => $reservasi->id,
            'scanned_by' => session('admin_id'),
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
                'status' => 'telah_berkunjung',
            ],
        ]);
    }

    public function logout()
    {
        session()->flush();
        return redirect('/gatekeeper/login');
    }
}
