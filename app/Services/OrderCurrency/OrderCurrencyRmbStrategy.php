<?php

namespace App\Services\OrderCurrency;

use App\Repositories\OrderCurrency\OrderRmbRepository;

class OrderCurrencyRmbStrategy implements OrderCurrencyStrategy
{
    public function getOrderCurrencyRepository()
    {
        return OrderRmbRepository::new();
    }
}
