@extends('layouts.admin')
@section('title', 'Kelola Zona')

@section('content')
<div class="top-bar">
    <h2><i class="fas fa-map me-2" style="color:var(--gold);"></i>Zona / Ruangan</h2>
    <a href="/admin/zona/create" class="btn btn-gold"><i class="fas fa-plus me-2"></i>Tambah Zona</a>
</div>

<div class="table-dark-custom">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nama Zona</th>
                <th>Jumlah Benda</th>
                <th>Urutan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($zonaList as $z)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($z->foto)
                    <img src="{{ asset($z->foto) }}" style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                    @else
                    <div style="width:50px;height:50px;background:var(--dark-surface);border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-image" style="color:var(--dark-border);"></i></div>
                    @endif
                </td>
                <td><strong>{{ $z->nama_zona }}</strong></td>
                <td>{{ $z->bendaSejarah->count() }} benda</td>
                <td>{{ $z->urutan }}</td>
                <td>{!! $z->is_active ? '<span class="badge-valid">Aktif</span>' : '<span class="badge-used">Nonaktif</span>' !!}</td>
                <td>
                    <a href="/admin/zona/{{ $z->id }}/edit" class="btn btn-sm btn-outline-gold me-1"><i class="fas fa-edit"></i></a>
                    <form action="/admin/zona/{{ $z->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus zona ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="background:rgba(239,68,68,0.1);color:var(--danger);border:1px solid rgba(239,68,68,0.2);border-radius:8px;"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="color:var(--text-secondary);padding:2rem;">Belum ada zona.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection