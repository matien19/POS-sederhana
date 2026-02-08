<?php

namespace App\Models\Admin;

use App\Models\KTTransaksiModel;
use Illuminate\Database\Eloquent\Model;

class MDSupplierModel extends Model
{
    protected $table = 'md_supplier';
    protected $fillable = [
        'nama',
        'no_telepon',
        'tanggal_daftar',
        'alamat',
    ];
    public function transaksi()
    {
        return $this->hasMany(KTTransaksiModel::class, 'id_supplier');
    }
}
