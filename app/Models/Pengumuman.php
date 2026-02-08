<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'target',
    ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'pengumuman_user'
        )->withPivot('is_read')
         ->withTimestamps();
    }
}
