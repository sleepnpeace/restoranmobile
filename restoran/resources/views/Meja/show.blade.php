@extends('admin.layouts.app')

@section('content')
<div class="card menu-card" style="max-width: 600px;">
    <div class="card-header">
        <h3>Detail Meja</h3>
    </div>

    <div class="card-body">
        <div class="info-list">
            <p><b>Nomor Meja:</b> {{ $meja->nomor_meja }}</p>
            <p><b>Kapasitas:</b> {{ $meja->kapasitas }} Orang</p>
            <p><b>Status:</b> 
                <span class="badge {{ $meja->status ? 'badge-green' : 'badge-red' }}">
                    {{ $meja->status ? 'Tersedia' : 'Terisi/Nonaktif' }}
                </span>
            </p>
            <p><b>Dibuat Pada:</b> {{ $meja->created_at->format('d M Y, H:i') }}</p>
        </div>

        <div class="form-action">
            <a href="{{ route('meja.index') }}" class="btn btn-green">Kembali</a>
        </div>
    </div>
</div>

<style>
.menu-card { margin: auto; border-radius: 12px; background: #fff; }
.card-header { padding: 16px 20px; border-bottom: 1px solid #e5e7eb; }
.card-header h3 { margin: 0; color: #166534; }
.card-body { padding: 20px; }
.info-list p { margin-bottom: 12px; font-size: 15px; color: #334155; }
.info-list b { color: #166534; width: 120px; display: inline-block; }

.badge { padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; color: #fff; }
.badge-green { background-color: #22c55e; }
.badge-red { background-color: #ef4444; }

.form-action { margin-top: 24px; display: flex; justify-content: flex-end; }
</style>
@endsection