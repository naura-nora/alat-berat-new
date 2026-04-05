<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display dashboard petugas
     */
    public function index()
    {
        // Ambil data untuk petugas
        $data = [
            'peminjaman_hari_ini' => \App\Models\Peminjaman::whereDate('created_at', today())->count(),
            'pengembalian_hari_ini' => \App\Models\Pengembalian::whereDate('created_at', today())->count(),
            'alat_tersedia' => \App\Models\Alat::where('status', 'tersedia')->count(),
            'alat_dipinjam' => \App\Models\Alat::where('status', 'dipinjam')->count(),
            'alat_rusak' => \App\Models\Alat::where('status', 'rusak')->count(),
            'total_peminjam' => \App\Models\User::where('role', 'peminjam')->count(),
        ];

        return view('dashboard.petugas', compact('data'));
    }
    
    /**
     * Contoh method untuk petugas
     */
    public function peminjamanAktif()
    {
        $peminjaman = \App\Models\Peminjaman::where('status', 'dipinjam')->get();
        return view('petugas.peminjaman-aktif', compact('peminjaman'));
    }
}