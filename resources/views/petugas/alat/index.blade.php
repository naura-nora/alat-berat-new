@extends('layouts.app')

@section('title', 'Data Alat Berat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Alat Berat</h3>
                </div>
                <div class="card-body">
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1">
                                    <i class="fas fa-tools"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Alat</span>
                                    <span class="info-box-number">{{ \App\Models\Alat::count() }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success elevation-1">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Tersedia</span>
                                    <span class="info-box-number">
                                        {{ \App\Models\Alat::where('status', 'tersedia')->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1">
                                    <i class="fas fa-hand-holding"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Dipinjam</span>
                                    <span class="info-box-number">
                                        {{ \App\Models\Alat::where('status', 'dipinjam')->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1">
                                    <i class="fas fa-wrench"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Maintenance</span>
                                    <span class="info-box-number">
                                        {{ \App\Models\Alat::where('status', 'maintenance')->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Gambar</th>
                                    <th>Kode Alat</th>
                                    <th>Nama Alat</th>
                                    <th>Kategori</th>
                                    <th>Merk</th>
                                    <th>Stok</th>
                                    <th>Harga Sewa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alat as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($alat->perPage() * ($alat->currentPage() - 1)) }}</td>
                                   
                                    <td>
                                        @if($item->gambar_url)
                                            <img src="{{ $item->gambar_url }}" 
                                                class="rounded shadow-sm"
                                                style="width: 80px; height: 60px; object-fit: cover;"
                                                alt="Gambar {{ $item->nama }}">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </p>
                                    <td>{{ $item->kode_alat }}</p>
                                    <td>{{ $item->nama }}</p>
                                    <td>{{ $item->kategori->nama ?? '-' }}</p>
                                    <td>{{ $item->merk ?? '-' }}</p>
                                    <td>{{ $item->stok }}</p>
                                    
                                    <td>Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}</p>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('petugas.alat.show', $item) }}" 
                                               class="btn btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </p>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        <i class="fas fa-tools fa-2x mb-2"></i><br>
                                        Belum ada data alat berat.
                                    </p>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $alat->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection