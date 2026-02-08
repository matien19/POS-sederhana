<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\KTPenjualanModel;
use App\Models\KTTransaksiModel;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class RiwayatTransaksiController extends Controller
{
    /**
     * Halaman utama riwayat transaksi
     */
    public function index()
    {
        $transaksi = KTTransaksiModel::with('kasir')
                    ->where('jenis_transaksi','penjualan')
                    ->orderBy('tanggal','desc')
                    ->get();

        return view('kasir.riwayat.transaksi', compact('transaksi'));
    }

    /**
     * Halaman Detail Transaksi
     */
    public function show($id)
    {
        $transaksi = KTTransaksiModel::with('kasir')
                        ->where('id',$id)
                        ->firstOrFail();

        $detail = KTPenjualanModel::with('barang')
                    ->where('id_transaksi',$id)
                    ->get();

        return view('kasir.riwayat.detail', compact('transaksi','detail'));
    }

    /**
     * Hapus transaksi + kembalikan stok
     */
    public function destroy($id)
    {
        $transaksi = KTTransaksiModel::findOrFail($id);

        foreach ($transaksi->hasMany(KTPenjualanModel::class,'id_transaksi')->get() as $item) {
            $barang = $item->barang;
            $barang->stok += $item->jumlah_jual;
            $barang->save();
        }

        $transaksi->delete();

        return back()->with('success','Transaksi berhasil dihapus & stok dikembalikan.');
    }

    /**
     * Cetak Struk
     */
    public function struk($id)
{
    $transaksi = KTTransaksiModel::findOrFail($id);

    $detail = KTPenjualanModel::with('barang')
                ->where('id_transaksi', $id)
                ->get();

    $html = view('kasir.riwayat.struk', compact('transaksi','detail'))->render();

    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => [88, 250], // 88mm lebar, tinggi 500mm
        'margin_top' => 5,
        'margin_bottom' => 5,
        'margin_left' => 5,
        'margin_right' => 5
    ]);

    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output('struk-'.$transaksi->no_transaksi.'.pdf', 'I'),
        200
    )->header('Content-Type', 'application/pdf');
}

}
