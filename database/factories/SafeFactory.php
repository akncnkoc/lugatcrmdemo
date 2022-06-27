<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Safe>
 */
class SafeFactory extends Factory
{
    public function definition()
    {
        return [
      'name' => $this->faker->name,
      'total' => 0,
      'currency_id' => Currency::factory()
    ];
    }
}
