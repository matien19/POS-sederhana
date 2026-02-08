<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MDBarangModel;
use App\Models\KTTransaksiModel;
use Illuminate\Support\Facades\DB;

class AdminDashController extends Controller
{
public function index()
{
    // hitung stok real
    $barang = MDBarangModel::withSum('pembelian as total_masuk', 'jumlah_beli')
        ->withSum('penjualan as total_keluar', 'jumlah_jual')
        ->get()
        ->map(function ($item) {
            $item->stok_real = ($item->total_masuk ?? 0) - ($item->total_keluar ?? 0);
            return $item;
        });

    // grafik transaksi per bulan
    $grafik = KTTransaksiModel::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw("SUM(CASE WHEN jenis_transaksi='penjualan' THEN total_bayar ELSE 0 END) as penjualan"),
            DB::raw("SUM(CASE WHEN jenis_transaksi='pembelian' THEN total_bayar ELSE 0 END) as pembelian")
        )
        ->whereYear('tanggal', date('Y'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    return view('admin.dashboard', [
        'totalBarang'      => $barang->count(),
        'stokHabis'        => $barang->where('stok_real', '<=', 0)->count(),
        'totalPembelian'   => KTTransaksiModel::where('jenis_transaksi', 'pembelian')->sum('total_bayar'),
        'totalPenjualan'   => KTTransaksiModel::where('jenis_transaksi', 'penjualan')->sum('total_bayar'),
        'transaksiTerbaru' => KTTransaksiModel::latest()->take(5)->get(),
        'grafik'           => $grafik
    ]);
}
}