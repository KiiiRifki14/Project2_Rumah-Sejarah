@extends('layouts.gatekeeper')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="font-weight:800;margin:0;"><i class="fas fa-qrcode me-2" style="color:var(--gold);"></i>Scanner Tiket</h3>
        <form action="{{ route('gatekeeper.logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.1);color:var(--danger);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:0.5rem 1rem;">
                <i class="fas fa-sign-out-alt me-1"></i>Keluar
            </button>
        </form>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="glass-card">
                <h5 style="font-weight:700;margin-bottom:1rem;"><i class="fas fa-camera me-2" style="color:var(--gold);"></i>Arahkan Kamera ke QR Code</h5>
                <div id="qr-reader" style="width:100%;border-radius:12px;overflow:hidden;"></div>
                <div class="mt-3 text-center">
                    <small style="color:var(--text-secondary);">Atau masukkan kode tiket secara manual:</small>
                    <div class="input-group mt-2">
                        <input type="text" id="manualCode" class="form-control form-control-dark" placeholder="Masukkan kode tiket...">
                        <button class="btn btn-gold" onclick="validateManual()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div id="resultPanel" class="glass-card" style="min-height:300px;display:flex;align-items:center;justify-content:center;">
                <div class="text-center">
                    <i class="fas fa-qrcode" style="font-size:4rem;color:var(--dark-border);margin-bottom:1rem;"></i>
                    <p style="color:var(--text-secondary);margin:0;">Scan QR Code untuk memvalidasi tiket</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function showResult(data) {
        const panel = document.getElementById('resultPanel');

        if (data.success) {
            panel.innerHTML = `
            <div class="text-center w-100">
                <div style="width:80px;height:80px;border-radius:50%;background:rgba(16,185,129,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="fas fa-check-circle" style="font-size:2.5rem;color:var(--success);"></i>
                </div>
                <h4 style="color:var(--success);font-weight:800;">${data.message}</h4>
                <div style="background:var(--dark-surface);border-radius:12px;padding:1rem;margin-top:1rem;text-align:left;">
                    <p style="margin:0.3rem 0;"><strong>Nama:</strong> ${data.data.nama}</p>
                    <p style="margin:0.3rem 0;"><strong>Kode:</strong> ${data.data.kode_tiket}</p>
                    <p style="margin:0.3rem 0;"><strong>Jumlah:</strong> ${data.data.jumlah_anggota} orang</p>
                    <p style="margin:0.3rem 0;"><strong>Tanggal:</strong> ${data.data.tanggal_kunjungan}</p>
                    <p style="margin:0.3rem 0;"><strong>Sesi:</strong> ${data.data.sesi}</p>
                </div>
            </div>`;
            panel.style.borderColor = 'rgba(16,185,129,0.3)';
        } else {
            panel.innerHTML = `
            <div class="text-center w-100">
                <div style="width:80px;height:80px;border-radius:50%;background:rgba(239,68,68,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="fas fa-times-circle" style="font-size:2.5rem;color:var(--danger);"></i>
                </div>
                <h4 style="color:var(--danger);font-weight:800;">${data.message}</h4>
                ${data.data ? `<p style="color:var(--text-secondary);margin-top:0.5rem;">Nama: ${data.data.nama} | Kode: ${data.data.kode_tiket}</p>` : ''}
            </div>`;
            panel.style.borderColor = 'rgba(239,68,68,0.3)';
        }
    }

    function validateTicket(kode) {
        fetch('{{ route("gatekeeper.validate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    kode: kode
                })
            })
            .then(res => res.json())
            .then(data => showResult(data))
            .catch(err => showResult({
                success: false,
                message: 'Gagal memvalidasi tiket.'
            }));
    }

    function validateManual() {
        const code = document.getElementById('manualCode').value.trim();
        if (code) validateTicket(code);
    }

    // QR Scanner
    const html5QrCode = new Html5Qrcode("qr-reader");
    html5QrCode.start({
            facingMode: "environment"
        }, {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            }
        },
        (decodedText) => {
            html5QrCode.pause();
            validateTicket(decodedText);
            setTimeout(() => {
                html5QrCode.resume();
            }, 3000);
        },
        (errorMessage) => {}
    ).catch((err) => {
        document.getElementById('qr-reader').innerHTML = '<div class="text-center p-4"><p style="color:var(--text-secondary);"><i class="fas fa-camera-slash me-2"></i>Kamera tidak tersedia. Gunakan input manual di bawah.</p></div>';
    });
</script>
@endsection