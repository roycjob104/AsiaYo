<?php

namespace Database\Factories\Order\Currencies;

use App\Models\Order\Currencies\OrderJpyModel;

class OrderJpyModelFactory extends OrderCurrencyBaseFactory
{
    protected $model = OrderJpyModel::class;

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
