<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $expense_types = [
      'Fatura',
      'Mutfak, Market',
      'Vergi Ödemeleri',
      'SSK Ödemeleri'
    ];
    foreach ($expense_types as $expense_type) {
      ExpenseType::create([
        'name' => $expense_type
      ]);
    }
  }
}
