<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KTPembelianModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = KTPembelianModel::with([
                'transaksi.supplier',
                'barang'
            ])
            ->whereHas('transaksi', function($q){
                $q->where('jenis_transaksi', 'pembelian');
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.stokmasuk', compact('barangMasuk'));
    }
}
