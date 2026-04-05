@extends('layouts.app')

@section('content')

<style>
    /* Hover card effect */
    .card-hover {
        transition: all 0.25s ease;
        border-radius: 14px;
    }

    .card-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.06);
    }

    /* Text styling */
    .info-label {
        font-size: 12px;
        color: #6c757d;
    }

    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: #212529;
    }

    .harga-value {
        font-size: 15px;
        font-weight: 600;
        color: #2563eb; /* samakan dengan primary */
    }

    /* Divider */
    .divider {
        height: 1px;
        background-color: #f1f1f1;
        margin: 12px 0;
    }
</style>

<div class="container py-4">

    {{-- Header --}}
    <div class="mb-4">
        <h4 class="fw-semibold text-dark mb-0">Daftar Alat</h4>
    </div>

    {{-- Empty state --}}
    @if($alat->count() == 0)
        <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-triangle mr-1"></i>
            Tidak ada alat yang tersedia saat ini.
        </div>
    @else

        <div class="row">
            @foreach($alat as $item)
            <div class="col-md-4 mb-4">

                <div class="card h-100 border-0 shadow-sm card-hover">

                    {{-- Gambar --}}
                    @if($item->gambar)
                    <div class="position-relative">
                        <img src="{{ asset('images/' . $item->gambar) }}" 
                             class="card-img-top"
                             style="height: 220px; object-fit: cover;"
                             alt="Gambar {{ $item->nama }}">

                        {{-- Badge stok --}}
                        <span class="badge {{ $item->stok > 0 ? 'bg-success' : 'bg-secondary' }} 
                            position-absolute top-0 end-0 m-3 px-3 py-2">
                            {{ $item->stok > 0 ? 'Tersedia: '.$item->stok : 'Stok Habis' }}
                        </span>
                    </div>
                    @endif

                    <div class="card-body">

                        {{-- Nama & kode --}}
                        <h5 class="fw-semibold mb-1">{{ $item->nama }}</h5>
                        <small class="text-muted d-block mb-2">
                            Kode: {{ $item->kode_alat }}
                        </small>

                        <div class="divider"></div>

                        {{-- Info --}}
                        <div class="d-flex justify-content-between mb-2">
                            <span class="info-label">Stok</span>
                            <span class="info-value">{{ $item->stok }} Unit</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="info-label">Harga</span>
                            <span class="harga-value">
                                Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Deskripsi --}}
                        @if($item->keterangan)
                        <div class="divider"></div>

                        <div>
                            <span class="info-label d-block mb-1">Deskripsi</span>
                            <small class="text-muted">
                                {{ \Illuminate\Support\Str::limit($item->keterangan, 110) }}
                            </small>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($alat->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $alat->links() }}
        </div>
        @endif

    @endif
</div>

@endsection