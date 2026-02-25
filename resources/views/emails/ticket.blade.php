<x-mail::message>
    # Tiket Reservasi Anda

    Halo **{{ $reservasi->nama }}**,
    Terima kasih telah melakukan reservasi kunjungan. Berikut adalah rincian e-ticket Anda:

    - **Kode Tiket**: `{{ $reservasi->kode_tiket }}`
    - **Tanggal Kunjungan**: {{ $reservasi->tanggal_kunjungan->format('d M Y') }}
    - **Sesi Waktu**: {{ $reservasi->sesi->nama_sesi ?? '-' }} ({{ $reservasi->sesi->jam_mulai ?? '-' }} - {{ $reservasi->sesi->jam_selesai ?? '-' }})
    - **Jumlah Personal**: {{ $reservasi->jumlah_anggota }} Orang

    > **QR Code Tiket** telah kami lampirkan bersama email ini (file `.svg`). Silakan tunjukkan file QR Code tersebut kepada petugas gerbang saat Anda tiba, atau buka detail tiket langsung lewat website:

    <x-mail::button :url="url('/tiket/' . $reservasi->kode_tiket)">
        Lihat Tiket Online
    </x-mail::button>

    Terima kasih,<br>
    Manajemen {{ config('app.name') }}
</x-mail::message>