<?php

namespace Database\Factories\Order\Currencies;

use App\Enums\CurrencyEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderCurrencyBaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->bothify('A#######'),
            'name' => $this->faker->company,
            'address' => [
                'city' => $this->faker->city,
                'district' => $this->faker->word,
                'street' => $this->faker->streetName,
            ],
            'price' => $this->faker->randomFloat(2, 1000, 5000),
            'currency' => $this->faker->randomElement(CurrencyEnum::values()),
        ];
    }
}
