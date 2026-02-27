@extends('admin.layouts.app')

@section('content')
<div class="card menu-card">
    <div class="card-header">
        <h3>Tambah Meja Baru</h3>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('meja.store') }}">
            @csrf

            <div class="form-grid">
                {{-- Nomor Meja --}}
                <div class="form-group">
                    <label>Nomor Meja</label>
                    <input type="text" name="nomor_meja" placeholder="Contoh: A01" value="{{ old('nomor_meja') }}" required>
                    @error('nomor_meja') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Kapasitas --}}
                <div class="form-group">
                    <label>Kapasitas (Orang)</label>
                    <input type="number" name="kapasitas" placeholder="Contoh: 4" value="{{ old('kapasitas') }}" required>
                    @error('kapasitas') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label>Status Awal</label>
                <select name="status" required>
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Tersedia (Aktif)</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Tersedia (Nonaktif)</option>
                </select>
            </div>

            <div class="form-action">
                <a href="{{ route('meja.index') }}" class="btn btn-red">Batal</a>
                <button type="submit" class="btn btn-green">Simpan Meja</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Style Identik dengan Menu */
.menu-card { max-width: 900px; margin: auto; border-radius: 12px; }
.card-header { padding: 16px 20px; border-bottom: 1px solid #e5e7eb; }
.card-header h3 { margin: 0; color: #166534; }
.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; margin-bottom: 18px; }
.form-group { display: flex; flex-direction: column; margin-bottom: 15px; }
label { font-size: 13px; font-weight: 600; color: #166534; margin-bottom: 6px; }
input, select { padding: 11px 12px; border-radius: 8px; border: 1px solid #bbf7d0; font-size: 14px; transition: .25s; }
input:focus, select:focus { border-color: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,.2); outline: none; }
.form-action { margin-top: 24px; display: flex; justify-content: flex-end; gap: 10px; }
.text-danger { color: #ef4444; font-size: 12px; margin-top: 4px; }
</style>
@endsection