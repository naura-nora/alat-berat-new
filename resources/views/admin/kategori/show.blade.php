{{-- resources/views/admin/kategori/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin - Detail Kategori')
@section('page-title', 'Detail Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Kategori</h5>
                <span class="badge bg-primary">ID: {{ $kategori->id }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h4>{{ $kategori->nama }}</h4>
                        @if($kategori->deskripsi)
                            <p class="text-muted">{{ $kategori->deskripsi }}</p>
                        @endif
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-calendar"></i> 
                            {{ $kategori->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Informasi Kategori</h6>
                            </div>
                            <div class="card-body">
                                <dl class="mb-0">
                                    <dt>Nama Kategori:</dt>
                                    <dd>{{ $kategori->nama }}</dd>
                                    
                                    <dt>Deskripsi:</dt>
                                    <dd>{{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Timestamps</h6>
                            </div>
                            <div class="card-body">
                                <dl class="mb-0">
                                    <dt>Dibuat Pada:</dt>
                                    <dd>{{ $kategori->created_at->format('d/m/Y H:i:s') }}</dd>
                                    
                                    <dt>Diperbarui Pada:</dt>
                                    <dd>{{ $kategori->updated_at->format('d/m/Y H:i:s') }}</dd>
                                    
                                    <dt>Status:</dt>
                                    <dd>
                                        <span class="badge bg-success">Aktif</span>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <div>
                        <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Kategori
                        </a>
                        <button type="button" class="btn btn-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i> Hapus Kategori
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Peringatan!</strong> Tindakan ini akan menghapus kategori secara permanen.
                </div>
                <p>Apakah Anda yakin ingin menghapus kategori <strong>"{{ $kategori->nama }}"</strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection