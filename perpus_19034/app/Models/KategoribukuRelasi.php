<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoribukuRelasi extends Model
{
    use HasFactory;
    
    protected $table = 'kategoribuku_relasis';
    
    public $incrementing = true;
    
    protected $fillable = [
        'buku_id',
        'kategori_id',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategoribuku::class, 'kategori_id');
    }
}