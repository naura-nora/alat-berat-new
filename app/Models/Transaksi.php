<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'kode_transaksi',
        'peminjaman_id',
        'petugas_id',
        'no_telp',
        'harga_perhari',
        'jumlah_hari',
        'biaya_kerusakan',
        'total_bayar',
        'metode_pembayaran'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
