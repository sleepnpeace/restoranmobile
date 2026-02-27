@extends('admin.layouts.app')

@section('content')
<div class="card">
    <h3>Manajemen Meja</h3>

    <a href="{{ route('meja.create') }}" class="btn btn-green" style="margin-bottom:15px;">
        + Tambah Meja
    </a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Meja</th>
                <th>Kapasitas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($meja as $m)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $m->nomor_meja }}</td>
                <td>{{ $m->kapasitas }} Orang</td>
                <td>
                    @if($m->status)
                        <span style="color:#16a34a;font-weight:bold">Aktif</span>
                    @else
                        <span style="color:#dc2626;font-weight:bold">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('meja.show', $m->id) }}" class="btn btn-green">Lihat</a>
                    <a href="{{ route('meja.edit', $m->id) }}" class="btn btn-green">Edit</a>

                    <form action="{{ route('meja.destroy', $m->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-red" onclick="return confirm('Hapus meja ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;color:#64748b;">
                    Belum ada data meja
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
