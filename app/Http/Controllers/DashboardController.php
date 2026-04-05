<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirect ke dashboard berdasarkan role user
     */
    public function index()
    {
        $user = Auth::user();
        
        // Cek role dan redirect
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        
        if ($user->role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        }
        
        if ($user->role === 'peminjam') {
            return redirect()->route('peminjam.dashboard');
        }
        
        // Fallback jika role tidak valid
        Auth::logout();
        return redirect('/')->withErrors(['role' => 'Role tidak valid.']);
    }
}