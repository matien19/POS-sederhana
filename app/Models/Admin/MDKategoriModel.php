<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDKategoriModel extends Model
{
    use HasFactory;
    protected $table = 'md_kategori';
    protected $fillable = [ 
        'nama_kategori',
    ];
}
