<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function index()
    {
        $menu = Menu::with('kategori')->where('status', true)->orderBy('id_kategori')->get();
        $mejas = Meja::where('status', true)->get();
        return view('kasir.menu', compact('menu', 'mejas'));
    }

    public function meja()
    {
        $mejas = Meja::orderBy('nomor_meja')->get();
        return view('kasir.meja', compact('mejas'));
    }

    public function getMenuDetail($id)
    {
        try {
            $menu = Menu::with('kategori')->findOrFail($id);
            return response()->json($menu);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Menu tidak ditemukan'], 404);
        }
    }

    public function updateStatusMeja($id)
    {
        $meja = Meja::findOrFail($id);
        $meja->status = !$meja->status;
        $meja->save();
        return back()->with('success', 'Status Meja berhasil diperbarui');
    }

    public function transaksi()
    {
        $transaksis = Transaksi::with(['meja', 'user']) 
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('kasir.transaksi', compact('transaksis'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_konsumen' => 'required|string|max:255',
        'id_meja' => 'required|exists:mejas,id',
        'cart_data' => 'required'
    ]);

    $cartItems = json_decode($request->cart_data, true);
    if (empty($cartItems)) {
        return back()->with('error', 'Keranjang belanja kosong!');
    }

    try {
        DB::beginTransaction();
        $totalTambahan = collect($cartItems)->sum('subtotal');
        
        // AMBIL ID TRANSAKSI DARI SESSION (JIKA ADA)
        $existingId = session('edit_transaksi_id');

        if ($existingId) {
            // MODE: TAMBAH PESANAN KE STRUK LAMA
            $transaksiId = $existingId;
            
            // 1. Update total harga di transaksi lama (ditambah dengan pesanan baru)
            Transaksi::where('id', $transaksiId)->increment('total_bayar', $totalTambahan);
            
            // 2. Hapus session agar transaksi berikutnya dianggap transaksi baru
            session()->forget('edit_transaksi_id');
        } else {
            // MODE: TRANSAKSI BARU (STRUK BARU)
            $transaksi = Transaksi::create([
                'id_user' => Auth::id(),
                'id_meja' => $request->id_meja,
                'nama_konsumen' => $request->nama_konsumen,
                'total_bayar' => $totalTambahan,
                'tanggal' => now(),
                'status' => 'pending', 
            ]);
            $transaksiId = $transaksi->id;
            
            // Meja jadi terisi
            Meja::where('id', $request->id_meja)->update(['status' => false]);
        }

        // SIMPAN DETAIL PESANAN (Item-item yang baru saja dipilih)
        foreach ($cartItems as $item) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksiId,
                'id_menu'      => $item['id_menu'],
                'jumlah'       => $item['jumlah'],
                'metode'       => strtolower($item['metode']),
                'catatan'      => $item['catatan'] ?? null,
                'status'       => 'proses', 
                'subtotal'     => $item['subtotal'],
            ]);
        }

        DB::commit();
        // Redirect kembali ke detail transaksi (struk) yang sama
        return redirect()->route('transaksi.show', $transaksiId)->with('success', 'Pesanan berhasil ditambahkan ke struk!');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
    }
}

    public function konfirmasiBayar(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,qris',
            'jumlah_bayar' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();
            $transaksi = Transaksi::findOrFail($id);
            $details = DetailTransaksi::where('id_transaksi', $transaksi->id)->get();

            foreach ($details as $detail) {
                $menu = Menu::find($detail->id_menu);
                if ($menu && $menu->stok !== null) {
                    if ($menu->stok < $detail->jumlah) {
                        throw new \Exception("Stok menu {$menu->nama} tidak mencukupi.");
                    }
                    $menu->decrement('stok', $detail->jumlah);
                }
            }

            DB::table('pembayaran')->insert([
                'id_transaksi'      => $transaksi->id,
                'metode_pembayaran' => $request->metode_pembayaran,
                'jumlah_bayar'      => $request->jumlah_bayar,
                'status'            => 'success',
                'waktu_bayar'       => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            $transaksi->update(['status' => 'paid']);
            DetailTransaksi::where('id_transaksi', $id)->update(['status' => 'selesai']);

            if ($transaksi->id_meja) {
                Meja::where('id', $transaksi->id_meja)->update(['status' => true]);
            }

            DB::commit();
            return redirect()->route('kasir.transaksi')->with('success', 'Pembayaran Berhasil!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal Konfirmasi: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}