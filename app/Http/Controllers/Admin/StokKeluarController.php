<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KTPenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangKeluar = KTPenjualanModel::with([
                'transaksi.kasir',
                'barang'
            ])
            ->whereHas('transaksi', function($q){
                $q->where('jenis_transaksi', 'penjualan');
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.stokkeluar', compact('barangKeluar'));
    }
}
