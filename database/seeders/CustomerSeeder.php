<?php

namespace Database\Seeders;

use App\Models\Customer;
use Bezhanov\Faker\Provider\Commerce;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Factory::create('tr_TR');
      $faker->addProvider(new Commerce($faker));
      foreach (range(1, 20) as $item) {
        Customer::create([
          'name' => $faker->firstName,
          'phone' => $faker->phoneNumber,
          'surname' => $faker->lastName,
          'email' => $faker->email,
//          'country' => $faker->country,
//          'county' => $faker->country,
//          'district' => $faker->country,
          'address' => $faker->address,
          'gender' => $faker->boolean,
          'customer_role_id' => 1
        ]);
      }
    }
}
