<?php

namespace Database\Seeders;

use App\Models\CashRegister;
use Illuminate\Database\Seeder;

class CashRegisterSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $cashRegisters = [
      [
        'name' => 'Nakit',
        'percentage' => 0
      ],
      [
        'name' => 'Yazar Kasa Ahmet',
        'percentage' => 2.5
      ],
    ];
    foreach ($cashRegisters as $cashRegister) {
      CashRegister::create($cashRegister);
    }
  }
}
