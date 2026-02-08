<?php

namespace App\Models\Admin;

use App\Models\Admin\MDMerekModel as AdminMDMerekModel;
use App\Models\KTPembelianModel;
use App\Models\KTPenjualanModel;
use App\Models\MDMerekModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDBarangModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'md_barang';

    // Primary key
    protected $primaryKey = 'id';

    // Jika tabel tidak pakai created_at & updated_at
    public $timestamps = true;

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'id_kategori',
        'merek_id',
        'stok',
        'harga_beli',
        'harga_jual',
        'foto_barang',
    ];

    /**
     * Relasi ke tabel kategori dan merek
     * md_barang.id_kategori -> md_kategori.id
     * md_barang.merek_id -> md_merek.id
     */
    public function kategori()
    {
        return $this->belongsTo(MDKategoriModel::class, 'id_kategori', 'id');
    }
    public function merek()
    {
        return $this->belongsTo(AdminMDMerekModel::class, 'merek_id', 'id');
    }
    public function pembelian()
    {
        return $this->hasMany(KTPembelianModel::class, 'id_barang');
    }
    public function penjualan()
    {
        return $this->hasMany(KTPenjualanModel::class, 'id_barang');
    }
}
