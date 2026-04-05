<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    // TAMBAHKAN INI
    protected $table = 'pengembalian'; // Spesifikasikan nama table
    
    protected $fillable = [
        'peminjaman_id',
        'petugas_id',
        'tanggal_kembali_aktual',
        'kondisi_alat',
        'keterangan',
        'denda_per_hari',
        'hari_keterlambatan',
        'total_denda',
        'status'
    ];

    protected $casts = [
        'tanggal_kembali_aktual' => 'date',
        'denda_per_hari' => 'decimal:2',
        'total_denda' => 'decimal:2',
    ];

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    // Relasi ke petugas
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // Helper methods untuk status
    public function isMenunggu()
    {
        return $this->status === 'menunggu';
    }

    public function isDicek()
    {
        return $this->status === 'dicek';
    }

    public function isSelesai()
    {
        return $this->status === 'selesai';
    }

    public function isDibatalkan()
    {
        return $this->status === 'dibatalkan';
    }

    public function detailKerusakan()
    {
        return $this->hasMany(DetailKerusakan::class);
    }


    // Tambah method untuk total biaya
    public function getTotalBiayaKerusakanAttribute()
    {
        return $this->detailKerusakan->sum('biaya_perbaikan');
    }


    public function kerusakan()
    {
        return $this->hasMany(DetailKerusakan::class);
    }
}