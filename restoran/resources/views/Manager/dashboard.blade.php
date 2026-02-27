@extends('manager.layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; align-items: center; gap: 15px;">
        <div style="font-size: 40px;">👋</div>
        <div>
            <h3 style="margin: 0;">Dashboard Manager</h3>
            <p style="color: #666; margin: 5px 0 0;">Selamat datang kembali, <strong>{{ auth()->user()->username }}</strong>!</p>
        </div>
    </div>

    <hr style="margin: 25px 0; border: 0; border-top: 1px solid #eee;">

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        <div style="background: #dcfce7; padding: 20px; border-radius: 12px; text-align: center;">
            <h4 style="margin: 0; color: #166534;">Total User</h4>
            <p style="font-size: 24px; font-weight: bold; margin: 10px 0;">{{ \DB::table('modify_users')->count() }}</p>
        </div>
        
        <div style="background: #fef9c3; padding: 20px; border-radius: 12px; text-align: center;">
            <h4 style="margin: 0; color: #854d0e;">Role Anda</h4>
            <p style="font-size: 24px; font-weight: bold; margin: 10px 0;">{{ ucfirst(auth()->user()->role) }}</p>
        </div>
    </div>
</div>
@endsection