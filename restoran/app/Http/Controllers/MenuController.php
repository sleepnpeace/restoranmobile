<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;

class MenuController extends Controller
{
    // INDEX
    public function index()
    {
        return view('menu.index', [
            'menu' => Menu::with('kategori')->get(),
            'kategori' => Kategori::all()
        ]);
    }

    // FORM CREATE
public function create()
{
    return view('menu.create', [
        'kategori' => Kategori::all()
    ]);
}

// SIMPAN DATA
public function store(Request $request)
{
    $request->validate([
        'nama'        => 'required|string|max:255',
        'harga'       => 'required|numeric',
        'id_kategori' => 'required|exists:kategoris,id',
        'stok'        => 'required|integer',
        'gambar'      => 'nullable|url',
        'deskripsi'   => 'nullable|string'
    ]);

   Menu::create([
        'nama'        => $request->nama,
        // pastikan 2 angka desimal (.00)
        'harga'       => number_format($request->harga, 2, '.', ''),
        'id_kategori' => $request->id_kategori,
        'stok'        => $request->stok,
        'gambar'      => $request->gambar,
        'deskripsi'   => $request->deskripsi,
        'status'      => true
    ]);

    return redirect()->route('menu.index')
        ->with('success', 'Menu berhasil ditambahkan');
}



    // SHOW / LIHAT DETAIL
    public function show(Menu $menu)
    {
        return view('menu.show', compact('menu'));
    }

    // EDIT
    public function edit(Menu $menu)
    {
        return view('menu.edit', [
            'menu' => $menu,
            'kategori' => Kategori::all()
        ]);
    }

    // UPDATE
    public function update(Request $request, Menu $menu)
{
    $request->validate([
        'nama'        => 'required|string|max:255',
        'harga'       => 'required|numeric|min:0',
        'id_kategori' => 'required|exists:kategoris,id',
        'stok'        => 'required|integer|min:0',
    ]);

    $menu->update([
        'nama'        => $request->nama,
        'harga'       => number_format($request->harga, 2, '.', ''),
        'id_kategori' => $request->id_kategori,
        'stok'        => $request->stok,
        'gambar'      => $request->gambar,
        'deskripsi'   => $request->deskripsi,
    ]);

    return redirect()->route('menu.index')
        ->with('success', 'Menu berhasil diperbarui');
}


    // HAPUS
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return back()->with('success', 'Menu berhasil dihapus');
    }
}
