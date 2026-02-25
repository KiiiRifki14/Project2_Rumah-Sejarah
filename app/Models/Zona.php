<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class Zona extends Model
{
    use LogsActivity;

    protected $table = 'zona';

    protected $fillable = [
        'nama_zona',
        'deskripsi',
        'foto',
        'qr_code_path',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function bendaSejarah(): HasMany
    {
        return $this->hasMany(BendaSejarah::class, 'zona_id')->orderBy('urutan');
    }

    public function logScan(): HasMany
    {
        return $this->hasMany(LogZonaScan::class, 'zona_id');
    }
}
