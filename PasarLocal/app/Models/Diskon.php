<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diskon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diskons';
    protected $primaryKey = 'id_diskon';

    protected $fillable = [
        'kode_diskon',
        'nama_diskon',
        'deskripsi',
        'jenis_diskon',
        'max_diskon',
        'min_pembelian',
        'aktif',
        'tanggal_mulai',
        'tanggal_berakhir'
    ];

    protected $casts = [
        'max_diskon' => 'decimal:2',
        'min_pembelian' => 'decimal:2',
        'aktif' => 'boolean',
        'tanggal_mulai' => 'datetime',
        'tanggal_berakhir' => 'datetime'
    ];

    /**
     * Check if the discount is currently valid
     */
    public function isValid()
    {
        $now = now();
        return $this->aktif && 
               $now->between($this->tanggal_mulai, $this->tanggal_berakhir);
    }

    /**
     * Determine if the discount is expired.
     *
     * @return bool
     */
    public function getIsExpiredAttribute()
    {
        return $this->tanggal_berakhir->isPast();
    }

    /**
     * Get the realtime status of the discount based on dates.
     *
     * @return string
     */
    public function getRealtimeStatusAttribute()
    {
        $now = \Carbon\Carbon::now();

        if ($now->lt($this->tanggal_mulai)) {
            return 'Belum Aktif';
        } elseif ($now->gt($this->tanggal_berakhir)) {
            return 'Kadaluarsa';
        } else {
            return 'Aktif';
        }
    }
} 