<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $pengumuman = Pengumuman::latest()->get();

        return view('admin.pengumuman', compact('pengumuman'));
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
        'judul' => 'required',
        'isi' => 'required',
        'target' => 'required|in:semua,admin,gudang,kasir'
    ]);


    $pengumuman = Pengumuman::create([
        'judul' => $request->judul,
        'isi' => $request->isi,
        'target' => $request->target,
    ]);

    // Tentukan penerima
    if ($request->target == 'semua') {
        $users = User::all();
    } else {
        $users = User::where('posisi', $request->target)->get();
    }

    // Attach ke pivot
    foreach ($users as $user) {
        $pengumuman->users()->attach($user->id);
    }

    return back()->with('success', 'Pengumuman berhasil dikirim');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
