@extends('layouts.admin')
@section('title', 'Kelola Benda Sejarah')

@section('content')
<div class="top-bar">
    <h2><i class="fas fa-cubes me-2" style="color:var(--gold);"></i>Benda Sejarah</h2>
    <a href="/admin/benda/create" class="btn btn-gold"><i class="fas fa-plus me-2"></i>Tambah Benda</a>
</div>

<!-- Filter -->
<div class="mb-3">
    <form method="GET" class="d-flex gap-2">
        <select name="zona_id" class="form-select form-control-dark" style="max-width:250px;" onchange="this.form.submit()">
            <option value="">-- Semua Zona --</option>
            @foreach($zonaList as $z)
            <option value="{{ $z->id }}" {{ request('zona_id') == $z->id ? 'selected' : '' }}>{{ $z->nama_zona }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="table-dark-custom">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nama Benda</th>
                <th>Zona</th>
                <th>Audio</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bendaList as $b)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($b->foto)
                    <img src="{{ asset($b->foto) }}" style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                    @else
                    <div style="width:50px;height:50px;background:var(--dark-surface);border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-image" style="color:var(--dark-border);"></i></div>
                    @endif
                </td>
                <td><strong>{{ $b->nama_benda }}</strong></td>
                <td>{{ $b->zona->nama_zona ?? '-' }}</td>
                <td>{!! $b->audio ? '<i class="fas fa-headphones-alt" style="color:var(--success);"></i>' : '<span style="color:var(--text-secondary);">-</span>' !!}</td>
                <td>{!! $b->is_active ? '<span class="badge-valid">Aktif</span>' : '<span class="badge-used">Nonaktif</span>' !!}</td>
                <td>
                    <a href="/admin/benda/{{ $b->id }}/edit" class="btn btn-sm btn-outline-gold me-1"><i class="fas fa-edit"></i></a>
                    <form action="/admin/benda/{{ $b->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus benda ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="background:rgba(239,68,68,0.1);color:var(--danger);border:1px solid rgba(239,68,68,0.2);border-radius:8px;"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="color:var(--text-secondary);padding:2rem;">Belum ada benda sejarah.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection