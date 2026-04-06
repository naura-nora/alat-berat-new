@extends('layouts.app')

@section('title', 'Data Alat Berat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Alat Berat</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.alat.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah Alat
                        </a>
                    </div>
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
                                    <span class="info-box-number">{{ $alat->total() }}</span>
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
                                        {{ $alat->where('status', 'tersedia')->count() }}
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
                                        {{ $alat->where('status', 'dipinjam')->count() }}
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
                                        {{ $alat->where('status', 'maintenance')->count() }}
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
                                    <th></th>
                                    <th>Kode</th>
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
                                        <strong>{{ $item->kode_alat }}</strong>
                                        @if($item->gambar) 
                                        <br>
                                        <img src="{{ asset('images/' . $item->gambar) }}" 
                                            class="img-thumbnail mt-1" 
                                            style="width: 50px; height: 50px; object-fit: cover;"
                                            alt="Gambar {{ $item->nama }}">
                                        @endif
                                    </td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                                    <td>{{ $item->merk ?? '-' }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.alat.show', $item) }}" 
                                               class="btn btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.alat.edit', $item) }}" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.alat.destroy', $item) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin hapus data?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        <i class="fas fa-tools fa-2x mb-2"></i><br>
                                        Belum ada data alat berat.
                                    </td>
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