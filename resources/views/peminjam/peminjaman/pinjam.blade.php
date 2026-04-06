@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Form Peminjaman Alat</h3>
        <a href="{{ route('peminjam.peminjaman.create') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="text-primary mb-3">{{ $alat->nama }}</h5>

            <p>
                <strong>Merk:</strong> {{ $alat->merk ?? '-' }} <br>
                <strong>Stok tersedia:</strong> {{ $alat->stok }} unit <br>
                <strong>Harga sewa:</strong>
                Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}/hari
            </p>

            <hr>

            <form action="{{ route('peminjam.peminjaman.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label>Tanggal Pinjam</label>
                    <input type="date"
                           name="tanggal_pinjam"
                           class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                           value="{{ old('tanggal_pinjam') }}"
                           required>
                    @error('tanggal_pinjam')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Tanggal Kembali (Rencana)</label>
                    <input type="date"
                           name="tanggal_kembali_rencana"
                           class="form-control @error('tanggal_kembali_rencana') is-invalid @enderror"
                           value="{{ old('tanggal_kembali_rencana') }}"
                           required>
                    @error('tanggal_kembali_rencana')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Jumlah</label>
                    <input type="number"
                           name="jumlah"
                           min="1"
                           max="{{ $alat->stok }}"
                           class="form-control @error('jumlah') is-invalid @enderror"
                           value="{{ old('jumlah', 1) }}"
                           required>
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label>Alasan Peminjaman</label>
                    <textarea name="alasan_peminjaman"
                              rows="4"
                              class="form-control @error('alasan_peminjaman') is-invalid @enderror"
                              required>{{ old('alasan_peminjaman') }}</textarea>
                    @error('alasan_peminjaman')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-paper-plane"></i> Ajukan Peminjaman
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    @if(session('success'))
        function playSound() {
            const audio = new Audio('/audio/sound-correct.wav');
            audio.play().catch(error => {
                console.log('Gagal memutar suara:', error);
            });
        }
        playSound();
    @endif
</script>
@endsection


<script>
// Gunakan IIFE juga
(function() {
    'use strict';
    
    const jumlahInput = document.getElementById('jumlah');
    if (jumlahInput) {
        jumlahInput.addEventListener('input', function() {
            const maxStok = {{ $alat->stok }};
            const currentValue = parseInt(this.value) || 0;
            
            if (currentValue > maxStok) {
                this.value = maxStok;
                alert('Jumlah tidak boleh melebihi stok tersedia: ' + maxStok);
            }
        });
    }
})();
</script>