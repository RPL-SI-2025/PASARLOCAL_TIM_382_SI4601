<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Pemesanan
{
    // Untuk kompatibilitas jika ada pemanggilan App\Models\Order,
    // gunakan model Pemesanan (tabel: pemesanans)
    public function items()
    {
        return $this->hasMany(DetailPemesanan::class, 'pemesanan_id');
    }
}