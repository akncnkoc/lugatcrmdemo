<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\Safe;
use App\Models\Supplier;
use Bezhanov\Faker\Provider\Commerce;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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
    foreach (range(1, 20) as $item) {
      $product = Product::create([
        'uuid' => $faker->uuid,
        'name' => $faker->productName,
        'model_code' => $faker->numberBetween(1, 9999),
        'buy_price' => $faker->numberBetween(100, 1000),
        'buy_price_safe_id' => Safe::inRandomOrder()
          ->first()->id,
        'sale_price' => $faker->numberBetween(200, 1000),
        'sale_price_safe_id' => Safe::inRandomOrder()
          ->first()->id,
        'real_stock' => 0,
        'product_type_id' => ProductType::inRandomOrder()->first()->id,
      ]);
      $productSuppliers = [];
      for ($i = 0; $i < floor(rand(1, 3)); $i++) {
        $productSuppliers[] = [
          'product_id' => $product->id,
          'supplier_id' => Supplier::inRandomOrder()
            ->first()->id,
        ];
      }
      $product->suppliers()
        ->createMany($productSuppliers);

    }
  }
}
