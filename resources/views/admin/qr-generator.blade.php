@extends('layouts.admin')
@section('title', 'QR Generator Zona')

@section('content')
<div class="top-bar">
    <h2><i class="fas fa-qrcode me-2" style="color:var(--gold);"></i>QR Code Generator - Zona</h2>
</div>

<p style="color:var(--text-secondary);margin-bottom:2rem;">
    QR Code ini ditempelkan di setiap ruangan/zona museum agar pengunjung bisa scan dan melihat koleksi zona tersebut.
</p>

<div class="row g-4">
    @forelse($zonaList as $z)
    <div class="col-md-4 col-sm-6">
        <div class="stat-card text-center">
            <h5 style="font-weight:700;margin-bottom:1rem;">{{ $z->nama_zona }}</h5>
            @if($z->qr_code_path)
            <div style="background:#fff;border-radius:12px;padding:1rem;display:inline-block;margin-bottom:1rem;">
                <img src="{{ asset($z->qr_code_path) }}" alt="QR {{ $z->nama_zona }}" style="width:180px;height:180px;">
            </div>
            <div>
                <a href="{{ asset($z->qr_code_path) }}" download class="btn btn-sm btn-outline-gold me-1"><i class="fas fa-download me-1"></i>Download</a>
                <form action="/admin/qr-generator/{{ $z->id }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-gold"><i class="fas fa-sync me-1"></i>Regenerate</button>
                </form>
            </div>
            @else
            <div style="padding:2rem;color:var(--text-secondary);">
                <i class="fas fa-qrcode" style="font-size:3rem;color:var(--dark-border);"></i>
                <p class="mt-2">Belum ada QR Code</p>
            </div>
            <form action="/admin/qr-generator/{{ $z->id }}" method="POST">
                @csrf
                <button class="btn btn-gold"><i class="fas fa-plus me-1"></i>Generate QR</button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="stat-card text-center" style="padding:3rem;">
            <p style="color:var(--text-secondary);">Belum ada zona. <a href="/admin/zona/create" style="color:var(--gold);">Buat zona baru →</a></p>
        </div>
    </div>
    @endforelse
</div>
@endsection