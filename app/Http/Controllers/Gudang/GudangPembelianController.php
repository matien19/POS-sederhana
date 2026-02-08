<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Admin\MDBarangModel;
use App\Models\Admin\MDSupplierModel as AdminMDSupplierModel;
use App\Models\KTPembelianModel;
use App\Models\KTTransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GudangPembelianController extends Controller
{
    /**
     * HALAMAN TRANSAKSI PEMBELIAN
     * Hanya menampilkan form kosong dengan nomor otomatis (tanpa save ke DB).
     */
    public function index()
    {
        // 1. Hitung Calon Nomor Transaksi Berikutnya (Hanya untuk Tampilan)
        $last   = KTTransaksiModel::where('jenis_transaksi', 'pembelian')->latest('id')->first();
        $lastNo = $last ? (int)substr($last->no_transaksi, -4) : 0;
        $noUrut = $lastNo + 1;
        $calonNoTransaksi = 'PB-' . str_pad($noUrut, 4, '0', STR_PAD_LEFT);

        // 2. Buat Objek Dummy (Hanya di Memory, TIDAK masuk Database)
        $transaksi = new KTTransaksiModel();
        $transaksi->no_transaksi = $calonNoTransaksi;
        $transaksi->tanggal = now();

        return view('gudang.transaksi_pembelian', [
            'transaksi' => $transaksi, // Objek belum punya ID
            'users'     => Auth::user(),
            'tanggal'   => now(),
            'barang'    => MDBarangModel::all(),
            'supplier'  => AdminMDSupplierModel::all(),
        ]);
    }

    /**
     * SIMPAN TRANSAKSI (CREATE HEADER & DETAIL)
     * Data baru masuk database di sini.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (Hapus validasi id_transaksi karena baru akan dibuat)
        $request->validate([
            'id_supplier'    => 'required|exists:md_supplier,id',
            'barang'         => 'required|array|min:1', // Wajib ada minimal 1 barang
            'barang.*.id'    => 'required|exists:md_barang,id',
            'barang.*.qty'   => 'required|integer|min:1',
            'barang.*.harga' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {
                
                // 2. Generate Ulang Nomor (Untuk memastikan tidak duplikat saat save)
                $last   = KTTransaksiModel::where('jenis_transaksi', 'pembelian')
                            ->latest('id')
                            ->lockForUpdate() // Kunci tabel sebentar agar aman
                            ->first();
                $lastNo = $last ? (int)substr($last->no_transaksi, -4) : 0;
                $noUrut = $lastNo + 1;
                $fixedNoTransaksi = 'PB-' . str_pad($noUrut, 4, '0', STR_PAD_LEFT);

                // 3. Simpan HEADER Transaksi
                $transaksiBaru = KTTransaksiModel::create([
                    'no_transaksi'    => $fixedNoTransaksi,
                    'tanggal'         => now(),
                    'id_supplier'     => $request->id_supplier,
                    'jenis_transaksi' => 'pembelian',
                    'metode_bayar'    => 'cash', // Default cash
                    'total_qty'       => 0,      // Nanti diupdate
                    'total_bayar'     => 0,      // Nanti diupdate
                    'jumlah_bayar'    => 0,
                    'diskon'          => 0,
                ]);

                $totalQty   = 0;
                $totalBayar = 0;

                // 4. Simpan DETAIL Barang & Update Stok
                foreach ($request->barang as $item) {
                    $qty      = (int) $item['qty'];
                    $harga    = (float) $item['harga'];
                    $subtotal = $qty * $harga;

                    KTPembelianModel::create([
                        'tanggal'      => now(),
                        'id_transaksi' => $transaksiBaru->id, // Ambil ID dari header yg baru dibuat
                        'id_barang'    => $item['id'],
                        'jumlah_beli'  => $qty,
                        'harga_satuan' => $harga,
                        'subtotal'     => $subtotal,
                    ]);

                    // Tambah Stok Barang
                    MDBarangModel::where('id', $item['id'])
                        ->increment('stok', $qty);

                    $totalQty   += $qty;
                    $totalBayar += $subtotal;
                }

                // 5. Update Header dengan Total Akhir
                $transaksiBaru->update([
                    'total_qty'    => $totalQty,
                    'total_bayar'  => $totalBayar,
                    'jumlah_bayar' => $totalBayar, // Asumsi lunas
                ]);
            });

            return redirect()
                ->route('pembelian.tambah') // Pastikan route ini mengarah kembali ke index pembelian
                ->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}