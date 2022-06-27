<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    public function definition()
    {
        return [
      'name' => $this->faker->name,
      'banknote_buy' => 1,
      'banknote_sell' => 1,
      'forex_buy' => 1,
      'forex_sell' => 1,
      'code' => 'Test',
      'primary' => false,
      'unit' => 1,
    ];
    }
}
