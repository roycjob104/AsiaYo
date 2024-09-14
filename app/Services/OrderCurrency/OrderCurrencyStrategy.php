<?php

namespace App\Services\OrderCurrency;

interface OrderCurrencyStrategy
{
    public function getOrderCurrencyModel();
}