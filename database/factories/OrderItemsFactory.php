<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Orders;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItems>
 */
class OrderItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomOrder = Orders::get();
        $randomOrder = $randomOrder[0]->id;
        $randomProduct = Product::get();
        $randomProduct = $randomProduct[0]->id;
        return [
            //
            'orders_id' => $randomOrder,
            'product_id' => $randomProduct,
            'quantity' => $this->faker->randomNumber(2),
            'price' => $this->faker->randomFloat(2,12.99,89.99)
        ];
    }
}
