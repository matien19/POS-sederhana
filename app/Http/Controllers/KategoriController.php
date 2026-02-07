<?php

namespace App\Http\Controllers;
use App\Models\KategoriModel;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $data = KategoriModel::all();
        return view('kategori.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = new KategoriModel();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json(['status' => 'success', 'message' => 'Kategori berhasil ditambahkan']);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = KategoriModel::findOrFail($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json(['status' => 'success', 'message' => 'Kategori berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->delete();

        return response()->json(['status' => 'success', 'message' => 'Kategori berhasil dihapus']);
    }
}
