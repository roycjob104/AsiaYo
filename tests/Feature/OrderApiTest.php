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

    const DEFAULT_CURRENCY = 'TWD';

    use RefreshDatabase;

    public function test_create_order_success()
    {
        $currencies = [
            'TWD' => 'orders_twd',
            'USD' => 'orders_usd',
            'JPY' => 'orders_jpy',
            'RMB' => 'orders_rmb',
            'MYR' => 'orders_myr',
        ];

        foreach ($currencies as $currency => $table) {
            $orderData = OrderModel::factory()->raw([
                'currency' => $currency,
            ]);

            $response = $this->postJson(self::API_POST_PATH, $orderData);

            $response->assertStatus(Response::HTTP_OK)
                ->assertJson(['message' => 'Order created successfully!']);

            $this->assertDatabaseHas($table, [
                'id' => $orderData['id'],
            ]);
        }
    }

    public function test_create_order_with_invalid_currency_fails()
    {
        Event::fake();

        $orderData = OrderModel::factory()->raw([
            'currency' => 'INVALID',
        ]);

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_find_order_success()
    {
        $currencies = ['TWD', 'USD', 'JPY', 'RMB', 'MYR'];

        foreach ($currencies as $currency) {
            $orderData = OrderModel::factory()->raw([
                'currency' => $currency,
            ]);

            $resolverService = new OrderCurrencyStrategyResolverService;
            $resolverService->getOrderCurrencyModel($currency);
            $orderService = new OrderService($resolverService);
            $orderService->createOrder($orderData);

            $response = $this->getJson(self::API_POST_PATH.'/'.$orderData['id']);

            $response->assertStatus(Response::HTTP_OK)
                ->assertJson([
                    'data' => $orderData,
                ]);
        }
    }

    public function test_find_order_not_found()
    {
        $response = $this->getJson(self::API_POST_PATH.'/NOT_CORRECT');

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'message' => 'Record not found.',
            ]);
    }

    public function test_order_id_must_be_unique()
    {
        $orderData = OrderModel::factory()->raw([
            'currency' => self::DEFAULT_CURRENCY,
        ]);

        $resolverService = new OrderCurrencyStrategyResolverService;
        $resolverService->getOrderCurrencyModel(self::DEFAULT_CURRENCY);
        $orderService = new OrderService($resolverService);
        $existingOrder = OrderModel::factory()->raw([
            'currency' => self::DEFAULT_CURRENCY,
        ]);

        $orderService->createOrder($existingOrder);

        $orderData = OrderModel::factory()->raw(['id' => $existingOrder['id']]);

        $response = $this->postJson(self::API_POST_PATH, $orderData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors('id');
    }
}
