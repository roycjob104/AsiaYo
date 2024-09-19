<?php

namespace Database\Factories\Order;

use App\Models\Order\Currencies\OrderJpyModel;
use App\Models\Order\Currencies\OrderUsdModel;
use App\Models\Order\OrderModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderModel>
 */
class OrderModelFactory extends Factory
{
    protected $model = OrderModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->bothify('A#######'),
            'currency_type' => 'order_usd',
        ];
    }

    public function orderJpyModel($count = 1)
    {
        return $this->has(OrderJpyModel::factory()->count($count), 'orderJpyModels');
    }

    public function orderUsdModel($count = 1)
    {
        return $this->has(OrderUsdModel::factory()->count($count), 'orderUsdModels');
    }

    public function forOrderJpyModel($orderJpyModel): Factory
    {
        return $this->state(fn () => [
            'id' => $orderJpyModel->id,
        ]);
    }

    public function forOrderUsdModel($orderUsdModel): Factory
    {
        return $this->state(fn () => [
            'id' => $orderUsdModel->id,
        ]);
    }

    // 通用方法，根據模型類型自動選擇
    public function forOrdersModel($currencyModel)
    {
        $morphMap = Relation::morphMap();
        $tmp = $this->state(function (array $attributes) use ($currencyModel) {
            return [
                'id' => $currencyModel->id,          // 動態設定ID
            ];
        });

        return $tmp;
    }
}
