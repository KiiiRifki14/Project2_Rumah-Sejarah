<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Reservasi extends Model
{
    use HasUuids;

    protected $table = 'reservasi';

    protected $fillable = [
        'kode_tiket',
        'nama',
        'nik',
        'whatsapp',
        'email',
        'jumlah_anggota',
        'tanggal_kunjungan',
        'sesi_id',
        'qr_code_path',
        'status',
        'ip_address',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'nik' => 'encrypted',
        'whatsapp' => 'encrypted',
        'status' => \App\Enums\ReservasiStatus::class,
    ];

    public function sesi(): BelongsTo
    {
        return $this->belongsTo(SesiKunjungan::class, 'sesi_id');
    }
}
