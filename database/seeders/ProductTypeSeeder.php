<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    public function run()
    {
        $productTypes = [
      ['name' => 'Halı', 'initial_code' => 1],
      ['name' => 'Kilim', 'initial_code' => 2],
    ];
        if (ProductType::all()->isEmpty()) {
            foreach ($productTypes as $productType) {
                ProductType::create($productType);
            }
        }
    }
}
