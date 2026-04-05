<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AlatController as AdminAlatController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Peminjam\DashboardController as PeminjamDashboardController;
use App\Http\Controllers\Peminjam\PeminjamanController as PeminjamPeminjamanController;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController;
use App\Http\Controllers\Petugas\AlatController as PetugasAlatController;
use App\Http\Controllers\Petugas\UserController as PetugasUserController;
use App\Http\Controllers\Peminjam\AlatController;
use App\Http\Controllers\Petugas\TransaksiController;


// TAMBAHKAN INI
use App\Http\Controllers\Petugas\PengembalianController as PetugasPengembalianController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Welcome Page (Home) - Login Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login (dari welcome page)
    Route::get('/login', function () {
        return view('welcome');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    });

    // Register
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function (Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => 'peminjam',
        ]);

        Auth::login($user);
        
        return redirect()->route('peminjam.dashboard');
    });
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect('/');
})->name('logout');

// =============================================
// PROTECTED ROUTES (HARUS LOGIN)
// =============================================
Route::middleware(['auth'])->group(function () {
    // Dashboard umum (redirect ke dashboard berdasarkan role)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

// =============================================
// ADMIN ROUTES
// =============================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Alat Berat CRUD
    Route::resource('alat', AdminAlatController::class);
    
    // Kategori CRUD
    Route::resource('kategori', AdminKategoriController::class);
    
    // User Management CRUD
    Route::resource('user', AdminUserController::class);
    
    // LAPORAN BULANAN
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminLaporanController::class, 'index'])->name('index');
        Route::get('/cetak-bulan/{tahun}/{bulan}', [\App\Http\Controllers\Admin\AdminLaporanController::class, 'cetakBulan'])->name('cetak.bulan');
    });
    
    // Peminjaman admin
    Route::get('/peminjaman', [\App\Http\Controllers\Admin\PeminjamanController::class, 'index'])->name('peminjaman.index');
    
    Route::delete('/peminjaman/{id}', [\App\Http\Controllers\Admin\PeminjamanController::class, 'destroy'])
    ->name('peminjaman.destroy');

    // Pengembalian admin
    Route::get('/pengembalian', [\App\Http\Controllers\Admin\PengembalianController::class, 'index'])->name('pengembalian.index');

    Route::get('/pengembalian/{id}', [\App\Http\Controllers\Admin\PengembalianController::class, 'show'])
        ->name('pengembalian.show');

    Route::delete('/pengembalian/{id}', [\App\Http\Controllers\Admin\PengembalianController::class, 'destroy'])
        ->name('pengembalian.destroy');
});

// =============================================
// PETUGAS ROUTES - DIPERBAIKI
// =============================================
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'petugas'])->group(function () {

    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])
        ->name('dashboard');

    // ===== ALAT (VIEW ONLY) =====
    Route::get('/alat', [PetugasAlatController::class, 'index'])
        ->name('alat.index');

    Route::get('/alat/{alat}', [PetugasAlatController::class, 'show'])
        ->name('alat.show');

    // ===== PEMINJAMAN =====
    Route::get('/peminjaman', [PetugasPeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    Route::post('/peminjaman/{peminjaman}/approve', [PetugasPeminjamanController::class, 'approve'])
        ->name('peminjaman.approve');

    Route::post('/peminjaman/{peminjaman}/reject', [PetugasPeminjamanController::class, 'reject'])
        ->name('peminjaman.reject');

    // ===== PENGEMBALIAN =====
    Route::prefix('pengembalian')->name('pengembalian.')->group(function () {
        Route::get('/', [PetugasPengembalianController::class, 'index'])->name('index');
        Route::get('/{id}/cek', [PetugasPengembalianController::class, 'cek'])->name('cek');
        Route::post('/{id}/proses-cek', [PetugasPengembalianController::class, 'prosesCek'])->name('proses.cek');
        Route::get('/{id}/transaksi', [PetugasPengembalianController::class, 'transaksi'])->name('transaksi');
        Route::post('/{id}/selesai', [PetugasPengembalianController::class, 'selesai'])->name('selesai');
        Route::delete('/{id}/batalkan', [PetugasPengembalianController::class, 'batalkan'])->name('batalkan');
        Route::get('/{id}', [PetugasPengembalianController::class, 'show'])->name('show');
    });
    
    // ===== USER =====
        Route::get('/user', [PetugasUserController::class, 'index'])
            ->name('user.index');

        Route::get('/user/{user}', [PetugasUserController::class, 'show'])
            ->name('user.show');

    // ===== TRANSAKSI =====
        Route::get('/transaksi', [TransaksiController::class, 'index'])
            ->name('transaksi.index');

        Route::get('/transaksi/create/', [TransaksiController::class, 'create'])
            ->name('transaksi.create');

        Route::post('/transaksi/store', [TransaksiController::class, 'store'])
            ->name('transaksi.store');

        Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])
            ->name('transaksi.show');

});


// =============================================
// PEMINJAM ROUTES - DIPERBAIKI
// =============================================
Route::prefix('peminjam')->name('peminjam.')->middleware(['auth', 'peminjam'])->group(function () {

    Route::get('/dashboard', [PeminjamDashboardController::class, 'index'])
        ->name('dashboard');

    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {

        Route::get('/', [PeminjamPeminjamanController::class, 'index'])
            ->name('index');

        Route::get('/aktif', [PeminjamPeminjamanController::class, 'aktif'])
            ->name('aktif');

        Route::get('/riwayat', [PeminjamPeminjamanController::class, 'riwayat'])
            ->name('riwayat');

        Route::get('/create', [PeminjamPeminjamanController::class, 'create'])
            ->name('create');

        Route::post('/', [PeminjamPeminjamanController::class, 'store'])
            ->name('store');

        Route::get('/{peminjaman}', [PeminjamPeminjamanController::class, 'show'])
            ->name('show');

        Route::get('/{peminjaman}/edit', [PeminjamPeminjamanController::class, 'edit'])
            ->name('edit');

        Route::put('/{peminjaman}', [PeminjamPeminjamanController::class, 'update'])
            ->name('update');

        Route::delete('/{peminjaman}', [PeminjamPeminjamanController::class, 'destroy'])
            ->name('destroy');

        Route::post('/{peminjaman}/kembalikan', [PeminjamPeminjamanController::class, 'kembalikan'])
            ->name('kembalikan');

        
    });

        // DAFTAR ALAT
        Route::get('/alat', [AlatController::class, 'index'])
            ->name('alat.index');
});