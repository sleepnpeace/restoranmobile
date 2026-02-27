@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Detail Kategori</h3>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <p><strong>ID Kategori:</strong> {{ $kategori->id }}</p>
                <p><strong>Nama Kategori:</strong> {{ $kategori->nama }}</p>
                <p><strong>Total Menu Terkait:</strong> {{ $kategori->menu->count() }} Item</p>
                <p><strong>Tanggal Dibuat:</strong> {{ $kategori->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <hr>

            <div class="form-action">
                <a href="{{ route('kategori.index') }}" class="btn btn-green">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection