<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $tahunSekarang = now()->year;
        $laporan = [];
        
        for($bulan = 1; $bulan <= 12; $bulan++) {
            $data = Peminjaman::with(['user', 'details.alat', 'transaksi'])
                            ->whereYear('tanggal_pinjam', $tahunSekarang)
                            ->whereMonth('tanggal_pinjam', $bulan)
                            // ->whereIn('status', ['disetujui', 'dipinjam', 'selesai'])
                            ->whereHas('transaksi')
                            ->get();
            
            $laporan[$bulan] = [
                'bulan' => $this->namaBulan($bulan),
                'data' => $data,
                'total_peminjaman' => $data->count(),
                'total_barang' => $data->sum(fn($p) => $p->details->sum('jumlah')),
                'total_harga' => $data->sum(fn($p) => $p->transaksi->total_bayar ?? 0),
                'total_denda' => $data->sum(fn($p) => optional($p->transaksi)->denda ?? 0 ?? 0)
            ];
        }
        
        return view('admin.laporan.index', compact('laporan', 'tahunSekarang'));
    }
    
    
    
    public function cetakBulan($tahun, $bulan)
    {
        $data = Peminjaman::with(['user', 'details.alat', 'transaksi'])
                        ->whereYear('tanggal_pinjam', $tahun)
                        ->whereMonth('tanggal_pinjam', $bulan)
                        // ->whereIn('status', ['disetujui', 'dipinjam', 'selesai'])
                        ->whereHas('transaksi')
                        ->get();
        
        return view('admin.laporan.cetak-bulanan', [
            'bulan' => $this->namaBulan($bulan),
            'tahun' => $tahun,
            'data' => $data,
            'total_peminjaman' => $data->count(),
            'total_barang' => $data->sum(fn($p) => $p->details->sum('jumlah')),
            // ✅ GUNAKAN total_bayar dari transaksi
            'total_harga' => $data->sum(fn($p) => $p->transaksi->total_bayar ?? 0),
            'total_denda' => $data->sum(fn($p) => $p->transaksi->denda ?? 0)
        ]);
    }
    
    
    private function namaBulan($bulan)
    {
        $nama = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni',
            7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
        ];
        return $nama[$bulan] ?? '-';
    }
}