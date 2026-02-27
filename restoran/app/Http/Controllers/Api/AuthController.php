<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Karyawan;

class AuthController extends Controller
{
    // =====================
    // REGISTER (API)
    // =====================
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:modify_users,username',
            'email'    => 'required|email|unique:modify_users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:manager,admin,kasir',
            'nama'     => 'required|string',
            'notelp'   => 'required|string',
            'jenkel'   => 'required|in:L,P',
        ]);

        // buat karyawan
        $karyawan = Karyawan::create([
            'nama'    => $request->nama,
            'notelp'  => $request->notelp,
            'alamat'  => $request->alamat ?? '',
            'jenkel'  => $request->jenkel,
            'jabatan' => $request->role,
        ]);

        // buat user
        $user = User::create([
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
            'status'       => true,
            'id_karyawan'  => $karyawan->id,
        ]);

        return response()->json([
            'message' => 'Register success',
            'user'    => $user
        ], 201);
    }

    // =====================
    // LOGIN (API)
    // =====================
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        if (!$user->status) {
            return response()->json([
                'message' => 'Akun tidak aktif'
            ], 403);
        }

        Auth::login($user);

        // redirect logic SAMA dengan WEB
        $redirect = match ($user->role) {
            'manager' => 'manager/dashboard',
            'admin'   => 'admin/dashboard',
            'kasir'   => 'kasir/menu',
            default   => '/',
        };

        return response()->json([
            'message'  => 'Login success',
            'user'     => $user,
            'redirect' => $redirect
        ]);
    }

    // =====================
    // LOGOUT (API)
    // =====================
    public function logout(Request $request)
{
    Auth::logout();

    if ($request->hasSession()) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    return response()->json([
        'message' => 'Logout success'
    ]);
}

}
