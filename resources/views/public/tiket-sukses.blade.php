@extends('layouts.public')
@section('title', 'Detail Tiket')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="glass-card text-center animate-in">

                {{-- Flash messages --}}
                @if(session('success'))
                <div class="alert" style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);color:#10b981;border-radius:12px;margin-bottom:1.5rem;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert" style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#ef4444;border-radius:12px;margin-bottom:1.5rem;">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
                @endif
                @if(session('info'))
                <div class="alert" style="background:rgba(245,158,11,0.15);border:1px solid rgba(245,158,11,0.3);color:#f59e0b;border-radius:12px;margin-bottom:1.5rem;">
                    <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                </div>
                @endif

                {{-- Status icon --}}
                @if($reservasi->status === 'dibatalkan')
                <div style="width:80px;height:80px;border-radius:50%;background:rgba(239,68,68,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="fas fa-times-circle" style="font-size:2.5rem;color:#ef4444;"></i>
                </div>
                <h2 style="font-weight:800;margin-bottom:0.5rem;color:#ef4444;">Reservasi Dibatalkan</h2>
                <p style="color:var(--text-secondary);margin-bottom:2rem;">Tiket ini sudah tidak berlaku.</p>
                @else
                <div style="width:80px;height:80px;border-radius:50%;background:rgba(16,185,129,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="fas fa-check-circle" style="font-size:2.5rem;color:var(--success);"></i>
                </div>
                <h2 style="font-weight:800;margin-bottom:0.5rem;">Tiket Berhasil Dipesan!</h2>
                <p style="color:var(--text-secondary);margin-bottom:2rem;">Simpan atau screenshot QR Code di bawah ini sebagai tiket masuk.</p>
                @endif

                <!-- QR Code -->
                @if($reservasi->status !== 'dibatalkan' && $reservasi->qr_code_path)
                <div style="background:#fff;border-radius:16px;padding:1.5rem;display:inline-block;margin-bottom:1.5rem;">
                    <img id="qrImage" src="{{ asset($reservasi->qr_code_path) }}" alt="QR Code Tiket" style="width:250px;height:250px;">
                </div>
                @endif

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
                        <div class="col-12 mt-2">
                            <span style="color:var(--text-secondary);">Status:</span><br>
                            @if($reservasi->status === 'valid')
                            <span class="badge" style="background:rgba(16,185,129,0.2);color:#10b981;padding:0.4rem 0.8rem;">✅ Valid</span>
                            @elseif($reservasi->status === 'telah_berkunjung')
                            <span class="badge" style="background:rgba(59,130,246,0.2);color:#3b82f6;padding:0.4rem 0.8rem;">☑️ Telah Berkunjung</span>
                            @elseif($reservasi->status === 'dibatalkan')
                            <span class="badge" style="background:rgba(239,68,68,0.2);color:#ef4444;padding:0.4rem 0.8rem;">❌ Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    @if($reservasi->status !== 'dibatalkan' && $reservasi->qr_code_path)
                    <button type="button" class="btn btn-gold" id="btnDownload" onclick="downloadQrAsPng()">
                        <i class="fas fa-download me-2"></i>Download QR Code (PNG)
                    </button>
                    @endif

                    @if($reservasi->status === 'valid')
                    <button type="button" class="btn" style="background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.3);" onclick="showCancelForm()">
                        <i class="fas fa-times me-2"></i>Batalkan Reservasi
                    </button>
                    @endif

                    <a href="/" class="btn btn-outline-gold">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                </div>

                {{-- Cancel form (hidden by default) --}}
                @if($reservasi->status === 'valid')
                <div id="cancelForm" style="display:none;margin-top:1.5rem;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);border-radius:12px;padding:1.2rem;">
                    <h5 style="color:#ef4444;font-weight:700;margin-bottom:0.8rem;">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Pembatalan
                    </h5>
                    <p style="color:var(--text-secondary);font-size:0.9rem;margin-bottom:1rem;">
                        Masukkan NIK Anda untuk mengonfirmasi pembatalan reservasi. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <form action="{{ route('tiket.cancel', $reservasi->kode_tiket) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="nik" class="form-control" placeholder="Masukkan 16 digit NIK Anda"
                                maxlength="16" pattern="\d{16}" required
                                style="background:var(--dark-surface);border:1px solid rgba(239,68,68,0.3);color:var(--text-primary);border-radius:10px;padding:0.8rem;">
                        </div>
                        @if($errors->has('nik'))
                        <div style="color:#ef4444;font-size:0.85rem;margin-bottom:0.8rem;">{{ $errors->first('nik') }}</div>
                        @endif
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn flex-fill" style="background:#ef4444;color:#fff;" onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                <i class="fas fa-check me-1"></i>Ya, Batalkan
                            </button>
                            <button type="button" class="btn flex-fill" style="background:var(--dark-surface);color:var(--text-primary);" onclick="hideCancelForm()">
                                Tidak
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <div class="mt-3">
                    <small style="color:var(--text-secondary);">
                        <i class="fas fa-info-circle me-1"></i>
                        Tunjukkan QR Code ini kepada petugas di gerbang masuk museum.
                    </small>
                </div>

                <!-- Hidden canvas for SVG to PNG conversion -->
                <canvas id="qrCanvas" style="display:none;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showCancelForm() {
        document.getElementById('cancelForm').style.display = 'block';
        document.getElementById('cancelForm').scrollIntoView({
            behavior: 'smooth'
        });
    }

    function hideCancelForm() {
        document.getElementById('cancelForm').style.display = 'none';
    }

    function downloadQrAsPng() {
        const img = document.getElementById('qrImage');
        if (!img) return;

        const canvas = document.getElementById('qrCanvas');
        const ctx = canvas.getContext('2d');
        const size = 500;

        canvas.width = size;
        canvas.height = size;

        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, size, size);

        const tempImg = new Image();
        tempImg.crossOrigin = 'anonymous';

        tempImg.onload = function() {
            ctx.drawImage(tempImg, 0, 0, size, size);
            canvas.toBlob(function(blob) {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'tiket_{{ $reservasi->kode_tiket }}.png';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }, 'image/png');
        };

        tempImg.onerror = function() {
            const a = document.createElement('a');
            a.href = img.src;
            a.download = 'tiket_{{ $reservasi->kode_tiket }}.svg';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        };

        tempImg.src = img.src;
    }
</script>
@endsection