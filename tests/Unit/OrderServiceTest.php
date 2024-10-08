<?php

namespace Tests\Unit;

use App\Models\Order\OrderModel;
use App\Services\Order\OrderService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $orderService;

    const CURRENCY = 'USD';

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = OrderService::new();
    }

    public function test_it_create_order_in_correct_table()
    {
        $data = OrderModel::factory()->raw([
            'currency' => self::CURRENCY,
        ]);

        $this->orderService->createOrder($data);

        $this->assertDatabaseHas('orders', [
            'id' => $data['id'],
        ]);

        $this->assertDatabaseHas('orders_usd', [
            'id' => $data['id'],
            'name' => $data['name'],
        ]);
    }

    public function test_it_create_order_fail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported currency: non');

        $data = OrderModel::factory()->raw([
            'currency' => 'non',
        ]);

        $this->orderService->createOrder($data);

        $this->assertDatabaseMissing('orders', [
            'id' => $data['id'],
        ]);

        $this->assertDatabaseMissing('orders_usd', [
            'id' => $data['id'],
            'name' => $data['name'],
        ]);
    }

    public function test_it_find_in_usd_table()
    {
        $data = OrderModel::factory()->raw([
            'currency' => self::CURRENCY,
        ]);

        $this->orderService->createOrder($data);

        $order = $this->orderService->find($data['id']);

        $this->assertNotNull($order);
        $this->assertEquals($data['id'], $order->id);
        $this->assertEquals($data['name'], $order->name);
    }

    public function test_it_throws_exception_when_order_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->orderService->find('NON_EXISTENT_ID');
    }
}
