<?php

namespace Tests\Feature;

use App\Models\ProductType;
use App\Models\Safe;
use App\Models\Supplier;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_user_can_create_product()
    {
        ProductType::factory()
      ->count(3)
      ->create();
        Safe::factory()
      ->count(3)
      ->create();
        $suppliers = Supplier::factory()
      ->count(3)
      ->create();
        $data = [
      'uuid'               => $this->faker->uuid,
      'name'               => $this->faker->randomElement([
        $this->faker->televisions(),
        $this->faker->mobilePhones(),
        $this->faker->laptops(),
        $this->faker->cameras()
      ]),
      'model_code'         => $this->faker->numberBetween(1, 9999),
      'buy_price'          => $this->faker->numberBetween(500, 1000),
      'buy_price_safe_id'  => Safe::inRandomOrder()
        ->first()->id,
      'sale_price'         => $this->faker->numberBetween(500, 1000),
      'sale_price_safe_id' => Safe::inRandomOrder()
        ->first()->id,
      'real_stock'         => 0,
      'product_type_id'    => ProductType::inRandomOrder()
        ->first()->id,
      'suppliers'          => $suppliers->pluck('id')
        ->toArray()
    ];
        $this->post(route('product.store'), $data)
      ->assertStatus(200);
    }

    public function test_user_can_create_and_update_product()
    {
        ProductType::factory()
      ->count(3)
      ->create();
        Safe::factory()
      ->count(3)
      ->create();
        $suppliers = Supplier::factory()
      ->count(3)
      ->create();
        $data = [
      'uuid'               => $this->faker->uuid,
      'name'               => $this->faker->randomElement([
        $this->faker->televisions(),
        $this->faker->mobilePhones(),
        $this->faker->laptops(),
        $this->faker->cameras()
      ]),
      'model_code'         => $this->faker->numberBetween(1, 9999),
      'buy_price'          => $this->faker->numberBetween(500, 1000),
      'buy_price_safe_id'  => Safe::inRandomOrder()
        ->first()->id,
      'sale_price'         => $this->faker->numberBetween(500, 1000),
      'sale_price_safe_id' => Safe::inRandomOrder()
        ->first()->id,
      'real_stock'         => 0,
      'product_type_id'    => ProductType::inRandomOrder()
        ->first()->id,
      'suppliers'          => $suppliers->pluck('id')
        ->toArray()
    ];
        $this->post(route('product.store'), $data)
      ->assertStatus(200);

        $product_id = $this->test_user_can_show_product()->id;
        $update_data = [
      'id'                 => $product_id,
      'uuid'               => $this->faker->uuid,
      'name'               => $this->faker->randomElement([
        $this->faker->televisions(),
        $this->faker->mobilePhones(),
        $this->faker->laptops(),
        $this->faker->cameras()
      ]),
      'model_code'         => $this->faker->numberBetween(1, 9999),
      'buy_price'          => $this->faker->numberBetween(500, 1000),
      'buy_price_safe_id'  => Safe::inRandomOrder()
        ->first()->id,
      'sale_price'         => $this->faker->numberBetween(500, 1000),
      'sale_price_safe_id' => Safe::inRandomOrder()
        ->first()->id,
      'real_stock'         => 0,
      'product_type_id'    => ProductType::inRandomOrder()
        ->first()->id,
      'suppliers'          => $suppliers->pluck('id')
        ->toArray()
    ];
        $this->post(route('product.update'), $update_data)
      ->assertStatus(200);
    }

    /**
     * @throws \Throwable
     */
    public function test_user_can_show_product()
    {
        $post = $this->post(route('product.get'), ['id' => 1]);
        $post->assertStatus(200);
        $json = json_decode($post->getContent());
        return $json;
    }

    /**
     * @throws \Throwable
     */
    public function test_user_can_delete_product()
    {
        $this->post(route('product.delete'), ['id' => 1])
      ->assertStatus(200);
    }
}
