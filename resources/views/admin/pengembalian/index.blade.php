@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Pengembalian (Admin)</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Peminjam</th>
                <th>Petugas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengembalian as $key => $item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $item->peminjaman->kode_peminjaman }}</td>
                <td>{{ $item->peminjaman->user->name }}</td>
                <td>{{ $item->petugas->name ?? '-' }}</td>

                {{-- STATUS FIX --}}
                <td>
                    @if($item->status == 'menunggu')
                        <span class="badge bg-warning">Menunggu</span>
                    @elseif($item->status == 'dicek')
                        <span class="badge bg-info">Dicek</span>
                    @elseif($item->status == 'selesai')
                        <span class="badge bg-success">Selesai</span>
                    @else
                        <span class="badge bg-secondary">{{ $item->status }}</span>
                    @endif
                </td>

                {{-- AKSI FIX --}}
                <td>
                    <a href="{{ route('admin.pengembalian.show', $item->id) }}" 
                       class="btn btn-sm btn-info">Detail</a>

                    <form action="{{ route('admin.pengembalian.destroy', $item->id) }}" 
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