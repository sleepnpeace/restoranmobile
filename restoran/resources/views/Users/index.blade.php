@extends('manager.layouts.app')

@section('content')
<div class="main-content" style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-weight: 800;">Manajemen User</h1>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; color: #16a34a; padding: 15px; border-radius: 12px; border: 1px solid #bbf7d0; margin-bottom: 20px; font-weight: 600;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <tr>
                    <th style="padding: 18px 15px; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em;">User Info</th>
                    <th style="padding: 18px 15px; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em;">Karyawan</th>
                    <th style="padding: 18px 15px; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em;">Role</th>
                    <th style="padding: 18px 15px; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                    <th style="padding: 18px 15px; color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                    <td style="padding: 15px;">
                        <div style="font-weight: 800; color: #1e293b; font-size: 15px;">{{ $user->username }}</div>
                        <div style="color: #64748b; font-size: 13px;">{{ $user->email }}</div>
                    </td>
                    <td style="padding: 15px;">
                        <div style="font-weight: 700; color: #334155;">{{ $user->nama_karyawan ?? 'Internal System' }}</div>
                        <div style="color: #94a3b8; font-size: 12px; font-style: italic;">{{ $user->jabatan ?? '-' }}</div>
                    </td>
                    <td style="padding: 15px;">
                        @php
                            $roleColors = [
                                'manager' => ['bg' => '#fef2f2', 'text' => '#dc2626'],
                                'admin'   => ['bg' => '#eff6ff', 'text' => '#2563eb'],
                                'kasir'   => ['bg' => '#f0fdf4', 'text' => '#16a34a'],
                            ];
                            $color = $roleColors[$user->role] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
                        @endphp
                        <span style="padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; background: {{ $color['bg'] }}; color: {{ $color['text'] }}; text-transform: uppercase;">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        @if($user->status)
                            <span style="display: flex; align-items: center; gap: 6px; color: #16a34a; font-weight: 700; font-size: 13px;">
                                <div style="width: 8px; height: 8px; background: #16a34a; border-radius: 50%;"></div> Aktif
                            </span>
                        @else
                            <span style="display: flex; align-items: center; gap: 6px; color: #94a3b8; font-weight: 700; font-size: 13px;">
                                <div style="width: 8px; height: 8px; background: #cbd5e1; border-radius: 50%;"></div> Non-Aktif
                            </span>
                        @endif
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="background: #ef4444; color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-weight: 700; font-size: 12px; transition: 0.3s;">
                                    <i class="fas fa-trash"></i> HAPUS
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #94a3b8;">
                        <i class="fas fa-user-slash" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                        Belum ada data user.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection