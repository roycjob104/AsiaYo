<?php

namespace App\Services\OrderCurrency;

use App\Models\Order\Currencies\OrderTwdModel;

class OrderCurrencyTwdStrategy implements OrderCurrencyStrategy
{
    public function getOrderCurrencyModel()
    {
        return OrderTwdModel::class;
    }
}
