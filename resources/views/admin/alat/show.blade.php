@extends('layouts.app')

@section('title', 'Detail Alat Berat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Alat Berat</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.alat.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($alat->gambar)
                                <img src="{{ Storage::url($alat->gambar) }}" 
                                     alt="{{ $alat->nama }}" 
                                     class="img-fluid rounded shadow" 
                                     style="max-height: 250px;">
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
                                    <td>{{ $alat->stok }} unit</td>
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
                                    </td>
                                </tr>
                                <tr>
                                    <th>Harga Sewa</th>
                                    <td>Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Dibuat</th>
                                    <td>{{ $alat->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diupdate</th>
                                    <td>{{ $alat->updated_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                            
                            @if($alat->deskripsi)
                            <div class="mt-3">
                                <h5>Deskripsi:</h5>
                                <p class="text-justify">{{ $alat->deskripsi }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.alat.edit', $alat) }}" class="btn btn-warning">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.alat.destroy', $alat) }}" method="POST" 
                          class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Statistik</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Dibuat
                            <span class="badge badge-secondary">{{ $alat->created_at->diffForHumans() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Diupdate
                            <span class="badge badge-secondary">{{ $alat->updated_at->diffForHumans() }}</span>
                        </li>
                        @if($alat->kategori)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Alat di Kategori
                            <span class="badge badge-primary">{{ $alat->kategori->alat->count() }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.alat.create') }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-plus mr-1"></i> Tambah Alat Baru
                    </a>
                    <a href="{{ route('admin.alat.index') }}" class="btn btn-secondary btn-block mb-2">
                        <i class="fas fa-list mr-1"></i> Lihat Semua Alat
                    </a>
                    <button class="btn btn-info btn-block mb-2" onclick="window.print()">
                        <i class="fas fa-print mr-1"></i> Cetak Detail
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection