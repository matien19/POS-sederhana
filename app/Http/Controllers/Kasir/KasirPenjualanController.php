<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Admin\MDBarangModel;
use App\Models\KTPenjualanModel;
use App\Models\KTTransaksiModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KasirPenjualanController extends Controller
{
    /**
     * Generate No Transaksi Penjualan
     */
    private function generateNoTransaksi()
    {
        $last = KTTransaksiModel::where('jenis_transaksi', 'penjualan')
            ->orderBy('id', 'desc')
            ->first();

        if (!$last) {
            return 'PJ-0001';
        }

        $lastNumber = (int) substr($last->no_transaksi, -4);
        $newNumber  = $lastNumber + 1;

        return 'PJ-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * HALAMAN TRANSAKSI
     */
    public function index()
    {
        $barang = MDBarangModel::select(
            'id',
            'kode_barang',
            'nama_barang',
            'stok',
            'harga_jual'
        )->get();

        $noNota = $this->generateNoTransaksi();

        // reset cart saat masuk transaksi baru
        session()->forget('cart');

        return view('kasir.penjualan.transaksi', compact('barang', 'noNota'));
    }

    /**
     * TAMBAH KE CART (DARI JS / AJAX)
     */
    public function addCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $cart[] = [
            'kode'  => $request->kode,
            'nama'  => $request->nama,
            'harga' => $request->harga,
            'qty'   => $request->qty,
            'total' => $request->harga * $request->qty
        ];

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    /**
     * HALAMAN BAYAR
     */
    public function bayar()
{
    $cart = session('cart', []);

    // hitung total qty
    $total_qty = collect($cart)->sum('qty');

    return view('kasir.penjualan.bayar', [
        'cart' => $cart,
        'nota' => $this->generateNoTransaksi(),
        'total_qty' => $total_qty
    ]);
}



    /**
     * SIMPAN TRANSAKSI (NEXT STEP)
     */
    public function store(Request $request)
    {
        $request->validate([
        'jumlah_bayar' => 'required|numeric|min:0',
        'metode_bayar' => 'required',
    ]);

       
       
        $cart = session('cart', []);

        if (count($cart) === 0) {
           return redirect()->back()->with('warning','Cart kosong');
        }

        // hitung ulang (AMAN)
        $totalQty   = collect($cart)->sum('qty');
        $grandTotal = collect($cart)->sum('total');

        // SIMPAN HEADER SAJA
        $transaksi = KTTransaksiModel::create([
            'no_transaksi'    => $this->generateNoTransaksi(),
            'jenis_transaksi' => 'penjualan',
            'tanggal'         => now(),
            'id_users'        => auth('kasir')->id(),

            'total_qty'    => $totalQty,
            'diskon'       => $request->diskon,
            'total_bayar'  => $grandTotal,
            'jumlah_bayar' => $request->jumlah_bayar,
            'kembalian'    => $request->jumlah_bayar - $grandTotal,
            'metode_bayar' => $request->metode_bayar,
            'keterangan'   => $request->keterangan,
        ]);

        foreach ($cart as $item) {

            $barang = MDBarangModel::where('kode_barang', $item['kode'])
                ->lockForUpdate()
                ->first();

            if (!$barang || $barang->stok < $item['qty']) {
               return redirect()->back()->with('warning','Stok tidak mencukupi');
            }

            // ✅ SIMPAN DETAIL KE kt_penjualan
            KTPenjualanModel::create([
                'id_transaksi'  => $transaksi->id,
                'tanggal'       => now(),
                'id_barang'     => $barang->id,
                'harga_satuan'  => $item['harga'],
                'jumlah_jual'   => $item['qty'],
                'subtotal'      => $item['total'],
            ]);

            // ✅ KURANGI STOK
            $barang->decrement('stok', $item['qty']);
        }


        // KURANGI STOK SAJA
        foreach ($cart as $item) {
            $barang = MDBarangModel::where('kode_barang', $item['kode'])
                ->lockForUpdate()
                ->first();

            if (!$barang || $barang->stok < $item['qty']) {
               return redirect()->back()->with('warning','Stok tidak mencukupi');
            }

            $barang->decrement('stok', $item['qty']);
        }

        session()->forget('cart');

        return redirect()->route('kasir.penjualan')
            ->with('success', 'Transaksi berhasil disimpan');

    }
}
