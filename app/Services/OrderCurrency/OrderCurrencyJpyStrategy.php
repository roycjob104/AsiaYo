<?php

namespace App\Services\OrderCurrency;

use App\Repositories\OrderCurrency\OrderJpyRepository;

class OrderCurrencyJpyStrategy implements OrderCurrencyStrategy
{
    public function getOrderCurrencyRepository()
    {
        return OrderJpyRepository::new();
    }
}
