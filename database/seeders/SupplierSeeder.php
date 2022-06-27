<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Bezhanov\Faker\Provider\Commerce;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
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
        foreach (range(1, 15) as $item) {
            Supplier::create([
        'name' => $faker->company,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber]);
        }
    }
}
