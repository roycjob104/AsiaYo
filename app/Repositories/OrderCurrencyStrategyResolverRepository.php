<?php

namespace App\Repositories;

use App\Services\OrderCurrency\OrderCurrencyJpyStrategy;
use App\Services\OrderCurrency\OrderCurrencyMyrStrategy;
use App\Services\OrderCurrency\OrderCurrencyRmbStrategy;
use App\Services\OrderCurrency\OrderCurrencyStrategy;
use App\Services\OrderCurrency\OrderCurrencyTwdStrategy;
use App\Services\OrderCurrency\OrderCurrencyUsdStrategy;
use App\Support\Repositories\BaseRepository;
use InvalidArgumentException;

class OrderCurrencyStrategyResolverRepository extends BaseRepository
{
    protected $strategies;

    public function __construct()
    {
        $this->strategies = [
            'TWD' => new OrderCurrencyTwdStrategy,
            'USD' => new OrderCurrencyUsdStrategy,
            'JPY' => new OrderCurrencyJpyStrategy,
            'RMB' => new OrderCurrencyRmbStrategy,
            'MYR' => new OrderCurrencyMyrStrategy,
        ];
    }

    public function resolve(string $currency): OrderCurrencyStrategy
    {
        if (! isset($this->strategies[$currency])) {
            throw new InvalidArgumentException("Unsupported currency: $currency");
        }

        return $this->strategies[$currency];
    }

    public function getOrderCurrencyRepository(string $currency)
    {
        return $this->resolve($currency)->getOrderCurrencyRepository();
    }
}
