<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MDBarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stok_barang = MDBarangModel::withSum('pembelian as total_masuk', 'jumlah_beli')
            ->withSum('penjualan as total_keluar', 'jumlah_jual')
            ->get()
            ->map(function($item){
                $item->stok = ($item->total_masuk ?? 0) - ($item->total_keluar ?? 0);
                return $item;
            });
        
    return view('admin.stokbarang', compact('stok_barang'));
    }
}
