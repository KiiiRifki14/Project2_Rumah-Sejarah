@extends('layouts.admin')
@section('title', 'Sesi Kunjungan')

@section('content')
<div class="top-bar">
    <h2><i class="fas fa-clock me-2" style="color:var(--gold);"></i>Sesi Kunjungan</h2>
    <a href="/admin/sesi/create" class="btn btn-gold"><i class="fas fa-plus me-2"></i>Tambah Sesi</a>
</div>

<div class="table-dark-custom">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Sesi</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Kuota</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sesiList as $s)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $s->nama_sesi }}</strong></td>
                <td>{{ $s->jam_mulai }}</td>
                <td>{{ $s->jam_selesai }}</td>
                <td>{{ $s->kuota }} orang</td>
                <td>{!! $s->is_active ? '<span class="badge-valid">Aktif</span>' : '<span class="badge-used">Nonaktif</span>' !!}</td>
                <td>
                    <form action="/admin/sesi/{{ $s->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus sesi ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="background:rgba(239,68,68,0.1);color:var(--danger);border:1px solid rgba(239,68,68,0.2);border-radius:8px;"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="color:var(--text-secondary);padding:2rem;">Belum ada sesi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection