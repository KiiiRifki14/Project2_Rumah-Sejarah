<?php

namespace App\Enums;

enum ReservasiStatus: string
{
    case VALID = 'valid';
    case DIBATALKAN = 'dibatalkan';
    case TELAH_BERKUNJUNG = 'telah_berkunjung';
}
