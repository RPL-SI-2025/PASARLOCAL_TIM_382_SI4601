<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
    use HasFactory;

    protected $table = 'pedagang';
    protected $primaryKey = 'id_pedagang';

    protected $fillable = [
        'user_id',
        'nama_toko',
        'nama_pemilik',
        'alamat',
        'nomor_telepon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function produkPedagang()
    {
        return $this->hasMany(ProdukPedagang::class, 'id_pedagang');
    }
} 