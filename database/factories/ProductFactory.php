<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'price' => $this->faker->randomNumber(2),
            // 'category_id' => $this->faker->randomNumber(2),
            'in_stock' => $this->faker->randomNumber(2),

        ];
    }
}
