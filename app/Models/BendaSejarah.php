<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class BendaSejarah extends Model
{
    use LogsActivity;

    protected $table = 'benda_sejarah';

    protected $fillable = [
        'zona_id',
        'nama_benda',
        'deskripsi',
        'foto',
        'audio',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class, 'zona_id');
    }
}
