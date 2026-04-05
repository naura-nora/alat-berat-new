@extends('layouts.app')

@section('title', 'Edit Alat Berat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Edit Alat Berat</h3>
                </div>
                <form action="{{ route('admin.alat.update', $alat) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kategori_id">Kategori *</label>
                                    <select class="form-control @error('kategori_id') is-invalid @enderror" 
                                            id="kategori_id" name="kategori_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" 
                                                {{ old('kategori_id', $alat->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_alat">Kode Alat *</label>
                                    <input type="text" class="form-control @error('kode_alat') is-invalid @enderror" 
                                           id="kode_alat" name="kode_alat" 
                                           value="{{ old('kode_alat', $alat->kode_alat) }}" 
                                           placeholder="Contoh: EXC-001" required>
                                    @error('kode_alat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama">Nama Alat *</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" 
                                           value="{{ old('nama', $alat->nama) }}" 
                                           placeholder="Contoh: Excavator Caterpillar 320D" required>
                                    @error('nama')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stok">Stok *</label>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                           id="stok" name="stok" 
                                           value="{{ old('stok', $alat->stok) }}" 
                                           min="1" required>
                                    @error('stok')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control @error('merk') is-invalid @enderror" 
                                   id="merk" name="merk" 
                                   value="{{ old('merk', $alat->merk) }}" 
                                   placeholder="Contoh: Caterpillar">
                            @error('merk')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="harga_sewa">Harga Sewa *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" class="form-control @error('harga_sewa') is-invalid @enderror" 
                                               id="harga_sewa" name="harga_sewa" 
                                               value="{{ old('harga_sewa', $alat->harga_sewa) }}" 
                                               min="0" step="1000" 
                                               placeholder="500000" required>
                                    </div>
                                    @error('harga_sewa')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        
                        <div class="form-group">
                            <label>Denda Keterlambatan / Hari</label>
                            <input type="number"
                                name="denda_per_hari"
                                class="form-control"
                                value="{{ old('denda_per_hari', $alat->denda_per_hari) }}"
                                min="0">
                        </div>




                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" 
                                      rows="3" placeholder="Deskripsi alat...">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gambar">Gambar Alat</label>
                            @if($alat->gambar)
                            <div class="mb-2">
                                <img src="{{ asset('images/' . $alat->gambar) }}"
                                     alt="{{ $alat->nama }}" 
                                     class="img-thumbnail" style="max-height: 150px;">
                                <p class="text-muted">Gambar saat ini</p>
                            </div>
                            @endif
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror" 
                                       id="gambar" name="gambar" accept="image/*">
                                <label class="custom-file-label" for="gambar">
                                    {{ $alat->gambar ? 'Ganti gambar...' : 'Pilih file...' }}
                                </label>
                                @error('gambar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                Biarkan kosong jika tidak ingin mengubah gambar.
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save mr-1"></i> Update
                        </button>
                        <a href="{{ route('admin.alat.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <a href="{{ route('admin.alat.show', $alat) }}" class="btn btn-info ml-2">
                            <i class="fas fa-eye mr-1"></i> Lihat Detail
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Saat Ini</h3>
                </div>
                <div class="card-body">
                    <p><strong>Kode:</strong> {{ $alat->kode_alat }}</p>
                    <p><strong>Nama:</strong> {{ $alat->nama }}</p>
                    <p><strong>Kategori:</strong> {{ $alat->kategori->nama ?? '-' }}</p>
                    <p><strong>Status:</strong> 
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
                    <p><strong>Stok:</strong> {{ $alat->stok }} unit</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview file name
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("gambar").files[0]?.name || 'Pilih file...';
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush