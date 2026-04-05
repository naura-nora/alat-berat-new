@extends('layouts.app')

@section('title', 'Dashboard Admin')

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

/* Samakan warna biar konsisten */
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
                Dashboard Admin Alat Berat
            </small>
        </div>
    </div>

    {{-- Info statistik --}}
    <div class="row">

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-info elevation-1">
                    <i class="fas fa-tools"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Alat</span>
                    <span class="info-box-number">{{ $stats['total_alat'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success elevation-1">
                    <i class="fas fa-hand-holding"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Peminjaman</span>
                    <span class="info-box-number">{{ $stats['total_peminjaman'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-warning elevation-1">
                    <i class="fas fa-undo-alt"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Pengembalian</span>
                    <span class="info-box-number">{{ $stats['total_pengembalian'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number">{{ $stats['total_users'] ?? 0 }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Chart --}}
    <div class="row mt-4">

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title text-sm">Grafik Peminjaman Minggu Ini</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartPeminjaman"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title text-sm">Alat Paling Sering Dipinjam</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartAlat"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- Bottom section --}}
    <div class="row mt-4">

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title text-sm">Informasi Sistem</h3>
                </div>
                <div class="card-body">
                    <p>Anda login sebagai <strong>Administrator</strong>.</p>
                    <p>Sistem Peminjaman Alat Berat v1.0</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title text-sm">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.alat.create') }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-plus mr-2"></i> Tambah Alat
                    </a>

                    <a href="{{ route('admin.user.index') }}" class="btn btn-success btn-block mb-2">
                        <i class="fas fa-users mr-2"></i> Kelola Users
                    </a>

                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-warning btn-block">
                        <i class="fas fa-chart-bar mr-2"></i> Laporan
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- Script Chart --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let dataPeminjaman = @json($chartData);
let alatLabels = @json($alatLabels);
let alatData = @json($alatData);

// Bar chart
new Chart(document.getElementById('chartPeminjaman'), {
    type: 'bar',
    data: {
        labels: ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],
        datasets: [{
            data: dataPeminjaman,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display:false }},
        scales: { y: { beginAtZero: true } }
    }
});

// Pie chart
new Chart(document.getElementById('chartAlat'), {
    type: 'pie',
    data: {
        labels: alatLabels,
        datasets: [{ data: alatData }]
    },
    options: { responsive:true }
});
</script>

@endsection