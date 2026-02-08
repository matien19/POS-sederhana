<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KTTransaksiModel;
use App\Models\Admin\MDBarangModel;
use App\Models\Admin\MDSupplierModel as AdminMDSupplierModel;
use App\Models\MDSupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class TransaksiPembelianController extends Controller
{
    /**
     * LIST TRANSAKSI PEMBELIAN
     * 1 TRANSAKSI = 1 BARIS
     */
    public function index()
    {
        $pembelian = KTTransaksiModel::with([
                'supplier',
                'petugas'
            ])
            ->where('jenis_transaksi', 'pembelian')
            ->whereNotNull('id_supplier')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.pembelian', compact('pembelian'));
    }

    /**
     * DETAIL TRANSAKSI PEMBELIAN
     */
    public function show(string $id)
    {
        $transaksi = KTTransaksiModel::with([
                'supplier',
                'petugas',
                'detail.barang'
            ])
            ->where('jenis_transaksi', 'pembelian')
            ->findOrFail($id);

        return view('admin.detail_pembelian', compact('transaksi'));
    }

    /**
     * FORM EDIT PEMBELIAN
     * (PAKAI VIEW YANG SAMA DENGAN TAMBAH)
     */
    public function edit(string $id)
    {
        $transaksi = KTTransaksiModel::with([
            'detail.barang',
            'supplier',
            'petugas'
        ])->findOrFail($id);

        return view('admin.tambah_pembelian', [
            // variabel ini DISAMAKAN dengan Blade kamu
            'transaksi' => $transaksi,
            'pembelian' => $transaksi,
            'users'     => $transaksi->petugas,
            'tanggal'   => (object)[
                'id'       => $transaksi->id,
                'tanggal' => $transaksi->tanggal
            ],
            'barang'   => MDBarangModel::all(),
            'supplier' => AdminMDSupplierModel::all(),
        ]);
    }

    /**
     * UPDATE DATA PEMBELIAN
     */
    public function update(Request $request, string $id)
    {
    DB::transaction(function () use ($request, $id) {

        $transaksi = KTTransaksiModel::findOrFail($id);

        $total = 0;
        if ($request->has('barang')) {
            foreach ($request->barang as $b) {
                $total += $b['qty'] * $b['harga'];
            }
        }

        $transaksi->update([
            'id_supplier'  => $request->id_supplier,
            'total_bayar'  => $total,
            'jumlah_bayar' => $total,
        ]);

        $transaksi->detail()->delete();

        if ($request->has('barang')) {
            foreach ($request->barang as $item) {
                $transaksi->detail()->create([
                    'id_barang'    => $item['id'],
                    'tanggal'      => now(),
                    'jumlah_beli'  => $item['qty'],
                    'harga_satuan' => $item['harga'],
                    'subtotal'     => $item['qty'] * $item['harga'],
                ]);
            }
        }
    });

    return redirect()
        ->route('admin.pembelian')
        ->with('success', 'Pembelian berhasil diperbarui');
    }


    /**
     * HAPUS TRANSAKSI (HEADER + DETAIL)
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $transaksi = KTTransaksiModel::findOrFail($id);
            $transaksi->detail()->delete();
            $transaksi->delete();
        });

        return back()->with('success', 'Transaksi berhasil dihapus');
    }
}