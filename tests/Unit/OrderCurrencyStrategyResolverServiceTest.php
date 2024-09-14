<?php

namespace Tests\Unit\Services\OrderCurrency;

use App\Models\Order\Currencies\OrderJpyModel;
use App\Models\Order\Currencies\OrderMyrModel;
use App\Models\Order\Currencies\OrderRmbModel;
use App\Models\Order\Currencies\OrderTwdModel;
use App\Models\Order\Currencies\OrderUsdModel;
use App\Services\OrderCurrency\OrderCurrencyJpyStrategy;
use App\Services\OrderCurrency\OrderCurrencyMyrStrategy;
use App\Services\OrderCurrency\OrderCurrencyRmbStrategy;
use App\Services\OrderCurrency\OrderCurrencyStrategyResolverService;
use App\Services\OrderCurrency\OrderCurrencyTwdStrategy;
use App\Services\OrderCurrency\OrderCurrencyUsdStrategy;
use PHPUnit\Framework\TestCase;

class OrderCurrencyStrategyResolverServiceTest extends TestCase
{
    protected $resolverService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolverService = new OrderCurrencyStrategyResolverService;
    }

    public function testResolveValidCurrency()
    {
        $strategy = $this->resolverService->resolve('TWD');
        $this->assertInstanceOf(OrderCurrencyTwdStrategy::class, $strategy);

        $strategy = $this->resolverService->resolve('USD');
        $this->assertInstanceOf(OrderCurrencyUsdStrategy::class, $strategy);

        $strategy = $this->resolverService->resolve('JPY');
        $this->assertInstanceOf(OrderCurrencyJpyStrategy::class, $strategy);

        $strategy = $this->resolverService->resolve('RMB');
        $this->assertInstanceOf(OrderCurrencyRmbStrategy::class, $strategy);

        $strategy = $this->resolverService->resolve('MYR');
        $this->assertInstanceOf(OrderCurrencyMyrStrategy::class, $strategy);
    }

    public function testResolveInvalidCurrency()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->resolverService->resolve('INVALID');
    }

    public function testGetOrderCurrencyModel()
    {
        $model = $this->resolverService->getOrderCurrencyModel('TWD');
        $this->assertEquals(OrderTwdModel::class, $model);

        $model = $this->resolverService->getOrderCurrencyModel('USD');
        $this->assertEquals(OrderUsdModel::class, $model);

        $model = $this->resolverService->getOrderCurrencyModel('JPY');
        $this->assertEquals(OrderJpyModel::class, $model);

        $model = $this->resolverService->getOrderCurrencyModel('RMB');
        $this->assertEquals(OrderRmbModel::class, $model);

        $model = $this->resolverService->getOrderCurrencyModel('MYR');
        $this->assertEquals(OrderMyrModel::class, $model);
    }
}
