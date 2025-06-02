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
        'id_pasar', // tambahkan agar mass-assignment id_pasar bisa
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function produkPedagang()
    {
        return $this->belongsTo(ProdukPedagang::class, 'produk_pedagang_id', 'id_produk_pedagang');
    }
}
