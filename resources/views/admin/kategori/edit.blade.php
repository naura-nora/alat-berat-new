{{-- resources/views/admin/kategori/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin - Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Kategori: {{ $kategori->nama }}</h5>
                <span class="badge bg-info">ID: {{ $kategori->id }}</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Dibuat Pada</label>
                            <input type="text" class="form-control" 
                                   value="{{ $kategori->created_at->format('d/m/Y H:i:s') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Diperbarui Pada</label>
                            <input type="text" class="form-control" 
                                   value="{{ $kategori->updated_at->format('d/m/Y H:i:s') }}" readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <div>
                            <a href="{{ route('admin.kategori.show', $kategori) }}" class="btn btn-info">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Perbarui
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection