<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'profile_image', // Pastikan kolom ini ada di tabel users
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Akses role
    public function isPedagang()
    {
        return $this->role === 'pedagang';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPembeli()
    {
        return $this->role === 'pembeli';
    }

    // Relasi jika pedagang punya produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Method untuk menghapus gambar profil lama
    public function deleteProfileImage()
    {
        if ($this->profile_image && Storage::disk('public')->exists($this->profile_image)) {
            Storage::disk('public')->delete($this->profile_image);
        }
    }
}
