<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamans';
    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status_peminjaman',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
    
    public function scopeStatus($query, $status)
    {
        return $query->where('status_peminjaman', $status);
    }
    
    public function isTerlambat()
    {
        if ($this->status_peminjaman !== 'Dipinjam') {
            return false;
        }
        
        return now()->greaterThan($this->tanggal_pengembalian);
    }
}