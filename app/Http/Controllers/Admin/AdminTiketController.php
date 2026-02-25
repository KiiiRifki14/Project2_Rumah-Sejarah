<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;

class AdminTiketController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with('sesi')->latest();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_kunjungan', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode_tiket', 'like', "%{$search}%");
            });
        }

        $reservasiList = $query->paginate(20);

        return view('admin.tiket.index', compact('reservasiList'));
    }

    public function cancel($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        if ($reservasi->status === \App\Enums\ReservasiStatus::DIBATALKAN) {
            return back()->with('info', 'Reservasi ini sudah dibatalkan sebelumnya.');
        }

        $reservasi->update(['status' => \App\Enums\ReservasiStatus::DIBATALKAN->value]);

        // Hapus file QR code jika ada
        if ($reservasi->qr_code_path && \Illuminate\Support\Facades\Storage::exists($reservasi->qr_code_path)) {
            \Illuminate\Support\Facades\Storage::delete($reservasi->qr_code_path);
        }

        return back()->with('success', "Reservasi {$reservasi->kode_tiket} berhasil dibatalkan.");
    }
}
