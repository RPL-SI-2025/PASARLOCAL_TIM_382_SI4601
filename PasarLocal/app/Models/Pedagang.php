<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
    use HasFactory;

    protected $table = 'pedagang';
    protected $primaryKey = 'id_pedagang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pedagang',
        'id_pasar',
        'nama_pemilik',
        'email',
        'password',
        'alamat',
        'nama_toko',
        'nomor_telepon'
    ];

    public function pasar()
    {
        return $this->belongsTo(Pasar::class, 'id_pasar', 'id_pasar');
    }

    public function produkPedagang()
    {
        return $this->hasMany(ProdukPedagang::class, 'id_pedagang');
    }
} 
