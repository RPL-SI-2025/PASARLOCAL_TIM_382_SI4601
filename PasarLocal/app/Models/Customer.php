<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_customer',
        'email',
        'password',
        'alamat',
        'nomor_telepon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class, 'customer_id', 'id');
    }
}
