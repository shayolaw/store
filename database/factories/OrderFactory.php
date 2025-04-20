<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'status' => 'Created',
            'sub_total' => $this->faker->randomFloat(2,10.99,220.99),
            'total_price' => $this->faker->randomFloat(2,10.99,220.99),
            'user_id' => User::factory(),
            'total_tax' => $this->faker->randomFloat(2,10.99,220.99),
        ];
    }
}
