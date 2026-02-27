<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kulkaltim POS</title>
    <link rel="stylesheet" href="{{ asset('css/kasir-style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            background: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        /* Navbar Atas */
        .top-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 75px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-brand {
            color: #166534;
            font-weight: 800;
            font-size: 1.5rem;
            margin: 0;
            letter-spacing: -1px;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 10px;
        }

        .nav-item {
            /* Ukuran Seragam */
            width: 150px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            color: #64748b;
            font-weight: 700;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            border-radius: 12px;
        }

        .nav-item:hover, .nav-item.active {
            background: #f0fdf4;
            color: #16a34a;
        }

        .btn-logout-nav {
            background: #fef2f2;
            color: #ef4444;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-logout-nav:hover {
            background: #fee2e2;
        }

        main {
            flex: 1;
            padding: 25px;
            width: 100%;
            max-width: 1440px;
            margin: 0 auto;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            .top-navbar { height: auto; padding: 15px; flex-direction: column; gap: 15px; }
            .nav-left { flex-direction: column; width: 100%; }
            .nav-links { width: 100%; justify-content: center; }
            .nav-item { flex: 1; width: auto; font-size: 0.8rem; }
        }
    </style>
</head>
<body>
    <header class="top-navbar">
        <div class="nav-left">
            <a href="{{ route('kasir.menu') }}" class="nav-brand">KUKT</a>
            <nav class="nav-links">
                <a href="{{ route('kasir.menu') }}" class="nav-item {{ request()->routeIs('kasir.menu') ? 'active' : '' }}">
                    <span>🍽️</span> Menu
                </a>
                <a href="{{ route('kasir.meja') }}" class="nav-item {{ request()->routeIs('kasir.meja') ? 'active' : '' }}">
                    <span>🪑</span> Meja
                </a>
                <a href="{{ route('kasir.transaksi') }}" class="nav-item {{ request()->routeIs('kasir.transaksi') ? 'active' : '' }}">
                    <span>📜</span> Transaksi
                </a>
            </nav>
        </div>
        <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout-nav">🚪 KELUAR</button>
        </form>
    </header>

    <main>
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>