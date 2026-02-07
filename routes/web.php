<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::post('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::post('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');


