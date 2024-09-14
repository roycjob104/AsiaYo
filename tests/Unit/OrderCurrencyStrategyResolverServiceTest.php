<?php

namespace Tests\Unit\Services\OrderCurrency;

use PHPUnit\Framework\TestCase;
use App\Services\OrderCurrency\OrderCurrencyStrategyResolverService;
use App\Services\OrderCurrency\OrderCurrencyTwdStrategy;
use App\Services\OrderCurrency\OrderCurrencyUsdStrategy;
use App\Services\OrderCurrency\OrderCurrencyJpyStrategy;
use App\Services\OrderCurrency\OrderCurrencyRmbStrategy;
use App\Services\OrderCurrency\OrderCurrencyMyrStrategy;
use App\Models\Order\Currencies\OrderTwdModel;
use App\Models\Order\Currencies\OrderUsdModel;
use App\Models\Order\Currencies\OrderJpyModel;
use App\Models\Order\Currencies\OrderRmbModel;
use App\Models\Order\Currencies\OrderMyrModel;

class OrderCurrencyStrategyResolverServiceTest extends TestCase
{
    protected $resolverService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolverService = new OrderCurrencyStrategyResolverService();
    }

    public function testResolveValidCurrency()
    {
        // Test TWD currency
        $strategy = $this->resolverService->resolve('TWD');
        $this->assertInstanceOf(OrderCurrencyTwdStrategy::class, $strategy);

        // Test USD currency
        $strategy = $this->resolverService->resolve('USD');
        $this->assertInstanceOf(OrderCurrencyUsdStrategy::class, $strategy);

        // Test JPY currency
        $strategy = $this->resolverService->resolve('JPY');
        $this->assertInstanceOf(OrderCurrencyJpyStrategy::class, $strategy);

        // Test RMB currency
        $strategy = $this->resolverService->resolve('RMB');
        $this->assertInstanceOf(OrderCurrencyRmbStrategy::class, $strategy);

        // Test MYR currency
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
        // Test TWD currency model
        $model = $this->resolverService->getOrderCurrencyModel('TWD');
        $this->assertEquals(OrderTwdModel::class, $model);

        // Test USD currency model
        $model = $this->resolverService->getOrderCurrencyModel('USD');
        $this->assertEquals(OrderUsdModel::class, $model);

        // Test JPY currency model
        $model = $this->resolverService->getOrderCurrencyModel('JPY');
        $this->assertEquals(OrderJpyModel::class, $model);

        // Test RMB currency model
        $model = $this->resolverService->getOrderCurrencyModel('RMB');
        $this->assertEquals(OrderRmbModel::class, $model);

        // Test MYR currency model
        $model = $this->resolverService->getOrderCurrencyModel('MYR');
        $this->assertEquals(OrderMyrModel::class, $model);
    }
}
