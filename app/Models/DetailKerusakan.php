<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKerusakan extends Model
{
    use HasFactory;

    protected $table = 'detail_kerusakan';
    
    protected $fillable = [
        'pengembalian_id',
        'detail_peminjaman_id',
        'deskripsi_kerusakan',
        'jumlah_rusak', 
        'biaya_perbaikan',
    ];

    protected $casts = [
        'biaya_perbaikan' => 'decimal:2',
    ];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class);
    }
}
