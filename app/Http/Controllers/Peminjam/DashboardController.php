<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display dashboard peminjam
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data khusus peminjam
        $data = [
            'peminjaman_aktif' => \App\Models\Peminjaman::where('user_id', $user->id)
                ->where('status', 'dipinjam')
                ->count(),
            'riwayat_peminjaman' => \App\Models\Peminjaman::where('user_id', $user->id)
                ->count(),
            'total_peminjaman' => \App\Models\Peminjaman::where('user_id', $user->id)->count(),
            'alat_favorit' => \App\Models\Alat::inRandomOrder()->limit(3)->get(),
            'user' => $user,
        ];

        return view('dashboard.peminjam', compact('data'));
    }
    
    /**
     * Contoh method untuk peminjam
     */
    public function riwayatPeminjaman()
    {
        $user = Auth::user();
        $riwayat = \App\Models\Peminjaman::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('peminjam.riwayat', compact('riwayat'));
    }
}