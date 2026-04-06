@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cek Pengembalian</h2>
    <h4>Kode: {{ $pengembalian->peminjaman->kode_peminjaman }}</h4>
    <h4>Peminjam: {{ $pengembalian->peminjaman->user->name }}</h4>

    <form action="{{ route('petugas.pengembalian.proses.cek', $pengembalian->id) }}" method="POST">
        @csrf

        @foreach($pengembalian->peminjaman->details as $index => $detail)
        <div class="card mb-4">
            <div class="card-header">
                <strong>{{ $detail->alat->nama }}</strong>
                <input type="hidden" name="detail[{{ $index }}][id]" value="{{ $detail->id }}">
                <input type="hidden" name="detail[{{ $index }}][jumlah]" value="{{ $detail->jumlah }}">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Jumlah Dipinjam: <strong>{{ $detail->jumlah }}</strong></label>
                    </div>
                    <div class="col-md-4">
                        <label>Jumlah Baik</label>
                        <input type="number" 
                               name="detail[{{ $index }}][jumlah_baik]" 
                               class="form-control jumlah-baik"
                               data-index="{{ $index }}"
                               data-jumlah="{{ $detail->jumlah }}"
                               min="0" 
                               max="{{ $detail->jumlah }}"
                               value="{{ $detail->jumlah }}"
                               required>
                    </div>
                    <div class="col-md-4">
                        <label>Jumlah Rusak</label>
                        <input type="number" 
                               name="detail[{{ $index }}][jumlah_rusak]" 
                               class="form-control jumlah-rusak-{{ $index }}"
                               readonly
                               value="0">
                    </div>
                </div>

                {{-- FORM KERUSAKAN (muncul jika jumlah_rusak > 0) --}}
                <div class="kerusakan-container-{{ $index }}" style="display: none; margin-top: 15px;">
                    <div class="alert alert-warning">
                        <h6>Detail Kerusakan:</h6>
                        <div class="kerusakan-list-{{ $index }}">
                            <div class="row mb-2 kerusakan-item-0">
                                <div class="col-md-6">
                                    <input type="text" 
                                           name="detail[{{ $index }}][kerusakan][0][deskripsi]" 
                                           class="form-control form-control-sm" 
                                           placeholder="Deskripsi kerusakan">
                                </div>
                                <div class="col-md-4">
                                    <input type="number" 
                                           name="detail[{{ $index }}][kerusakan][0][biaya]" 
                                           class="form-control form-control-sm" 
                                           placeholder="Biaya perbaikan">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm hapus-kerusakan" style="display: none;">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-success tambah-kerusakan mt-2" data-index="{{ $index }}">
                            + Tambah Kerusakan Lain
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Proses Pengembalian</button>
        <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    // Hitung jumlah rusak otomatis
    document.querySelectorAll('.jumlah-baik').forEach(function(input) {
        input.addEventListener('input', function() {
            let index = this.dataset.index;
            let jumlahTotal = parseInt(this.dataset.jumlah);
            let jumlahBaik = parseInt(this.value) || 0;
            let jumlahRusak = jumlahTotal - jumlahBaik;
            
            let rusakInput = document.querySelector('.jumlah-rusak-' + index);
            rusakInput.value = jumlahRusak;
            
            let kerusakanContainer = document.querySelector('.kerusakan-container-' + index);
            
            if (jumlahRusak > 0) {
                kerusakanContainer.style.display = 'block';
            } else {
                kerusakanContainer.style.display = 'none';
            }
        });
    });
    
    // Tambah baris kerusakan
    document.querySelectorAll('.tambah-kerusakan').forEach(function(btn) {
        btn.addEventListener('click', function() {
            let index = this.dataset.index;
            let container = document.querySelector('.kerusakan-list-' + index);
            let itemCount = container.children.length;
            
            let newRow = document.createElement('div');
            newRow.className = 'row mb-2 kerusakan-item-' + itemCount;
            newRow.innerHTML = `
                <div class="col-md-6">
                    <input type="text" 
                           name="detail[${index}][kerusakan][${itemCount}][deskripsi]" 
                           class="form-control form-control-sm" 
                           placeholder="Deskripsi kerusakan">
                </div>
                <div class="col-md-4">
                    <input type="number" 
                           name="detail[${index}][kerusakan][${itemCount}][biaya]" 
                           class="form-control form-control-sm" 
                           placeholder="Biaya perbaikan">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm hapus-kerusakan">Hapus</button>
                </div>
            `;
            container.appendChild(newRow);
            
            // Event hapus
            newRow.querySelector('.hapus-kerusakan').addEventListener('click', function() {
                newRow.remove();
            });
        });
    });
</script>
@endsection