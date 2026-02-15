<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MDBarangImport;
use App\Models\Admin\MDBarangModel;
use App\Models\Admin\MDKategoriModel;
use App\Models\Admin\MDMerekModel as AdminMDMerekModel;
use App\Models\MDMerekModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Milon\Barcode\DNS1D;
use Mpdf\Mpdf;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_barang = MDBarangModel::with(['kategori', 'merek'])->get();
        $kategori = MDKategoriModel::all();
        $merek = AdminMDMerekModel::all();
        return view('admin.barang.barang', compact('data_barang','kategori','merek'));
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
            'kode_barang'=> 'required|string|max:255',
            'nama_barang'=> 'required|string|max:255',
            'id_kategori'=> 'required|exists:md_kategori,id',
            'merek_id'=> 'required|exists:md_merek,id',
            'stok'=> 'required|integer|min:0',
            'harga_beli'=> 'required|numeric|min:0',
            'harga_jual'=> 'required|numeric|min:0',
            'foto_barang'=> 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);
        $barang_sudah_ada = MDBarangModel::where('kode_barang', $request->kode_barang)->first();
        
        if ($barang_sudah_ada) {
            return redirect()->back()->with('warning','data sudah ada');
        }
        $filename = null;
        if ($request->hasFile('foto_barang')) {
            $file = $request->file('foto_barang');
            $filename = $request->kode_barang .'.'. $file->getClientOriginalExtension();
            $request->foto_barang->move(public_path('storage/img'), $filename);
        }
        $barang = MDBarangModel::create([
            'kode_barang'=> $request->kode_barang,
            'nama_barang'=> $request->nama_barang,
            'id_kategori'=> $request->id_kategori,
            'merek_id'=> $request->merek_id,
            'stok'=> $request->stok,
            'harga_beli'=> $request->harga_beli,
            'harga_jual'=> $request->harga_jual,
            'foto_barang'=> $filename,
        ]);
        if(!$barang){
            return redirect()->back()->with('error','error tambah');
        }
        return redirect()->back()->with('success','berhasil tambah');
    }

    /**
 * Display the specified resource.
 */
    public function show(string $id)
    {
        $barang = MDBarangModel::with('kategori', 'merek')->findOrFail($id);
        $barcodePath = 'barcode/' . $barang->kode_barang . '.png';

        !Storage::disk('public')->exists('barcode') ? Storage::disk('public')->makeDirectory('barcode') : null;

        if (!Storage::disk('public')->exists($barcodePath)) {
            $dns1d = new DNS1D();
            $dns1d->setStorPath(public_path('storage/barcode/'));

            $dns1d->getBarcodePNGPath(
                $barang->kode_barang,
                'C128',
                3,
                100,
                [0, 0, 0]
            );
        }
        
        return view('admin.barang.barang_detail', compact('barang','barcodePath'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_barang'=> 'required|string|max:255',
            'nama_barang'=> 'required|string|max:255',
            'id_kategori'=> 'required|exists:md_kategori,id',
            'merek_id'=> 'required|exists:md_merek,id',
            'stok'=> 'required|integer|min:0',
            'harga_beli'=> 'required|numeric|min:0',
            'harga_jual'=> 'required|numeric|min:0',
            'foto_barang'=> 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);
        $barang_sudah_ada = MDBarangModel::where('nama_barang', $request->nama_barang)->where('id', '!=', $id)->first();
        if ($barang_sudah_ada) {
            return redirect()->back()->with('warning','data sudah ada');
        }
        if ($request->hasFile('foto_barang')) {
            $file = $request->file('foto_barang');
            $filename = $request->kode_barang .'.'. $file->getClientOriginalExtension();
            $request->foto_barang->move(public_path('storage/img'), $filename);
        }
        else {
            $existingBarang = MDBarangModel::find($id);
            $filename = $existingBarang ? $existingBarang->foto_barang : null;
        }
        $barang = MDBarangModel::where('id',$id)->update([
            'kode_barang'=> $request->kode_barang,
            'nama_barang'=> $request->nama_barang,
            'id_kategori'=> $request->id_kategori,
            'merek_id'=> $request->merek_id,
            'stok'=> $request->stok,
            'harga_beli'=> $request->harga_beli,
            'harga_jual'=> $request->harga_jual,
            'foto_barang'=> $filename,
        ]);
        if(!$barang){
            return redirect()->back()->with('error','error edit');
        }
        return redirect()->back()->with('success','berhasil edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = MDBarangModel::where('id',$id);
        if($barang){
        $barang->delete();
        return redirect()->back()->with('success','data berhasil dihapus');

        }else{
            return redirect()->back()->with('error','data error');
        }
    }

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file_barang'=> 'required|file|mimes:xls,xlsx|max:5120',
    //     ]);
    //     Excel::import(new MDBarangImport,$request->file('file_barang'));
    //     return redirect()->back()->with('success','berhasil import');
    // }

    public function barcode($id)
    {
        $barang = MDBarangModel::findOrFail($id);

        $barcodePath = public_path(
        'storage/barcode/'.$barang->kode_barang.'.png'
    );

    // Cek file barcode ada atau tidak
    if (!file_exists($barcodePath)) {
        abort(404, 'Barcode tidak ditemukan');
    }

    // Kirim path ke view
    $html = view('admin.barang.barcode', [
        'barang' => $barang,
        'barcodePath' => $barcodePath
    ])->render();

    // mPDF config
    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4', // bisa diganti label
        'margin_top' => 10,
        'margin_bottom' => 10,
        'margin_left' => 10,
        'margin_right' => 10,
    ]);

    $mpdf->WriteHTML($html);

    // Tampilkan PDF di tab baru
    return response(
        $mpdf->Output(
            'barcode-'.$barang->kode_barang.'.pdf',
            'I'
        ),
        200
    )->header('Content-Type', 'application/pdf');
    }
}
