@extends('layouts.app')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between mb-3">
<h4>Riwayat Transaksi</h4>

<a href="{{ route('petugas.transaksi.create') }}"
class="btn btn-primary">
Tambah Transaksi
</a>

</div>


@if($transaksi->isEmpty())

<div class="alert alert-info">
Belum ada riwayat transaksi
</div>

@else

<table class="table table-bordered">

<thead>
<tr>
<th>No</th>
<th>Kode Transaksi</th>
<th>Peminjam</th>
<th>Total</th>
<th>Tanggal</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($transaksi as $t)

<tr>
<td>{{ $loop->iteration }}</td>

<td>{{ $t->kode_transaksi }}</td>

<td>{{ $t->peminjaman->user->name }}</td>

<td>
Rp {{ number_format($t->total_bayar,0,',','.') }}
</td>

<td>
{{ $t->created_at->format('d-m-Y') }}
</td>

<td>
<a href="{{ route('petugas.transaksi.show', $t->id) }}"
class="btn btn-info btn-sm">
View
</a>
</td>

</tr>

@endforeach

</tbody>

</table>

@endif

</div>

@endsection