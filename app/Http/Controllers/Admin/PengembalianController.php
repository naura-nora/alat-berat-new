<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with([
            'petugas',
            'peminjaman.user'
        ])
        ->latest()
        ->paginate(10);

        return view('admin.pengembalian.index', compact('pengembalian'));
    }

    public function show($id)
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.details.alat',
            'peminjaman.user',
            'petugas'
        ])->findOrFail($id);

        return view('admin.pengembalian.show', compact('pengembalian'));
    }

    public function destroy($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->delete();

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Data pengembalian berhasil dihapus');
    }
}
