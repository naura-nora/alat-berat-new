@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Peminjaman</h3>
                    <div class="card-tools">
                        {{-- Kosongkan seperti di index alat --}}
                    </div>
                </div>
                <div class="card-body">
                    @if($peminjaman->isEmpty())
                        <div class="alert alert-info">
                            Belum ada data peminjaman.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background-color: #fff;">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Peminjaman</th>
                                        <th>Peminjam</th>
                                        <th>Petugas</th>
                                        <th>Barang</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjaman as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + ($peminjaman->perPage() * ($peminjaman->currentPage() - 1)) }}</td>
                                        <td>{{ $item->kode_peminjaman }}</td>
                                        <td>{{ $item->user->name ?? '-' }}</td>
                                        <td>{{ $item->petugas->name ?? '-' }}</td>
                                        {{-- PERBAIKAN ADA DI SINI --}}
                                        <td>
                                            @if($item->details && $item->details->count() > 0)
                                                @foreach($item->details as $detail)
                                                    {{ $detail->alat->nama ?? '-' }} ({{ $detail->jumlah }})<br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d/m/Y') }}</td>
                                        <td>{{ $item->jumlah_barang }} unit</td>
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
                                            @endphp
                                            <span class="badge badge-{{ $statusColors[$item->status] ?? 'secondary' }}">
                                                @if($item->status == 'pending')
                                                    Menunggu
                                                @elseif($item->status == 'disetujui')
                                                    Disetujui
                                                @elseif($item->status == 'dipinjam')
                                                    Dipinjam
                                                @elseif($item->status == 'dalam_pengembalian')
                                                    Proses Pengembalian
                                                @elseif($item->status == 'dikembalikan')
                                                    Dikembalikan
                                                @elseif($item->status == 'ditolak')
                                                    Ditolak
                                                @else
                                                    {{ $item->status }}
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.peminjaman.show', $item->id) }}" class="btn btn-info" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.peminjaman.destroy', $item->id) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection