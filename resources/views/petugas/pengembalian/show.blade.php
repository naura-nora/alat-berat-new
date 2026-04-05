@extends('layouts.app')

@section('content')
<style>
.struk-card{
    max-width:500px;
    margin:auto;
    border-radius:10px;
}
.struk-header{
    text-align:center;
    font-weight:bold;
    font-size:18px;
}
.struk-line{
    border-top:1px dashed #ccc;
    margin:10px 0;
}
.total-box{
    font-size:18px;
    font-weight:bold;
    color:#198754;
}
.status-badge{
    font-size:14px;
}
</style>

<div class="container">
    <div class="card shadow struk-card">
        <div class="card-body">
            
            {{-- HEADER --}}
            <div class="struk-header text-primary">
                DETAIL PENGEMBALIAN
            </div>

            <div class="struk-line"></div>

            {{-- INFO PEMINJAM --}}
            <p><b>Kode Pengembalian:</b><br>{{ $pengembalian->id }}</p>
            <p><b>Kode Peminjaman:</b><br>{{ $pengembalian->peminjaman->kode_peminjaman }}</p>
            <p><b>Peminjam:</b><br>{{ $pengembalian->peminjaman->user->name }}</p>
            <p><b>Tanggal Pengembalian:</b><br>{{ $pengembalian->tanggal_kembali_aktual->format('d-m-Y') }}</p>

            <div class="struk-line"></div>

            {{-- STATUS --}}
            <p><b>Status:</b><br>
                <span class="badge status-badge {{ $pengembalian->status == 'selesai' ? 'bg-success' : 'bg-warning' }}">
                    {{ ucfirst($pengembalian->status) }}
                </span>
            </p>

            <div class="struk-line"></div>

            {{-- DAFTAR ALAT --}}
            <p><b>Daftar Alat</b></p>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Alat</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalian->peminjaman->details as $detail)
                    <tr>
                        <td>{{ $detail->alat->nama }}</td>
                        <td class="text-center">{{ $detail->jumlah }}</td>
                        <td class="text-center">
                            @if($detail->kondisi_pengembalian)
                                <span class="badge bg-{{ $detail->kondisi_pengembalian == 'baik' ? 'success' : 'danger' }}">
                                    {{ ucfirst($detail->kondisi_pengembalian) }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Belum dicek</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="struk-line"></div>

            

            {{-- FOOTER --}}
            <p class="text-center text-muted mb-4">
                Terima kasih telah mengembalikan alat
            </p>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>
</div>
@endsection