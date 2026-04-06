@extends('layouts.app')

@section('title', 'Detail Pengembalian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Pengembalian</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Kode Peminjaman</th>
                                    <td>{{ $pengembalian->peminjaman->kode_peminjaman ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Peminjam</th>
                                    <td>{{ $pengembalian->peminjaman->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kembali Aktual</th>
                                    <td>{{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali_aktual)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Denda Keterlambatan</th>
                                    <td>Rp {{ number_format($pengembalian->total_denda, 0, ',', '.') }}</p>
                                </tr>
                                <tr>
                                    <th>Denda Kerusakan</th>
                                    <td>Rp {{ number_format($pengembalian->detailKerusakan->sum('biaya_perbaikan'), 0, ',', '.') }}</p>
                                </tr>
                                <tr>
                                    <th>Total Denda Keseluruhan</th>
                                    <td>
                                        @php
                                            $totalDenda = $pengembalian->total_denda + $pengembalian->detailKerusakan->sum('biaya_perbaikan');
                                        @endphp
                                        <strong class="text-danger">
                                            Rp {{ number_format($totalDenda, 0, ',', '.') }}
                                        </strong>
                                    </p>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $pengembalian->keterangan ?? '-' }}</p>
                                </tr>
                                <tr>
                                    <th>Tanggal Dibuat</th>
                                    <td>{{ $pengembalian->created_at->format('d F Y H:i') }}</p>
                                </tr>
                                <tr>
                                    <th>Terakhir Diupdate</th>
                                    <td>{{ $pengembalian->updated_at->format('d F Y H:i') }}</p>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>
@endsection