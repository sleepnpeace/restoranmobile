@extends('admin.layouts.app')

@section('content')
<div class="card">
    <h3>Manajemen Kategori</h3>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert-success" style="margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tambah Kategori --}}
    <a href="{{ route('kategori.create') }}" class="btn btn-green" style="margin-bottom:15px;">
        + Tambah Kategori
    </a>

    {{-- Table --}}
    <table>
        <thead>
            <tr>
                <th width="60">No</th>
                <th>Nama Kategori</th>
                <th width="220">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($kategori as $k)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $k->nama }}</td>
                <td>
                    <a href="{{ route('kategori.show', $k->id) }}" class="btn btn-green">Lihat</a>
                    <a href="{{ route('kategori.edit', $k->id) }}" class="btn btn-green">Edit</a>

                    <form action="{{ route('kategori.destroy', $k->id) }}"
                          method="POST"
                          style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-red"
                                onclick="return confirm('Hapus kategori ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align:center;color:#64748b;">
                    Belum ada kategori
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- STYLE (DISAMAKAN DENGAN HALAMAN MEJA) --}}
<style>
.alert-success {
    background: #dcfce7;
    color: #166534;
    padding: 10px 14px;
    border-radius: 8px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th {
    background: #f8fafc;
    color: #0f172a;
    text-align: left;
    font-weight: 600;
}

table th,
table td {
    padding: 12px 14px;
    border-bottom: 1px solid #e5e7eb;
}

table tr:hover {
    background: #f1f5f9;
}
</style>
@endsection
