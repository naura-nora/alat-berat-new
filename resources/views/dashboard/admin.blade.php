@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

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