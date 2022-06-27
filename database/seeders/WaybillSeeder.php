<?php

namespace Database\Seeders;

use App\AppHelper;
use App\Models\BulkWaybill;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\Safe;
use App\Models\SubProduct;
use App\Models\Supplier;
use App\Models\Waybill;
use Bezhanov\Faker\Provider\Commerce;
use Faker\Factory;
use Illuminate\Database\Seeder;

class WaybillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $faker->addProvider(new Commerce($faker));
        foreach (range(1, 50) as $item) {
            $supplier = Supplier::inRandomOrder()
          ->first();
            $waybill = Waybill::create([
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
                    $subProduct = SubProduct::create([
              'sale_price' => $sale_price,
              'buy_price' => $buy_price,
              'sale_price_safe_id' => $sale_safe->id,
              'buy_price_safe_id' => $buy_safe->id,
              'product_id' => $product->id,
              'waybill_id' => $waybill->id
            ]);
//            ProductLog::create([
//              'content' => sprintf("%s adındaki üründen %s tarihinde %s ürün kodlu ürün giriş yaptı.", $product->name, AppHelper::convertDateGet($waybill->waybill_date), $subProduct->product_code),
//              'product_id' => $product->id,
//              'waybill_id' => $waybill->id,
//              'date' => $waybill->waybill_date
//            ]);
                    $product->update([
              'real_stock' => $product->real_stock + 1
            ]);
                }
            }
        }
    }
}
