<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f0fdf4;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            background: linear-gradient(180deg, #15803d, #22c55e);
            min-height: 100vh;
            color: #fff;
            padding: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
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
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 30px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #dcfce7;
        }

        .btn {
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            color: #fff;
        }

        .btn-green { background: #16a34a; }
        .btn-red { background: #dc2626; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>🌿 ADMIN</h2>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <a href="{{ route('menu.index') }}">Menu</a>
    <a href="{{ route('kategori.index') }}">Kategori</a>
    <a href="{{ route('meja.index') }}">Meja</a>

    <form method="POST" action="/logout">
        @csrf
        <button style="margin-top:20px;width:100%;padding:10px;border:none;border-radius:8px;background:#991b1b;color:#fff">
            Logout
        </button>
    </form>
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
