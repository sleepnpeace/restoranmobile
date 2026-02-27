@extends('kasir.layouts.app')

@section('content')
<div class="main-content">
    <h1 style="margin-bottom: 30px; font-weight: 800;">Status Meja</h1>
    
    <div class="menu-grid">
        @foreach($mejas as $m)
        <div class="menu-card" style="padding: 20px; text-align: center;">
            <div style="font-size: 3rem;">{{ $m->status ? '✅' : '🚫' }}</div>
            <h2 style="margin: 10px 0;">Meja {{ $m->nomor_meja }}</h2>
            <p style="color: #64748b; margin-bottom: 15px;">Kapasitas: {{ $m->kapasitas }} Orang</p>
            
            <form action="{{ route('kasir.meja.update', $m->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-submit" style="background: {{ $m->status ? '#16a34a' : '#ef4444' }}">
                    {{ $m->status ? 'SET TIDAK TERSEDIA' : 'SET TERSEDIA' }}
                </button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection