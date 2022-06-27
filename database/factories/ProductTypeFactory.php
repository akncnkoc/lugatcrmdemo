<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductType>
 */
class ProductTypeFactory extends Factory
{
    public function definition()
    {
        return [
      'name' => $this->faker->colorName,
      'initial_code' => 1
    ];
    }
}
