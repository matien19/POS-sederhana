<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ManajemenUserController extends Controller
{
    /**
     * -----------------------------
     * HALAMAN LIST
     * -----------------------------
     */
    public function admin()
    {
        $users = User::where('posisi', 'admin')->get();
        return view('admin.user.admin', compact('users'));
    }

    public function gudang()
    {
        $users = User::where('posisi', 'gudang')->get();
        return view('admin.user.gudang', compact('users'));
    }

    public function kasir()
    {
        $users = User::where('posisi', 'kasir')->get();
        return view('admin.user.kasir', compact('users'));
    }

    /**
     * -----------------------------
     * VALIDASI UMUM
     * -----------------------------
     */
    private function validateUser($request, $id = null)
    {
        return $request->validate([
            'name'       => 'required|string|min:3',
            'email'      => 'required|email|unique:users,email,' . $id,
            'no_telepon' => 'required|regex:/^[0-9]{10,15}$/',
        ],[
            'name.required'      => 'Nama wajib diisi.',
            'name.min'           => 'Nama minimal 3 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan oleh user lain.',
            'no_telepon.required'=> 'Nomor telepon wajib diisi.',
            'no_telepon.regex'   => 'Nomor telepon harus berupa angka 10 - 15 digit.',
        ]);
    }

    /**
     * -----------------------------
     * STORE ADMIN / GUDANG / KASIR
     * -----------------------------
     */
    public function storeAdmin(Request $request)
    {
        $this->validateUser($request);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
            'posisi'     => 'admin',
            'password'   => bcrypt('admin'),
        ]);

        return back()->with('success', 'User admin berhasil ditambahkan');
    }

    public function storeGudang(Request $request)
    {
        $this->validateUser($request);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
            'posisi'     => 'gudang',
            'password'   => bcrypt('gudang'),
        ]);

        return back()->with('success', 'User gudang berhasil ditambahkan');
    }

    public function storeKasir(Request $request)
    {
        $this->validateUser($request);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
            'posisi'     => 'kasir',
            'password'   => bcrypt('kasir'),
        ]);

        return back()->with('success', 'User kasir berhasil ditambahkan');
    }

    /**
     * -----------------------------
     * UPDATE ADMIN / GUDANG / KASIR
     * -----------------------------
     */
    public function update(Request $request, string $id)
    {
        $this->validateUser($request, $id);

        $user = User::findOrFail($id);
        $user->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        return back()->with('success', 'Data user berhasil diupdate');
    }

    /**
     * -----------------------------
     * HAPUS
     * -----------------------------
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}
