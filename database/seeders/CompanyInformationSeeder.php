<?php

namespace Database\Seeders;

use App\Models\CompanyInformation;
use Illuminate\Database\Seeder;

class CompanyInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyInformation::create([
      'title' => 'Omar Ugs',
      'business_sector' => 'Halı',
      'country' => 'Türkiye',
      'city' => 'İstanbul',
      'county' => 'Sultanahmet',
    ]);
    }
}
