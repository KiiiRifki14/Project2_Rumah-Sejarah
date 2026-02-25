<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\SesiKunjungan;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\RateLimit;
use App\Http\Requests\StoreReservasiRequest;

class ReservasiController extends Controller
{
    public function create()
    {
        $sesiList = SesiKunjungan::where('is_active', true)->get();
        return view('public.reservasi', compact('sesiList'));
    }

    public function store(StoreReservasiRequest $request)
    {
        // Honeypot check
        if ($request->filled('website_url')) {
            return redirect('/reservasi')->with('success', 'Tiket berhasil dipesan!');
        }

        // Rate limiting digantikan middleware throttle


        // Dapatkan semua data validasi
        $validated = $request->validated();

        return \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $request) {
            // Cek kuota sesi dengan lock
            $sesi = SesiKunjungan::lockForUpdate()->findOrFail($validated['sesi_id']);
            $sisaKuota = $sesi->sisaKuota($validated['tanggal_kunjungan']);

            if ($sisaKuota < $validated['jumlah_anggota']) {
                return back()->with('error', "Kuota sesi {$sesi->nama_sesi} tidak mencukupi. Sisa kuota: {$sisaKuota} orang.")->withInput();
            }

            // Cek duplikat: NIK + tanggal + sesi yang sama
            $existing = Reservasi::where('nik', $validated['nik'])
                ->where('tanggal_kunjungan', $validated['tanggal_kunjungan'])
                ->where('sesi_id', $validated['sesi_id'])
                ->whereIn('status', ['valid', 'telah_berkunjung'])
                ->first();

            if ($existing) {
                return redirect('/tiket/' . $existing->kode_tiket)
                    ->with('info', 'Anda sudah memiliki reservasi untuk tanggal dan sesi ini.');
            }

            // Generate kode tiket unik
            do {
                $kodeTiket = strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
            } while (Reservasi::where('kode_tiket', $kodeTiket)->exists());

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
                'ip_address' => $request->ip(),
            ]);

            // Generate QR Code menggunakan Storage builtin
            $qrContent = json_encode([
                'kode' => $kodeTiket,
                'id' => $reservasi->id,
                'hash' => hash('sha256', $kodeTiket . $reservasi->id . config('app.key')),
            ]);

            $qrPath = 'private/tickets/' . $kodeTiket . '.svg';
            $qrSvg = QrCode::format('svg')->size(300)->errorCorrection('H')->generate($qrContent);

            Storage::put($qrPath, $qrSvg);

            $reservasi->update(['qr_code_path' => $qrPath]);

            return redirect('/tiket/' . $kodeTiket);
        });
    }

    public function show($kode)
    {
        $reservasi = Reservasi::where('kode_tiket', $kode)->with('sesi')->firstOrFail();
        return view('public.tiket-sukses', compact('reservasi'));
    }

    public function cancel(Request $request, $kode)
    {
        $request->validate([
            'nik' => 'required|string|size:16',
        ], [
            'nik.required' => 'NIK wajib diisi untuk konfirmasi pembatalan.',
            'nik.size' => 'NIK harus 16 digit.',
        ]);

        $reservasi = Reservasi::where('kode_tiket', $kode)->firstOrFail();

        // Verifikasi NIK pemilik tiket
        if ($reservasi->nik !== $request->nik) {
            return back()->with('error', 'NIK tidak sesuai dengan data reservasi.');
        }

        if ($reservasi->status === 'dibatalkan') {
            return back()->with('info', 'Reservasi ini sudah dibatalkan sebelumnya.');
        }

        if ($reservasi->status === 'telah_berkunjung') {
            return back()->with('error', 'Reservasi yang sudah digunakan tidak dapat dibatalkan.');
        }

        $reservasi->update(['status' => 'dibatalkan']);

        // Hapus file QR code
        if ($reservasi->qr_code_path && file_exists(storage_path($reservasi->qr_code_path))) {
            unlink(storage_path($reservasi->qr_code_path));
        }

        return redirect('/tiket/' . $kode)->with('success', 'Reservasi berhasil dibatalkan.');
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

    public function showQr($kode)
    {
        $reservasi = Reservasi::where('kode_tiket', $kode)->firstOrFail();

        $path = storage_path($reservasi->qr_code_path);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }
}
