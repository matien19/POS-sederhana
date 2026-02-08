<?php

namespace App\Models;

use App\Models\Admin\MDBarangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KTPenjualanModel extends Model
{
    use HasFactory;
    protected $table = 'kt_penjualan';
    //buat isi nama kolom apa aja 
    protected $fillable = [
        'id_transaksi',
        'tanggal',
        'id_barang',
        'harga_satuan',
        'jumlah_jual',
        'subtotal',
    ];
    public function transaksi()
    {
        return $this->belongsTo(KTTransaksiModel::class, 'id_transaksi');
    }

    public function barang()
    {
        return $this->belongsTo(MDBarangModel::class, 'id_barang'); // md_barang
    }
}
