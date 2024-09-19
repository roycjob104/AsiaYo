<?php

namespace Database\Factories\Order\Currencies;

use App\Models\Order\Currencies\OrderTwdModel;

class OrderTwdModelFactory extends OrderCurrencyBaseFactory
{
    protected $model = OrderTwdModel::class;

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
