<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Safe;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = Factory::create('tr_TR');
    foreach (range(1,10) as $expense){
      Expense::create([
        'price' => $faker->numberBetween(200,500),
        'safe_id' => Safe::inRandomOrder()->first()->id,
        'date' => $faker->dateTimeBetween("-1 years", "+1 years"),
        'expense_type_id' => ExpenseType::inRandomOrder()->first()->id,
        'comment' => $faker->sentence,
      ]);
    }
  }
}
