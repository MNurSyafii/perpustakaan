<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nama_lengkap',
        'alamat',
        'role', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Mendapatkan semua catatan peminjaman yang terkait dengan user ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Mendapatkan semua catatan ulasan buku yang terkait dengan user ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ulasanBukus(): HasMany
    {
        return $this->hasMany(UlasanBuku::class);
    }
}
