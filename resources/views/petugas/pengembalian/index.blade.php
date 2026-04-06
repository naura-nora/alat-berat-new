@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Pengembalian - Petugas</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Peminjam</th>
                <th>Barang</th>
                <th>Status</th>
                <th width="200">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($pengembalian as $key => $item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $item->peminjaman->kode_peminjaman }}</td>
                <td>{{ $item->peminjaman->user->name }}</td>

                <td>
                    @foreach($item->peminjaman->details as $detail)
                        {{ $detail->alat->nama_alat }} ({{ $detail->jumlah }})<br>
                    @endforeach
                </td>

                <td>
                    @if($item->status == 'menunggu')
                        <span class="badge bg-warning">Menunggu</span>
                    @elseif($item->status == 'dicek')
                        <span class="badge bg-info">Dicek</span>
                    @elseif($item->status == 'selesai')
                        <span class="badge bg-success">Selesai</span>
                    @endif
                </td>

                <td>
                    {{-- CEK --}}
                    @if($item->status == 'menunggu')
                        <a href="{{ route('petugas.pengembalian.cek', $item->id) }}" 
                           class="btn btn-sm btn-warning">Cek</a>
                    @endif

                    {{-- DETAIL --}}
                    <a href="{{ route('petugas.pengembalian.show', $item->id) }}" 
                       class="btn btn-sm btn-info">Detail</a>

                    {{-- DELETE --}}
                    <form action="{{ route('petugas.pengembalian.batalkan', $item->id) }}" 
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $pengembalian->links() }}
</div>
@endsection