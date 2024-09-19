<?php

namespace Tests\Feature;

use App\Events\OrderCreated;
use App\Models\Order\OrderModel;
use App\Services\Order\OrderService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    const API_POST_PATH = '/api/orders';

    const DEFAULT_CURRENCY = 'TWD';

    protected $orderService;

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = OrderService::new();
    }

    public function test_create_order_success()
    {
        $morphMap = Relation::morphMap();

        foreach ($morphMap as $table => $model) {
            $parts = explode('_', $table);
            $orderCurrencyModel = $model::factory()->make(['currency' => strtoupper($parts[1])]);
            $orderData = OrderModel::factory()
                ->forOrdersModel($orderCurrencyModel)
                ->raw($orderCurrencyModel->toArray());

            unset($orderData['currency_type']);
            unset($orderData['currency_id']);
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
        $morphMap = Relation::morphMap();

        foreach ($morphMap as $table => $model) {
            $parts = explode('_', $table);
            $orderCurrencyModel = $model::factory()->make(['currency' => strtoupper($parts[1])]);
            $orderData = OrderModel::factory()
                ->forOrdersModel($orderCurrencyModel)
                ->raw($orderCurrencyModel->toArray());

            unset($orderData['currency_type']);
            unset($orderData['currency_id']);

            $this->orderService->createOrder($orderData);

            $response = $this->getJson(self::API_POST_PATH.'/'.$orderData['id']);

            $responseData = $response->decodeResponseJson();
            $responseData = Arr::except($responseData['data'], ['created_at', 'updated_at']);

            $response->assertStatus(Response::HTTP_OK);
            $this->assertEquals($responseData, $orderData);
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
        $orderCurrencyModel = \App\Models\Order\Currencies\OrderTwdModel::factory()->create(['currency' => strtoupper('TWD')]);
        $orderData = OrderModel::factory()
            ->forOrdersModel($orderCurrencyModel)
            ->make($orderCurrencyModel->toArray());
        unset($orderData['currency_type']);
        unset($orderData['currency_id']);

        $response = $this->postJson(self::API_POST_PATH, $orderData->toArray());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors('id');
    }
}
