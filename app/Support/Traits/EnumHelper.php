<?php

namespace App\Support\Traits;

use Illuminate\Support\Str;

trait EnumHelper
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
