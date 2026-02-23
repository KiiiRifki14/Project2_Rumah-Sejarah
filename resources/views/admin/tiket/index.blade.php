@extends('layouts.admin')
@section('title', 'Daftar Tiket')

@section('content')
<div class="top-bar">
    <h2><i class="fas fa-ticket-alt me-2" style="color:var(--gold);"></i>Daftar Tiket / Reservasi</h2>
</div>

<!-- Filter -->
<div class="mb-3" style="background:var(--dark-card);border:1px solid var(--dark-border);border-radius:14px;padding:1.2rem;">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control form-control-dark" value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select form-control-dark">
                <option value="">Semua</option>
                <option value="valid" {{ request('status') == 'valid' ? 'selected' : '' }}>Valid</option>
                <option value="telah_berkunjung" {{ request('status') == 'telah_berkunjung' ? 'selected' : '' }}>Telah Berkunjung</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Cari</label>
            <input type="text" name="search" class="form-control form-control-dark" placeholder="Nama / kode tiket..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-gold w-100"><i class="fas fa-filter me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="table-dark-custom">
    <table class="table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>WhatsApp</th>
                <th>Tanggal</th>
                <th>Sesi</th>
                <th>Jml</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasiList as $r)
            <tr>
                <td><code style="color:var(--gold);">{{ $r->kode_tiket }}</code></td>
                <td>{{ $r->nama }}</td>
                <td>{{ $r->whatsapp }}</td>
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
                <td colspan="7" class="text-center" style="color:var(--text-secondary);padding:2rem;">Belum ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($reservasiList->hasPages())
<div class="mt-3">{{ $reservasiList->withQueryString()->links() }}</div>
@endif
@endsection