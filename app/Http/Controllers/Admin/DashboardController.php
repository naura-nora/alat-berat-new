<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display dashboard admin
     */
    public function index()
    {
        // statistik
        $stats = [
            'total_alat' => \App\Models\Alat::count(),
            'total_peminjaman' => \App\Models\Peminjaman::count(),
            'total_pengembalian' => \App\Models\Pengembalian::count(),
            'total_users' => \App\Models\User::count(),
            'users_admin' => \App\Models\User::where('role', 'admin')->count(),
            'users_petugas' => \App\Models\User::where('role', 'petugas')->count(),
            'users_peminjam' => \App\Models\User::where('role', 'peminjam')->count(),
        ];

        // =============================
        // GRAFIK PEMINJAMAN MINGGU INI
        // =============================

        $start = Carbon::now()->startOfWeek(); // senin
        $end   = Carbon::now()->endOfWeek();   // minggu

        $data = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])
            ->selectRaw('DAYOFWEEK(tanggal_pinjam) as hari, COUNT(*) as total')
            ->groupBy('hari')
            ->pluck('total', 'hari');

        // urutan hari senin - minggu
        $chartData = [
            $data[2] ?? 0, // senin
            $data[3] ?? 0, // selasa
            $data[4] ?? 0, // rabu
            $data[5] ?? 0, // kamis
            $data[6] ?? 0, // jumat
            $data[7] ?? 0, // sabtu
            $data[1] ?? 0, // minggu
        ];


        // =============================
        // GRAFIK ALAT PALING SERING DIPINJAM
        // =============================
        
        $alatPopuler = DB::table('detail_peminjaman')
            ->join('alat', 'detail_peminjaman.alat_id', '=', 'alat.id')
            ->select('alat.nama', DB::raw('SUM(detail_peminjaman.jumlah) as total'))
            ->groupBy('alat.nama')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        
        $alatLabels = $alatPopuler->pluck('nama');
        $alatData = $alatPopuler->pluck('total');


        return view('dashboard.admin', compact(
            'stats',
            'chartData',
            'alatLabels',
            'alatData'
        ));
    }

    
    /**
     * Contoh method tambahan untuk admin
     */
    public function laporan()
    {
        // Method untuk laporan admin
        return view('admin.laporan');
    }
}