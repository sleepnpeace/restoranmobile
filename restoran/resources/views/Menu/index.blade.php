@extends('admin.layouts.app')

@section('content')
<div class="card">
    <h3>Manajemen Menu</h3>

    <a href="{{ route('menu.create') }}" class="btn btn-green" style="margin-bottom:15px;">
        + Tambah Menu
    </a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($menu as $m)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $m->nama }}</td>
                <td>{{ $m->kategori->nama }}</td>
                <td>Rp {{ number_format($m->harga,0,',','.') }}</td>
                <td>{{ $m->stok }}</td>
                <td>
                    @if($m->status)
                        <span style="color:#16a34a;font-weight:bold">Aktif</span>
                    @else
                        <span style="color:#dc2626;font-weight:bold">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('menu.show',$m->id) }}" class="btn btn-green">Lihat</a>
                    <a href="{{ route('menu.edit',$m->id) }}" class="btn btn-green">Edit</a>

                    <form action="{{ route('menu.destroy',$m->id) }}"
                          method="POST"
                          style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-red"
                                onclick="return confirm('Hapus menu ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;">
                    <span style="color:#64748b;">
                        Belum ada data menu
                    </span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
