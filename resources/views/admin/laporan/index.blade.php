@extends('layouts.app')

@section('content')


    @foreach($laporan as $bulan => $lap)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-calendar me-2"></i>
                    <strong>{{ $lap['bulan'] }} {{ $tahunSekarang }}</strong>
                    <span class="badge bg-light text-dark ms-2">{{ $lap['total_peminjaman'] }} transaksi</span>
                </div>
                <a href="{{ route('admin.laporan.cetak.bulan', [$tahunSekarang, $bulan]) }}" 
                   class="btn btn-light btn-sm" target="_blank">
                    <i class="fas fa-print"></i> Cetak
                </a>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($lap['data']->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="25%">Peminjam</th>
                            <th width="12%" class="text-center">Jumlah Barang</th>
                            <th width="28%">Barang</th>
                            <th width="15%" class="text-end">Total Harga</th>
                            <th width="15%" class="text-end">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lap['data'] as $peminjaman)
                        <tr>
                            <td><strong>{{ $peminjaman->user->name }}</strong></td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $peminjaman->details->sum('jumlah') }}</span>
                            </td>
                            <td>
                                @foreach($peminjaman->details->take(2) as $detail)
                                    - {{ $detail->alat->nama }} ({{ $detail->jumlah }})
                                    <br>
                                @endforeach
                                @if($peminjaman->details->count() > 2)
                                    +{{ $peminjaman->details->count() - 2 }} item lagi
                                @endif
                            </td>
                            <td class="fw-bold text-success text-end">
                                Rp {{ number_format($peminjaman->transaksi->total_bayar ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="text-end {{ ($peminjaman->transaksi->denda ?? 0) > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                                {{ ($peminjaman->transaksi->denda ?? 0) > 0 ? 'Rp ' . number_format($peminjaman->transaksi->denda, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-success">
                        <tr class="fw-bold">
                            <td colspan="2" class="text-end">TOTAL {{ $lap['bulan'] }}</td>
                            <td class="text-center">{{ $lap['total_barang'] }} barang</td>
                            <td class="text-end">Rp {{ number_format($lap['total_harga'], 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($lap['total_denda'], 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="text-center py-5 bg-light rounded">
                <i class="fas fa-calendar-xmark fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada peminjaman di {{ $lap['bulan'] }}</h5>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection