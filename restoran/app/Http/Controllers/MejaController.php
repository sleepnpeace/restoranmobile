<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    // 📄 TAMPILKAN DATA
    public function index()
    {
        return view('meja.index', [
            'meja' => Meja::orderBy('nomor_meja')->get()
        ]);
    }

    // ➕ FORM TAMBAH
    public function create()
    {
        return view('meja.create');
    }

    // 💾 SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|unique:mejas,nomor_meja',
            'kapasitas'  => 'required|integer|min:1',
            'status'     => 'required|boolean',
        ]);

        Meja::create($request->all());

        return redirect()
            ->route('meja.index')
            ->with('success', 'Meja berhasil ditambahkan');
    }

    // ✏️ FORM EDIT
    public function edit(Meja $meja)
    {
        return view('meja.edit', compact('meja'));
    }

    // 🔄 UPDATE DATA
    public function update(Request $request, Meja $meja)
    {
        $request->validate([
            'nomor_meja' => 'required|unique:mejas,nomor_meja,' . $meja->id,
            'kapasitas'  => 'required|integer|min:1',
            'status'     => 'required|boolean',
        ]);

        $meja->update($request->all());

        return redirect()
            ->route('meja.index')
            ->with('success', 'Meja berhasil diperbarui');
    }

public function show(Meja $meja)
    {
        // Mengirim data satu meja ke view meja.show
        return view('meja.show', compact('meja'));
    }

    // 🗑️ HAPUS DATA
    public function destroy(Meja $meja)
    {
        $meja->delete();

        return redirect()
            ->route('meja.index')
            ->with('success', 'Meja berhasil dihapus');
    }
}
