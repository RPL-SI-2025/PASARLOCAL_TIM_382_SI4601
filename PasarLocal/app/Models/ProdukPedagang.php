<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukPedagang extends Model
{
    use HasFactory;

    protected $table = 'produk_pedagang';
    protected $primaryKey = 'id_produk_pedagang';
    public $timestamps = true;

    protected $fillable = [
        'id_pedagang',
        'id_produk',
        'stok',
        'jumlah_satuan',
        'satuan',
        'harga',
        'foto_produk'
    ];

    public function pedagang()
    {
        return $this->belongsTo(Pedagang::class, 'id_pedagang', 'id_pedagang');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }
}
