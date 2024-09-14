<?php

namespace App\Services\OrderCurrency;

use InvalidArgumentException;

class OrderCurrencyStrategyResolverService
{
    protected $strategies;

    public function __construct()
    {
        $this->strategies = [
            'TWD' => new OrderCurrencyTwdStrategy(),
            'USD' => new OrderCurrencyUsdStrategy(),
            'JPY' => new OrderCurrencyJpyStrategy(),
            'RMB' => new OrderCurrencyRmbStrategy(),
            'MYR' => new OrderCurrencyMyrStrategy(),
        ];
    }

    public function resolve(string $currency): OrderCurrencyStrategy
    {
        if (!isset($this->strategies[$currency])) {
            throw new InvalidArgumentException("Unsupported currency: $currency");
        }

        return $this->strategies[$currency];
    }

    public function getOrderCurrencyModel(string $currency)
    {
        return $this->resolve($currency)->getOrderCurrencyModel();
    }
}
