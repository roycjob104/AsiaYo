<?php

namespace Tests\Feature;

use App\Events\OrderCreated;
use App\Models\Order\OrderModel;
use App\Services\Order\OrderService;
use App\Services\OrderCurrency\OrderCurrencyStrategyResolverService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    const API_POST_PATH = '/api/orders';

    use RefreshDatabase;

    public function test_create_order_success()
    {
        $orderData = OrderModel::factory()->raw([
            'currency' => 'USD',
        ]);

        $response = $this->postJson(self::API_POST_PATH, $orderData);

        // 驗證回應狀態和 JSON 結果
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Order created successfully!']);

        // 驗證數據是否插入到正確的資料表
        $this->assertDatabaseHas('orders_usd', [
            'id' => $orderData['id'],
        ]);
    }

    public function test_create_order_with_invalid_currency_fails()
    {

        // 偵測事件
        Event::fake();

        $orderData = OrderModel::factory()->raw([
            'currency' => 'INVALID',
        ]);

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        // 驗證沒有觸發事件
        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_find_order_success()
    {
        $orderData = OrderModel::factory()->raw([
            'currency' => 'USD',
        ]);

        $resolverService = new OrderCurrencyStrategyResolverService;
        $resolverService->getOrderCurrencyModel('USD');
        $orderService = new OrderService($resolverService);

        $orderService->createOrder($orderData);

        $response = $this->getJson(self::API_POST_PATH . '/' . $orderData['id']);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'id' => $orderData['id'],
            ]);
    }

    public function test_find_order_not_found()
    {
        // Try to get a non-existing order ID through the API
        $response = $this->getJson(self::API_POST_PATH . '/NOT_CORRECT');

        // Assert that the response is 404 Not Found
        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson(['message' => 'Record not found.']);
    }
}
