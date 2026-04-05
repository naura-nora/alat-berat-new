@extends('layouts.app')

@section('title', 'Dashboard Petugas')

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
                Dashboard Petugas Alat Berat
            </small>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row">

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-info elevation-1">
                    <i class="fas fa-hand-holding"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Peminjaman Hari Ini</span>
                    <span class="info-box-number">{{ $data['peminjaman_hari_ini'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success elevation-1">
                    <i class="fas fa-undo-alt"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Pengembalian Hari Ini</span>
                    <span class="info-box-number">{{ $data['pengembalian_hari_ini'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-warning elevation-1">
                    <i class="fas fa-check-circle"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Alat Tersedia</span>
                    <span class="info-box-number">{{ $data['alat_tersedia'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-tools"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Alat Dipinjam</span>
                    <span class="info-box-number">{{ $data['alat_dipinjam'] ?? 0 }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Konten utama --}}
    <div class="row mt-4">

        <div class="col-md-12">
            <div class="card shadow-sm">

                <div class="card-header">
                    <h3 class="card-title text-sm">
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                </div>

                <div class="card-body">
                    <p>Anda login sebagai <strong>Petugas</strong>.</p>
                    <p>Tanggal: {{ date('d F Y') }}</p>

                    <div class="row mt-4">

                        {{-- Quick action --}}
                        <div class="col-md-6">
                            <h5>Quick Actions:</h5>

                            <a href="#" class="btn btn-primary btn-block mb-2">
                                <i class="fas fa-plus mr-2"></i> Proses Peminjaman Baru
                            </a>

                            <a href="#" class="btn btn-success btn-block mb-2">
                                <i class="fas fa-undo-alt mr-2"></i> Proses Pengembalian
                            </a>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <h5>Status Sistem:</h5>

                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Sistem Peminjaman
                                    <span class="badge badge-success badge-pill">Aktif</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Database
                                    <span class="badge badge-success badge-pill">Online</span>
                                </li>
                            </ul>

                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection