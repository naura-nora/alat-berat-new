<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Tambahkan konstanta untuk role
    const ROLE_ADMIN = 'admin';
    const ROLE_PETUGAS = 'petugas';
    const ROLE_PEMINJAM = 'peminjam';

    // Helper methods untuk cek role
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPetugas()
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function isPeminjam()
    {
        return $this->role === self::ROLE_PEMINJAM;
    }
}