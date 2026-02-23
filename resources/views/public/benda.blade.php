@extends('layouts.public')
@section('title', $benda->nama_benda)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav class="mb-4 animate-in">
                <a href="/zona/{{ $benda->zona->id }}" style="color:var(--gold);text-decoration:none;font-weight:500;">
                    <i class="fas fa-arrow-left me-2"></i>{{ $benda->zona->nama_zona }}
                </a>
            </nav>

            <!-- Foto Benda -->
            @if($benda->foto)
            <div class="mb-4 animate-in delay-1">
                <img src="{{ asset($benda->foto) }}" alt="{{ $benda->nama_benda }}"
                    style="width:100%;max-height:400px;object-fit:cover;border-radius:16px;border:1px solid var(--dark-border);">
            </div>
            @endif

            <!-- Judul & Info -->
            <div class="animate-in delay-2">
                <h1 style="font-weight:800;font-size:2rem;margin-bottom:0.5rem;">{{ $benda->nama_benda }}</h1>
                <p style="color:var(--text-secondary);font-size:0.9rem;margin-bottom:1.5rem;">
                    <i class="fas fa-map-marker-alt me-1" style="color:var(--gold);"></i>
                    {{ $benda->zona->nama_zona }}
                </p>
            </div>

            <!-- Audio Player -->
            @if($benda->audio)
            <div class="glass-card mb-4 animate-in delay-3" style="padding:1.2rem;">
                <div class="d-flex align-items-center mb-2">
                    <div style="width:45px;height:45px;border-radius:50%;background:rgba(212,168,67,0.15);display:flex;align-items:center;justify-content:center;margin-right:1rem;">
                        <i class="fas fa-headphones-alt" style="color:var(--gold);font-size:1.2rem;"></i>
                    </div>
                    <div>
                        <h6 style="margin:0;font-weight:700;">Narasi Audio</h6>
                        <small style="color:var(--text-secondary);">Dengarkan sambil melihat benda fisiknya</small>
                    </div>
                </div>
                <audio controls style="width:100%;border-radius:8px;margin-top:0.5rem;" preload="metadata">
                    <source src="{{ asset($benda->audio) }}" type="audio/mpeg">
                    Browser Anda tidak mendukung pemutar audio.
                </audio>
            </div>
            @endif

            <!-- Narasi Teks -->
            <div class="glass-card animate-in delay-3">
                <h4 style="font-weight:700;margin-bottom:1rem;color:var(--gold);">
                    <i class="fas fa-book-open me-2"></i>Sejarah & Narasi
                </h4>
                <div style="color:var(--text-secondary);line-height:1.9;font-size:1rem;">
                    {!! nl2br(e($benda->deskripsi ?? 'Belum ada narasi untuk benda ini.')) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection