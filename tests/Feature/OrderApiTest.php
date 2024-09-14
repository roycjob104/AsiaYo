<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Order\OrderModel;
use App\Services\Order\OrderService;
use App\Services\OrderCurrency\OrderCurrencyStrategyResolverService;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_success()
    {
        // 使用 raw 來生成原始數據
        $orderData = OrderModel::factory()->raw([
            'currency' => 'USD'
        ]);

        // 發送 POST 請求
        $response = $this->postJson('/api/orders', $orderData);

        // 驗證回應狀態和 JSON 結果
        $response->assertStatus(200)
            ->assertJson(['message' => 'Order created successfully!']);

        // 驗證數據是否插入到正確的資料表
        $this->assertDatabaseHas('orders_usd', [
            'id' => $orderData['id'],
        ]);
    }

    public function test_create_order_with_invalid_currency_fails()
    {
        $orderData = OrderModel::factory()->raw([
            'currency' => 'INVALID'
        ]);

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(400);
    }

    public function test_find_order_success()
    {
        $orderData = OrderModel::factory()->raw([
            'currency' => 'USD'
        ]);
        $resolverService = new OrderCurrencyStrategyResolverService();
        $resolverService->getOrderCurrencyModel('USD');
        // $orderCurrencyStrategyResolverService = new OrderCurrencyStrategyResolverService();
        $orderService = new OrderService($resolverService);
        // // 創建訂單
        $orderService->createOrder($orderData);

        // 發送 GET 請求
        $response = $this->getJson('/api/orders/' . $orderData['id']);

        // 驗證回應狀態和 JSON 結果
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $orderData['id'],
        ]);
    }
}
