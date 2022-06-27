<?php

namespace Database\Factories;

use App\Models\ExpenseType;
use App\Models\Safe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    public function definition()
    {
        return [
      'safe_id' => Safe::factory(),
      'price' => $this->faker->numberBetween(10, 50),
      'date' => $this->faker->dateTimeBetween("-1 years"),
      'expense_type_id' => ExpenseType::factory()
    ];
    }
}
