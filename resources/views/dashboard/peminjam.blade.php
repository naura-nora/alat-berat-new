@extends('layouts.app')

@section('title', 'Dashboard Peminjam')

@section('content')

<style>
/* Hero */
.hero-dashboard {
    height: 180px;
    border-radius: 16px;
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    position: relative;
    overflow: hidden;
}

.hero-dashboard::before,
.hero-dashboard::after {
    content: "";
    position: absolute;
    border-radius: 50%;
}

.hero-dashboard::before {
    width: 250px;
    height: 250px;
    background: rgba(255,255,255,0.06);
    top: -60px;
    right: -60px;
}

.hero-dashboard::after {
    width: 180px;
    height: 180px;
    background: rgba(255,255,255,0.04);
    bottom: -50px;
    left: -50px;
}

/* Info box */
.info-box {
    border-radius: 14px;
    transition: 0.2s;
}

.info-box:hover {
    transform: translateY(-2px);
}

.info-box-icon {
    border-radius: 12px;
    opacity: 0.9;
}

.info-box-icon i {
    font-size: 22px;
}

/* Card */
.card {
    border-radius: 14px;
    border: none;
}

.card-header {
    background: transparent;
    border-bottom: 1px solid #f1f1f1;
    font-weight: 600;
}

/* Button */
.btn {
    border-radius: 10px;
}

.btn-primary { background: #2563eb; border: none; }
.btn-success { background: #22c55e; border: none; }
.btn-warning { background: #f59e0b; border: none; }

/* Konsistensi warna */
.bg-info    { background: #3b82f6 !important; color: #fff !important; }
.bg-success { background: #22c55e !important; color: #fff !important; }
.bg-warning { background: #f59e0b !important; color: #fff !important; }
.bg-danger  { background: #ef4444 !important; color: #fff !important; }

</style>

<div class="container-fluid">

    {{-- Hero --}}
    <div class="hero-dashboard d-flex align-items-end p-4 mb-4 text-white">
        <div>
            <h3 class="mb-1 fw-semibold">
                Selamat Datang, {{ Auth::user()->name }}
            </h3>
            <small class="text-light opacity-50">
                Dashboard Peminjam Alat Berat
            </small>
        </div>
    </div>

    {{-- Info statistik --}}
    <div class="row">

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-info elevation-1">
                    <i class="fas fa-hand-holding"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Peminjaman Aktif</span>
                    <span class="info-box-number">{{ $data['peminjaman_aktif'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success elevation-1">
                    <i class="fas fa-history"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Riwayat Peminjaman</span>
                    <span class="info-box-number">{{ $data['riwayat_peminjaman'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-warning elevation-1">
                    <i class="fas fa-star"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Alat Favorit</span>
                    <span class="info-box-number">{{ $data['alat_favorit']->count() ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-user"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Status Akun</span>
                    <span class="info-box-number">Aktif</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Konten utama --}}
    <div class="row mt-4">

       {{-- Informasi & favorit --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header"></div>

                <div class="card-body">
                    <p>Anda login sebagai <strong>Peminjam</strong>.</p>

                    <h5>Alat Favorit:</h5>

                    <div class="row">
                        @foreach($data['alat_favorit'] ?? [] as $alat)
                        <div class="col-md-4">
                            <div class="card">

                                {{-- Gambar alat --}}
                                @if($alat->gambar)
                                    <img src="{{ asset('images/' . $alat->gambar) }}"
                                        alt="{{ $alat->nama }}"
                                        style="height: 120px; object-fit: cover; border-top-left-radius: 14px; border-top-right-radius: 14px;">
                                @endif

                                <div class="card-body">
                                    <h6 class="mb-1">{{ $alat->nama ?? 'Alat Sample' }}</h6>

                                    <small class="text-muted">
                                        Status: {{ $alat->status ?? 'Tersedia' }}
                                    </small>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

        {{-- Quick menu --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title text-sm">Quick Menu</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('peminjam.alat.index') }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-search mr-2"></i> Cari Alat Berat
                    </a>
                    <a href="{{ route('peminjam.peminjaman.create') }}" class="btn btn-success btn-block mb-2">
                        <i class="fas fa-hand-holding mr-2"></i> Ajukan Peminjaman
                    </a>
                    <a href="{{ route('peminjam.peminjaman.index') }}" class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-clipboard-list mr-2"></i> Lihat Peminjaman Saya
                    </a>
        
                </div>
            </div>
        </div>

    </div>

</div>

<!-- SOUND SUCCESS LOGIN -->


@endsection