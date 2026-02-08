<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KTTransaksiModel;
use App\Models\User;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use App\Exports\LaporanPenjualanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        // $petugas = User::where('posisi','kasir')->get();

        $query = KTTransaksiModel::with('kasir')
            ->where('jenis_transaksi','penjualan');

        // Filter tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal','>=',$request->tanggal_awal)
                  ->whereDate('tanggal','<=',$request->tanggal_akhir);
        }

        // Filter kasir
        if ($request->filled('id_user')) {
            $query->where('id_users',$request->id_user);
        }

        // Filter pembayaran
        if ($request->filled('pembayaran')) {
            $query->where('metode_bayar',$request->pembayaran);
        }

        $data = $query->orderBy('tanggal','desc')->get();

        return view('admin.laporanpenjualan', compact('data'));
    }

    /**
     * EXPORT PDF
     */
    public function exportPdf(Request $request)
    {
        $query = KTTransaksiModel::with('kasir')
            ->where('jenis_transaksi','penjualan');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal','>=',$request->tanggal_awal)
                  ->whereDate('tanggal','<=',$request->tanggal_akhir);
        }

        if ($request->filled('id_user')) {
            $query->where('id_users',$request->id_user);
            $namaKasir = User::find($request->id_user)?->name;
        } else {
            $namaKasir = 'Semua Kasir';
        }

        if ($request->filled('pembayaran')) {
            $query->where('metode_bayar',$request->pembayaran);
            $metodePembayaran = $request->pembayaran;
        } else {
            $metodePembayaran = 'Semua';
        }

        $data = $query->orderBy('tanggal','desc')->get();

        $html = view('admin.laporan_penjualan', compact(
            'data',
            'request',
            'namaKasir',
            'metodePembayaran'
        ))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10
        ]);

        $mpdf->WriteHTML($html);
        return $mpdf->Output('Laporan_Penjualan.pdf','I');
    }

    /**
     * EXPORT EXCEL
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanPenjualanExport($request),
            'Laporan_Penjualan.xlsx'
        );
    }
}
