<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasar extends Model
{
    use HasFactory;

    protected $table = 'pasar';
    protected $primaryKey = 'id_pasar';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pasar',
        'nama_pasar',
        'lokasi',
        'deskripsi',
        'gambar',
        'latitude',
        'longitude'
    ];

    public function ongkir()
{
    return $this->hasMany(ongkir::class, 'id_pasar');
}
}
