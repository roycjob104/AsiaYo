<?php

namespace App\Enums;

use App\Support\Traits\EnumHelper;

enum CurrencyEnum: string
{
    use EnumHelper;

    case TWD = 'TWD';
    case USD = 'USD';
    case JPY = 'JPY';
    case RMB = 'RMB';
    case MYR = 'MYR';
}
