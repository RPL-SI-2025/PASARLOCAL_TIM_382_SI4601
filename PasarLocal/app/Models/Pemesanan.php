<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanans';
    protected $fillable = [
        'customer_id',
        'ongkir_id',
        'total_harga',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status',
    ];

    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class, 'pemesanan_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
