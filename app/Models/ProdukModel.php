<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $fillable = [
        'nama_produk',
        'kategori_id',
        'stok_produk',
        'harga_produk',
        'deskripsi_produk',
        'gambar_produk',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id');
    }
}
