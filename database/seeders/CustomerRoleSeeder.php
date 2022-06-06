<?php

namespace Database\Seeders;

use App\Models\CustomerRole;
use Illuminate\Database\Seeder;

class CustomerRoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    if (CustomerRole::all()->isEmpty()){
      CustomerRole::create([
        'name' => 'Genel Müşteri'
      ]);
    }
  }
}
