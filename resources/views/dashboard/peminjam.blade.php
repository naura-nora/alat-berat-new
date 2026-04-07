@extends('layouts.app')

@section('title', 'Dashboard Peminjam')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/peminjam.css') }}">
@endpush

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



@endsection