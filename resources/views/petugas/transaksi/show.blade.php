@extends('layouts.app')

@section('content')

<style>

.struk-card{
max-width:500px;
margin:auto;
border-radius:10px;
}

.struk-header{
text-align:center;
font-weight:bold;
font-size:18px;
}

.struk-line{
border-top:1px dashed #ccc;
margin:10px 0;
}

.total-box{
font-size:18px;
font-weight:bold;
color:#198754;
}

</style>

<div class="container">

<div class="card shadow struk-card">

<div class="card-body">

<div class="struk-header">
DETAIL TRANSAKSI
</div>

<div class="struk-line"></div>

<p>
<b>Kode Transaksi :</b><br>
{{ $transaksi->kode_transaksi }}
</p>

<p>
<b>Peminjam :</b><br>
{{ $transaksi->peminjaman->user->name }}
</p>

<p>
<b>No Telp :</b><br>
{{ $transaksi->no_telp }}
</p>

<p>
<b>Tanggal :</b><br>
{{ $transaksi->created_at->format('d-m-Y') }}
</p>

<div class="struk-line"></div>

<p><b>Daftar Alat</b></p>

<table class="table table-sm">

<thead>
<tr>
<th>Alat</th>
<th class="text-center">Qty</th>
</tr>
</thead>

<tbody>

@foreach($transaksi->peminjaman->details as $detail)

<tr>
<td>{{ $detail->alat->nama }}</td>
<td class="text-center">{{ $detail->jumlah }}</td>
</tr>

@endforeach

</tbody>

</table>

<div class="struk-line"></div>

<p>
<b>Metode Pembayaran :</b>
<span class="badge bg-primary">
{{ strtoupper($transaksi->metode_pembayaran) }}
</span>
</p>

<p class="total-box">
Total Bayar :
Rp {{ number_format($transaksi->total_bayar,0,',','.') }}
</p>

<div class="struk-line"></div>

<p class="text-center text-muted">
Terima kasih telah menyewa alat kami
</p>

<div class="d-flex justify-content-center gap-2">

<button onclick="window.print()" class="btn btn-success btn-sm">
Cetak Struk
</button>

<a href="{{ route('petugas.transaksi.index') }}" class="btn btn-secondary btn-sm">
Kembali
</a>

</div>

</div>
</div>

</div>

@endsection