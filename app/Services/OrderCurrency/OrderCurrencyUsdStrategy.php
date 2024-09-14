<?php

namespace App\Services\OrderCurrency;

use App\Models\Order\Currencies\OrderUsdModel;

class OrderCurrencyUsdStrategy implements OrderCurrencyStrategy
{
    public function getOrderCurrencyModel()
    {
        return OrderUsdModel::class;
    }
}
