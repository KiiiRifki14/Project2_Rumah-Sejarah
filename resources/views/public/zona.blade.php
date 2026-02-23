@extends('layouts.public')
@section('title', $zona->nama_zona)

@section('content')
<div class="container py-5">
    <div class="text-center mb-5 animate-in">
        <div class="hero-badge" style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(212,168,67,0.1);border:1px solid rgba(212,168,67,0.2);padding:0.5rem 1.2rem;border-radius:50px;font-size:0.85rem;color:var(--gold);font-weight:500;">
            <i class="fas fa-map-marker-alt"></i> Zona Pameran
        </div>
        <h1 style="font-weight:800;font-size:2.5rem;margin-top:1rem;">{{ $zona->nama_zona }}</h1>
        @if($zona->deskripsi)
        <p style="color:var(--text-secondary);max-width:600px;margin:1rem auto 0;font-size:1.05rem;line-height:1.7;">{{ $zona->deskripsi }}</p>
        @endif
    </div>

    @if($zona->foto)
    <div class="text-center mb-5 animate-in delay-1">
        <img src="{{ asset($zona->foto) }}" alt="{{ $zona->nama_zona }}" style="max-width:100%;height:300px;object-fit:cover;border-radius:16px;border:1px solid var(--dark-border);">
    </div>
    @endif

    <h3 class="mb-4" style="font-weight:700;"><i class="fas fa-cubes me-2" style="color:var(--gold);"></i>Koleksi di Zona Ini</h3>

    @if($zona->bendaSejarah->count() > 0)
    <div class="row g-4">
        @foreach($zona->bendaSejarah as $index => $benda)
        <div class="col-md-4 col-sm-6">
            <a href="/benda/{{ $benda->id }}" style="text-decoration:none;color:inherit;">
                <div class="glass-card h-100" style="padding:0;overflow:hidden;cursor:pointer;">
                    @if($benda->foto)
                    <div style="height:200px;overflow:hidden;">
                        <img src="{{ asset($benda->foto) }}" alt="{{ $benda->nama_benda }}" style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s ease;">
                    </div>
                    @else
                    <div style="height:200px;background:var(--dark-surface);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-image" style="font-size:3rem;color:var(--dark-border);"></i>
                    </div>
                    @endif
                    <div style="padding:1.2rem;">
                        <h5 style="font-weight:700;margin-bottom:0.4rem;">{{ $benda->nama_benda }}</h5>
                        <p style="color:var(--text-secondary);font-size:0.85rem;margin:0;">
                            <i class="fas fa-headphones-alt me-1" style="color:var(--gold);"></i>
                            {{ $benda->audio ? 'Audio tersedia' : 'Teks narasi' }}
                        </p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @else
    <div class="glass-card text-center" style="padding:3rem;">
        <i class="fas fa-inbox" style="font-size:3rem;color:var(--dark-border);margin-bottom:1rem;"></i>
        <p style="color:var(--text-secondary);margin:0;">Belum ada koleksi di zona ini.</p>
    </div>
    @endif
</div>
@endsection