<?php

namespace App\Services\OrderCurrency;

use App\Models\Order\Currencies\OrderJpyModel;

class OrderCurrencyJpyStrategy implements OrderCurrencyStrategy
{
    public function getOrderCurrencyModel()
    {
        return OrderJpyModel::class;
    }
}
