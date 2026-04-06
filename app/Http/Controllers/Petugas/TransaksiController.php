<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Peminjaman;
use App\Traits\LogActivityTrait;
use App\Models\DetailKerusakan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiController extends Controller
{

    use LogActivityTrait;

    public function index()
    {
        $transaksi = Transaksi::with('peminjaman.user')
            ->latest()
            ->get();

        return view('petugas.transaksi.index', compact('transaksi'));
    }




    public function create()
    {
        $peminjaman = Peminjaman::with([
            'user',
            'details.alat',
            'pengembalian.detailKerusakan'
        ])
        ->where('status','menunggu_transaksi')
        ->get();

        

        return view('petugas.transaksi.create', compact('peminjaman'));
    }


    
   public function store(Request $request)
{
    // Validasi
    $request->validate([
        'peminjaman_id' => 'required',
        'metode_pembayaran' => 'required',
        'no_telp' => 'required',
        'total_bayar' => 'required|numeric',
    ]);

    $peminjaman = Peminjaman::with('details.alat')
        ->findOrFail($request->peminjaman_id);

    // Validasi khusus cash: uang yang dibayar harus >= total bayar
    if ($request->metode_pembayaran == 'cash') {
        $uangBayar = $request->uang_bayar;
        $totalBayar = $request->total_bayar;
        
        if ($uangBayar < $totalBayar) {
            return redirect()->back()
                ->with('error', 'Uang yang dibayar kurang! Transaksi tidak dapat diproses.')
                ->withInput();
        }
    }

    // Hitung denda keterlambatan
    $today = Carbon::today();
    $rencana = Carbon::parse($peminjaman->tanggal_kembali_rencana);
    $hariTerlambat = 0;

    if ($today->gt($rencana)) {
        $hariTerlambat = $today->diffInDays($rencana);
    }

    $denda = 0;
    foreach ($peminjaman->details as $detail) {
        $dendaPerHari = $detail->alat->denda_per_hari;
        $jumlah = $detail->jumlah;
        $denda += $hariTerlambat * $dendaPerHari * $jumlah;
    }

    // Kode transaksi
    $last = Transaksi::latest()->first();
    if ($last) {
        $number = intval(substr($last->kode_transaksi, 4)) + 1;
    } else {
        $number = 1;
    }
    $kode = 'TRX-' . str_pad($number, 4, '0', STR_PAD_LEFT);

    $kerusakan = $request->biaya_kerusakan ?? 0;

    // Simpan transaksi (TANPA uang_dibayar dan kembalian)
    Transaksi::create([
        'kode_transaksi' => $kode,
        'peminjaman_id' => $request->peminjaman_id,
        'petugas_id' => Auth::id(),
        'no_telp' => $request->no_telp,
        'denda' => $denda,
        'biaya_kerusakan' => $kerusakan,
        'total_bayar' => $request->total_bayar,
        'metode_pembayaran' => $request->metode_pembayaran,
    ]);

    // Update status peminjaman
    $peminjaman->update([
        'status' => 'selesai'
    ]);

    // LOG AKTIVITAS ✅
    $this->logActivity('create', 'transaksi');

    return redirect()
        ->route('petugas.transaksi.index')
        ->with('success', 'Transaksi berhasil disimpan');
}



    public function show($id)
    {
        $transaksi = Transaksi::with([
            'peminjaman.user',
            'peminjaman.details.alat'
        ])->findOrFail($id);

        return view('petugas.transaksi.show', compact('transaksi'));
    }
}