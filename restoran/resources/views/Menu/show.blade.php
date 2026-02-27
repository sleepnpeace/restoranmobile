@extends('admin.layouts.app')

@section('content')
<div class="card">
    <h3>Detail Menu</h3>

    <p><b>Nama:</b> {{ $menu->nama }}</p>
    <p><b>Kategori:</b> {{ $menu->kategori->nama }}</p>
    <p><b>Harga:</b> Rp {{ number_format($menu->harga,0,',','.') }}</p>
    <p><b>Stok:</b> {{ $menu->stok }}</p>
    <p><b>Status:</b> {{ $menu->status ? 'Aktif' : 'Nonaktif' }}</p>
    <p><b>Deskripsi:</b> {{ $menu->deskripsi }}</p>

    <a href="{{ route('menu.index') }}" class="btn btn-green">Kembali</a>
</div>
@endsection
