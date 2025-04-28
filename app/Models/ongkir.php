<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ongkir extends Model
{
    protected $table = 'ongkir'; // Explicitly set the table name

    // app/Models/Ongkir.php
    protected $fillable = [
        'id_pasar',
        'kecamatan_tujuan',
        'ongkir'
    ];

    public function pasar()
    {
        return $this->belongsTo(Pasar::class, 'id_pasar', 'id_pasar');
    }
}
