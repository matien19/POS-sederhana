<?php

namespace App\Models;

use App\Models\Admin\MDBarangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturModel extends Model
{
    use HasFactory;

    protected $table = 'retur';

    protected $guarded = [];

    public function barang(){
        return $this->belongsTo(MDBarangModel::class, 'id_barang', 'id');
    }
}
