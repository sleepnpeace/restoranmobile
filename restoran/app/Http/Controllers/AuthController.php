<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Karyawan;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;
            if ($role == 'manager') return redirect()->route('manager.dashboard');
            if ($role == 'admin') return redirect()->route('admin.dashboard');
            if ($role == 'kasir') return redirect()->route('kasir.menu');
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:modify_users,username',
            'email' => 'required|email|unique:modify_users,email',
            'password' => 'required|confirmed',
            'role' => 'required|in:manager,admin,kasir',
            'nama' => 'required|string',
            'notelp' => 'required|string',
            'jenkel' => 'required|in:L,P',
        ]);

        // Buat karyawan terlebih dahulu
        $karyawan = Karyawan::create([
            'nama' => $request->nama,
            'notelp' => $request->notelp,
            'alamat' => $request->alamat ?? '',
            'jenkel' => $request->jenkel,
            'jabatan' => $request->role
        ]);

        // Buat user
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => true,
            'id_karyawan' => $karyawan->id
        ]);

        return redirect()->route('auth.login')->with('success', 'Registrasi berhasil, silahkan login');
    }
}
