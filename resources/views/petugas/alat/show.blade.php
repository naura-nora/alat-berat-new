@extends('layouts.app')

@section('title', 'Detail Alat Berat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Alat Berat</h3>
                    <div class="card-tools">
                        <a href="{{ route('petugas.alat.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($alat->gambar)
                                <img src="{{ asset('images/' . $alat->gambar) }}" 
                                    alt="{{ $alat->nama }}" 
                                    class="img-fluid rounded shadow" 
                                    style="max-height: 250px; width: 100%; object-fit: cover;">
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-tools fa-5x text-muted"></i>
                                    <p class="mt-2">Tidak ada gambar</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Kode Alat</th>
                                    <td>{{ $alat->kode_alat }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Alat</th>
                                    <td>{{ $alat->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>{{ $alat->kategori->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Merk</th>
                                    <td>{{ $alat->merk ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td>{{ $alat->stok }} unit</p>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'tersedia' => 'success',
                                                'dipinjam' => 'warning',
                                                'rusak' => 'danger',
                                                'maintenance' => 'info'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $statusColors[$alat->status] ?? 'secondary' }}">
                                            {{ ucfirst($alat->status) }}
                                        </span>
                                    </p>
                                </tr>
                                <tr>
                                    <th>Harga Sewa</th>
                                    <td>Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}</p>
                                </tr>
                                <tr>
                                    <th>Denda per Hari</th>
                                    <td>
                                        @if($alat->denda_per_hari)
                                            <span class="text-danger">
                                                <strong>Rp {{ number_format($alat->denda_per_hari, 0, ',', '.') }}</strong>
                                            </span>
                                        @else
                                            <span class="text-muted">Belum ditentukan</span>
                                        @endif
                                    </p>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $alat->deskripsi ?? '-' }}</p>
                                </tr>
                                <tr>
                                    <th>Tanggal Dibuat</th>
                                    <td>{{ $alat->created_at->format('d F Y H:i') }}</p>
                                </tr>
                                <tr>
                                    <th>Terakhir Diupdate</th>
                                    <td>{{ $alat->updated_at->format('d F Y H:i') }}</p>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection