<?php

namespace Tests\Unit;

use App\Models\Order\OrderModel;
use App\Services\Order\OrderService;
use App\Services\OrderCurrency\OrderCurrencyStrategyResolverService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $orderService;

    protected $resolverService;

    const CURRENCY = 'USD';

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolverService = new OrderCurrencyStrategyResolverService;
        $this->resolverService->getOrderCurrencyModel(self::CURRENCY);
        $this->orderService = new OrderService($this->resolverService);
    }

    public function test_it_create_order_in_correct_table()
    {
        // 使用 raw 來生成原始數據
        $data = OrderModel::factory()->raw([
            'currency' => self::CURRENCY,
        ]);

        // Store the order in the correct table
        $this->orderService->createOrder($data);

        // Check that the order is stored in the correct currency table
        $this->assertDatabaseHas('orders', [
            'id' => $data['id'],
        ]);

        // Check that the order is stored in the correct currency table
        $this->assertDatabaseHas('orders_usd', [
            'id' => $data['id'],
            'name' => $data['name'],
        ]);
    }

    public function test_it_create_order_fail()
    {
        // Expect an InvalidArgumentException when the currency is unsupported
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported currency: non');

        // 使用 raw 來生成原始數據
        $data = OrderModel::factory()->raw([
            'currency' => "non",
        ]);

        // Store the order in the correct table
        $this->orderService->createOrder($data);

        // Check that the order is stored in the correct currency table
        $this->assertDatabaseMissing('orders', [
            'id' => $data['id'],
        ]);

        // Check that the order is stored in the correct currency table
        $this->assertDatabaseMissing('orders_usd', [
            'id' => $data['id'],
            'name' => $data['name'],
        ]);
    }

    public function test_it_find_in_usd_table()
    {
        // Insert a mock order in the orders_usd table
        $data = OrderModel::factory()->raw([
            'currency' => self::CURRENCY,
        ]);

        // Store the order in the correct table
        $this->orderService->createOrder($data);

        // Attempt to find the order by ID
        $order = $this->orderService->find($data['id']);

        // Ensure the correct order was retrieved
        $this->assertNotNull($order);
        $this->assertEquals($data['id'], $order->id);
        $this->assertEquals($data['name'], $order->name);
    }

    public function test_it_throws_exception_when_order_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        // Attempt to find a non-existent order, which should throw an exception
        $this->orderService->find('NON_EXISTENT_ID');
    }
}
