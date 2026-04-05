@extends('layouts.app')

@section('title', 'Tambah Alat Berat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Alat Berat Baru</h3>
                </div>
                <form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                                                {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
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
                                           value="{{ old('kode_alat') }}" 
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
                                           value="{{ old('nama') }}" 
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
                                           value="{{ old('stok', 1) }}" 
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
                                   value="{{ old('merk') }}" 
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
                                               value="{{ old('harga_sewa') }}" 
                                               min="0" step="1000" 
                                               placeholder="500000" required>
                                    </div>
                                    @error('harga_sewa')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="denda_per_hari">Denda / Hari *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number"
                                        class="form-control @error('denda_per_hari') is-invalid @enderror"
                                        name="denda_per_hari"
                                        id="denda_per_hari"
                                        value="{{ old('denda_per_hari') }}"
                                        min="0"
                                        step="1000"
                                        placeholder="50000"
                                        required>
                                </div>

                                @error('denda_per_hari')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label>Denda Keterlambatan / Hari</label>
                            <input type="number"
                                name="denda_per_hari"
                                class="form-control"
                                value="{{ old('denda_per_hari') }}"
                                min="0">
                        </div>


                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" 
                                      rows="3" placeholder="Deskripsi alat...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gambar">Gambar Alat</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror" 
                                       id="gambar" name="gambar" accept="image/*">
                                <label class="custom-file-label" for="gambar">Pilih file...</label>
                                @error('gambar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                Format: JPG, PNG, GIF (Maks: 2MB)
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                        <a href="{{ route('admin.alat.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi</h3>
                </div>
                <div class="card-body">
                    <p><strong>Kode Alat:</strong> Gunakan format unik seperti EXC-001, DMP-002, etc.</p>
                    <p><strong>Status:</strong>
                        <ul>
                            <li><span class="badge badge-success">Tersedia</span> - Siap dipinjam</li>
                            <li><span class="badge badge-warning">Dipinjam</span> - Sedang dipinjam</li>
                            <li><span class="badge badge-danger">Rusak</span> - Tidak bisa digunakan</li>
                            <li><span class="badge badge-info">Maintenance</span> - Dalam perawatan</li>
                        </ul>
                    </p>
                    <p><strong>Stok:</strong> Jumlah unit alat yang tersedia.</p>
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
        var fileName = document.getElementById("gambar").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush