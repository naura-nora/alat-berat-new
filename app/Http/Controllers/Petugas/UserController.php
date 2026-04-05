<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Hanya ambil role peminjam
        $users = User::where('role', User::ROLE_PEMINJAM)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('petugas.user.index', compact('users'));
    }

    public function show(User $user)
    {
        // Proteksi manual kalau ada yang maksa buka user selain peminjam
        if ($user->role !== User::ROLE_PEMINJAM) {
            abort(403, 'Hanya dapat melihat data peminjam');
        }

        return view('petugas.user.show', compact('user'));
    }
}
