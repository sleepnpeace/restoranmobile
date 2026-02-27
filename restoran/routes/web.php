<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KasirController;   
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ModifyUserController;

// Redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

//DASHBOARD KASIR & TRANSAKSI 
// Menu (Dashboard Utama)
    Route::get('/kasir/menu', [KasirController::class, 'index'])->name('kasir.menu');
    Route::post('/transaksi/store', [KasirController::class, 'store'])->name('transaksi.store');
    Route::get('/kasir/menu/{id}', [KasirController::class, 'getMenuDetail']);

    // Meja
    Route::get('/kasir/meja', [KasirController::class, 'meja'])->name('kasir.meja');
    Route::post('/kasir/meja/{id}/update', [KasirController::class, 'updateStatusMeja'])->name('kasir.meja.update');

    // Transaksi
    Route::get('/kasir/transaksi', [KasirController::class, 'transaksi'])->name('kasir.transaksi');
    Route::post('/kasir/transaksi/bayar/{id}', [KasirController::class, 'konfirmasiBayar'])->name('kasir.transaksi.bayar');
    Route::get('/kasir/transaksi/{id}/detail', [TransaksiController::class, 'show'])->name('kasir.detailtransaksi');
    Route::post('/transaksi/{id}/tambah', [TransaksiController::class, 'tambahPesanan'])->name('transaksi.tambah');

// DASHBOARD MANAGER & ADMIN
Route::get('/manager/dashboard', [DashboardController::class, 'manager'])->name('manager.dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

// KATEGORI
Route::resource('kategori', KategoriController::class);

// MEJA
Route::resource('meja', MejaController::class);

// MENU
Route::resource('menu', MenuController::class);

// USER
Route::resource('users', ModifyUserController::class)->names([
    'index'   => 'users.index',
    'create'  => 'users.create',
    'store'   => 'users.store',
    'edit'    => 'users.edit',
    'update'  => 'users.update',
    'destroy' => 'users.destroy',
]);

// TRANSAKSI
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');    
Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');

// Route BARU untuk Manager
Route::get('/manager/laporan-transaksi', [TransaksiController::class, 'managerIndex'])->name('manager.transaksi.index');
Route::get('/manager/laporan-transaksi/{id}', [TransaksiController::class, 'managerShow'])->name('manager.transaksi.show');