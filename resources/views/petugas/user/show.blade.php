@extends('layouts.app')

@section('title','Detail Peminjam')

@section('content')
<div class="container">

<div class="card">
<div class="card-header">
<a href="{{ route('petugas.user.index') }}"
   class="btn btn-secondary btn-sm">
Kembali
</a>
</div>

<div class="card-body">

<table class="table">
<tr>
    <th>Nama</th>
    <td>{{ $user->name }}</td>
</tr>

<tr>
    <th>Email</th>
    <td>{{ $user->email }}</td>
</tr>

<tr>
    <th>Telepon</th>
    <td>{{ $user->phone ?? '-' }}</td>
</tr>

<tr>
    <th>Tanggal Daftar</th>
    <td>{{ $user->created_at }}</td>
</tr>

</table>

</div>
</div>

</div>
@endsection
