@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Peminjaman</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary btn-sm">
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
                                    <td>{{ $peminjaman->kode_peminjaman }}</td>
                                </tr>
                                <tr>
                                    <th>Peminjam</th>
                                    <td>{{ $peminjaman->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Petugas</th>
                                    <td>{{ $peminjaman->petugas->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pinjam</th>
                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kembali Rencana</th>
                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kembali Aktual</th>
                                        <td>
                                            @if($peminjaman->pengembalian && $peminjaman->pengembalian->tanggal_kembali_aktual)
                                                {{ \Carbon\Carbon::parse($peminjaman->pengembalian->tanggal_kembali_aktual)->format('d F Y') }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                </tr>
                                <tr>
                                    <th>Jumlah Barang</th>
                                    <td>{{ $peminjaman->jumlah_barang }} unit</p></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'disetujui' => 'success',
                                                'dipinjam' => 'primary',
                                                'dalam_pengembalian' => 'info',
                                                'dikembalikan' => 'secondary',
                                                'ditolak' => 'danger'
                                            ];
                                            $statusTexts = [
                                                'pending' => 'Menunggu',
                                                'disetujui' => 'Disetujui',
                                                'dipinjam' => 'Dipinjam',
                                                'dalam_pengembalian' => 'Proses Pengembalian',
                                                'dikembalikan' => 'Dikembalikan',
                                                'ditolak' => 'Ditolak'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $statusColors[$peminjaman->status] ?? 'secondary' }}">
                                            {{ $statusTexts[$peminjaman->status] ?? ucfirst($peminjaman->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <td>{{ $peminjaman->alasan_peminjaman ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Dibuat</th>
                                    <td>{{ $peminjaman->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diupdate</th>
                                    <td>{{ $peminjaman->updated_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                            
                            @if($peminjaman->details && $peminjaman->details->count() > 0)
                            <div class="mt-4">
                                <h5>Detail Barang yang Dipinjam:</h5>
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
                                            {{-- PERBAIKAN ADA DI SINI --}}
                                            @foreach($peminjaman->details as $index => $detail)
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
                
            </div>
        </div>
    </div>
</div>
@endsection