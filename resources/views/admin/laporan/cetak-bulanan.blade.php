<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman - {{ $bulan }} {{ $tahun }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">

</head>
<body>
    <div class="header">
        <h1>LAPORAN PEMINJAMAN ALAT BERAT</h1>
        <h2>{{ $bulan }} {{ $tahun }}</h2>
    </div>

    <div class="summary">
        <strong>Total Peminjaman:</strong> {{ $total_peminjaman }}<br>
        <strong>Total Barang:</strong> {{ $total_barang }}<br>
        <strong>Total Harga Sewa:</strong> Rp {{ number_format($total_harga, 0, ',', '.') }}<br>
        <strong>Total Denda:</strong> Rp {{ number_format($total_denda, 0, ',', '.') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pinjam</th>
                <th>User</th>
                <th>Alat</th>
                <th>Jumlah</th>
                <th>Total Bayar</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $peminjaman)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                <td>{{ $peminjaman->user->name }}</td>
                <td>
                    @foreach($peminjaman->details as $detail)
                        {{ $detail->alat->nama }} ({{ $detail->jumlah }})
                    @endforeach
                </td>
                <td>{{ $peminjaman->details->sum('jumlah') }}</td>
                <!-- ✅ PAKAI total_bayar dari transaksi -->
                <td>Rp {{ number_format($peminjaman->transaksi->total_bayar ?? 0, 0, ',', '.') }}</td>
                <td>{{ ucfirst($peminjaman->status) }}</td>
                <td>Rp {{ number_format($peminjaman->transaksi->denda ?? 0, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <script>window.print();</script>
</body>
</html>