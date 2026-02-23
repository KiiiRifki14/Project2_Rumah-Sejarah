@extends('layouts.public')
@section('title', 'Tiket Berhasil Dipesan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="glass-card text-center animate-in">
                <div style="width:80px;height:80px;border-radius:50%;background:rgba(16,185,129,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="fas fa-check-circle" style="font-size:2.5rem;color:var(--success);"></i>
                </div>

                <h2 style="font-weight:800;margin-bottom:0.5rem;">Tiket Berhasil Dipesan!</h2>
                <p style="color:var(--text-secondary);margin-bottom:2rem;">Simpan atau screenshot QR Code di bawah ini sebagai tiket masuk.</p>

                <!-- QR Code -->
                <div style="background:#fff;border-radius:16px;padding:1.5rem;display:inline-block;margin-bottom:1.5rem;">
                    @if($reservasi->qr_code_path)
                    <img src="{{ asset($reservasi->qr_code_path) }}" alt="QR Code Tiket" style="width:250px;height:250px;">
                    @endif
                </div>

                <div style="background:var(--dark-surface);border-radius:12px;padding:1.2rem;margin-bottom:1.5rem;text-align:left;">
                    <div style="font-family:monospace;font-size:1.4rem;text-align:center;color:var(--gold);font-weight:700;letter-spacing:0.1em;margin-bottom:1rem;">
                        {{ $reservasi->kode_tiket }}
                    </div>
                    <div class="row g-2" style="font-size:0.9rem;">
                        <div class="col-6">
                            <span style="color:var(--text-secondary);">Nama:</span><br>
                            <strong>{{ $reservasi->nama }}</strong>
                        </div>
                        <div class="col-6">
                            <span style="color:var(--text-secondary);">Jumlah Anggota:</span><br>
                            <strong>{{ $reservasi->jumlah_anggota }} orang</strong>
                        </div>
                        <div class="col-6">
                            <span style="color:var(--text-secondary);">Tanggal:</span><br>
                            <strong>{{ $reservasi->tanggal_kunjungan->format('d M Y') }}</strong>
                        </div>
                        <div class="col-6">
                            <span style="color:var(--text-secondary);">Sesi:</span><br>
                            <strong>{{ $reservasi->sesi->nama_sesi ?? '-' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    @if($reservasi->qr_code_path)
                    <a href="{{ asset($reservasi->qr_code_path) }}" download="tiket_{{ $reservasi->kode_tiket }}.svg" class="btn btn-gold">
                        <i class="fas fa-download me-2"></i>Download QR Code
                    </a>
                    @endif
                    <a href="/" class="btn btn-outline-gold">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                </div>

                <div class="mt-3">
                    <small style="color:var(--text-secondary);">
                        <i class="fas fa-info-circle me-1"></i>
                        Tunjukkan QR Code ini kepada petugas di gerbang masuk museum.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection