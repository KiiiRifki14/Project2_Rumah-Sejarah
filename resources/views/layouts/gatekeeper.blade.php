<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scanner Tiket - Gatekeeper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4A843;
            --dark-bg: #0A0F1C;
            --dark-card: #111827;
            --dark-surface: #1A2332;
            --dark-border: #2A3544;
            --text-primary: #F1F5F9;
            --text-secondary: #94A3B8;
            --success: #10B981;
            --danger: #EF4444;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            min-height: 100vh;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
        }

        .glass-card {
            background: rgba(26, 35, 50, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 168, 67, 0.1);
            border-radius: 16px;
            padding: 2rem;
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), #B8922F);
            color: var(--dark-bg);
            border: none;
            font-weight: 700;
            padding: 0.75rem 2rem;
            border-radius: 12px;
        }

        .form-control-dark {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 0.75rem 1rem;
        }

        .form-control-dark:focus {
            background: var(--dark-surface);
            border-color: var(--gold);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(212, 168, 67, 0.15);
        }
    </style>
</head>

<body>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>