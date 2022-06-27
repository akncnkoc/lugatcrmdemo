<?php

namespace Database\Seeders;

use App\Models\StaffPaymentType;
use Illuminate\Database\Seeder;

class StaffPaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staffPaymentTypes = [
      ['name' => 'Maaş'],
      ['name' => 'Borç'],
      ['name' => 'Avans'],
      ['name' => 'Hanutçu Ödemesi'],
    ];
        foreach ($staffPaymentTypes as $staffPaymentType) {
            StaffPaymentType::create($staffPaymentType);
        }
    }
}
