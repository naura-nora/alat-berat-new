<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alat = Alat::with('kategori')->latest()->paginate(10);

        return view('petugas.alat.index', compact('alat'));
    }

    public function show(Alat $alat)
    {
        $alat->load('kategori');

        return view('petugas.alat.show', compact('alat'));
    }
}
