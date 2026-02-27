@extends('admin.layouts.app')

@section('content')
<div class="card menu-card">
    <div class="card-header">
        <h3>Edit Meja {{ $meja->nomor_meja }}</h3>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('meja.update', $meja->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                {{-- Nomor Meja --}}
                <div class="form-group">
                    <label>Nomor Meja</label>
                    <input type="text" name="nomor_meja" value="{{ old('nomor_meja', $meja->nomor_meja) }}" required>
                    @error('nomor_meja') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Kapasitas --}}
                <div class="form-group">
                    <label>Kapasitas</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas', $meja->kapasitas) }}" required>
                    @error('kapasitas') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label>Status Meja</label>
                <select name="status" required>
                    <option value="1" {{ $meja->status == 1 ? 'selected' : '' }}>Tersedia</option>
                    <option value="0" {{ $meja->status == 0 ? 'selected' : '' }}>Terisi / Nonaktif</option>
                </select>
            </div>

            <div class="form-action">
                <a href="{{ route('meja.index') }}" class="btn btn-red">Batal</a>
                <button type="submit" class="btn btn-green">Update Meja</button>
            </div>
        </form>
    </div>
</div>

{{-- Style sama dengan create di atas --}}
<style>
.menu-card { max-width: 900px; margin: auto; border-radius: 12px; }
.card-header { padding: 16px 20px; border-bottom: 1px solid #e5e7eb; }
.card-header h3 { margin: 0; color: #166534; }
.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; margin-bottom: 18px; }
.form-group { display: flex; flex-direction: column; margin-bottom: 15px; }
label { font-size: 13px; font-weight: 600; color: #166534; margin-bottom: 6px; }
input, select { padding: 11px 12px; border-radius: 8px; border: 1px solid #bbf7d0; font-size: 14px; transition: .25s; }
input:focus, select:focus { border-color: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,.2); outline: none; }
.form-action { margin-top: 24px; display: flex; justify-content: flex-end; gap: 10px; }
</style>
@endsection