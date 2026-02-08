<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Admin\MDBarangModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\KTTransaksiModel;

class GudangDashController extends Controller
{
    /**
     * Dashboard Gudang
     */
    public function index()
    {
        /* ===============================
         * INFO BOX
         * =============================== */

        // Total barang
        $totalBarang = MDBarangModel::count();

        // Stok menipis (misal <= 5)
        $stokMenipis = MDBarangModel::where('stok', '<=', 5)->count();

        // Total pembelian tahun ini
        $totalPembelian = KTTransaksiModel::whereYear('tanggal', date('Y'))
            ->sum('total_bayar');

        /* ===============================
         * BARANG STOK MENIPIS (TABEL)
         * =============================== */
        $barangMenipis = MDBarangModel::where('stok', '<=', 5)
            ->orderBy('stok', 'asc')
            ->limit(10)
            ->get();

        /* ===============================
         * GRAFIK PEMBELIAN PER BULAN
         * =============================== */
        $grafik = KTTransaksiModel::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('SUM(total_bayar) as total')
            )
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy('bulan')
            ->get();

        // Siapkan data grafik (12 bulan)
        $bulan = [];
        $total = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = Carbon::create()->month($i)->translatedFormat('F');

            $data = $grafik->firstWhere('bulan', $i);
            $total[] = $data ? (int) $data->total : 0;
        }

        /* ===============================
         * RETURN VIEW
         * =============================== */
        return view('gudang.dashboard', compact(
            'totalBarang',
            'stokMenipis',
            'totalPembelian',
            'barangMenipis',
            'bulan',
            'total'
        ));
    }
}
