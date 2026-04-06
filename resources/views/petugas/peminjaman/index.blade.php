{{-- resources/views/petugas/peminjaman/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Peminjaman</h2>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Peminjam</th>
                <th>Alat</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $item)
            <tr>
                <td>{{ $item->kode_peminjaman }}</td>
                <td>{{ $item->user->name }}</td>
                <td>
                    @foreach($item->details as $detail)
                        <div>
                            {{ $detail->alat->nama }} 
                            ({{ $detail->jumlah }} unit)
                        </div>
                    @endforeach
                </td>
                <td>{{ $item->tanggal_pinjam }}</td>
                <td>{{ $item->tanggal_kembali_rencana }}</td>
               
                <td>
        

                    @if($item->status == 'pending')
                        <span class="badge badge-warning">Menunggu</span>

                    @elseif($item->status == 'disetujui')
                        <span class="badge badge-success">Disetujui</span>

                    @elseif($item->status == 'dipinjam')
                        <span class="badge badge-primary">Dipinjam</span>

                    @elseif($item->status == 'dalam_pengembalian')
                        <span class="badge badge-info">Menunggu Konfirmasi Pengembalian</span>

                    @elseif($item->status == 'menunggu_transaksi')
                        <span class="badge badge-secondary">Menunggu Transaksi</span>

                    @elseif($item->status == 'selesai')
                        <span class="badge badge-dark">Selesai</span>

                    @elseif($item->status == 'ditolak')
                        <span class="badge badge-danger">Ditolak</span>

                    @else
                        <span class="badge badge-light">{{ $item->status }}</span>
                    @endif
                </td>


                <td>
                    @if($item->status == 'pending')
                        <form action="{{ route('petugas.peminjaman.approve', $item) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                        </form>
                        
                        <form action="{{ route('petugas.peminjaman.reject', $item) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection