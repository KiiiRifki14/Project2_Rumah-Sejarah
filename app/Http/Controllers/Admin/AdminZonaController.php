<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zona;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminZonaController extends Controller
{
    public function index()
    {
        $zonaList = Zona::orderBy('urutan')->get();
        return view('admin.zona.index', compact('zonaList'));
    }

    public function create()
    {
        return view('admin.zona.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_zona' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/zona'), $fotoName);
            $validated['foto'] = 'uploads/zona/' . $fotoName;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $zona = Zona::create($validated);

        // Auto-generate QR code untuk zona
        $qrDir = public_path('qrcodes/zona');
        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0755, true);
        }

        $qrUrl = url('/zona/' . $zona->id);
        $qrPath = 'qrcodes/zona/zona_' . $zona->id . '.svg';
        QrCode::format('svg')->size(400)->errorCorrection('H')->generate($qrUrl, public_path($qrPath));
        $zona->update(['qr_code_path' => $qrPath]);

        return redirect('/admin/zona')->with('success', 'Zona berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $zona = Zona::findOrFail($id);
        return view('admin.zona.edit', compact('zona'));
    }

    public function update(Request $request, $id)
    {
        $zona = Zona::findOrFail($id);

        $validated = $request->validate([
            'nama_zona' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($zona->foto && file_exists(public_path($zona->foto))) {
                unlink(public_path($zona->foto));
            }
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/zona'), $fotoName);
            $validated['foto'] = 'uploads/zona/' . $fotoName;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $zona->update($validated);

        return redirect('/admin/zona')->with('success', 'Zona berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $zona = Zona::findOrFail($id);

        if ($zona->foto && file_exists(public_path($zona->foto))) {
            unlink(public_path($zona->foto));
        }
        if ($zona->qr_code_path && file_exists(public_path($zona->qr_code_path))) {
            unlink(public_path($zona->qr_code_path));
        }

        $zona->delete();

        return redirect('/admin/zona')->with('success', 'Zona berhasil dihapus!');
    }
}
