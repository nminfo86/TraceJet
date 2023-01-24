<?php

namespace App\Enums;

enum BoxStatusEnum: string
{
    case Open = 'open';
    case Closed = 'closed';
    case Filled = 'filled';
}