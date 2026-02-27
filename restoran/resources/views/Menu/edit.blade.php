@extends('admin.layouts.app')

@section('content')
<div class="card menu-card">
    <div class="card-header">
        <h3>Edit Menu</h3>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('menu.update', $menu->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <!-- Nama -->
                <div class="form-group">
                    <label>Nama Menu</label>
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama', $menu->nama) }}"
                        required
                    >
                </div>

                <!-- Harga -->
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input
                        type="number"
                        name="harga"
                        value="{{ old('harga', (int)$menu->harga) }}"
                        required
                    >
                </div>

                <!-- Kategori -->
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="id_kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option
                                value="{{ $k->id }}"
                                {{ old('id_kategori', $menu->id_kategori) == $k->id ? 'selected' : '' }}
                            >
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Stok -->
                <div class="form-group">
                    <label>Stok</label>
                    <input
                        type="number"
                        name="stok"
                        value="{{ old('stok', $menu->stok) }}"
                        required
                    >
                </div>

            </div>

            <!-- Gambar -->
            <div class="form-group">
                <label>Link Gambar Menu</label>
                <input
                    type="url"
                    name="gambar"
                    value="{{ old('gambar', $menu->gambar) }}"
                    placeholder="https://example.com/menu.jpg"
                >
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
                <label>Deskripsi Menu</label>
                <textarea
                    name="deskripsi"
                    rows="4"
                    placeholder="Deskripsi singkat menu..."
                >{{ old('deskripsi', $menu->deskripsi) }}</textarea>
            </div>

            <!-- Action -->
            <div class="form-action">
                <a href="{{ route('menu.index') }}" class="btn btn-red">Batal</a>
                <button class="btn btn-green">Update Menu</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Card */
.menu-card {
    max-width: 900px;
    margin: auto;
    border-radius: 12px;
}

/* Header */
.card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.card-header h3 {
    margin: 0;
    color: #166534;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
    margin-bottom: 18px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

/* Label */
label {
    font-size: 13px;
    font-weight: 600;
    color: #166534;
    margin-bottom: 6px;
}

/* Input */
input, select, textarea {
    padding: 11px 12px;
    border-radius: 8px;
    border: 1px solid #bbf7d0;
    font-size: 14px;
    transition: .25s;
}

input:focus, select:focus, textarea:focus {
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34,197,94,.2);
    outline: none;
}

/* Action */
.form-action {
    margin-top: 24px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
</style>
@endsection
