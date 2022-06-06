<?php

namespace Database\Seeders;

use App\Models\CargoType;
use Illuminate\Database\Seeder;

class CargoTypeSeeder extends Seeder
{
  public function run()
  {
    $cargoTypes = ['Kargoya Verilecek', 'Gönderilmiş', 'Teslim Olanlar', 'Geri Dönenler'];
    if (CargoType::all()->isEmpty()) {
      foreach ($cargoTypes as $cargoType) {
        CargoType::create(['name' => $cargoType]);
      }
    }
  }
}
