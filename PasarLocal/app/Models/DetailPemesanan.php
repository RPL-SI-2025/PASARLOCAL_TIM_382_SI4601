<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    use HasFactory;
    protected $table = 'detail_pemesanans';
    protected $fillable = [
        'pemesanan_id',
        'produk_pedagang_id',
        'jumlah',
        'harga',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function produkPedagang()
    {
        return $this->belongsTo(ProdukPedagang::class, 'produk_pedagang_id', 'id_produk_pedagang');
    }

    public function pasar()
    {
        return $this->produkPedagang
            ? $this->produkPedagang->pedagang->pasar
            : null;
    }
}
