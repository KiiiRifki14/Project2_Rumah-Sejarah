<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SesiKunjungan extends Model
{
    protected $table = 'sesi_kunjungan';

    protected $fillable = [
        'nama_sesi',
        'jam_mulai',
        'jam_selesai',
        'kuota',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function reservasi(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'sesi_id');
    }

    public function sisaKuota($tanggal): int
    {
        $terpakai = $this->reservasi()
            ->where('tanggal_kunjungan', $tanggal)
            ->whereIn('status', ['valid', 'telah_berkunjung'])
            ->sum('jumlah_anggota');

        return max(0, $this->kuota - $terpakai);
    }
}
