<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SesiKunjungan;

class AdminSesiController extends Controller
{
    public function index()
    {
        $sesiList = SesiKunjungan::all();
        return view('admin.sesi.index', compact('sesiList'));
    }

    public function create()
    {
        return view('admin.sesi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sesi' => 'required|string|max:100',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kuota' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        SesiKunjungan::create($validated);

        return redirect('/admin/sesi')->with('success', 'Sesi kunjungan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $sesi = SesiKunjungan::findOrFail($id);
        $sesi->delete();
        return redirect('/admin/sesi')->with('success', 'Sesi kunjungan berhasil dihapus!');
    }
}
