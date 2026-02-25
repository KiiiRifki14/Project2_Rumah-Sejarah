@extends('layouts.public')

@section('title', 'Beranda')
@section('description', 'Selamat datang di Rumah Sejarah - Museum bersejarah di Lanud. Pesan tiket kunjungan secara online.')

@section('styles')
<style>
    .hero-section {
        min-height: 90vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--dark-bg) 0%, #0D1526 50%, #111D30 100%);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(212, 168, 67, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.06) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 10s ease-in-out infinite reverse;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-30px);
        }
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(212, 168, 67, 0.1);
        border: 1px solid rgba(212, 168, 67, 0.2);
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-size: 0.85rem;
        color: var(--gold);
        font-weight: 500;
        margin-bottom: 1.5rem;
    }

    .hero-title {
        font-family: 'Outfit', sans-serif;
        font-size: 3.8rem;
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        letter-spacing: -0.03em;
    }

    .hero-title .gold-text {
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
        font-size: 1.15rem;
        color: var(--text-secondary);
        line-height: 1.7;
        max-width: 520px;
        margin-bottom: 2.5rem;
    }

    .hero-stats {
        display: flex;
        gap: 3rem;
        margin-top: 3rem;
    }

    .hero-stat-item h3 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--gold);
        margin-bottom: 0.2rem;
    }

    .hero-stat-item p {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 500;
    }

    .feature-section {
        padding: 5rem 0;
    }

    .section-title {
        text-align: center;
        margin-bottom: 3.5rem;
    }

    .section-title h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
    }

    .section-title p {
        color: var(--text-secondary);
        font-size: 1.05rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.2rem;
    }

    .feature-icon.gold {
        background: rgba(212, 168, 67, 0.15);
        color: var(--gold);
    }

    .feature-icon.blue {
        background: rgba(59, 130, 246, 0.15);
        color: var(--accent-blue);
    }

    .feature-icon.green {
        background: rgba(16, 185, 129, 0.15);
        color: var(--success);
    }

    .feature-card h4 {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.6rem;
    }

    .feature-card p {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .cta-section {
        padding: 5rem 0;
    }

    .cta-box {
        background: linear-gradient(135deg, rgba(212, 168, 67, 0.1), rgba(59, 130, 246, 0.05));
        border: 1px solid rgba(212, 168, 67, 0.15);
        border-radius: 24px;
        padding: 4rem 3rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.4rem;
        }

        .hero-stats {
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .cta-box {
            padding: 2.5rem 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="animate-in">
                    <div class="hero-badge">
                        <i class="fas fa-shield-alt"></i> Museum Resmi Lanud
                    </div>
                </div>
                <h1 class="hero-title animate-in delay-1">
                    Jelajahi Warisan<br>
                    <span class="gold-text">Sejarah Penerbangan</span><br>
                    Indonesia
                </h1>
                <p class="hero-subtitle animate-in delay-2">
                    Nikmati pengalaman unik menelusuri sejarah penerbangan militer Indonesia
                    melalui koleksi benda bersejarah, narasi mendalam, dan panduan audio interaktif.
                </p>
                <div class="animate-in delay-3">
                    <a href="/reservasi" class="btn btn-gold me-3">
                        <i class="fas fa-ticket-alt me-2"></i>Pesan Tiket Sekarang
                    </a>
                </div>
                <div class="hero-stats animate-in delay-3">
                    <div class="hero-stat-item">
                        <h3>100+</h3>
                        <p>Koleksi Benda</p>
                    </div>
                    <div class="hero-stat-item">
                        <h3>10+</h3>
                        <p>Zona Pameran</p>
                    </div>
                    <div class="hero-stat-item">
                        <h3>Gratis</h3>
                        <p>Tiket Masuk</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <div style="position:relative;">
                    <div style="width:320px;height:320px;margin:0 auto;border-radius:50%;background:linear-gradient(135deg,rgba(212,168,67,0.1),rgba(59,130,246,0.05));display:flex;align-items:center;justify-content:center;border:1px solid rgba(212,168,67,0.15);">
                        <i class="fas fa-fighter-jet" style="font-size:8rem;color:var(--gold);opacity:0.6;transform:rotate(-30deg);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="feature-section">
    <div class="container">
        <div class="section-title">
            <h2>Kenapa <span style="color: var(--gold);">Rumah Sejarah?</span></h2>
            <p>Kami menghadirkan pengalaman museum modern yang memadukan teknologi digital dengan kekayaan sejarah.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="glass-card feature-card h-100">
                    <div class="feature-icon gold"><i class="fas fa-qrcode"></i></div>
                    <h4>E-Ticket & QR Code</h4>
                    <p>Pesan tiket secara online, dapatkan QR Code unik, dan masuk tanpa antri panjang di gerbang museum.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card feature-card h-100">
                    <div class="feature-icon blue"><i class="fas fa-headphones-alt"></i></div>
                    <h4>Panduan Audio Interaktif</h4>
                    <p>Scan QR di setiap ruangan, dapatkan narasi sejarah mendalam dan audio guide langsung di HP Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card feature-card h-100">
                    <div class="feature-icon green"><i class="fas fa-shield-alt"></i></div>
                    <h4>Aman & Terkendali</h4>
                    <p>Sistem kuota per sesi mencegah penumpukan, dan tiket QR terenkripsi menjamin keamanan akses.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-box">
            <h2 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 1rem;">Siap Menjelajahi Sejarah?</h2>
            <p style="color: var(--text-secondary); font-size: 1.1rem; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
                Pesan tiket kunjungan Anda sekarang. Pilih tanggal dan sesi yang tersedia, dan rasakan pengalaman museum yang berbeda.
            </p>
            <a href="/reservasi" class="btn btn-gold btn-lg">
                <i class="fas fa-arrow-right me-2"></i>Pesan Tiket Gratis
            </a>
        </div>
    </div>
</section>
@endsection