<?php

namespace Database\Seeders;

use App\Models\CargoCompany;
use Illuminate\Database\Seeder;

class CargoCompanySeeder extends Seeder
{
    public function run()
    {
        $cargoCompanies = [
      ['name' => 'MNG Kargo', 'photo_path' => 'mngcargo.png'],
      ['name' => 'UPS Kargo', 'photo_path' => 'upscargo.png'],
      ['name' => 'Aras Kargo', 'photo_path' => 'arascargo.png'],
      ['name' => 'Sürat Kargo', 'photo_path' => 'suratcargo.png'],
      ['name' => 'DHL Kargo', 'photo_path' => 'dhlcargo.png'],
      ['name' => 'Fedex Kargo', 'photo_path' => 'fedexcargo.jpg'],
    ];
        if (CargoCompany::all()->isEmpty()) {
            foreach ($cargoCompanies as $cargoCompany) {
                CargoCompany::create($cargoCompany);
            }
        }
    }
}
