<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
    use HasFactory;

    protected $table = 'pedagang';
    protected $primaryKey = 'id_pedagang';
<<<<<<< HEAD

    protected $fillable = [
        'user_id',
        'nama_toko',
        'nama_pemilik',
        'alamat',
        'nomor_telepon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function produkPedagang()
    {
        return $this->hasMany(ProdukPedagang::class, 'id_pedagang');
=======
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pedagang',
        'id_pasar',
        'nama_pemilik',
        'alamat',
        'nama_toko',
        'nomor_telepon'
    ];

    public function pasar()
    {
        return $this->belongsTo(Pasar::class, 'id_pasar', 'id_pasar');
>>>>>>> dbaa521cb2b340872797bb9a31ee58e00748fb72
    }
} 