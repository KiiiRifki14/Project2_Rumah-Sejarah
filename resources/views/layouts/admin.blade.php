<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Rumah Sejarah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4A843;
            --gold-light: #E8C97A;
            --dark-bg: #0A0F1C;
            --dark-card: #111827;
            --dark-surface: #1A2332;
            --dark-border: #2A3544;
            --text-primary: #F1F5F9;
            --text-secondary: #94A3B8;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --sidebar-w: 260px;
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
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
        }

        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--dark-card);
            border-right: 1px solid rgba(212, 168, 67, 0.1);
            padding: 1.5rem 0;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(212, 168, 67, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar-brand h4 {
            color: var(--gold);
            font-weight: 800;
            font-size: 1.2rem;
            margin: 0;
        }

        .sidebar-brand small {
            color: var(--text-secondary);
            font-size: 0.8rem;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
        }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.7rem 1.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-nav li a:hover,
        .sidebar-nav li a.active {
            color: var(--gold);
            background: rgba(212, 168, 67, 0.05);
            border-left-color: var(--gold);
        }

        .sidebar-nav li a i {
            width: 20px;
            text-align: center;
        }

        .sidebar-section {
            padding: 0.5rem 1.5rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: var(--text-secondary);
            letter-spacing: 0.1em;
            margin-top: 0.5rem;
        }

        .main-content {
            margin-left: var(--sidebar-w);
            padding: 2rem;
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--dark-border);
        }

        .top-bar h2 {
            font-weight: 800;
            font-size: 1.6rem;
        }

        .stat-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 14px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: rgba(212, 168, 67, 0.2);
            transform: translateY(-2px);
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .stat-card h3 {
            font-size: 1.8rem;
            font-weight: 800;
        }

        .stat-card p {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin: 0;
        }

        .table-dark-custom {
            background: var(--dark-card);
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--dark-border);
        }

        .table-dark-custom table {
            margin: 0;
            color: var(--text-primary);
        }

        .table-dark-custom th {
            background: var(--dark-surface);
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-color: var(--dark-border);
            padding: 1rem;
        }

        .table-dark-custom td {
            border-color: var(--dark-border);
            padding: 0.8rem 1rem;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table-dark-custom tr:hover td {
            background: rgba(212, 168, 67, 0.03);
        }

        .badge-valid {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            padding: 0.3rem 0.7rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-pending {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
            padding: 0.3rem 0.7rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-used {
            background: rgba(148, 163, 184, 0.15);
            color: var(--text-secondary);
            padding: 0.3rem 0.7rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), #B8922F);
            color: var(--dark-bg);
            border: none;
            font-weight: 700;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
        }

        .btn-gold:hover {
            color: var(--dark-bg);
            box-shadow: 0 4px 15px rgba(212, 168, 67, 0.3);
        }

        .btn-outline-gold {
            border: 1px solid var(--gold);
            color: var(--gold);
            background: transparent;
            font-weight: 600;
            padding: 0.5rem 1.2rem;
            border-radius: 10px;
        }

        .btn-outline-gold:hover {
            background: var(--gold);
            color: var(--dark-bg);
        }

        .form-control-dark {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 0.7rem 1rem;
        }

        .form-control-dark:focus {
            background: var(--dark-surface);
            border-color: var(--gold);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(212, 168, 67, 0.15);
        }

        .form-select.form-control-dark {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23D4A843' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        }

        .form-label {
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .alert-success-custom {
            background: rgba(16, 185, 129, 0.12);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
        }

        .alert-danger-custom {
            background: rgba(239, 68, 68, 0.12);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4><i class="fas fa-landmark me-2"></i>Admin Panel</h4>
            <small>{{ session('admin_nama', 'Admin') }}</small>
        </div>
        <ul class="sidebar-nav">
            <li><a href="/admin" class="{{ request()->is('admin') && !request()->is('admin/*') ? 'active' : '' }}"><i class="fas fa-th-large"></i> Dashboard</a></li>

            <div class="sidebar-section">Konten</div>
            <li><a href="/admin/zona" class="{{ request()->is('admin/zona*') ? 'active' : '' }}"><i class="fas fa-map"></i> Zona / Ruangan</a></li>
            <li><a href="/admin/benda" class="{{ request()->is('admin/benda*') ? 'active' : '' }}"><i class="fas fa-cubes"></i> Benda Sejarah</a></li>
            <li><a href="/admin/sesi" class="{{ request()->is('admin/sesi*') ? 'active' : '' }}"><i class="fas fa-clock"></i> Sesi Kunjungan</a></li>

            <div class="sidebar-section">Tiket & Laporan</div>
            <li><a href="/admin/tiket" class="{{ request()->is('admin/tiket*') ? 'active' : '' }}"><i class="fas fa-ticket-alt"></i> Daftar Tiket</a></li>
            <li><a href="/admin/qr-generator" class="{{ request()->is('admin/qr-generator*') ? 'active' : '' }}"><i class="fas fa-qrcode"></i> QR Generator</a></li>
            <li><a href="/admin/laporan" class="{{ request()->is('admin/laporan*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Laporan</a></li>

            <div class="sidebar-section">Lainnya</div>
            <li><a href="/" target="_blank"><i class="fas fa-external-link-alt"></i> Lihat Website</a></li>
            <li>
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">@csrf
                    <a href="#" onclick="this.parentNode.submit();return false;" style="color:var(--danger) !important;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </li>
        </ul>
    </aside>

    <div class="main-content">
        @if(session('success'))
        <div class="alert alert-success-custom mb-3"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger-custom mb-3"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>