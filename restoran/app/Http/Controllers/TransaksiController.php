<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = DB::table('transaksis')
            ->leftJoin('modify_users', 'transaksis.id_user', '=', 'modify_users.id')
            ->leftJoin('mejas', 'transaksis.id_meja', '=', 'mejas.id')
            ->select('transaksis.*', 'modify_users.username as nama_kasir', 'mejas.nomor_meja')
            ->orderBy('transaksis.tanggal', 'desc')
            ->get();

        return view('kasir.transaksi', compact('transaksis'));
    }

    // FUNGSI UNTUK REDIRECT KE MENU UNTUK PESAN LAGI
  public function tambahPesanan($id)
{
    $transaksi = DB::table('transaksis')->where('id', $id)->first();
    
    if (!$transaksi) return redirect()->back()->with('error', 'Data tidak ditemukan');
    if ($transaksi->status == 'paid') return redirect()->back()->with('error', 'Transaksi sudah lunas.');

    // Simpan data transaksi lama ke session
    session([
        'edit_transaksi_id' => $id,
        'old_nama' => explode('||', $transaksi->nama_konsumen)[0],
        'old_meja' => $transaksi->id_meja
    ]);

    return redirect()->route('kasir.menu')->with('success', 'Menambah pesanan untuk ' . session('old_nama'));
}

    public function show($id)
    {
        $transaksi = DB::table('transaksis')
            ->leftJoin('modify_users', 'transaksis.id_user', '=', 'modify_users.id')
            ->leftJoin('mejas', 'transaksis.id_meja', '=', 'mejas.id')
            ->where('transaksis.id', $id)
            ->select('transaksis.*', 'modify_users.username as nama_kasir', 'mejas.nomor_meja')
            ->first();

        if (!$transaksi) return redirect()->back()->with('error', 'Data tidak ditemukan');

        $details = DB::table('detail_transaksis')
            ->join('menus', 'detail_transaksis.id_menu', '=', 'menus.id')
            ->where('detail_transaksis.id_transaksi', $id) 
            ->select('detail_transaksis.*', 'menus.nama as nama_menu', 'menus.harga as harga_satuan')
            ->get();

        $transaksi->nama_bersih = explode('||', $transaksi->nama_konsumen)[0];

        return view('kasir.detailtransaksi', compact('transaksi', 'details'));
    }

    public function managerIndex(Request $request)
    {
        $query = DB::table('transaksis')
            ->leftJoin('modify_users', 'transaksis.id_user', '=', 'modify_users.id')
            ->leftJoin('mejas', 'transaksis.id_meja', '=', 'mejas.id')
            ->select('transaksis.*', 'modify_users.username as nama_kasir', 'mejas.nomor_meja');

        // Opsional: Manager bisa filter berdasarkan status lunas/pending
        if ($request->has('status')) {
            $query->where('transaksis.status', $request->status);
        }

        $transaksis = $query->orderBy('transaksis.tanggal', 'desc')->get();

        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * Menampilkan detail transaksi untuk Manager
     */
    public function managerShow($id)
    {
        $transaksi = DB::table('transaksis')
            ->leftJoin('modify_users', 'transaksis.id_user', '=', 'modify_users.id')
            ->leftJoin('mejas', 'transaksis.id_meja', '=', 'mejas.id')
            ->where('transaksis.id', $id)
            ->select('transaksis.*', 'modify_users.username as nama_kasir', 'mejas.nomor_meja')
            ->first();

        if (!$transaksi) return redirect()->back()->with('error', 'Data tidak ditemukan');

        $details = DB::table('detail_transaksis')
            ->join('menus', 'detail_transaksis.id_menu', '=', 'menus.id')
            ->where('detail_transaksis.id_transaksi', $id) 
            ->select('detail_transaksis.*', 'menus.nama as nama_menu', 'menus.harga as harga_satuan')
            ->get();

        return view('transaksi.show', compact('transaksi', 'details'));
    }
}