<?php

namespace Database\Factories\Order\Currencies;

use App\Models\Order\Currencies\OrderRmbModel;

class OrderRmbModelFactory extends OrderCurrencyBaseFactory
{
    protected $model = OrderRmbModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return parent::definition();
    }
}
