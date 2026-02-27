<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    // =====================
    // DATA AWAL KASIR (PUBLIC)
    // =====================
    public function index()
    {
        $menu = Menu::with('kategori')
            ->where('status', true)
            ->orderBy('id_kategori')
            ->get()
            ->groupBy('kategori.nama');

        $mejas = Meja::where('status', true)->get();

        return response()->json([
            'menu'  => $menu,
            'mejas' => $mejas
        ]);
    }

    // =====================
    // DATA SEMUA MEJA (UNTUK VUE GRID MEJA)
    // =====================
 public function meja()
{
    try {
        // Ambil semua meja dari tabel 'mejas'
        $mejas = Meja::orderBy('nomor_meja', 'asc')->get();

        $data = $mejas->map(function($meja) {
            // Cari transaksi pending di tabel 'transaksis'
            // Gunakan query manual yang aman dari error relasi
            $transaksi = DB::table('transaksis')
                ->where('id_meja', $meja->id)
                ->where('status', 'pending')
                ->select('nama_konsumen', 'id')
                ->latest()
                ->first();

            return [
                'id'             => $meja->id,
                'nomor_meja'     => $meja->nomor_meja,
                'kapasitas'      => $meja->kapasitas,
                // Pastikan status di-cast ke boolean dengan benar
                'status'         => (bool)$meja->status, 
                'nama_pelanggan' => $transaksi ? $transaksi->nama_konsumen : null,
                'transaksi_id'   => $transaksi ? $transaksi->id : null
            ];
        });

        return response()->json($data); // Langsung return $data

    } catch (\Exception $e) {
        // Jika error, kita bisa baca pesan error aslinya
        return response()->json([
            'message' => 'Gagal mengambil data meja',
            'error'   => $e->getMessage() 
        ], 500);
    }
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

    // =====================
    // UPDATE STATUS MEJA MANUAL
    // =====================
    public function updateStatusMeja($id)
    {
        try {
            $meja = Meja::findOrFail($id);
            $meja->status = !$meja->status;
            $meja->save();
            
            // Return JSON agar Vue bisa update tampilan tanpa refresh halaman
            return response()->json([
                'status' => 'success', 
                'data' => $meja
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    // =====================
    // SIMPAN TRANSAKSI (PROTECTED)
    // =====================
  public function store(Request $request)
{
    $request->validate([
        'nama_konsumen' => 'required|string|max:255',
        'id_meja'       => 'required|exists:mejas,id',
        'cart_data'     => 'required|array'
    ]);

    if (empty($request->cart_data)) {
        return response()->json([
            'message' => 'Keranjang kosong'
        ], 400);
    }

    try {

        DB::beginTransaction();

        $totalTambahan = collect($request->cart_data)->sum('subtotal');

        // ======================
        // BUAT TRANSAKSI BARU
        // ======================
        $transaksi = Transaksi::create([
            'id_user'       => 1, // sementara hardcode
            'id_meja'       => $request->id_meja,
            'nama_konsumen' => $request->nama_konsumen,
            'total_bayar'   => $totalTambahan,
            'tanggal'       => now(),
            'status'        => 'pending',
        ]);

        // Meja jadi terisi
        Meja::where('id', $request->id_meja)
            ->update(['status' => false]);

        // ======================
        // SIMPAN DETAIL
        // ======================
        foreach ($request->cart_data as $item) {

            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_menu'      => $item['id_menu'],
                'jumlah'       => $item['jumlah'],
                'metode'       => strtolower($item['metode']),
                'catatan'      => $item['catatan'] ?? null,
                'status'       => 'proses',
                'subtotal'     => $item['subtotal'],
            ]);
        }

        DB::commit();

        return response()->json([
            'message' => 'Pesanan berhasil disimpan',
            'transaksi_id' => $transaksi->id
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'message' => 'Gagal menyimpan',
            'error'   => $e->getMessage()
        ], 500);
    }
}

    // =====================
    // LIST TRANSAKSI
    // =====================
    public function transaksi()
    {
        $transaksis = Transaksi::with(['meja', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($transaksis);
    }

    // =====================
    // KONFIRMASI BAYAR
    // =====================
    public function konfirmasiBayar(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,qris',
            'jumlah_bayar'      => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::findOrFail($id);
            $details = DetailTransaksi::where('id_transaksi', $transaksi->id)->get();

            // POTONG STOK SEKARANG DARI DETAIL TRANSAKSI YANG SUDAH DISIMPAN SEBELUMNYA
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

            // UPDATE STATUS TRANSAKSI DAN DETAIL
            $transaksi->update(['status' => 'paid']);
            DetailTransaksi::where('id_transaksi', $id)->update(['status' => 'selesai']);

            if ($transaksi->id_meja) {
                Meja::where('id', $transaksi->id_meja)->update(['status' => true]);
            }

            DB::commit();
            return response()->json(['message' => 'Pembayaran Berhasil!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal Konfirmasi: ' . $e->getMessage()], 500);
        }
    }

    // =====================
    // TAMPILKAN DETAIL STRUK
    // =====================
    public function show($id)
    {
        $transaksi = DB::table('transaksis')
            ->leftJoin('modify_users', 'transaksis.id_user', '=', 'modify_users.id')
            ->leftJoin('mejas', 'transaksis.id_meja', '=', 'mejas.id')
            ->where('transaksis.id', $id)
            ->select('transaksis.*', 'modify_users.username as nama_kasir', 'mejas.nomor_meja')
            ->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $details = DB::table('detail_transaksis')
            ->join('menus', 'detail_transaksis.id_menu', '=', 'menus.id')
            ->where('detail_transaksis.id_transaksi', $id) 
            ->select('detail_transaksis.*', 'menus.nama as nama_menu', 'menus.harga as harga_satuan')
            ->get();

        return response()->json([
            'transaksi' => $transaksi,
            'details' => $details
        ]);
    }
}