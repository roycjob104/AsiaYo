<?php

namespace App\Services\OrderCurrency;

use App\Repositories\OrderCurrency\OrderTwdRepository;

class OrderCurrencyTwdStrategy implements OrderCurrencyStrategy
{
    public function getOrderCurrencyRepository()
    {
        return OrderTwdRepository::new();
    }
}
