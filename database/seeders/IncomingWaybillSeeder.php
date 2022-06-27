<?php

namespace Database\Seeders;

use App\Models\IncomingWaybill;
use App\Models\IncomingWaybillProduct;
use App\Models\Product;
use App\Models\Safe;
use App\Models\Supplier;
use Bezhanov\Faker\Provider\Commerce;
use Faker\Factory;
use Illuminate\Database\Seeder;

class IncomingWaybillSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $faker->addProvider(new Commerce($faker));
        foreach (range(1, 50) as $item) {
            $supplier = Supplier::inRandomOrder()
        ->first();
            $waybill = IncomingWaybill::create([
        'supplier_id' => $supplier->id,
        'waybill_date' => $faker->dateTimeBetween("-2 years", "now", "Europe/Istanbul"),
      ]);

            for ($i = 0; $i < floor(rand(1, 3)); $i++) {
                $product = Product::inRandomOrder()
          ->first();
                for ($k = 0; $k < floor(rand(1, 6)); $k++) {
                    $buy_safe = Safe::inRandomOrder()
            ->first();
                    $sale_safe = Safe::inRandomOrder()
            ->first();
                    $buy_price = $faker->numberBetween(100, 500);
                    $sale_price = $faker->numberBetween(500, 1000);
                    IncomingWaybillProduct::create([
            'sale_price' => $sale_price,
            'buy_price' => $buy_price,
            'sale_price_safe_id' => $sale_safe->id,
            'buy_price_safe_id' => $buy_safe->id,
            'product_id' => $product->id,
            'waybill_id' => $waybill->id
          ]);
                }
            }
        }
    }
}
