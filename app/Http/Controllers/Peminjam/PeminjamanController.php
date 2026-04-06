<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Traits\LogActivityTrait;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    use LogActivityTrait;

    public function pinjamAlat(Alat $alat)
    {
        // Cek apakah alat masih bisa dipinjam
        if ($alat->stok <= 0 || $alat->status != 'tersedia') {
            return redirect()
                ->back()
                ->with('error', 'Alat sedang tidak tersedia untuk dipinjam.');
        }

        return view('peminjam.peminjaman.pinjam', compact('alat'));
    }

    
    public function aktif()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->where('status', 'disetujui') // Ganti dari 'dipinjam' ke 'disetujui'
            ->with('details.alat')
            ->get();

        return view('peminjam.peminjaman.aktif', compact('peminjaman'));
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'disetujui') // Hanya yang disetujui bisa dikembalikan
            ->firstOrFail();

        // Buat entri pengembalian
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_kembali_aktual' => now(),
            'kondisi_alat' => 'baik', // default, nanti diisi petugas
            'status' => 'menunggu', // Menunggu pengecekan petugas
        ]);

        // Ubah status peminjaman menjadi 'dalam_pengembalian'
        $peminjaman->update([
            'status' => 'dalam_pengembalian'
        ]);

        // ✅ LOG AKTIVITAS 
        $this->logActivity('return', 'pengembalian');

        return redirect()
            ->back()
            ->with('success', 'Pengembalian berhasil diajukan. Menunggu pengecekan petugas.');
    }
    
    public function index()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->with('details.alat')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('peminjam.peminjaman.index', compact('peminjaman'));
    }

    // ... method create, pinjamAlat, store tetap sama ...

    public function riwayat()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', ['dikembalikan', 'ditolak'])
            ->with('details.alat')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('peminjam.peminjaman.riwayat', compact('peminjaman'));
    }

   public function create()
    {
        $alat = Alat::where('status','tersedia')
                    ->where('stok','>',0)
                    ->get();
                    // ->paginate(9);

        return view('peminjam.peminjaman.create', compact('alat'));
    }

    
    
    public function store(Request $request)
    {
        
        $request->validate([
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'alat_id' => 'required|array',
            'alat_id.*' => 'exists:alat,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'alasan_peminjaman' => 'required|string|max:1000',
        ]);

        DB::beginTransaction();

        try {

            // 1️⃣ Buat header peminjaman dulu
            $kode = 'PINJ-' . date('Ymd') . '-' . Str::random(5);

            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $kode,
                'user_id' => Auth::id(),
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'alasan_peminjaman' => $request->alasan_peminjaman,
                'status' => 'pending',
            ]);

            // 2️⃣ Loop setiap barang
            foreach ($request->alat_id as $index => $alatId) {

                $alat = Alat::findOrFail($alatId);
                $jumlah = $request->jumlah[$index];

                // Cek stok
                if ($alat->stok < $jumlah) {
                    throw new \Exception("Stok {$alat->nama_alat} tidak mencukupi.");
                }

                // Kurangi stok
                $alat->decrement('stok', $jumlah);

                if ($alat->stok == 0) {
                    $alat->update(['status' => 'dipinjam']);
                }

                // Simpan ke detail
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $alatId,
                    'jumlah' => $jumlah,
                    'harga_sewa' => $alat->harga_sewa,
                ]);
            }

            DB::commit();

            // ✅ SIMPAN LOG AKTIVITAS
            $this->logActivity('create', 'peminjaman');

            return redirect()->route('peminjam.peminjaman.index')
                ->with('success', 'Pengajuan peminjaman berhasil!');

        } catch (\Exception $e) {

            DB::rollBack();
            // dd($e->getMessage());
            return back()->with('error', 'Gagal mengajukan peminjaman: ' . $e->getMessage());
        }
    }


    

    public function show($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['details.alat', 'pengembalian'])
            ->firstOrFail();
        
        return view('peminjam.peminjaman.show', compact('peminjaman'));
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::with('details.alat')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $alat = Alat::where('status', 'tersedia')
            ->orWhereIn('id', $peminjaman->details->pluck('alat_id'))
            ->get();

        return view('peminjam.peminjaman.edit', compact('peminjaman', 'alat'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('details.alat')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'alasan_peminjaman' => 'required',
            'alat' => 'required|array'
        ]);

        DB::beginTransaction();

        try {

            // 1️⃣ KEMBALIKAN STOK LAMA
            foreach ($peminjaman->details as $detail) {
                $detail->alat->increment('stok', $detail->jumlah);
            }

            // 2️⃣ HAPUS DETAIL LAMA
            $peminjaman->details()->delete();

            // 3️⃣ SIMPAN DATA BARU
            foreach ($request->alat as $item) {

                $alat = Alat::findOrFail($item['alat_id']);

                if ($alat->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$alat->nama} tidak mencukupi");
                }

                // kurangi stok
                $alat->decrement('stok', $item['jumlah']);

                // simpan detail baru
                $peminjaman->details()->create([
                    'alat_id' => $alat->id,
                    'jumlah' => $item['jumlah'],
                    'harga_sewa' => $alat->harga_sewa
                ]);
            }

            // 4️⃣ UPDATE DATA UTAMA
            $peminjaman->update([
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'alasan_peminjaman' => $request->alasan_peminjaman,
            ]);

            DB::commit();

            // LOG AKTIVITAS ✅
            $this->logActivity('update', 'peminjaman');

            return redirect()
                ->route('peminjam.peminjaman.index')
                ->with('success', 'Peminjaman berhasil diperbarui.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::with('details.alat')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        DB::beginTransaction();

        try {

            // ✅ Loop semua detail alat
            foreach ($peminjaman->details as $detail) {

                // Pastikan relasi alat ada
                if ($detail->alat) {

                    // Kembalikan stok
                    $detail->alat->increment('stok', $detail->jumlah);

                    // Jika stok sudah ada kembali, ubah status
                    if ($detail->alat->stok > 0 && $detail->alat->status == 'dipinjam') {
                        $detail->alat->update([
                            'status' => 'tersedia'
                        ]);
                    }
                }
            }

            // Hapus detail dulu
            $peminjaman->details()->delete();

            // Hapus peminjaman
            $peminjaman->delete();

            DB::commit();

            // LOG AKTIVITAS
            $this->logActivity('cancel', 'peminjaman');

            return redirect()
                ->route('peminjam.peminjaman.index')
                ->with('success', 'Peminjaman berhasil dibatalkan.');

        } catch (\Exception $e) {

            DB::rollBack();

            dd($e->getMessage()); // sementara untuk debug
        }
    }
    

}