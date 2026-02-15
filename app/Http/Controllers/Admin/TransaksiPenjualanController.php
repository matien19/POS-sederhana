<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MDBarangModel;
use App\Models\KTPenjualanModel;
use App\Models\KTTransaksiModel;
use App\Models\PembayaranTransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class TransaksiPenjualanController extends Controller
{
    // =========================
    // INDEX
    // =========================
    public function index()
    {
        $transaksi = KTTransaksiModel::with(['kasir', 'penjualan.barang','pembayaran'])->withSum('pembayaran', 'jumlah_bayar')->get();
        return view('admin.transaksipenjualan', compact('transaksi'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'items'   => 'required|json',
        ]);

        $items = json_decode($request->items, true);

        $totalQty = 0;
        $totalBayar = 0;

        foreach ($items as $item) {
            $totalQty   += $item['qty'];
            $totalBayar += $item['subtotal'];
        }

        DB::beginTransaction();

        try {
            $transaksi = KTTransaksiModel::create([
                'no_transaksi'    => 'TRX-' . time(),
                'id_users'        => Auth::id(),
                'jenis_transaksi' => 'penjualan',
                'tanggal'         => $request->tanggal,
                'total_qty'       => $totalQty,
                'total_bayar'     => $totalBayar,
                'jumlah_bayar'    => $totalBayar,
                'kembalian'       => 0,
                'metode_bayar'    => 'Cash',
            ]);

            foreach ($items as $item) {
                $barang = MDBarangModel::where('kode_barang', $item['kode'])->first();

                if (!$barang) continue;

                KTPenjualanModel::create([
                    'id_transaksi' => $transaksi->id,
                    'tanggal'      => $request->tanggal,
                    'id_barang'    => $barang->id,
                    'harga_satuan' => $item['harga'],
                    'jumlah_jual'  => $item['qty'],
                    'subtotal'     => $item['subtotal'],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.penjualan.index')
                ->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // =========================
    // ✅ SHOW (DETAIL)
    // =========================
    public function show($id)
    {
        $transaksi = KTTransaksiModel::with([
            'kasir',
            'penjualan.barang'
        ])->findOrFail($id);

        $total = $transaksi->penjualan->sum('subtotal');
        $pembayaran = PembayaranTransaksiModel::where('id_transaksi', $id)->get();
        $total_dibayar = $pembayaran->sum('jumlah_bayar');

        return view('admin.penjualan_detail', compact('transaksi', 'total', 'pembayaran', 'total_dibayar'));
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $transaksi = KTTransaksiModel::with('penjualan.barang')->findOrFail($id);
        $barang = MDBarangModel::all();

        return view('admin.penjualan_edit', compact('transaksi', 'barang'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'items' => 'required|json'
        ]);

        $items = json_decode($request->items, true);

        DB::beginTransaction();

        try {
            $transaksi = KTTransaksiModel::findOrFail($id);

            KTPenjualanModel::where('id_transaksi', $id)->delete();

            $totalQty = 0;
            $totalBayar = 0;

            foreach ($items as $item) {
                KTPenjualanModel::create([
                    'id_transaksi' => $transaksi->id,
                    'tanggal'      => $transaksi->tanggal,
                    'id_barang'    => MDBarangModel::where('kode_barang', $item['kode'])->value('id'),
                    'harga_satuan' => $item['harga'],
                    'jumlah_jual'  => $item['qty'],
                    'subtotal'     => $item['subtotal'],
                ]);

                $totalQty   += $item['qty'];
                $totalBayar += $item['subtotal'];
            }

            $transaksi->update([
                'total_qty'   => $totalQty,
                'total_bayar' => $totalBayar,
                'jumlah_bayar' => $totalBayar,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.penjualan.index')
                ->with('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // =========================
    // DESTROY
    // =========================
    public function destroy($id)
    {
        KTTransaksiModel::findOrFail($id)->delete();
        return back()->with('success', 'Berhasil dihapus');
    }

    public function tambahBayar(Request $request, string $id)
    {
        $request->validate([
            'bayar' => 'required|integer'
        ]);

        $date = now();
        $jumlah_bayar = $request->bayar;
        $sisa = $request->sisa;

        $pembayaran = PembayaranTransaksiModel::create([
            'id_transaksi' => $id,
            'tanggal_bayar' => $date,
            'jumlah_bayar' => $jumlah_bayar,
        ]);

        if ($pembayaran) {
            if ($jumlah_bayar >= $sisa) {
                KTTransaksiModel::where('id', $id)->update([
                    'status_pembayaran' => 'LUNAS',
                ]);
            }
        }

        return back()->with('success', 'Berhasil bayar');
    }

    public function editBayar(Request $request, string $id, string $id_bayar)
    {
        $request->validate([
            'bayar' => 'required|integer'
        ]);

        $jumlah_bayar = $request->bayar;
        $sisa = $request->sisa;

        $pembayaran = PembayaranTransaksiModel::where('id', $id_bayar)->update([
            'jumlah_bayar' => $jumlah_bayar,
        ]);

        if ($pembayaran) {
            if ($jumlah_bayar >= $sisa) {
                KTTransaksiModel::where('id', $id)->update([
                    'status_pembayaran' => 'LUNAS',
                ]);
            }
        }

        return back()->with('success', 'Berhasil Edit bayar');
    }
}
