<?php

namespace App\Http\Controllers;
use App\Models\ProdukModel;
use App\Models\KategoriModel;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $data = ProdukModel::all();
        $kategori = KategoriModel::all();
        return view('produk.index', compact('data', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'stok_produk' => 'required|integer',
            'harga_produk' => 'required|numeric',
            'deskripsi_produk' => 'nullable|string',
            'gambar_produk' => 'nullable|image|max:2048',
        ]);

        $produk = new ProdukModel();
        $produk->nama_produk = $request->nama_produk;
        $produk->kategori_id = $request->kategori_id;
        $produk->stok_produk = $request->stok_produk;
        $produk->harga_produk = $request->harga_produk;
        $produk->deskripsi_produk = $request->deskripsi_produk;

        if ($request->hasFile('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/produk');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $file->move($path, $filename);
            $produk->gambar_produk = $filename;
        }

        $produk->save();

        return response()->json(['status' => 'success', 'message' => 'Produk berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'stok_produk' => 'required|integer',
            'harga_produk' => 'required|numeric',
            'deskripsi_produk' => 'nullable|string',
            'gambar_produk' => 'nullable|image|max:2048',
        ]);

        $produk = ProdukModel::findOrFail($id);
        $produk->nama_produk = $request->nama_produk;
        $produk->kategori_id = $request->kategori_id;
        $produk->stok_produk = $request->stok_produk;
        $produk->harga_produk = $request->harga_produk;
        $produk->deskripsi_produk = $request->deskripsi_produk;

        if ($request->hasFile('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/produk');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $file->move($path, $filename);
            $produk->gambar_produk = $filename;
        }

        $produk->save();

        return response()->json(['status' => 'success', 'message' => 'Produk berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $produk = ProdukModel::findOrFail($id);
        $produk->delete();

        return response()->json(['status' => 'success', 'message' => 'Produk berhasil dihapus']);
    }
}
