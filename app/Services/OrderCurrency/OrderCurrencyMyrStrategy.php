<?php

namespace App\Services\OrderCurrency;

use App\Repositories\OrderCurrency\OrderMyrRepository;

class OrderCurrencyMyrStrategy implements OrderCurrencyStrategy
{
    public function getOrderCurrencyRepository()
    {
        return OrderMyrRepository::new();
    }
}
