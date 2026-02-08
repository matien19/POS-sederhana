<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KasirDashController extends Controller
{
    public function index()
{
    $today = Carbon::today();
    $year  = date('Y');

    // DATA GRAFIK BULANAN
    $grafik = DB::table('kt_transaksi')
        ->select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('SUM(total_bayar) as total')
        )
        ->whereYear('tanggal', $year)
        ->where('jenis_transaksi', 'penjualan')
        ->groupBy(DB::raw('MONTH(tanggal)'))
        ->orderBy('bulan')
        ->get();

    $bulan = [];
    $total = [];

    foreach ($grafik as $g) {
        $bulan[] = Carbon::create()->month($g->bulan)->format('F');
        $total[] = $g->total;
    }

    return view('kasir.dashboard', [
        'totalHariIni'    => DB::table('kt_transaksi')->whereDate('tanggal',$today)->sum('total_bayar'),
        'jumlahTransaksi' => DB::table('kt_transaksi')->whereDate('tanggal',$today)->count(),
        'transaksiTerbaru'=> DB::table('kt_transaksi')->latest()->limit(5)->get(),
        'bulan'           => $bulan,
        'total'           => $total
    ]);
}
}
