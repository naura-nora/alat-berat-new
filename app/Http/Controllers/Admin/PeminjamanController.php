<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with([
            'details.alat',
            'user',
            'petugas',
            'pengembalian'
        ])
        ->latest()
        ->paginate(10);

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // OPTIONAL: keamanan tambahan
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus');
    }
}
