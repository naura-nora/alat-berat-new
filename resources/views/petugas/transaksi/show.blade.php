@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Transaksi</h3>
                    <div class="card-tools">
                        <a href="{{ route('petugas.transaksi.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Kode Transaksi</th>
                                    <td>{{ $transaksi->kode_transaksi }}</td>
                                </tr>
                                <tr>
                                    <th>Peminjam</th>
                                    <td>{{ $transaksi->peminjaman->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>No Telepon</th>
                                    <td>{{ $transaksi->no_telp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <td>{{ $transaksi->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ strtoupper($transaksi->metode_pembayaran) }}
                                        </span>
                                    </p>
                                </tr>
                                <tr>
                                    <th>Total Bayar</th>
                                    <td>
                                        <strong class="text-success" style="font-size: 16px;">
                                            Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                                        </strong>
                                    </p>
                                </tr>

                                {{-- KOLOM KEMBALIAN (HANYA UNTUK CASH) --}}
                                @if($transaksi->metode_pembayaran == 'cash')
                                <tr>
                                    <th>Uang Dibayar</th>
                                    <td>
                                        Rp {{ number_format($transaksi->uang_dibayar, 0, ',', '.') }}
                                    </p>
                                </tr>
                                <tr>
                                    <th>Kembalian</th>
                                    <td>
                                        <strong class="text-danger">
                                            Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
                                        </strong>
                                    </p>
                                </tr>
                                @endif

                            </table>

                            @if($transaksi->peminjaman->details && $transaksi->peminjaman->details->count() > 0)
                            <div class="mt-4">
                                <h5>Detail Alat yang Disewa:</h5>
                                <div class="table-responsive mt-2">
                                    <table class="table table-bordered table-sm">
                                        <thead style="background-color: #fff;">
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Alat</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaksi->peminjaman->details as $detail)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $detail->alat->nama ?? '-' }}</p>
                                                <td>{{ $detail->jumlah }} unit</p>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('petugas.transaksi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button onclick="window.print()" class="btn btn-success">
                            <i class="fas fa-print mr-1"></i> Cetak Struk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection