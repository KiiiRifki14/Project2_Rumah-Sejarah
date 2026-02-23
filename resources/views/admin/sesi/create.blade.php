@extends('layouts.admin')
@section('title', 'Tambah Sesi')

@section('content')
<div class="top-bar">
    <h2><i class="fas fa-plus me-2" style="color:var(--gold);"></i>Tambah Sesi Kunjungan</h2>
    <a href="/admin/sesi" class="btn btn-outline-gold"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
</div>

<div style="background:var(--dark-card);border:1px solid var(--dark-border);border-radius:14px;padding:2rem;max-width:600px;">
    @if($errors->any())
    <div class="alert alert-danger-custom mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.sesi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Sesi *</label>
            <input type="text" name="nama_sesi" class="form-control form-control-dark" value="{{ old('nama_sesi') }}" placeholder="Contoh: Sesi Pagi" required>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Jam Mulai *</label>
                <input type="time" name="jam_mulai" class="form-control form-control-dark" value="{{ old('jam_mulai') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Jam Selesai *</label>
                <input type="time" name="jam_selesai" class="form-control form-control-dark" value="{{ old('jam_selesai') }}" required>
            </div>
        </div>
        <div class="row g-3 mt-1">
            <div class="col-md-6">
                <label class="form-label">Kuota per Sesi *</label>
                <input type="number" name="kuota" class="form-control form-control-dark" value="{{ old('kuota', 50) }}" min="1" required>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" checked>
                    <label class="form-check-label" for="isActive" style="color:var(--text-secondary);">Status Aktif</label>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-gold"><i class="fas fa-save me-2"></i>Simpan Sesi</button>
        </div>
    </form>
</div>
@endsection