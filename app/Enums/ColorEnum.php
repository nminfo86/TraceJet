<?php

namespace App\Enums;


enum ColorEnum: string
{
    case Green = 'success';
    case Yellow = 'warning';
    case Red = 'danger';
    case Blue = 'info';
    case Primary = 'primary';
    // case Closed = 'closed';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
