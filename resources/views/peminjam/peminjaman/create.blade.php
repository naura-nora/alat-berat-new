@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Form Peminjaman Alat</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('peminjam.peminjaman.store') }}" method="POST">
                @csrf

                {{-- TANGGAL --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Tanggal Pinjam</label>
                        <input type="date"
                               name="tanggal_pinjam"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label>Tanggal Kembali (Rencana)</label>
                        <input type="date"
                               name="tanggal_kembali_rencana"
                               class="form-control"
                               required>
                    </div>
                </div>

                {{-- ALAT SECTION --}}
                <hr>
                <h5 class="mb-3">Daftar Alat</h5>

                <div id="alat-container">

                    <div class="row mb-3 alat-item">
                        <div class="col-md-6">
                            <label>Pilih Alat</label>
                            <select name="alat_id[]" class="form-control" required>
                                <option value="">-- Pilih Alat --</option>
                                @foreach($alat as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama }} (Stok: {{ $item->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Jumlah</label>
                            <input type="number"
                                   name="jumlah[]"
                                   class="form-control"
                                   min="1"
                                   required>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-item">
                                Hapus
                            </button>
                        </div>
                    </div>

                </div>

                <button type="button" id="tambah-alat" class="btn btn-success mb-4">
                    + Tambah Alat
                </button>

                {{-- ALASAN --}}
                <div class="form-group mb-4">
                    <label>Alasan Peminjaman</label>
                    <textarea name="alasan_peminjaman"
                              rows="3"
                              class="form-control"
                              required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Ajukan Peminjaman
                </button>

            </form>
        </div>
    </div>
</div>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('alat-container');
    const tambahBtn = document.getElementById('tambah-alat');

    tambahBtn.addEventListener('click', function () {

        const item = document.querySelector('.alat-item');
        const clone = item.cloneNode(true);

        // reset value
        clone.querySelectorAll('select, input').forEach(el => el.value = '');

        container.appendChild(clone);
    });

    // remove item
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {

            const items = document.querySelectorAll('.alat-item');

            if (items.length > 1) {
                e.target.closest('.alat-item').remove();
            } else {
                alert('Minimal harus ada 1 alat.');
            }
        }
    });

});
</script>