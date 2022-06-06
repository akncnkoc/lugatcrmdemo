<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Safe;
use Illuminate\Database\Seeder;

class SafeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    foreach (Currency::all() as $currencyType) {
      if ($currencyType->id == 13 || $currencyType->id == 4 || $currencyType->id == 1)
        Safe::create([
          'currency_id' => $currencyType->id,
          'name' => $currencyType->name,
          'total' => 0,
        ]);
    }
  }
}
