<?php
namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index() {
        return response()->json(Meja::orderBy('nomor_meja')->get());
    }

    public function toggleStatus(Meja $meja) {
        $meja->update(['status' => !$meja->status]);
        return response()->json(['message' => 'Status berhasil diubah', 'data' => $meja]);
    }
    
    // ... Method store, update, destroy tetap sama tapi return response()->json()
}