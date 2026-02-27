@extends('admin.layouts.app')

@section('content')
<div class="card">
    <h3>Dashboard Admin</h3>
    <p>Selamat datang, {{ auth()->user()->username }}</p>
</div>
@endsection
