@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="top-bar">
    <h2><i class="fas fa-th-large me-2" style="color:var(--gold);"></i>Dashboard</h2>
    <span style="color:var(--text-secondary);">{{ now()->translatedFormat('l, d F Y') }}</span>
</div>

<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(212,168,67,0.15);color:var(--gold);"><i class="fas fa-ticket-alt"></i></div>
            <h3>{{ $totalTiketHariIni }}</h3>
            <p>Tiket Hari Ini</p>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(16,185,129,0.15);color:var(--success);"><i class="fas fa-users"></i></div>
            <h3>{{ $totalPengunjungHariIni }}</h3>
            <p>Pengunjung Hari Ini</p>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(59,130,246,0.15);color:#3B82F6;"><i class="fas fa-map"></i></div>
            <h3>{{ $totalZona }}</h3>
            <p>Total Zona</p>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(139,92,246,0.15);color:#8B5CF6;"><i class="fas fa-cubes"></i></div>
            <h3>{{ $totalBenda }}</h3>
            <p>Koleksi Benda</p>
        </div>
    </div>
</div>

<!-- Recent -->
<div class="table-dark-custom">
    <div style="padding:1rem 1.5rem;border-bottom:1px solid var(--dark-border);">
        <h5 style="font-weight:700;margin:0;"><i class="fas fa-history me-2" style="color:var(--gold);"></i>Reservasi Terbaru</h5>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Sesi</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentReservasi as $r)
            <tr>
                <td><code style="color:var(--gold);">{{ $r->kode_tiket }}</code></td>
                <td>{{ $r->nama }}</td>
                <td>{{ $r->tanggal_kunjungan->format('d/m/Y') }}</td>
                <td>{{ $r->sesi->nama_sesi ?? '-' }}</td>
                <td>{{ $r->jumlah_anggota }}</td>
                <td>
                    @if($r->status === 'valid') <span class="badge-valid">Valid</span>
                    @elseif($r->status === 'telah_berkunjung') <span class="badge-used">Telah Berkunjung</span>
                    @else <span class="badge-pending">Pending</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="color:var(--text-secondary);padding:2rem;">Belum ada reservasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection