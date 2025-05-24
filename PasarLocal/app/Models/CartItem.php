<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'produk_pedagang_id',
        'quantity',
        'price',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function produkPedagang(): BelongsTo
    {
        return $this->belongsTo(ProdukPedagang::class, 'produk_pedagang_id', 'id_produk_pedagang');
    }

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }
} 