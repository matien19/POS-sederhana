<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MDKategoriModel;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_kategori = MDKategoriModel::all();
        return view('admin.kategori', compact('data_kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori'=> 'required|string|max:255',
        ]);
        $kategori_sudah_ada = MDKategoriModel::where('nama_kategori', $request->nama_kategori)->first();
        if($kategori_sudah_ada){
            return redirect()->back()->with('warning', 'data sudah ada');
        }
        $kategori = MDKategoriModel::create([
            'nama_kategori'=> $request->nama_kategori,
        ]);
        if(!$kategori){
            return redirect()->back()->with('error', 'error tambah');
        }
        return redirect()->back()->with('success', 'berhasil ditambahkan');
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori'=> 'required|string|max:255',
        ]);
        $kategori_sudah_ada = MDKategoriModel::where('nama_kategori', $request->nama_kategori)->first();
        if($kategori_sudah_ada){
            return redirect()->back()->with('warning', 'data sudah ada');
        }
        $kategori = MDKategoriModel::where('id', $id)-> update([
            'nama_kategori'=> $request->nama_kategori,
        ]);
        if(!$kategori){
            return redirect()->back()->with('error', 'error edit');
        }
        return redirect()->back()->with('success', 'berhasil edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = MDKategoriModel::where('id', $id);
        if($kategori){
            $kategori->delete();
            return redirect()->back()->with('success', 'berhasil hapus');
        }else{
            return redirect()->back()->with('error', 'error hapus');
        }
    }
}
