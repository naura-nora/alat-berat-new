@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-search mr-2"></i>
                        Pengecekan Pengembalian Alat
                    </h3>
                    <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('petugas.pengembalian.proses.cek', $pengembalian->id) }}" method="POST">
                    @csrf

                    @foreach($pengembalian->peminjaman->details as $detail)
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong>{{ $detail->alat->nama }}</strong>
                            (Jumlah: {{ $detail->jumlah }})
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label>Kondisi Alat</label>
                                <select name="detail[{{ $detail->id }}][kondisi]" 
                                    class="form-control kondisi-select"
                                    data-id="{{ $detail->id }}"
                                    required>
                                    <option value="">-- Pilih --</option>
                                    <option value="baik">Baik</option>
                                    <option value="rusak">Rusak</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Catatan</label>
                                <textarea name="detail[{{ $detail->id }}][catatan]" 
                                    class="form-control"></textarea>
                            </div>

                            {{-- FORM RUSAK PER ALAT --}}
                            <div class="form-rusak" id="rusak-{{ $detail->id }}" style="display:none">

                                <h6>Detail Kerusakan</h6>

                                <div id="listKerusakan-{{ $detail->id }}"></div>

                                <button type="button"
                                    class="btn btn-sm btn-danger"
                                    onclick="tambahKerusakan({{ $detail->id }})">
                                    + Tambah Kerusakan
                                </button>

                            </div>

                        </div>
                    </div>
                    @endforeach

                    <button type="submit" class="btn btn-success">
                        Simpan & Selesaikan Pengecekan
                    </button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
let indexMap = {};

function tambahKerusakan(detailId) {

    if (!indexMap[detailId]) {
        indexMap[detailId] = 0;
    }

    let index = indexMap[detailId];

    const div = document.createElement('div');
    div.className = 'border p-2 mb-2';

    div.innerHTML = `
        <input type="text"
            name="detail[${detailId}][kerusakan][${index}][deskripsi]"
            class="form-control mb-2"
            placeholder="Nama Kerusakan" required>

        <input type="number"
            name="detail[${detailId}][kerusakan][${index}][biaya]"
            class="form-control mb-2"
            placeholder="Biaya" required>

        <button type="button"
            class="btn btn-sm btn-secondary"
            onclick="this.parentElement.remove()">
            Hapus
        </button>
    `;

    document.getElementById('listKerusakan-' + detailId)
        .appendChild(div);

    indexMap[detailId]++;
}

// show hide rusak per alat
document.querySelectorAll('.kondisi-select').forEach(function(select){
    select.addEventListener('change', function(){
        const id = this.dataset.id;
        const formRusak = document.getElementById('rusak-' + id);

        formRusak.style.display =
            this.value === 'rusak' ? 'block' : 'none';
    });
});
</script>
@endsection