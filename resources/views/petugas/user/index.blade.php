@extends('layouts.app')

@section('title', 'Data Peminjam')

@section('content')
<div class="container-fluid">
<div class="card">
<div class="card-header">
    <h3 class="card-title">Data Peminjam</h3>
</div>

<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered">
<thead>
<tr>
    <th>#</th>
    <th>Nama</th>
    <th>Email</th>
    <th>Telepon</th>
    <th>Tanggal Daftar</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>
@forelse ($users as $user)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>{{ $user->phone ?? '-' }}</td>
<td>{{ $user->created_at->format('d/m/Y') }}</td>

<td>
<a href="{{ route('petugas.user.show', $user) }}"
   class="btn btn-info btn-sm">
   <i class="fas fa-eye"></i> Detail
</a>
</td>

</tr>
@empty
<tr>
<td colspan="6" class="text-center">
Belum ada data peminjam
</td>
</tr>
@endforelse
</tbody>

</table>
</div>

{{ $users->links() }}

</div>
</div>
</div>
@endsection
