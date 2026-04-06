<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogActivityTrait;

class PeminjamanController extends Controller
{
    use LogActivityTrait;

    public function index()
    {
        $peminjaman = Peminjaman::with('details.alat', 'user')
            ->latest()
            ->paginate(10);

        return view('petugas.peminjaman.index', compact('peminjaman'));
    }



    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman sudah diproses.');
        }

        $peminjaman->update([
            'status' => 'disetujui',
            'petugas_id' => auth()->id(),
        ]);

        // ✅ TAMBAHKAN LOG AKTIVITAS
        $this->logActivity('approve', 'peminjaman');

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }


    public function reject(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman sudah diproses.');
        }

        foreach ($peminjaman->details as $detail) {
            $detail->alat->increment('stok', $detail->jumlah);
        }

        $peminjaman->update([
            'status' => 'ditolak',
            'petugas_id' => auth()->id(),
        ]);

        // ✅ TAMBAHKAN LOG AKTIVITAS
        $this->logActivity('reject', 'peminjaman');
        
        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }
}

