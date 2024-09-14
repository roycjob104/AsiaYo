<?php

namespace App\Models\Order\Currencies;

use App\Enums\CurrencyEnum;
use App\Models\Order\OrderModel;
use App\Support\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class OrderCurrencyBaseModel extends BaseModel
{
    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'address' => 'array',  // 告訴 Laravel 自動轉換為陣列,
        'currency' => CurrencyEnum::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function orders(): MorphMany
    {
        return $this->morphMany(OrderModel::class, 'currency', 'currency_type', 'id');
    }
}
