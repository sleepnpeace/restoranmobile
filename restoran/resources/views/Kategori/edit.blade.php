@extends('admin.layouts.app')

@section('content')
<div class="card kategori-card">
    <div class="card-header">
        <h3>Edit Kategori</h3>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('kategori.update', $kategori->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama" value="{{ $kategori->nama }}" required>
            </div>

            <div class="form-action">
                <a href="{{ route('kategori.index') }}" class="btn btn-red">Batal</a>
                <button class="btn btn-green">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
