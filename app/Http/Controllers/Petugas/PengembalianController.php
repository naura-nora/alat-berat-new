<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\DetailKerusakan;
use App\Models\DetailPeminjaman;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    /**
     * Menampilkan daftar pengembalian yang menunggu pengecekan
     */
     public function index()
    {
        $pengembalian = Pengembalian::with([
            'peminjaman',
            'peminjaman.details.alat',
            'peminjaman.user'
        ])
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $pengembalianDiproses = Pengembalian::with([
            'peminjaman',
            'peminjaman.details.alat',
            'peminjaman.user'
        ])
            ->whereIn('status', ['dicek', 'selesai'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10, ['*'], 'diproses_page');

        return view('petugas.pengembalian.index', compact('pengembalian', 'pengembalianDiproses'));
    }

    public function cek($id)
    {
        $pengembalian = Pengembalian::with([
            'peminjaman',
            'peminjaman.details.alat',
            'peminjaman.user'
        ])
            ->where('id', $id)
            ->where('status', 'menunggu')
            ->firstOrFail();

        return view('petugas.pengembalian.cek', compact('pengembalian'));
    }

    
    

    public function prosesCek(Request $request, $id)
{
    $pengembalian = Pengembalian::with('peminjaman.details.alat')->findOrFail($id);

    foreach ($request->detail as $data) {
        
        $detail = DetailPeminjaman::findOrFail($data['id']);
        
        $jumlahBaik = (int)($data['jumlah_baik'] ?? 0);
        $jumlahRusak = (int)($data['jumlah_rusak'] ?? 0);
        $keteranganRusak = $data['keterangan_rusak'] ?? null;
        
        // Update detail peminjaman dengan kondisi
        $detail->update([
            'kondisi_pengembalian' => $jumlahRusak > 0 ? 'rusak' : 'baik',
            'catatan_pengembalian' => $keteranganRusak,
            'jumlah_baik' => $jumlahBaik,
            'jumlah_rusak' => $jumlahRusak,
        ]);
        
        // ==========================================
        // LOGIKA STOK: HANYA YANG BAIK YANG DIKEMBALIKAN
        // ==========================================
        
        // Kembalikan stok hanya sejumlah barang yang BAIK
        if ($jumlahBaik > 0) {
            $detail->alat->increment('stok', $jumlahBaik);
        }
        
        // Update status alat
        if ($jumlahRusak == $detail->jumlah) {
            // Semua rusak
            $detail->alat->update(['status' => 'rusak']);
        } else {
            // Sebagian atau semua baik
            $detail->alat->update(['status' => 'tersedia']);
        }
        
        // ==========================================
        // DENDA KERUSAKAN TETAP DIHITUNG
        // ==========================================
        $totalBiayaKerusakan = 0;
        
        if ($jumlahRusak > 0 && isset($data['kerusakan'])) {
            foreach ($data['kerusakan'] as $kerusakan) {
                $biaya = (int)($kerusakan['biaya'] ?? 0);
                $totalBiayaKerusakan += $biaya;
                
                DetailKerusakan::create([
                    'pengembalian_id' => $pengembalian->id,
                    'detail_peminjaman_id' => $detail->id,
                    'deskripsi_kerusakan' => $kerusakan['deskripsi'],
                    'jumlah_rusak' => $kerusakan['jumlah'] ?? $jumlahRusak,
                    'biaya_perbaikan' => $biaya,
                ]);
            }
        }
        
        // Simpan total biaya kerusakan ke detail_peminjaman (opsional)
        $detail->update([
            'biaya_kerusakan' => $totalBiayaKerusakan
        ]);
    }
    
    // ==========================================
    // HITUNG TOTAL DENDA KERUSAKAN DARI SEMUA DETAIL
    // ==========================================
    $totalBiayaKerusakan = DetailPeminjaman::where('peminjaman_id', $pengembalian->peminjaman_id)
        ->sum('biaya_kerusakan');
    
    // Update pengembalian
    $pengembalian->update([
        'status' => 'selesai',
        'petugas_id' => Auth::id(),
        'biaya_kerusakan' => $totalBiayaKerusakan,  // ← DENDA KERUSAKAN TETAP ADA
    ]);
    
    // Update status peminjaman
    $pengembalian->peminjaman->update([
        'status' => 'menunggu_transaksi'
    ]);
    
    return redirect()
        ->route('petugas.pengembalian.index')
        ->with('success', 'Pengembalian berhasil diproses.');
}




    public function batalkan($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        
        // Update status pengembalian menjadi dibatalkan
        $pengembalian->update([
            'status' => 'dibatalkan'
        ]);
        
        // Kembalikan status peminjaman ke disetujui
        $pengembalian->peminjaman->update([
            'status' => 'disetujui'
        ]);

        return redirect()->route('petugas.pengembalian.index')
            ->with('success', 'Pengembalian berhasil dibatalkan.');
    }

    // Method untuk mengubah status menjadi dicek (jika ingin step by step)
    public function mulaiCek($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        
        $pengembalian->update([
            'status' => 'dicek',
            'petugas_id' => Auth::id(),
        ]);

        return redirect()->route('petugas.pengembalian.cek', $pengembalian->id)
            ->with('info', 'Mulai pengecekan...');
    }

    // public function show($id)
    // {
    //     $pengembalian = Pengembalian::with([
    //         'peminjaman.details.alat',
    //         'peminjaman.user'
    //     ])->findOrFail($id);

    //     return view('petugas.pengembalian.show', compact('pengembalian'));
    // }
    public function show($id)
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.details.alat',
            'peminjaman.user',
            'petugas'  // ← TAMBAH INI
        ])->findOrFail($id);

        return view('petugas.pengembalian.show', compact('pengembalian'));
    }
}