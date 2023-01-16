<?php

namespace App\Enums;


enum OfStatusEnum: string
{
    case New = 'new';
    case InProduction = 'inProd';
    case Posed = 'posed';
    case Closed = 'closed';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}