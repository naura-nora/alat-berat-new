<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'alat'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    public function approve(Peminjaman $peminjaman)
    {
        $peminjaman->update([
            'status' => 'disetujui',
            'petugas_id' => Auth::id(),
        ]);
        
        return redirect()->back()->with('success', 'Peminjaman disetujui!');
    }

    public function reject(Peminjaman $peminjaman)
    {
        $peminjaman->update([
            'status' => 'ditolak',
            'petugas_id' => Auth::id(),
        ]);
        
        return redirect()->back()->with('success', 'Peminjaman ditolak!');
    }
}