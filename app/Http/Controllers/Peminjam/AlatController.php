<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;

class AlatController extends Controller
{
    public function index()
    {
        $alat = Alat::where('status', 'tersedia')
                    ->where('stok', '>', 0)
                    ->paginate(9);

        return view('peminjam.alat.index', compact('alat'));
    }
}
