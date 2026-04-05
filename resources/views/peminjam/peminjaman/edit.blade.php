@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Peminjaman</h2>
        <a href="{{ route('peminjam.peminjaman.show', $peminjaman->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">
                Edit Peminjaman #{{ $peminjaman->kode_peminjaman }}
            </h5>
        </div>

        <div class="card-body">

            <div class="alert alert-info">
                Anda hanya dapat mengedit peminjaman yang masih berstatus 
                <strong>Menunggu</strong>.
            </div>

            <form action="{{ route('peminjam.peminjaman.update', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ================= TANGGAL ================= --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Tanggal Pinjam</label>
                        <input type="date"
                               name="tanggal_pinjam"
                               class="form-control"
                               value="{{ $peminjaman->tanggal_pinjam }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label>Tanggal Kembali Rencana</label>
                        <input type="date"
                               name="tanggal_kembali_rencana"
                               class="form-control"
                               value="{{ $peminjaman->tanggal_kembali_rencana }}"
                               required>
                    </div>
                </div>

                <hr>
                <h5>Daftar Alat</h5>

                {{-- ================= LIST ALAT ================= --}}
                <div id="alatContainer">

                    @foreach($peminjaman->details as $index => $detail)
                    <div class="row mb-3 alat-item">

                        {{-- SIMPAN DETAIL ID --}}
                        <input type="hidden"
                               name="alat[{{ $index }}][detail_id]"
                               value="{{ $detail->id }}">

                        <div class="col-md-6">
                            <label>Alat</label>
                            <select name="alat[{{ $index }}][alat_id]"
                                    class="form-control"
                                    required>

                                <option value="">-- Pilih Alat --</option>

                                @foreach($alat as $a)
                                    <option value="{{ $a->id }}"
                                        {{ $a->id == $detail->alat_id ? 'selected' : '' }}>
                                        {{ $a->nama }} 
                                        (Stok: {{ $a->stok + ($a->id == $detail->alat_id ? $detail->jumlah : 0) }})
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Jumlah</label>
                            <input type="number"
                                   name="alat[{{ $index }}][jumlah]"
                                   class="form-control"
                                   min="1"
                                   value="{{ $detail->jumlah }}"
                                   required>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-alat">
                                Hapus
                            </button>
                        </div>

                    </div>
                    @endforeach

                </div>

                <button type="button"
                        class="btn btn-primary mb-3"
                        onclick="tambahAlat()">
                    + Tambah Alat
                </button>

                <div class="mb-3">
                    <label>Alasan Peminjaman</label>
                    <textarea name="alasan_peminjaman"
                              class="form-control"
                              rows="3"
                              required>{{ $peminjaman->alasan_peminjaman }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-warning">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- ================= JAVASCRIPT ================= --}}
<script>

let alatIndex = {{ $peminjaman->details->count() }};

function tambahAlat() {

    const container = document.getElementById('alatContainer');

    let html = `
    <div class="row mb-3 alat-item">

        <div class="col-md-6">
            <label>Alat</label>
            <select name="alat[${alatIndex}][alat_id]"
                    class="form-control"
                    required>

                <option value="">-- Pilih Alat --</option>

                @foreach($alat as $a)
                    <option value="{{ $a->id }}">
                        {{ $a->nama }} (Stok: {{ $a->stok }})
                    </option>
                @endforeach

            </select>
        </div>

        <div class="col-md-4">
            <label>Jumlah</label>
            <input type="number"
                   name="alat[${alatIndex}][jumlah]"
                   class="form-control"
                   min="1"
                   required>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger remove-alat">
                Hapus
            </button>
        </div>

    </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    alatIndex++;
}

document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-alat')){
        e.target.closest('.alat-item').remove();
    }
});

</script>
@endsection