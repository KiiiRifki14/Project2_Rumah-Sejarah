<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zona;
use App\Models\LogZonaScan;

class ZonaPublicController extends Controller
{
    public function show($id)
    {
        $zona = Zona::where('id', $id)->where('is_active', true)->with(['bendaSejarah' => function ($q) {
            $q->where('is_active', true)->orderBy('urutan');
        }])->firstOrFail();

        // Catat scan zona
        LogZonaScan::create([
            'zona_id' => $zona->id,
            'scanned_at' => now(),
            'ip_address' => request()->ip(),
        ]);

        return view('public.zona', compact('zona'));
    }
}
