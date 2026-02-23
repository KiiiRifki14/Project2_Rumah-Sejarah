@extends('layouts.admin')
@section('title', 'Edit Benda Sejarah')

@section('content')
<div class="top-bar">
    <h2><i class="fas fa-edit me-2" style="color:var(--gold);"></i>Edit Benda Sejarah</h2>
    <a href="/admin/benda" class="btn btn-outline-gold"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<div style="background:var(--dark-card);border:1px solid var(--dark-border);border-radius:14px;padding:2rem;max-width:700px;">
    @if($errors->any())
    <div class="alert alert-danger-custom mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="/admin/benda/{{ $benda->id }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Zona *</label>
            <select name="zona_id" class="form-select form-control-dark" required>
                @foreach($zonaList as $z)
                <option value="{{ $z->id }}" {{ $benda->zona_id == $z->id ? 'selected' : '' }}>{{ $z->nama_zona }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Benda *</label>
            <input type="text" name="nama_benda" class="form-control form-control-dark" value="{{ old('nama_benda', $benda->nama_benda) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi / Narasi Sejarah</label>
            <textarea name="deskripsi" class="form-control form-control-dark" rows="6">{{ old('deskripsi', $benda->deskripsi) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Benda</label>
            @if($benda->foto)
            <div class="mb-2"><img src="{{ asset($benda->foto) }}" style="width:120px;height:80px;object-fit:cover;border-radius:8px;"></div>
            @endif
            <input type="file" name="foto" class="form-control form-control-dark" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label">Audio Narasi</label>
            @if($benda->audio)
            <div class="mb-2"><audio controls style="width:100%;">
                    <source src="{{ asset($benda->audio) }}" type="audio/mpeg">
                </audio></div>
            @endif
            <input type="file" name="audio" class="form-control form-control-dark" accept="audio/*">
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Urutan Tampil</label>
                <input type="number" name="urutan" class="form-control form-control-dark" value="{{ old('urutan', $benda->urutan) }}">
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ $benda->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActive" style="color:var(--text-secondary);">Status Aktif</label>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-gold"><i class="fas fa-save me-2"></i>Perbarui</button>
        </div>
    </form>
</div>
@endsection