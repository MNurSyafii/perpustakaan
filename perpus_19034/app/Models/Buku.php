<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $fillable = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'cover'];

    public function ulasanbukus()
    {
        return $this->hasMany(Ulasanbuku::class);
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function koleksipribadis()
    {
        return $this->hasMany(Koleksipribadi::class);
    }

    public function kategoribukus()
    {
        return $this->belongsToMany(Kategoribuku::class, 'kategoribuku_relasis', 'buku_id', 'kategori_id');
    }
}