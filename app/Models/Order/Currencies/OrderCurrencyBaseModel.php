<?php

namespace App\Models\Order\Currencies;

use Illuminate\Database\Eloquent\Model;
use App\Enums\CurrencyEnum;

class OrderCurrencyBaseModel extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'address' => 'array',  // 告訴 Laravel 自動轉換為陣列,
        'currency' => CurrencyEnum::class
    ];
}
