<?php

namespace App\Http\Controllers;

use App\Models\Admin\MDBarangModel;
use App\Models\ReturModel;
use Illuminate\Http\Request;

use function Termwind\render;

class ReturController extends Controller
{
    public function index()
    {
        $barang = MDBarangModel::all();
        $data = ReturModel::with('barang')->get();
        return view('admin.retur', compact('barang', 'data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kustomer' => 'required|string',
            'barang_id' => 'required|integer',
            'jumlah_retur' => 'required|integer',
        ]);

        $barang = MDBarangModel::findOrFail($request->barang_id);
        $stok_barang = $barang->stok;
        $retur = $request->jumlah_retur;
        if ($stok_barang < $retur) {
            return redirect()->back()->with('warning', 'Stok barang kurang Cokk!!');
        }
        $barang->stok -= $retur;
        $barang->save();

        ReturModel::create([
            'id_barang' => $request->barang_id,
            'customer' => $request->kustomer,
            'qty' => $request->jumlah_retur,
        ]);

        return redirect()->back()->with('success', 'berhasil Retur');
    }
}
