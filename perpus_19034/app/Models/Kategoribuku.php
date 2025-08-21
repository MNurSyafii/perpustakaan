<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoribuku extends Model
{
    use HasFactory;
    protected $fillable=[
        'nama_kategori',
    ];

    public function bukus()
    {
        return $this->belongsToMany(Buku::class,'kategoribuku_relasis', 'kategori_id', 'buku_id');
    }
}
