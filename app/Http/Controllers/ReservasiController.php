<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\SesiKunjungan;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\RateLimit;

class ReservasiController extends Controller
{
    public function create()
    {
        $sesiList = SesiKunjungan::where('is_active', true)->get();
        return view('public.reservasi', compact('sesiList'));
    }

    public function store(Request $request)
    {
        // Honeypot check
        if ($request->filled('website_url')) {
            return redirect('/reservasi')->with('success', 'Tiket berhasil dipesan!');
        }

        // Rate limiting - max 3 per jam per IP
        $ip = $request->ip();
        $rateLimit = \DB::table('rate_limits')
            ->where('ip_address', $ip)
            ->where('action', 'reservasi')
            ->where('window_start', '>', now()->subHour())
            ->first();

        if ($rateLimit && $rateLimit->attempts >= 3) {
            return back()->with('error', 'Terlalu banyak percobaan. Silakan coba lagi dalam 1 jam.')->withInput();
        }

        // Update rate limit
        if ($rateLimit) {
            \DB::table('rate_limits')->where('id', $rateLimit->id)->update([
                'attempts' => $rateLimit->attempts + 1,
            ]);
        } else {
            \DB::table('rate_limits')->insert([
                'ip_address' => $ip,
                'action' => 'reservasi',
                'attempts' => 1,
                'window_start' => now(),
            ]);
        }

        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'required|string|size:16',
            'whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'jumlah_anggota' => 'required|integer|min:1|max:20',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'sesi_id' => 'required|exists:sesi_kunjungan,id',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'jumlah_anggota.required' => 'Jumlah anggota wajib diisi.',
            'jumlah_anggota.min' => 'Minimal 1 orang.',
            'jumlah_anggota.max' => 'Maksimal 20 orang per reservasi.',
            'tanggal_kunjungan.required' => 'Tanggal kunjungan wajib dipilih.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal tidak boleh di masa lalu.',
            'sesi_id.required' => 'Sesi kunjungan wajib dipilih.',
        ]);

        // Cek kuota sesi
        $sesi = SesiKunjungan::findOrFail($validated['sesi_id']);
        $sisaKuota = $sesi->sisaKuota($validated['tanggal_kunjungan']);

        if ($sisaKuota < $validated['jumlah_anggota']) {
            return back()->with('error', "Kuota sesi {$sesi->nama_sesi} tidak mencukupi. Sisa kuota: {$sisaKuota} orang.")->withInput();
        }

        // Generate kode tiket unik
        $kodeTiket = strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));

        // Simpan reservasi
        $reservasi = Reservasi::create([
            'kode_tiket' => $kodeTiket,
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'whatsapp' => $validated['whatsapp'],
            'email' => $validated['email'],
            'jumlah_anggota' => $validated['jumlah_anggota'],
            'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
            'sesi_id' => $validated['sesi_id'],
            'status' => 'valid',
            'ip_address' => $ip,
        ]);

        // Generate QR Code
        $qrDir = public_path('qrcodes/tiket');
        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0755, true);
        }

        $qrContent = json_encode([
            'kode' => $kodeTiket,
            'id' => $reservasi->id,
            'hash' => hash('sha256', $kodeTiket . $reservasi->id . env('APP_KEY')),
        ]);

        $qrPath = 'qrcodes/tiket/' . $kodeTiket . '.svg';
        QrCode::format('svg')->size(300)->errorCorrection('H')->generate($qrContent, public_path($qrPath));

        $reservasi->update(['qr_code_path' => $qrPath]);

        return redirect('/tiket/' . $kodeTiket);
    }

    public function show($kode)
    {
        $reservasi = Reservasi::where('kode_tiket', $kode)->with('sesi')->firstOrFail();
        return view('public.tiket-sukses', compact('reservasi'));
    }

    public function cekSlot(Request $request)
    {
        $tanggal = $request->input('tanggal');

        if (!$tanggal) {
            return response()->json([]);
        }

        $sesiList = SesiKunjungan::where('is_active', true)->get()->map(function ($sesi) use ($tanggal) {
            return [
                'id' => $sesi->id,
                'nama_sesi' => $sesi->nama_sesi,
                'jam_mulai' => $sesi->jam_mulai,
                'jam_selesai' => $sesi->jam_selesai,
                'kuota' => $sesi->kuota,
                'sisa_kuota' => $sesi->sisaKuota($tanggal),
            ];
        });

        return response()->json($sesiList);
    }
}
