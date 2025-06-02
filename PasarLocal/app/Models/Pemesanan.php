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

    public function getStatusPembayaranAttribute()
    {
      switch ($this->status) {
        case 'belum proses':
            return 'Belum Di-ACC';
        case 'diproses':
        case 'dikirim':
        case 'selesai':
            return 'Lunas';
        case 'batal':
            return 'Ditolak';
        default:
            return 'Tidak Diketahui';
    }
    }
    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class, 'pemesanan_id');
    }
        public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function ongkir()
    {
    return $this->belongsTo(Ongkir::class);
    }

}