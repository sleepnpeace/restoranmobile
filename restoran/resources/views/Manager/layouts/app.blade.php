<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Panel - Restoran</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f0fdf4;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #166534, #22c55e); /* Warna Hijau Manager */
            min-height: 100vh;
            color: #fff;
            padding: 20px;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: block;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 8px;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
            padding-left: 25px;
        }

        /* CONTENT AREA */
        .content {
            flex: 1;
            padding: 30px;
            margin-left: 250px; /* Jarak agar tidak tertutup sidebar fixed */
        }

        .card {
            background: #fff;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .btn-logout {
            margin-top: 30px;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #991b1b;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #7f1d1d;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>🌿 MANAGER</h2>
    <a href="{{ route('manager.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('users.index') }}">👥 Daftar User</a>
    <a href="{{ route('manager.transaksi.index') }}">⭐ Daftar Transaksi</a>
    <a href="#">📈 Laporan Penjualan</a>

    <form method="POST" action="{{ route('auth.logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
            🚪 Logout
        </button>
    </form>
</div>

<div class="content">
    @yield('content')
</div>