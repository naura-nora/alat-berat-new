@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Data Peminjaman (Admin)</h2>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- DATA KOSONG --}}
    @if($peminjaman->isEmpty())
        <div class="alert alert-info">
            Belum ada data peminjaman.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Peminjam</th>
                        <th>Petugas</th>
                        <th>Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $item)
                    <tr>
                        {{-- KODE --}}
                        <td>{{ $item->kode_peminjaman }}</td>

                        {{-- PEMINJAM --}}
                        <td>{{ $item->user->name ?? '-' }}</td>

                        {{-- PETUGAS --}}
                        <td>{{ $item->petugas->name ?? '-' }}</td>

                        {{-- BARANG --}}
                        <td>
                            @foreach($item->details as $detail)
                                {{ $detail->alat->nama_alat ?? '-' }} ({{ $detail->jumlah }}) <br>
                            @endforeach
                        </td>

                        {{-- TANGGAL --}}
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d/m/Y') }}</td>

                        {{-- JUMLAH --}}
                        <td>{{ $item->jumlah_barang }}</td>

                        {{-- STATUS --}}
                        <td>
                            @if($item->status == 'pending')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($item->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($item->status == 'dipinjam')
                                <span class="badge bg-primary">Dipinjam</span>
                            @elseif($item->status == 'dalam_pengembalian')
                                <span class="badge bg-info text-dark">Proses Pengembalian</span>
                            @elseif($item->status == 'dikembalikan')
                                <span class="badge bg-secondary">Dikembalikan</span>
                            @elseif($item->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-dark">{{ $item->status }}</span>
                            @endif
                        </td>

                        {{-- AKSI ADMIN --}}
                        <td>
                            {{-- DETAIL (optional nanti bisa kamu buat route sendiri) --}}
                            <a href="#" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            {{-- HAPUS --}}
                            <form action="{{ route('admin.peminjaman.destroy', $item->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($peminjaman->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $peminjaman->links() }}
        </div>
        @endif
    @endif
</div>
@endsection