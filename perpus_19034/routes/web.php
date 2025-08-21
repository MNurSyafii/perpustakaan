<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoribukuController;
use App\Http\Controllers\KategoribukuRelasiController;
use App\Http\Controllers\KoleksipribadiController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UlasanbukuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController; 
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/{id}/reset-password', [AuthController::class, 'resetPassword'])
     ->name('user.reset-password');
Route::get('/{id}/loan-history', [AuthController::class, 'showLoanHistory'])
     ->name('user.loan-history');

/*
|--------------------------------------------------------------------------
| Protected Routes (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/', function () {
        return view('auth/login');
    });
    // Redirect pengguna berdasarkan role
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');
    Route::get('/peminjam/dashboard', [DashboardController::class, 'index'])->name('peminjam.dashboard');
    // Halaman Home default
    Route::get('/home', function () {
        return redirect()->route('peminjam.dashboard'); // Atur route default
    })->name('home');
    
Route::get('/admin/ulasan', [UlasanbukuController::class, 'index'])->name('admin.ulasan.index');
Route::get('/admin/ulasan/create', [UlasanbukuController::class, 'create'])->name('admin.ulasan.create');
Route::post('/admin/ulasan', [UlasanbukuController::class, 'store'])->name('admin.ulasan.store');
Route::get('/admin/ulasan/{id}', [UlasanbukuController::class, 'show'])->name('admin.ulasan.show');
Route::get('/admin/ulasan/{id}/edit', [UlasanbukuController::class, 'edit'])->name('admin.ulasan.edit');
Route::put('/admin/ulasan/{id}', [UlasanbukuController::class, 'update'])->name('admin.ulasan.update');
Route::delete('/admin/ulasan/{id}', [UlasanbukuController::class, 'destroy'])->name('admin.ulasan.destroy');

    // Laporan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/buku', [LaporanController::class, 'bukuIndex'])->name('laporan.buku');
Route::post('/laporan/buku/generate', [LaporanController::class, 'generateBukuPDF'])->name('laporan.buku.generate');
Route::get('/laporan/peminjaman', [LaporanController::class, 'peminjamanIndex'])->name('laporan.peminjaman');
Route::post('/laporan/peminjaman/generate', [LaporanController::class, 'generatePeminjamanPDF'])->name('laporan.peminjaman.generate');

   
Route::resource('buku', BukuController::class);
Route::resource('kategoribuku', KategoribukuController::class);
Route::resource('kategoribuku_relasi', KategoribukuRelasiController::class)->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy', 'show'
    ]);
Route::resource('koleksipribadi', KoleksipribadiController::class);
Route::resource('peminjaman', PeminjamanController::class);
Route::resource('ulasanbuku', UlasanbukuController::class);

Route::get('/users', [AuthController::class, 'index'])->name('user.tampil');
Route::get('/users/create', [AuthController::class, 'createUser'])->name('user.create');
Route::post('/users', [AuthController::class, 'storeUser'])->name('user.store');
Route::get('/users/{id}', [AuthController::class, 'show'])->name('user.show');
Route::get('/users/{id}/edit', [AuthController::class, 'edit'])->name('user.edit');
Route::put('/users/{id}', [AuthController::class, 'update'])->name('user.update');
Route::delete('/users/{id}', [AuthController::class, 'destroy'])->name('user.destroy');

    // Hanya peminjam
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');

// Admin/Petugas
Route::post('peminjaman/{id}/acc', [PeminjamanController::class, 'acc'])->name('peminjaman.acc');
Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
Route::post('/peminjaman/{id}/mulai', [PeminjamanController::class, 'mulaiPinjam'])->name('peminjaman.mulai');
Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
Route::get('/ulasan/search', [UlasanbukuController::class, 'searchUlasan'])->name('ulasan.search');



});