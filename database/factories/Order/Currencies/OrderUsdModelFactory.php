<?php

namespace Database\Factories\Order\Currencies;

use App\Models\Order\Currencies\OrderUsdModel;

class OrderUsdModelFactory extends OrderCurrencyBaseFactory
{
    protected $model = OrderUsdModel::class;

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
