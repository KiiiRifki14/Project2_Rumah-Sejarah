<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zona;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrGeneratorController extends Controller
{
    public function index()
    {
        $zonaList = Zona::orderBy('urutan')->get();
        return view('admin.qr-generator', compact('zonaList'));
    }

    public function generate($id)
    {
        $zona = Zona::findOrFail($id);

        $qrDir = public_path('qrcodes/zona');
        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0755, true);
        }

        $qrUrl = url('/zona/' . $zona->id);
        $qrPath = 'qrcodes/zona/zona_' . $zona->id . '.svg';

        // Hapus QR lama jika ada
        if (file_exists(public_path($qrPath))) {
            unlink(public_path($qrPath));
        }

        QrCode::format('svg')->size(500)->errorCorrection('H')->generate($qrUrl, public_path($qrPath));
        $zona->update(['qr_code_path' => $qrPath]);

        return back()->with('success', "QR Code untuk zona '{$zona->nama_zona}' berhasil di-generate!");
    }
}
