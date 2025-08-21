<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koleksipribadi extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'buku_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku()
    {
    return $this->belongsTo(Buku::class, 'buku_id');
    }
}
