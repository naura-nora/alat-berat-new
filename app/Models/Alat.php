<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alat';
    
    protected $fillable = [
        'kategori_id',
        'kode_alat',
        'nama',
        'merk',
        'deskripsi',
        'stok',
        'gambar',
        'status',
        'harga_sewa',
        'denda_per_hari'
    ];

    protected $casts = [
        'harga_sewa' => 'decimal:2',
        'stok' => 'integer',
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Scope untuk alat tersedia
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    // Scope untuk alat dipinjam
    public function scopeDipinjam($query)
    {
        return $query->where('status', 'dipinjam');
    }

    public function getGambarUrlAttribute()
    {
        if (!$this->gambar) {
            // ✅ PERUBAHAN DI SINI (gambar default):
            return asset('images/photo1.png');
        }
        
        // Cek apakah file gambar ada
        $path = public_path('images/' . $this->gambar);
        if (file_exists($path)) {
            return asset('images/' . $this->gambar);
        }
        
        // ✅ PERUBAHAN DI SINI (gambar default):
        return asset('images/photo1.png');
    }

    public function kurangiStok($jumlah)
    {
        $this->decrement('stok', $jumlah);
        
        if ($this->stok <= 0) {
            $this->update(['status' => 'dipinjam']);
        }
    }

    public function tambahStok($jumlah)
    {
        $this->increment('stok', $jumlah);
        
        if ($this->stok > 0 && $this->status == 'dipinjam') {
            $this->update(['status' => 'tersedia']);
        }
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

}