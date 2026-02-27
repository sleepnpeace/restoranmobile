<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModifyUserController extends Controller
{
    public function index()
    {
        // Menggunakan paginate agar {{ $users->links() }} di view tidak error
        $users = DB::table('modify_users')
            ->leftJoin('karyawans', 'modify_users.id_karyawan', '=', 'karyawans.id')
            ->select('modify_users.*', 'karyawans.nama as nama_karyawan', 'karyawans.jabatan')
            ->paginate(10); 
        
        return view('users.index', compact('users'));
    }


    public function edit($id)
    {
        $user = DB::table('modify_users')->where('id', $id)->first();
        $karyawans = DB::table('karyawans')->get(); // Untuk pilihan di dropdown
        
        return view('users.edit', compact('user', 'karyawans'));
    }

    public function destroy($id)
    {
        DB::table('modify_users')->where('id', $id)->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}