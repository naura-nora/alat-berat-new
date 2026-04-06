@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Riwayat Peminjaman Saya</h2>
        <!-- <a href="{{ route('peminjam.peminjaman.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajukan Peminjaman Baru
        </a> -->
    </div>

    @if($peminjaman->isEmpty())
        <div class="alert alert-info">
            Anda belum memiliki riwayat peminjaman. Silakan ajukan peminjaman baru.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Alat</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali Rencana</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjaman as $item)
                <tr>
                    <td>{{ $item->kode_peminjaman }}</td>
                    <td>
                        @foreach($item->details as $detail)
                            {{ $detail->alat->nama_alat }} ({{ $detail->jumlah }}) <br>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d/m/Y') }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>
                        @if($item->status == 'pending')
                            <span class="badge badge-warning">Menunggu</span>
                        @elseif($item->status == 'disetujui')
                            <span class="badge badge-success">Disetujui</span>
                        @elseif($item->status == 'dalam_pengembalian')
                            <span class="badge badge-info">Menunggu Konfirmasi Pengembalian</span>
                        @elseif($item->status == 'dikembalikan')
                            <span class="badge badge-secondary">Dikembalikan</span>
                        @elseif($item->status == 'ditolak')
                            <span class="badge badge-danger">Ditolak</span>
                        @else
                            <span class="badge badge-secondary">{{ $item->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('peminjam.peminjaman.show', $item->id) }}" 
                           class="btn btn-sm btn-info" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        @if($item->status == 'pending')
                        <a href="{{ route('peminjam.peminjaman.edit', $item->id) }}" 
                           class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <form action="{{ route('peminjam.peminjaman.destroy', $item->id) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Batalkan">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                        
                        {{-- TOMBOL KEMBALIKAN UNTUK STATUS DISETUJUI --}}
                        @if($item->status == 'disetujui')
                        <form action="{{ route('peminjam.peminjaman.kembalikan', $item->id) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Ajukan pengembalian alat ini?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary" title="Ajukan Pengembalian">
                                <i class="fas fa-undo"></i> Kembalikan
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if($peminjaman->hasPages())
        <div class="d-flex justify-content-center">
            {{ $peminjaman->links() }}
        </div>
        @endif
    @endif
</div>



@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var audio = new Audio('/audio/sound-correct.wav');
        audio.play().catch(function(error) {
            console.log('Suara tidak bisa diputar:', error);
        });
    });
</script>
@endif


@endsection


