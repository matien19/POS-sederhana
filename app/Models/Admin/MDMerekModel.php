<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDMerekModel extends Model
{
    use HasFactory;
    protected $table = 'md_merek';
    //buat isi nama kolom apa aja 
    protected $fillable = [
        'nama_merek',
    ];
}