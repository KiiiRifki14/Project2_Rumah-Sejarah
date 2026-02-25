@extends('layouts.public')

@section('title', 'Daftar Pengunjung')

@section('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        background: linear-gradient(135deg, var(--dark-bg) 0%, #0D1526 50%, #111D30 100%);
    }

    .auth-card {
        background: rgba(17, 24, 39, 0.8);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(212, 168, 67, 0.2);
        border-radius: 20px;
        padding: 3rem;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .auth-header h2 {
        color: var(--gold);
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .auth-header p {
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .form-floating>.form-control-dark {
        background-color: var(--dark-surface);
        border-color: var(--dark-border);
        color: var(--text-primary);
    }

    .form-floating>.form-control-dark:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 0.25rem rgba(212, 168, 67, 0.25);
    }

    .form-floating>label {
        color: var(--text-secondary);
    }

    .btn-auth {
        width: 100%;
        padding: 1rem;
        font-size: 1.1rem;
        border-radius: 12px;
        margin-top: 1rem;
    }

    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .auth-footer a {
        color: var(--gold);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .auth-footer a:hover {
        color: var(--gold-light);
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-card animate-in">
        <div class="auth-header">
            <h2>Buat Akun</h2>
            <p>Daftar sebagai pengunjung Rumah Sejarah untuk keperluan reservasi tiket.</p>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger-custom mb-4">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-dark" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus autocomplete="name">
                <label for="name">Nama Lengkap</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control form-control-dark" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email">
                <label for="email">Alamat Email</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control form-control-dark" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                <label for="password">Kata Sandi (Min: 8 Karakter)</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control form-control-dark" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required autocomplete="new-password">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            </div>

            <button class="btn btn-gold btn-auth" type="submit">
                <i class="fas fa-user-plus me-2"></i> Daftar Akun
            </button>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection