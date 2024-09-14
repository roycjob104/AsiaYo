<?php

namespace App\Services\OrderCurrency;

use App\Models\Order\Currencies\OrderRmbModel;

class OrderCurrencyRmbStrategy implements OrderCurrencyStrategy
{
    public function getOrderCurrencyModel()
    {
        return OrderRmbModel::class;
    }
}
