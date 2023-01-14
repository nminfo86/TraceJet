<?php

namespace App\Enums;


enum OfStatusEnum: string
{
    case New = 'new';
    case InProduction = 'inProd';
    case Posed = 'posed';
    case Closed = 'closed';
}