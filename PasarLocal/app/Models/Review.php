<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pemesanan_id',
        'produk_pedagang_id',
        'rating',
        'feedback'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id', 'id');
    }

    public function produkPedagang()
    {
        return $this->belongsTo(ProdukPedagang::class, 'produk_pedagang_id', 'id_produk_pedagang');
    }

    public function detailPemesanan()
    {
        return $this->hasOne(DetailPemesanan::class, 'pemesanan_id', 'pemesanan_id')
                    ->where('produk_pedagang_id', $this->produk_pedagang_id);
    }
}
