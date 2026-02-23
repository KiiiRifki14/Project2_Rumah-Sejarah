<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BendaSejarah;

class BendaPublicController extends Controller
{
    public function show($id)
    {
        $benda = BendaSejarah::where('id', $id)->where('is_active', true)->with('zona')->firstOrFail();
        return view('public.benda', compact('benda'));
    }
}
