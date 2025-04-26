<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{


    public function definition(): array
    {
        return [
                "user_id" => null,
                'name' => $this->faker->word(),
                'description' => $this->faker->sentence(),
                'price' => $this->faker->randomFloat(2, 1, 100),
                'quantity' => $this->faker->randomNumber(2),
                'created_at' => $this->faker->dateTime(),
                'updated_at' => $this->faker->dateTime(),
        ];
    }
}
