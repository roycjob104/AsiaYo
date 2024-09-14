<?php

namespace App\Services\OrderCurrency;

use App\Repositories\OrderCurrency\OrderUsdRepository;

class OrderCurrencyUsdStrategy implements OrderCurrencyStrategy
{
    public function getOrderCurrencyRepository()
    {
        return OrderUsdRepository::new();
    }
}
