<?php

namespace Database\Seeders;

use App\Models\Safe;
use App\Models\Staff;
use Bezhanov\Faker\Provider\Commerce;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
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
        foreach (range(1, 10) as $item) {
            Staff::create([
          'name' => $faker->firstName,
          'surname' => $faker->lastName,
          'email' => $faker->email,
          'phone' => $faker->phoneNumber,
          'staff_role_id' => 1,
          'salary' => $faker->numberBetween(4250, 10000),
          'salary_safe_id' => Safe::inRandomOrder()
            ->first()->id,
        ]);
        }
    }
}
