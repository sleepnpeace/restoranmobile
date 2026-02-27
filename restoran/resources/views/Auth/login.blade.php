<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Kulkaltim</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f0fdf4; /* Light Green Bg */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            display: flex;
            background: white;
            width: 900px;
            height: 550px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        /* BAGIAN KIRI (GAMBAR) */
        .login-image {
            flex: 1.2;
            background: url('https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80') center/cover no-repeat;
            position: relative;
        }
        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(22, 163, 74, 0.8), transparent);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: white;
        }
        .overlay h2 { font-size: 28px; font-weight: 700; margin-bottom: 10px; }
        .overlay p { font-size: 16px; opacity: 0.9; }

        /* BAGIAN KANAN (FORM) */
        .login-form {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .header { margin-bottom: 30px; }
        .header h1 { font-size: 26px; color: #14532d; font-weight: 800; }
        .header p { color: #64748b; font-size: 14px; margin-top: 5px; }

        .input-group { margin-bottom: 20px; }
        .input-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        
        input {
            width: 100%;
            padding: 14px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: .3s;
            outline: none;
            background: #f8fafc;
        }
        input:focus {
            border-color: #16a34a;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #16a34a;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: .3s;
            margin-top: 10px;
        }
        .btn-submit:hover { background: #15803d; transform: translateY(-2px); }

        .footer { margin-top: 25px; text-align: center; font-size: 14px; color: #64748b; }
        .footer a { color: #16a34a; font-weight: 600; text-decoration: none; }
        .footer a:hover { text-decoration: underline; }

        /* ALERTS */
        .alert { padding: 12px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

        @media (max-width: 768px) {
            .login-container { flex-direction: column; width: 90%; height: auto; }
            .login-image { height: 200px; display: none; } /* Hide image on mobile */
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-image">
        <div class="overlay">
            <h2>KUKT</h2>
            <p>Kelola restoran dengan rasa otentik khas Kalimantan Timur.</p>
        </div>
    </div>

    <div class="login-form">
        <div class="header">
            <h1>Selamat Datang 👋</h1>
            <p>Silakan masukkan detail akun Anda</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @error('username')
            <div class="alert alert-error">{{ $message }}</div>
        @enderror

        <form method="POST" action="/login">
            @csrf
            <div class="input-group">
                <label class="input-label">Username</label>
                <input type="text" name="username" placeholder="Masukan username Anda" required autofocus>
            </div>

            <div class="input-group">
                <label class="input-label">Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-submit">Masuk Sekarang</button>
        </form>

        <div class="footer">
            Belum punya akun? <a href="/register">Daftar Karyawan</a>
        </div>
    </div>
</div>

</body>
</html>