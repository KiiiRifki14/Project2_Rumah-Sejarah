<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogKunjungan extends Model
{
    protected $table = 'log_kunjungan';
    public $timestamps = false;

    protected $fillable = [
        'reservasi_id',
        'scanned_by',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];
}
