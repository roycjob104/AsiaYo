<?php

namespace App\Services\OrderCurrency;

use App\Models\Order\Currencies\OrderMyrModel;

class OrderCurrencyMyrStrategy implements OrderCurrencyStrategy
{
    public function getOrderCurrencyModel()
    {
        return OrderMyrModel::class;
    }
}
