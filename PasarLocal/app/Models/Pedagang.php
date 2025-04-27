<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
    use HasFactory;

    protected $table = 'pedagang';
    protected $primaryKey = 'id_pedagang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pedagang',
        'id_pasar',
        'nama_pedagang',
        'lokasi_toko',
        'deskripsi',
        'gambar'
    ];

    public function pasar()
    {
        return $this->belongsTo(Pasar::class, 'id_pasar', 'id_pasar');
    }
} 