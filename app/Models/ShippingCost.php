<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCost extends Model
{
    protected $fillable = [
        'destination',
        'distance_km',
        'cost_per_km',
    ];
}

