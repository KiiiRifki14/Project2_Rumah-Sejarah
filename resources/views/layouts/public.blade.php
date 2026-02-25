<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rumah Sejarah') - Museum Sejarah Lanud</title>
    <meta name="description" content="@yield('description', 'Rumah Sejarah - Museum Sejarah di Lanud. Pesan tiket kunjungan online dan jelajahi koleksi sejarah penerbangan Indonesia.')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4A843;
            --gold-light: #E8C97A;
            --gold-dark: #B8922F;
            --dark-bg: #0A0F1C;
            --dark-card: #111827;
            --dark-surface: #1A2332;
            --dark-border: #2A3544;
            --text-primary: #F1F5F9;
            --text-secondary: #94A3B8;
            --accent-blue: #3B82F6;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(10, 15, 28, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(212, 168, 67, 0.15);
            padding: 0.8rem 0;
            transition: all 0.3s ease;
        }

        .navbar-custom.scrolled {
            background: rgba(10, 15, 28, 0.95);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--gold) !important;
            letter-spacing: -0.02em;
        }

        .navbar-brand i {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 1rem !important;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--gold) !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 60%;
        }

        /* Buttons */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--dark-bg);
            border: none;
            font-weight: 700;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.9rem;
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 168, 67, 0.35);
            color: var(--dark-bg);
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
        }

        .btn-gold:active {
            transform: translateY(0);
        }

        .btn-outline-gold {
            border: 2px solid var(--gold);
            color: var(--gold);
            background: transparent;
            font-weight: 600;
            padding: 0.65rem 1.75rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-outline-gold:hover {
            background: var(--gold);
            color: var(--dark-bg);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 168, 67, 0.25);
        }

        /* Cards */
        .glass-card {
            background: rgba(26, 35, 50, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 168, 67, 0.1);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.4s ease;
        }

        .glass-card:hover {
            border-color: rgba(212, 168, 67, 0.3);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        /* Forms */
        .form-control-dark {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control-dark:focus {
            background: var(--dark-surface);
            border-color: var(--gold);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(212, 168, 67, 0.15);
        }

        .form-control-dark::placeholder {
            color: var(--text-secondary);
            opacity: 0.6;
        }

        .form-label {
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }

        /* Footer */
        .footer-custom {
            background: var(--dark-card);
            border-top: 1px solid rgba(212, 168, 67, 0.1);
            padding: 2rem 0;
            margin-top: 4rem;
        }

        .footer-custom p {
            color: var(--text-secondary);
            margin: 0;
            font-size: 0.9rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        /* Alerts */
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
        }

        .alert-success-custom {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-danger-custom {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--dark-border);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold-dark);
        }

        /* Mobile */
        .navbar-toggler {
            border-color: var(--gold) !important;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23D4A843' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        }

        @media (max-width: 768px) {
            .navbar-collapse {
                background: rgba(10, 15, 28, 0.95);
                padding: 1rem;
                border-radius: 12px;
                margin-top: 0.5rem;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-landmark me-2"></i>Rumah Sejarah
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                            <i class="fas fa-home me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link {{ request()->is('reservasi') ? 'active' : '' }}" href="/reservasi">
                            <i class="fas fa-ticket-alt me-1"></i> Pesan Tiket
                        </a>
                    </li>
                    @guest
                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="btn btn-outline-gold d-block" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Masuk
                        </a>
                    </li>
                    @else
                    <li class="nav-item dropdown mt-2 mt-lg-0">
                        <a class="nav-link dropdown-toggle btn btn-outline-gold d-flex align-items-center justify-content-between" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--gold) !important; padding-top: 0.65rem !important; padding-bottom: 0.65rem !important;">
                            <span><i class="fas fa-user-circle me-1"></i> {{ explode(' ', Auth::user()->name)[0] }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="navbarDropdown" style="background: var(--dark-surface); border: 1px solid var(--dark-border);">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger" style="font-weight: 500;">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main style="padding-top: 80px; min-height: calc(100vh - 120px);">
        @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-custom alert-success-custom animate-in">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-custom alert-danger-custom animate-in">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container text-center">
            <p><i class="fas fa-landmark me-1" style="color: var(--gold);"></i> &copy; {{ date('Y') }} Rumah Sejarah - Museum Sejarah Lanud. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    @yield('scripts')
</body>

</html>