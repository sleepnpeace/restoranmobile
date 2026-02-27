<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    /**
     * Menampilkan daftar semua meja
     */
    public function index() 
    {
        $mejas = Meja::orderBy('nomor_meja')->get();
        return response()->json([
            'status' => 'success',
            'data'   => $mejas
        ], 200);
    }

    /**
     * Menampilkan detail meja tertentu
     */
    public function show(Meja $meja) 
    {
        return response()->json([
            'status' => 'success',
            'data'   => $meja
        ], 200);
    }

    /**
     * Mengubah/Toggle status ketersediaan meja (Tersedia / Terisi)
     */
    public function toggleStatus(Meja $meja) 
    {
        $meja->update(['status' => !$meja->status]);
        
        $statusText = $meja->status ? 'Tersedia' : 'Terisi';

        return response()->json([
            'status'  => 'success',
            'message' => "Status meja berhasil diubah menjadi {$statusText}", 
            'data'    => $meja
        ], 200);
    }
}