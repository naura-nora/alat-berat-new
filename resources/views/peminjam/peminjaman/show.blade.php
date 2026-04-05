@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Peminjaman</h2>

        <a href="{{ route('peminjam.peminjaman.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th width="30%">Kode Peminjaman</th>
                    <td>{{ $peminjaman->kode_peminjaman }}</td>
                </tr>

                <tr>
                    <th>Nama Alat</th>
                    <td>
                        @foreach($peminjaman->details as $detail)
                            {{ $detail->alat->nama }}
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Pinjam</th>
                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</td>
                </tr>

                <tr>
                    <th>Tanggal Kembali Rencana</th>
                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->format('d/m/Y') }}</td>
                </tr>

                <tr>
                    <th>Tanggal Kembali Aktual</th>
                    <td>
                        @if($peminjaman->pengembalian)
                            {{ \Carbon\Carbon::parse($peminjaman->pengembalian->tanggal_kembali_aktual)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Jumlah</th>
                    <td>{{ $peminjaman->jumlah }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($peminjaman->status == 'pending')
                            <span class="badge bg-warning">Pending</span>

                        @elseif($peminjaman->status == 'disetujui')
                            <span class="badge bg-success">Disetujui</span>

                        @elseif($peminjaman->status == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>

                        @elseif($peminjaman->status == 'dalam_pengembalian')
                            <span class="badge bg-info">Dalam Pengembalian</span>

                        @else
                            <span class="badge bg-secondary">{{ $peminjaman->status }}</span>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Tombol kembalikan jika status disetujui --}}
            @if($peminjaman->status == 'disetujui')
                <form action="{{ route('peminjam.peminjaman.kembalikan', $peminjaman->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary">
                        <i class="fas fa-undo"></i> Ajukan Pengembalian
                    </button>
                </form>
            @endif

        </div>
    </div>

</div>
@endsection
