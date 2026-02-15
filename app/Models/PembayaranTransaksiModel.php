<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranTransaksiModel extends Model
{
    use HasFactory;
    
    protected $table = 'pembayaran_transaksi';

    protected $guarded = [];
 
}
