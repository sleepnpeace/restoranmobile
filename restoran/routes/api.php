<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KasirController;
use App\Http\Controllers\Api\MejaController;

// LOGIN
Route::post('/login', [AuthController::class, 'login']);

// GROUP KASIR
Route::prefix('kasir')->group(function () {

    Route::get('/initial-data', [KasirController::class, 'index']);
    Route::get('/menu/{id}', [KasirController::class, 'getMenuDetail']);
    Route::get('/meja', [KasirController::class, 'meja']);
    Route::post('/meja/update/{id}', [KasirController::class, 'updateStatusMeja']);

    Route::get('/transaksi', [KasirController::class, 'transaksi']);
    Route::get('/transaksi/{id}', [KasirController::class, 'show']);

    Route::post('/store', [KasirController::class, 'store']);
    Route::post('/konfirmasi-bayar/{id}', [KasirController::class, 'konfirmasiBayar']);
});

// LOGOUT
Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);
});