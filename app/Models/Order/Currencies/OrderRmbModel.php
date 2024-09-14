<?php

namespace App\Models\Order\Currencies;

use App\Models\Order\OrderModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class OrderRmbModel extends OrderCurrencyBaseModel
{
    protected $table = 'orders_rmb';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function orders(): MorphMany
    {
        return $this->morphMany(OrderModel::class, 'currency', 'currency_type', 'id');
    }
}
