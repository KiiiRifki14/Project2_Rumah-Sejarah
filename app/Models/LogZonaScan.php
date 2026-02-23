<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogZonaScan extends Model
{
    protected $table = 'log_zona_scan';
    public $timestamps = false;

    protected $fillable = [
        'zona_id',
        'scanned_at',
        'ip_address',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];
}
