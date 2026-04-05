<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\DetailKerusakan;
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
        $pengembalian = Pengembalian::with('peminjaman.details.alat')
            ->findOrFail($id);

        foreach ($request->detail as $detailId => $data) {

            $detail = $pengembalian->peminjaman
                ->details
                ->where('id', $detailId)
                ->first();

            if ($detail) {

                $detail->update([
                    'kondisi_pengembalian' => $data['kondisi'],
                    'catatan_pengembalian' => $data['catatan'] ?? null,
                ]);

                // kembalikan stok alat
                $detail->alat->increment('stok', $detail->jumlah);

                // ===============================
                // SIMPAN DATA KERUSAKAN
                // ===============================

                if(isset($data['kerusakan'])){

                    foreach($data['kerusakan'] as $kerusakan){

                        DetailKerusakan::create([
                            'pengembalian_id' => $pengembalian->id,
                            'deskripsi_kerusakan' => $kerusakan['deskripsi'],
                            'biaya_perbaikan' => $kerusakan['biaya'],
                        ]);

                    }

                }

            }
        }

        $pengembalian->update([
            'status' => 'selesai',
            'petugas_id' => Auth::id(),
        ]);

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