<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\LogZonaScan;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan');
    }

    public function getData(Request $request)
    {
        $dari = $request->input('dari', now()->subDays(30)->format('Y-m-d'));
        $sampai = $request->input('sampai', now()->format('Y-m-d'));

        // Data kunjungan harian
        $kunjunganHarian = Reservasi::select(
            DB::raw('DATE(tanggal_kunjungan) as tanggal'),
            DB::raw('SUM(jumlah_anggota) as total')
        )
            ->where('status', 'telah_berkunjung')
            ->whereBetween('tanggal_kunjungan', [$dari, $sampai])
            ->groupBy(DB::raw('DATE(tanggal_kunjungan)'))
            ->orderBy('tanggal')
            ->get();

        // Zona terpopuler
        $zonaPopuler = LogZonaScan::select(
            'zona.nama_zona',
            DB::raw('COUNT(log_zona_scan.id) as total_scan')
        )
            ->join('zona', 'zona.id', '=', 'log_zona_scan.zona_id')
            ->whereBetween('log_zona_scan.scanned_at', [$dari, $sampai . ' 23:59:59'])
            ->groupBy('zona.nama_zona')
            ->orderByDesc('total_scan')
            ->take(10)
            ->get();

        return response()->json([
            'kunjunganHarian' => $kunjunganHarian,
            'zonaPopuler' => $zonaPopuler,
        ]);
    }
}
