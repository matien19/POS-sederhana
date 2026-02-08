<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MDSupplierModel;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = MDSupplierModel::all();
        return view('admin.supplier', compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required|string|max:255',
            'no_telepon'=>'required|string|max:20',
            'tanggal_daftar'=>'required|date',
            'alamat'=>'nullable|string',
        ]);
        $supplier_sudah_Ada = MDSupplierModel::where('nama', $request->nama)->first();
        if ($supplier_sudah_Ada) {
            return redirect()->back()->with('warning', 'Data Supplier Sudah Ada!');
        }

        $supplier = MDSupplierModel::create([
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'tanggal_daftar' => $request->tanggal_daftar,
            'alamat' => $request->alamat,
        ]);
        if (!$supplier) {
            return redirect()->back()->with('error', 'Gagal Menambah Supplier!');
        }
        return redirect()->back()->with('success', 'Berhasil Menambah Supplier');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = MDSupplierModel::where('id', $id)->update([
        'no_telepon'     => $request->no_telepon,
        'tanggal_daftar' => $request->tanggal_daftar,
        'alamat'         => $request->alamat,
        ]);

        if (!$supplier) {
            return redirect()->back()->with('error', 'Gagal mengubah data');
        }

        return redirect()->back()->with('success', 'Berhasil Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $supplier = MDSupplierModel::where('id',$id);
        if ($supplier) {
            $supplier->delete();
            return redirect()->back()->with('success', 'Berhasil hapus');

        }else {
            return redirect()->back()->with('error', 'error');
        }
    }
}
