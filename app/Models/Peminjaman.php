<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_peminjaman',
        'user_id',
        'petugas_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'alasan_peminjaman'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
    ];

    // Relasi ke user (peminjam)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke petugas
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // Relasi ke detail peminjaman
    public function details()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    // Relasi ke pengembalian
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    // Relasi ke transaksi
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }

    // Peminjaman.php - TAMBAH INI
    public function scopePerBulan($query, $tahun, $bulan)
    {
        return $query->whereYear('tanggal_pinjam', $tahun)
                    ->whereMonth('tanggal_pinjam', $bulan)
                    ->whereIn('status', ['disetujui', 'dipinjam', 'selesai']); // Hanya yang selesai
    }

    public function getJumlahBarangAttribute()
    {
        return $this->details->sum('jumlah');
    }

    public function getTotalHargaAttribute()
    {
        return $this->details->sum(function($detail) {
            return $detail->harga_sewa * $detail->jumlah;
        });
    }

    public function getDendaAttribute()
    {
        return $this->transaksi->denda ?? 0;
    }

    public function getBarangListAttribute()
    {
        return $this->details->pluck('alat.nama')->unique()->implode(', ');
    }
}