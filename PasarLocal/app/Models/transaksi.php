<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pasar',
        'id_produk_pedagang',
        'id_user',
        'quantity',
        'ulasan',
    ];

    public function pasar()
    {
        return $this->belongsTo(Pasar::class, 'id_pasar');
    }

    public function produkPedagang()
    {
        return $this->belongsTo(ProdukPedagang::class, 'id_produk_pedagang');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

