<?php

namespace App\Models;

use App\Models\Admin\MDSupplierModel as AdminMDSupplierModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MDSupplierModel;
use App\Models\User;

class KTTransaksiModel extends Model
{
    use HasFactory;

    protected $table = 'kt_transaksi';

    protected $fillable = [
        'no_transaksi',
        'id_supplier',
        'jenis_transaksi',
        'customer',
        'tanggal',
        'total_qty',
        'diskon',
        'total_bayar',
        'jumlah_bayar',
        'kembalian',
        'metode_bayar',
        'keterangan',
    ];

    public function supplier()
    {
        return $this->belongsTo(AdminMDSupplierModel::class, 'id_supplier');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_users');
    }


    public function detail()
    {
        return $this->hasMany(KTPembelianModel::class, 'id_transaksi');
    }

    public function penjualan()
    {
        return $this->hasMany(KTPenjualanModel::class, 'id_transaksi');
    }

    public function pembayaran()  
    {
        return $this->hasMany(PembayaranTransaksiModel::class, 'id_transaksi');    
    }
}
