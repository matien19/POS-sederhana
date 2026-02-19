<?php

use App\Http\Controllers\Admin\AdminDashController;
use App\Http\Controllers\Admin\TransaksiPenjualanController;
use App\Http\Controllers\Admin\TransaksiPembelianController;
use App\Http\Controllers\Admin\MerekBarangController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\KategoriBarangController;
use App\Http\Controllers\Admin\StokBarangController;
use App\Http\Controllers\Admin\StokMasukController;
use App\Http\Controllers\Admin\StokKeluarController;
use App\Http\Controllers\Admin\LaporanPembelianController;
use App\Http\Controllers\Admin\LaporanPenjualanController;
use App\Http\Controllers\Gudang\GudangPembelianController;
use App\Http\Controllers\Kasir\KasirPenjualanController;
use App\Http\Controllers\ReturController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminDashController::class, 'index'])->name('dashboard');


//transaksi pembelian
Route::get('/pembelian', [TransaksiPembelianController::class, 'index'])
    ->name('pembelian');

Route::get('/pembelian/tambah', [GudangPembelianController::class, 'index'])->name('pembelian.tambah');
Route::post('/pembelian/tambah', [GudangPembelianController::class, 'store'])->name('pembelian.store');

Route::post('/pembelian/update{id}', [TransaksiPembelianController::class, 'update'])->name('detail_pembelian.update');
Route::get('/pembelian/show{id}', [TransaksiPembelianController::class, 'show'])->name('detail_pembelian.show');
Route::get('/pembelian/destroy/{id}', [TransaksiPembelianController::class, 'destroy'])->name('pembelian.destroy');
Route::get('/pembelian/lunaskan/{id}', [TransaksiPembelianController::class, 'lunaskan'])->name('pembelian.lunaskan');


// Transaksi Penjualan

Route::get('/penjualan/tambah', [KasirPenjualanController::class, 'index'])
    ->name('penjualan.tambah');
Route::post('/penjualan/add-cart', [KasirPenjualanController::class, 'addCart'])
    ->name('penjualan.addCart');
Route::get('/penjualan/bayar', [KasirPenjualanController::class, 'bayar'])
    ->name('penjualan.bayar');
Route::post('/penjualan/store', [KasirPenjualanController::class, 'store'])
    ->name('penjualan.store');

Route::get('/penjualan', [TransaksiPenjualanController::class, 'index'])
    ->name('penjualan.index');
Route::post('/penjualan/add', [TransaksiPenjualanController::class, 'store'])
    ->name('penjualan.add');
Route::get('/penjualan/destroy/{id}', [TransaksiPenjualanController::class, 'destroy'])
    ->name('penjualan.destroy');
Route::get('/penjualan/{id}', [TransaksiPenjualanController::class, 'show'])
    ->name('penjualan.show');
    
Route::post('/penjualan/pembayaran/{id}', [TransaksiPenjualanController::class, 'tambahBayar'])
    ->name('penjualan.pembayaran.add');
Route::post('/penjualan/pembayaran/{id}/{id_bayar}', [TransaksiPenjualanController::class, 'editBayar'])
    ->name('penjualan.pembayaran.update');

// merek
Route::get('/merek', [MerekBarangController::class, 'index'])->name('merek');
Route::post('/merek/add', [MerekBarangController::class, 'store'])->name('merek.add');
Route::post('/merek/update/{id}', [MerekBarangController::class, 'update'])->name('merek.update');
Route::get('/merek/destroy/{id}', [MerekBarangController::class, 'destroy'])->name('merek.destroy');

// supplier
Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
Route::post('/supplier/add', [SupplierController::class, 'store'])->name('supplier.add');
Route::post('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::get('/supplier/destroy/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

// Barang
Route::get('/barang', [BarangController::class, 'index'])->name('barang');
Route::post('/barang/add', [BarangController::class, 'store'])->name('barang.add');
Route::post('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::get('/barang/destroy/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
Route::get('/barang/show/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::post('/barang/import', [BarangController::class, 'import'])->name('barang.import');
Route::get('/barang/{id}/barcode', [BarangController::class, 'barcode'])->name('barang.barcode');

// kategori
Route::get('/kategori', [KategoriBarangController::class, 'index'])->name('kategori');
Route::post('/kategori/add', [KategoriBarangController::class, 'store'])->name('kategori.add');
Route::post('/kategori/update/{id}', [KategoriBarangController::class, 'update'])->name('kategori.update');
Route::get('/kategori/destroy/{id}', [KategoriBarangController::class, 'destroy'])->name('kategori.destroy');

// Stok
Route::get('/stok/barang', [StokBarangController::class, 'index'])->name('stok.barang');
Route::get('/stok/masuk', [StokMasukController::class, 'index'])->name('stok.masuk');
Route::get('/stok/keluar', [StokKeluarController::class, 'index'])->name('stok.keluar');

// Laporan
Route::get('/laporan/pembelian', [LaporanPembelianController::class, 'index'])->name('laporan.pembelian');
Route::get('/laporan/pembelian/pdf', [LaporanPembelianController::class, 'exportPdf'])->name('laporan.pembelian.pdf');
Route::get('/laporan/pembelian/excel', [LaporanPembelianController::class, 'exportExcel'])->name('laporan.pembelian.excel');

Route::get('/laporan/penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan.penjualan');
Route::get('/laporan/penjualan/pdf', [LaporanPenjualanController::class, 'exportPdf'])->name('laporan.penjualan.pdf');
Route::get('/laporan/penjualan/excel', [LaporanPenjualanController::class, 'exportExcel'])->name('laporan.penjualan.excel');

//retur
Route::get('/retur', [ReturController::class, 'index'])->name('retur');
Route::post('/retur/add', [ReturController::class, 'store'])->name('retur.add');



//     // Manajemen User Admin
//     Route::get('/user/admin', [ManajemenUserController::class,'admin'])->name('user.admin');
//     Route::post('/user/admin/add', [ManajemenUserController::class,'storeAdmin'])->name('user.admin.add');
//     Route::post('/user/admin/update/{id}', [ManajemenUserController::class,'update'])->name('user.admin.update');
//     Route::get('/user/admin/destroy/{id}', [ManajemenUserController::class,'destroy'])->name('user.admin.destroy');

//     // Manajemen User Gudang
//     Route::get('/user/gudang', [ManajemenUserController::class,'gudang'])->name('user.gudang');
//     Route::post('/user/gudang/add', [ManajemenUserController::class,'storeGudang'])->name('user.gudang.add');
//     Route::post('/user/gudang/update/{id}', [ManajemenUserController::class,'update'])->name('user.gudang.update');
//     Route::get('/user/gudang/destroy/{id}', [ManajemenUserController::class,'destroy'])->name('user.gudang.destroy');

//     // Manajemen User Kasir
//     Route::get('/user/kasir', [ManajemenUserController::class,'kasir'])->name('user.kasir');
//     Route::post('/user/kasir/add', [ManajemenUserController::class,'storeKasir'])->name('user.kasir.add');
//     Route::post('/user/kasir/update/{id}', [ManajemenUserController::class,'update'])->name('user.kasir.update');
//     Route::get('/user/kasir/destroy/{id}', [ManajemenUserController::class,'destroy'])->name('user.kasir.destroy');

//     // Pengumuman
//     Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman');
//     // Simpan pengumuman
//     Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');



// Route::prefix('kasir')->middleware('auth:kasir')->name('kasir.')->group(function () {
//     Route::get('/dashboard', [KasirDashController::class, 'index'])->name('dashboard');
    
//     Route::get('/transaksi', [RiwayatTransaksiController::class, 'index'])->name('transaksi');
//     Route::get('/transaksi/{id}', [RiwayatTransaksiController::class, 'show'])->name('transaksi.show');
//     Route::get('/transaksi/destroy/{id}', [RiwayatTransaksiController::class, 'destroy'])->name('transaksi.destroy');
//     Route::get('/transaksi/{id}/struk', [RiwayatTransaksiController::class,'struk'])
//         ->name('transaksi.struk');

//     Route::get('/laporan', [KasirLaporanController::class,'index'])->name('laporan');
//     Route::get('/laporan/pdf', [KasirLaporanController::class,'exportPdf'])->name('laporan.pdf');
//     Route::get('/laporan/excel', [KasirLaporanController::class,'exportExcel'])->name('laporan.excel');

    
//     Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
//     Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
//     Route::put('/profile/foto', [ProfileController::class, 'updateFoto'])
//     ->name('profile.foto');



// });

// Route::prefix('gudang')->middleware('auth:gudang')->name('gudang.')->group(function () {
//     Route::get('/dashboard', [GudangDashController::class, 'index'])->name('dashboard');
    
//     Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
//     Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
//     Route::put('/profile/foto', [ProfileController::class, 'updateFoto'])
//     ->name('profile.foto');

    
// });
