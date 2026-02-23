@extends('layouts.public')
@section('title', 'Pesan Tiket Kunjungan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card animate-in">
                <div class="text-center mb-4">
                    <div class="feature-icon gold mx-auto" style="width:60px;height:60px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;background:rgba(212,168,67,0.15);color:var(--gold);">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h2 class="mt-3" style="font-weight: 800;">Pemesanan Tiket</h2>
                    <p style="color: var(--text-secondary);">Isi formulir berikut untuk memesan tiket kunjungan museum</p>
                </div>

                @if($errors->any())
                <div class="alert alert-custom alert-danger-custom mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('reservasi.store') }}" method="POST" id="formReservasi">
                    @csrf
                    <!-- Honeypot -->
                    <div style="position:absolute;left:-9999px;top:-9999px;">
                        <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-user me-1"></i> Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control form-control-dark" placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-id-card me-1"></i> NIK</label>
                            <input type="text" name="nik" class="form-control form-control-dark" placeholder="16 digit NIK" maxlength="16" value="{{ old('nik') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fab fa-whatsapp me-1"></i> Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control form-control-dark" placeholder="08xxxxxxxxxx" value="{{ old('whatsapp') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-envelope me-1"></i> Email</label>
                            <input type="email" name="email" class="form-control form-control-dark" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><i class="fas fa-users me-1"></i> Jumlah Rombongan</label>
                            <input type="number" name="jumlah_anggota" class="form-control form-control-dark" min="1" max="20" value="{{ old('jumlah_anggota', 1) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><i class="fas fa-calendar me-1"></i> Tanggal Kunjungan</label>
                            <input type="date" name="tanggal_kunjungan" id="tanggalKunjungan" class="form-control form-control-dark" min="{{ date('Y-m-d') }}" value="{{ old('tanggal_kunjungan') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><i class="fas fa-clock me-1"></i> Sesi Kunjungan</label>
                            <select name="sesi_id" id="sesiSelect" class="form-control form-control-dark" required>
                                <option value="">-- Pilih tanggal dulu --</option>
                            </select>
                        </div>
                    </div>

                    <div id="slotInfo" class="mt-3" style="display:none;">
                        <div class="glass-card" style="padding:1rem;background:rgba(16,185,129,0.08);border-color:rgba(16,185,129,0.15);">
                            <small style="color:var(--success);"><i class="fas fa-info-circle me-1"></i> <span id="slotInfoText"></span></small>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-gold btn-lg" id="btnSubmit">
                            <i class="fas fa-paper-plane me-2"></i>Pesan Tiket Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('tanggalKunjungan').addEventListener('change', function() {
        const tanggal = this.value;
        const select = document.getElementById('sesiSelect');
        const slotInfo = document.getElementById('slotInfo');

        if (!tanggal) return;

        select.innerHTML = '<option value="">Memuat sesi...</option>';

        fetch('{{ route("api.slot") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    tanggal: tanggal
                })
            })
            .then(res => res.json())
            .then(data => {
                select.innerHTML = '<option value="">-- Pilih Sesi --</option>';
                data.forEach(sesi => {
                    const disabled = sesi.sisa_kuota <= 0;
                    const opt = document.createElement('option');
                    opt.value = sesi.id;
                    opt.disabled = disabled;
                    opt.textContent = `${sesi.nama_sesi} (${sesi.jam_mulai} - ${sesi.jam_selesai}) — Sisa: ${sesi.sisa_kuota} orang${disabled ? ' [PENUH]' : ''}`;
                    select.appendChild(opt);
                });
            })
            .catch(() => {
                select.innerHTML = '<option value="">Gagal memuat sesi</option>';
            });
    });

    document.getElementById('sesiSelect').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const slotInfo = document.getElementById('slotInfo');
        const slotInfoText = document.getElementById('slotInfoText');
        if (this.value) {
            slotInfo.style.display = 'block';
            slotInfoText.textContent = selectedOption.textContent;
        } else {
            slotInfo.style.display = 'none';
        }
    });
</script>
@endsection