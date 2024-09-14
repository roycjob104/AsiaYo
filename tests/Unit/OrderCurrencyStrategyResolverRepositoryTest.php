<?php

namespace Tests\Unit\Services\OrderCurrency;

use App\Repositories\OrderCurrency\OrderJpyRepository;
use App\Repositories\OrderCurrency\OrderMyrRepository;
use App\Repositories\OrderCurrency\OrderRmbRepository;
use App\Repositories\OrderCurrency\OrderTwdRepository;
use App\Repositories\OrderCurrency\OrderUsdRepository;
use App\Repositories\OrderCurrencyStrategyResolverRepository;
use App\Services\OrderCurrency\OrderCurrencyJpyStrategy;
use App\Services\OrderCurrency\OrderCurrencyMyrStrategy;
use App\Services\OrderCurrency\OrderCurrencyRmbStrategy;
use App\Services\OrderCurrency\OrderCurrencyTwdStrategy;
use App\Services\OrderCurrency\OrderCurrencyUsdStrategy;
use PHPUnit\Framework\TestCase;

class OrderCurrencyStrategyResolverRepositoryTest extends TestCase
{
    protected $resolverService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolverService = OrderCurrencyStrategyResolverRepository::new();
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

    public function testGetOrderCurrencyRepository()
    {
        $Repository = $this->resolverService->getOrderCurrencyRepository('TWD');
        $this->assertEquals(OrderTwdRepository::class, get_class($Repository));

        $Repository = $this->resolverService->getOrderCurrencyRepository('USD');
        $this->assertEquals(OrderUsdRepository::class, get_class($Repository));

        $Repository = $this->resolverService->getOrderCurrencyRepository('JPY');
        $this->assertEquals(OrderJpyRepository::class, get_class($Repository));

        $Repository = $this->resolverService->getOrderCurrencyRepository('RMB');
        $this->assertEquals(OrderRmbRepository::class, get_class($Repository));

        $Repository = $this->resolverService->getOrderCurrencyRepository('MYR');
        $this->assertEquals(OrderMyrRepository::class, get_class($Repository));
    }
}
