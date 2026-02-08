<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MDMerekModel;
use Illuminate\Http\Request;

class MerekBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_merek = MDMerekModel::all(); //buat ambil semua data
        return view('admin.merek', compact('data_merek'));
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
            'nama_merek'=> 'required|string|max:255',
        ]);
        $merek_sudah_ada = MDMerekModel::where('nama_merek',$request->nama_merek)->first();
        if ($merek_sudah_ada){
            return redirect()->back()->with('warning','merek sudah ada');
        }
        $merek = MDMerekModel::create([
            'nama_merek'=> $request->nama_merek,
        ]);
        if(!$merek){
            return redirect()->back()->with('error','Gagal menambahkan merek');
        }
        return redirect()->back()->with('success','Berhasil menambahkan merek');
    }

    /**
     * Display the specified resource.
     */
    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_merek'=> 'required|string|max:255',
        ]);
        $merek_sudah_ada = MDMerekModel::where('nama_merek',$request->nama_merek)->first();
        if ($merek_sudah_ada){
            return redirect()->back()->with('warning','data sudah ada');
        }
        $merek = MDMerekModel::where('id',$id)->update([
            'nama_merek'=> $request->nama_merek,
        ]);
        if(!$merek){
            return redirect()->back()->with('error','error edit');
        }
        return redirect()->back()->with('success','berhasil edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $merek = MDMerekModel::where('id',$id);
        if($merek){
            $merek->delete();
            return redirect()->back()->with('success', 'berhasil hapus');

        }else{
            return redirect()->back()->with('error', 'error');
        }
    }
}
