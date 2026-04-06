<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Traits\LogActivityTrait;

class AlatController extends Controller
{
    use LogActivityTrait;

    public function index()
    {
        $alat = Alat::with('kategori')->latest()->paginate(10);
        return view('admin.alat.index', compact('alat'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.alat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'kode_alat' => 'required|unique:alat,kode_alat|max:20',
            'nama' => 'required|max:200',
            'merk' => 'nullable|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:1',
            'harga_sewa' => 'required|numeric|min:0',
            'denda_per_hari' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ✅ SET STATUS OTOMATIS
        $validated['status'] = 'tersedia';

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = time() . '_' . str()->slug($validated['nama']) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('images'), $fileName);
            $validated['gambar'] = $fileName;
        }

        Alat::create($validated);

        // LOG AKTIVITAS ✅
        $this->logActivity('create', 'alat');

        return redirect()->route('admin.alat.index')
            ->with('success', 'Data alat berhasil ditambahkan.');
    }

    public function show(Alat $alat)
    {
        $alat->load('kategori');
        return view('admin.alat.show', compact('alat'));
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'kode_alat' => 'required|max:20|unique:alat,kode_alat,' . $alat->id,
            'nama' => 'required|max:200',
            'merk' => 'nullable|max:100',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:1',
            'harga_sewa' => 'required|numeric|min:0',
            'denda_per_hari' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ✅ STATUS TETAP TERSEDIA
        $validated['status'] = 'tersedia';

        // Upload gambar baru
        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            if ($alat->gambar && file_exists(public_path('images/' . $alat->gambar))) {
                unlink(public_path('images/' . $alat->gambar));
            }

            $file = $request->file('gambar');
            $fileName = time() . '_' . str()->slug($validated['nama']) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('images'), $fileName);
            $validated['gambar'] = $fileName;
        } else {
            $validated['gambar'] = $alat->gambar;
        }

        $alat->update($validated);

        // LOG AKTIVITAS ✅
        $this->logActivity('update', 'alat');

        return redirect()->route('admin.alat.index')
            ->with('success', 'Data alat berhasil diperbarui.');
    }



    public function destroy(Alat $alat)
    {
        try {
            if ($alat->gambar && file_exists(public_path('images/' . $alat->gambar))) {
                unlink(public_path('images/' . $alat->gambar));
            }

            $alat->delete();


            // LOG AKTIVITAS ✅
            $this->logActivity('delete', 'alat');

            return redirect()->route('admin.alat.index')
                ->with('success', 'Data alat berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.alat.index')
                ->with('error', 'Data alat tidak bisa dihapus karena masih digunakan.');
        }
    }

    public function getStats()
    {
        return response()->json([
            'total' => Alat::count(),
            'tersedia' => Alat::where('status', 'tersedia')->count(),
            'dipinjam' => Alat::where('status', 'dipinjam')->count(),
            'rusak' => Alat::where('status', 'rusak')->count(),
            'maintenance' => Alat::where('status', 'maintenance')->count(),
        ]);
    }
}