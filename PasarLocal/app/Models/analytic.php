<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class analytic extends Model
{
    protected $table = 'analytic';
    protected $fillable = [
        'nama_analitik',
        'chart_type',
        'table_name',
        'x_column',
        'y_column',
        'aggregation',
    ];
}
