<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index', [
            'kategori' => Kategori::all()
        ]);
    }

    public function create()
{
    return view('kategori.create');
}


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100'
        ]);

        Kategori::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:100'
        ]);

        $kategori->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function show(Kategori $kategori)
{
    return view('kategori.show', [
        'kategori' => $kategori->load('menu')
    ]);
}


    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
