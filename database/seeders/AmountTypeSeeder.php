<?php

namespace Database\Seeders;

use App\Models\AmountTypes;
use Illuminate\Database\Seeder;

class AmountTypeSeeder extends Seeder
{
  public function run()
  {
    $amountTypes = ['cm', 'mm', 'inç', 'km', 'm2', 'm3', 'g', 'kg', 'ton'];
    if (AmountTypes::all()->isEmpty()) {
      foreach ($amountTypes as $amountType) {
        AmountTypes::create(['name' => $amountType]);
      }
    }
  }
}
