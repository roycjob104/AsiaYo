<?php

namespace Database\Factories\Order\Currencies;

use App\Models\Order\Currencies\OrderMyrModel;

class OrderMyrModelFactory extends OrderCurrencyBaseFactory
{
    protected $model = OrderMyrModel::class;

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
