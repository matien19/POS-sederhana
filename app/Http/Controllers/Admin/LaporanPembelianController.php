<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MDSupplierModel;
use App\Models\KTTransaksiModel;
use App\Models\User;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use App\Exports\LaporanPembelianExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPembelianController extends Controller
{
    public function index(Request $request)
    {
        $supplier = MDSupplierModel::all();
        // $users = User::where('posisi','gudang')->get();

        $query = KTTransaksiModel::with(['supplier', 'petugas'])
            ->where('jenis_transaksi', 'pembelian');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal)
                ->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('id_supplier')) {
            $query->where('id_supplier', $request->id_supplier);
        }

        if ($request->filled('id_user')) {
            $query->where('id_users', $request->id_user);
        }

        $data = $query->orderBy('tanggal', 'desc')->get();

        return view('admin.laporanPembelian', compact('supplier', 'data'));
    }

    public function exportPdf(Request $request)
    {
        $query = KTTransaksiModel::with(['supplier', 'petugas'])
            ->where('jenis_transaksi', 'pembelian');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal)
                ->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('id_supplier')) {
            $query->where('id_supplier', $request->id_supplier);
            $namaSupplier = MDSupplierModel::find($request->id_supplier)?->nama;
        } else {
            $namaSupplier = 'Semua Supplier';
        }

        if ($request->filled('id_user')) {
            $query->where('id_users', $request->id_user);
            $namaPetugas = User::find($request->id_user)?->name;
        } else {
            $namaPetugas = 'Semua Petugas';
        }

        $data = $query->orderBy('tanggal', 'desc')->get();

        $html = view('admin.laporan_pembelian_pdf', compact(
            'data',
            'request',
            'namaSupplier',
            'namaPetugas'
        ))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_left' => 5,
            'margin_right' => 5
        ]);

        $mpdf->WriteHTML($html);
        return $mpdf->Output('Laporan_Pembelian.pdf', 'I');
    }

    // public function exportExcel(Request $request)
    // {
    //     return Excel::download(
    //         new LaporanPembelianExport($request),
    //         'Laporan_Pembelian.xlsx'
    //     );
    // }
}
