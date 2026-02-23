<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BendaSejarah;
use App\Models\Zona;

class AdminBendaController extends Controller
{
    public function index(Request $request)
    {
        $query = BendaSejarah::with('zona')->orderBy('zona_id')->orderBy('urutan');

        if ($request->filled('zona_id')) {
            $query->where('zona_id', $request->zona_id);
        }

        $bendaList = $query->get();
        $zonaList = Zona::orderBy('urutan')->get();

        return view('admin.benda.index', compact('bendaList', 'zonaList'));
    }

    public function create()
    {
        $zonaList = Zona::where('is_active', true)->orderBy('urutan')->get();
        return view('admin.benda.create', compact('zonaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'zona_id' => 'required|exists:zona,id',
            'nama_benda' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'audio' => 'nullable|file|mimes:mp3,wav,ogg|max:20480',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_benda_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/benda'), $fotoName);
            $validated['foto'] = 'uploads/benda/' . $fotoName;
        }

        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $audioName = time() . '_audio_' . $audio->getClientOriginalName();
            $audio->move(public_path('uploads/audio'), $audioName);
            $validated['audio'] = 'uploads/audio/' . $audioName;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        BendaSejarah::create($validated);

        return redirect('/admin/benda')->with('success', 'Benda sejarah berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $benda = BendaSejarah::findOrFail($id);
        $zonaList = Zona::where('is_active', true)->orderBy('urutan')->get();
        return view('admin.benda.edit', compact('benda', 'zonaList'));
    }

    public function update(Request $request, $id)
    {
        $benda = BendaSejarah::findOrFail($id);

        $validated = $request->validate([
            'zona_id' => 'required|exists:zona,id',
            'nama_benda' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'audio' => 'nullable|file|mimes:mp3,wav,ogg|max:20480',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            if ($benda->foto && file_exists(public_path($benda->foto))) {
                unlink(public_path($benda->foto));
            }
            $foto = $request->file('foto');
            $fotoName = time() . '_benda_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/benda'), $fotoName);
            $validated['foto'] = 'uploads/benda/' . $fotoName;
        }

        if ($request->hasFile('audio')) {
            if ($benda->audio && file_exists(public_path($benda->audio))) {
                unlink(public_path($benda->audio));
            }
            $audio = $request->file('audio');
            $audioName = time() . '_audio_' . $audio->getClientOriginalName();
            $audio->move(public_path('uploads/audio'), $audioName);
            $validated['audio'] = 'uploads/audio/' . $audioName;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $benda->update($validated);

        return redirect('/admin/benda')->with('success', 'Benda sejarah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $benda = BendaSejarah::findOrFail($id);

        if ($benda->foto && file_exists(public_path($benda->foto))) {
            unlink(public_path($benda->foto));
        }
        if ($benda->audio && file_exists(public_path($benda->audio))) {
            unlink(public_path($benda->audio));
        }

        $benda->delete();

        return redirect('/admin/benda')->with('success', 'Benda sejarah berhasil dihapus!');
    }
}
